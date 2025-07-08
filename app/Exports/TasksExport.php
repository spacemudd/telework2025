<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Carbon\Carbon;

class TasksExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithEvents
{
    protected $tasks;

    public function __construct($tasks)
    {
        $this->tasks = $tasks;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->tasks;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'اسم الموظف',
            'عنوان المهمة',
            'الوصف',
            'الأولوية',
            'الحالة',
            'تاريخ الاستحقاق',
            'تاريخ الإنشاء',
            'التعليقات'
        ];
    }

    /**
     * @param mixed $task
     * @return array
     */
    public function map($task): array
    {
        $comments = $task->comments->map(function ($comment) {
            return $comment->user->name . ': ' . $comment->comment . ' (' . $comment->created_at->format('Y-m-d H:i') . ')';
        })->implode(' | ');

        return [
            $task->employee->name,
            $task->title,
            $task->description,
            __('words.' . $task->priority),
            __('words.' . $task->status),
            Carbon::parse($task->due_date)->format('Y-m-d'),
            $task->created_at->format('Y-m-d H:i'),
            $comments
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        $totalRows = count($this->tasks) + 1; // +1 for header row
        
        return [
            // Style the header row with black background, white text, middle alignment, bold
            'A1:H1' => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'] // White text
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '000000'] // Black background
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'readingOrder' => 2 // RTL
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000']
                    ]
                ]
            ],
            // Set RTL alignment and borders for all data rows (columns A to H only)
            'A2:H' . $totalRows => [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_RIGHT,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'readingOrder' => 2 // RTL
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000']
                    ]
                ]
            ],
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Set sheet to RTL mode
                $event->sheet->getDelegate()->setRightToLeft(true);
                
                // Auto-size columns
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(30);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(50);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(60);
            },
        ];
    }
}
