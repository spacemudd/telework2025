<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Interview;
use App\Models\InterviewQuestion;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class InterviewService
{
    public function generateQuestions(Interview $interview): void
    {
        $employee = $interview->employee;
        $talentCategories = $employee->talentCategories;
        
        // Default questions for all job seekers - Keep these short and simple
        $defaultQuestions = [
            [
                'en' => 'Tell me about yourself briefly.',
                'ar' => 'أخبرني عن نفسك بإيجاز.',
                'order' => 1,
            ],
            [
                'en' => 'What are your main skills?',
                'ar' => 'ما هي مهاراتك الرئيسية؟',
                'order' => 2,
            ],
            [
                'en' => 'Describe a challenging project you worked on.',
                'ar' => 'صف مشروعاً صعباً عملت عليه.',
                'order' => 3,
            ],
            [
                'en' => 'What are your career goals?',
                'ar' => 'ما هي أهدافك المهنية؟',
                'order' => 4,
            ],
        ];

        // Generate AI-powered questions based on talent categories if available
        if ($talentCategories->isNotEmpty()) {
            $aiQuestions = $this->generateAIQuestions($employee, $interview->language);
            
            if (!empty($aiQuestions)) {
                $defaultQuestions = array_merge($defaultQuestions, $aiQuestions);
            }
        }

        // Create questions in database
        foreach ($defaultQuestions as $questionData) {
            // Validate question length
            $validatedEn = $this->validateQuestionLength($questionData['en'], 'en');
            $validatedAr = $this->validateQuestionLength($questionData['ar'], 'ar');
            
            InterviewQuestion::create([
                'interview_id' => $interview->id,
                'question_text' => $validatedEn,
                'question_text_ar' => $validatedAr,
                'question_order' => $questionData['order'],
            ]);
        }
    }

    protected function generateAIQuestions($employee, string $language): array
    {
        try {
            $prompt = $this->buildAIPrompt($employee, $language);
            
            $response = Http::withToken(config('services.openai.key'))
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model' => 'gpt-4-turbo',
                    'messages' => [
                        ['role' => 'system', 'content' => 'You are an expert HR interviewer. Generate 2-3 SHORT and SIMPLE interview questions based on the candidate\'s profile. Each question should be concise and focus on one clear topic.'],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                    'max_tokens' => 300,
                    'temperature' => 0.7,
                ]);

            if ($response->successful()) {
                $content = $response->json('choices.0.message.content');
                return $this->parseAIQuestions($content, $language);
            }

        } catch (\Exception $e) {
            Log::error('Failed to generate AI questions', [
                'employee_id' => $employee->id,
                'error' => $e->getMessage(),
            ]);
        }

        return [];
    }

    protected function buildAIPrompt($employee, string $language): string
    {
        $locale = $language === 'ar' ? 'Arabic' : 'English';
        
        return "Generate 2-3 short and simple interview questions in {$locale} for a job seeker with the following profile:\n" .
               "Skills: {$employee->skills}\n" .
               "Experience Level: {$employee->experience_level}\n" .
               "Preferred Work Type: {$employee->preferred_work_type}\n" .
               "Talent Categories: " . $employee->talentCategories->pluck('name')->implode(', ') . "\n" .
               "IMPORTANT: Keep each question short and simple - maximum 15 words in English or 20 words in Arabic. Focus on one clear topic per question.\n" .
               "Format: Return only the questions, one per line, in {$locale}.";
    }

    protected function parseAIQuestions(string $content, string $language): array
    {
        $questions = [];
        $lines = explode("\n", trim($content));
        $order = 5; // Start after default questions

        foreach ($lines as $line) {
            $line = trim($line);
            if (!empty($line) && !str_starts_with($line, 'Q') && !str_starts_with($line, 'Question')) {
                // Ensure question is not too long
                $truncatedLine = $this->truncateQuestion($line, $language);
                
                $questions[] = [
                    'en' => $truncatedLine,
                    'ar' => $this->translateQuestion($truncatedLine, $language),
                    'order' => $order++,
                ];
            }
        }

        return array_slice($questions, 0, 3); // Limit to 3 additional questions
    }

    protected function translateQuestion(string $question, string $language): string
    {
        if ($language === 'ar') {
            try {
                $response = Http::withToken(config('services.openai.key'))
                    ->post('https://api.openai.com/v1/chat/completions', [
                        'model' => 'gpt-4-turbo',
                        'messages' => [
                            ['role' => 'system', 'content' => 'Translate the following English text to Arabic. Maintain the professional interview tone.'],
                            ['role' => 'user', 'content' => $question],
                        ],
                        'max_tokens' => 100,
                        'temperature' => 0.3,
                    ]);

                if ($response->successful()) {
                    return $response->json('choices.0.message.content');
                }
            } catch (\Exception $e) {
                Log::error('Failed to translate question', ['question' => $question, 'error' => $e->getMessage()]);
            }
        }

        return $question;
    }

    protected function truncateQuestion(string $question, string $language): string
    {
        $maxWords = $language === 'ar' ? 20 : 15;
        $words = explode(' ', trim($question));
        
        if (count($words) <= $maxWords) {
            return $question;
        }
        
        // Log when questions are truncated
        Log::info('Interview question truncated', [
            'original_length' => count($words),
            'max_words' => $maxWords,
            'language' => $language,
            'original_question' => $question
        ]);
        
        // Truncate to max words and add ellipsis if needed
        $truncated = implode(' ', array_slice($words, 0, $maxWords));
        
        // Add appropriate ellipsis based on language
        if ($language === 'ar') {
            return $truncated . '...';
        } else {
            return $truncated . '...';
        }
    }

    protected function validateQuestionLength(string $question, string $language): string
    {
        $maxWords = $language === 'ar' ? 20 : 15;
        $words = explode(' ', trim($question));

        if (count($words) > $maxWords) {
            // Log when questions are truncated
            Log::info('Interview question truncated for validation', [
                'original_length' => count($words),
                'max_words' => $maxWords,
                'language' => $language,
                'original_question' => $question
            ]);
            return implode(' ', array_slice($words, 0, $maxWords)) . '...';
        }
        return $question;
    }

    /**
     * Clean up existing long questions in the database
     * This method can be called via artisan command or scheduled task
     */
    public function cleanupLongQuestions(): int
    {
        $updatedCount = 0;
        
        // Get all interview questions
        $questions = InterviewQuestion::all();
        
        foreach ($questions as $question) {
            $originalEn = $question->question_text;
            $originalAr = $question->question_text_ar;
            
            $validatedEn = $this->validateQuestionLength($originalEn, 'en');
            $validatedAr = $this->validateQuestionLength($originalAr, 'ar');
            
            // Update if questions were truncated
            if ($validatedEn !== $originalEn || $validatedAr !== $originalAr) {
                $question->update([
                    'question_text' => $validatedEn,
                    'question_text_ar' => $validatedAr,
                ]);
                $updatedCount++;
                
                Log::info('Cleaned up long interview question', [
                    'question_id' => $question->id,
                    'interview_id' => $question->interview_id,
                    'original_en' => $originalEn,
                    'original_ar' => $originalAr,
                    'updated_en' => $validatedEn,
                    'updated_ar' => $validatedAr,
                ]);
            }
        }
        
        return $updatedCount;
    }
}
