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
        
        // Default questions for all job seekers
        $defaultQuestions = [
            [
                'en' => 'Tell me your name and a little bit about yourself. Try to keep it under a minute.',
                'ar' => 'أخبرني باسمك وقليلاً عن نفسك. حاول أن تبقي الإجابة تحت دقيقة واحدة.',
                'order' => 1,
            ],
            [
                'en' => 'What are your main skills and how did you develop them?',
                'ar' => 'ما هي مهاراتك الرئيسية وكيف طورتها؟',
                'order' => 2,
            ],
            [
                'en' => 'Describe a challenging project you worked on and how you overcame obstacles.',
                'ar' => 'صف مشروعاً صعباً عملت عليه وكيف تغلبت على العقبات.',
                'order' => 3,
            ],
            [
                'en' => 'What are your career goals for the next 3-5 years?',
                'ar' => 'ما هي أهدافك المهنية للسنوات 3-5 القادمة؟',
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
            InterviewQuestion::create([
                'interview_id' => $interview->id,
                'question_text' => $questionData['en'],
                'question_text_ar' => $questionData['ar'],
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
                        ['role' => 'system', 'content' => 'You are an expert HR interviewer. Generate 2-3 relevant interview questions based on the candidate\'s profile.'],
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
        
        return "Generate 2-3 interview questions in {$locale} for a job seeker with the following profile:\n" .
               "Skills: {$employee->skills}\n" .
               "Experience Level: {$employee->experience_level}\n" .
               "Preferred Work Type: {$employee->preferred_work_type}\n" .
               "Talent Categories: " . $employee->talentCategories->pluck('name')->implode(', ') . "\n" .
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
                $questions[] = [
                    'en' => $line,
                    'ar' => $this->translateQuestion($line, $language),
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
}
