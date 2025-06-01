<?php

namespace App\Mail;

use App\Models\Company;
use App\Services\CompanyTasksReportService;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Tags;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class DailyCompanyTasksReport extends Mailable
{
    use Queueable, SerializesModels;

    public $company;
    public $yesterday;
    public $tasksByEmployee;
    public $statistics;
    private $reportService;
    private $csvPath;

    /**
     * Create a new message instance.
     */
    public function __construct(Company $company, array $tasksByEmployee)
    {
        $this->company = $company;
        $this->yesterday = now()->subDay()->format('Y-m-d');
        $this->tasksByEmployee = $tasksByEmployee;
        
        // Initialize the report service
        $this->reportService = new CompanyTasksReportService();
        
        // Generate statistics
        $this->statistics = $this->reportService->getStatistics($tasksByEmployee);
        
        // Generate CSV report
        $this->csvPath = $this->reportService->generateCsvReport($company, $tasksByEmployee);
        
        // Force Arabic locale
        App::setLocale('ar');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "تقرير المهام العمل عن بعد - {$this->yesterday}",
        );
    }

    /**
     * Get the message tags.
     */
    public function tags(): Tags
    {
        return new Tags([
            'daily_report',
            'company_id:' . $this->company->id
        ]);
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.daily_company_tasks_report',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromStorage($this->csvPath)
                ->as('تقرير_المهام_' . $this->yesterday . '.csv')
                ->withMime('text/csv'),
        ];
    }
}
