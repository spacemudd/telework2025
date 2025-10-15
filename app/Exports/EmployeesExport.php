<?php

declare(strict_types=1);

namespace App\Exports;

use App\Models\Employee;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class EmployeesExport implements FromCollection, WithHeadings, WithMapping, WithCustomCsvSettings
{
    /** @var Collection<int, Employee> */
    protected Collection $employees;

    public function __construct(Collection $employees)
    {
        $this->employees = $employees;
    }

    public function collection(): Collection
    {
        return $this->employees;
    }

    public function headings(): array
    {
        return [
            'معيَّن لشركة؟',
            'اسم الشركة',
            'معرّف الموظف',
            'الاسم',
            'البريد الإلكتروني',
            'الهاتف',
            'المنصب',
            'رقم الهوية',
            'مستوى الخبرة',
            'نمط العمل المفضّل',
            'باحث عن عمل',
            'الملف مكتمل',
            'نبذة',
            'رابط السيرة الذاتية',
            'المهارات',
            'فئات المواهب',
            'الخبرات التفصيلية',
            'التعليم التفصيلي',
            'تاريخ الإنشاء',
        ];
    }

    public function map($employee): array
    {
        $yesNo = static fn ($v): string => $v ? 'نعم' : 'لا';

        // Handle conflict where model has a string attribute `skills` and a relation `skills()`
        $skills = '';
        if ($employee->relationLoaded('skills')) {
            $skillsRelation = $employee->getRelation('skills');
            $skills = $skillsRelation instanceof \Illuminate\Support\Collection
                ? $skillsRelation->pluck('name')->join(' | ')
                : '';
        } elseif (is_string($employee->skills ?? null)) {
            $skills = collect(array_map('trim', array_filter(explode(',', (string) $employee->skills))))->join(' | ');
        }

        $talentCategories = '';
        if ($employee->relationLoaded('talentCategories')) {
            $talentRelation = $employee->getRelation('talentCategories');
            $talentCategories = $talentRelation instanceof \Illuminate\Support\Collection
                ? $talentRelation->pluck('name')->join(' | ')
                : '';
        }

        $experiences = $employee->relationLoaded('experiences')
            ? $employee->getRelation('experiences')->map(function ($exp) use ($yesNo) {
                $start = optional($exp->start_date)->format('Y-m-d');
                $end = optional($exp->end_date)->format('Y-m-d');
                return implode(' | ', [
                    (string) $exp->company_name,
                    (string) $exp->job_title,
                    (string) $start,
                    (string) $end,
                    $yesNo((bool) $exp->is_current),
                    (string) $exp->description,
                ]);
            })->join(' || ')
            : '';

        $educations = $employee->relationLoaded('educations')
            ? $employee->getRelation('educations')->map(function ($edu) use ($yesNo) {
                $start = optional($edu->start_date)->format('Y-m-d');
                $end = optional($edu->end_date)->format('Y-m-d');
                return implode(' | ', [
                    (string) $edu->title,
                    (string) $edu->institute_name,
                    (string) $start,
                    (string) $end,
                    $yesNo((bool) $edu->is_current),
                    (string) $edu->certificate_type,
                ]);
            })->join(' || ')
            : '';

        $cvUrl = $employee->cv_path ? url($employee->cv_path) : '';

        return [
            $yesNo((bool) $employee->company_id),
            optional($employee->company)->name ?? '',
            (string) $employee->id,
            (string) $employee->name,
            (string) $employee->email,
            (string) optional($employee->user)->mobile ?? '',
            (string) ($employee->position ?? ''),
            (string) ($employee->identity_number ?? ''),
            (string) ($employee->experience_level ?? ''),
            (string) ($employee->preferred_work_type ?? ''),
            $yesNo((bool) $employee->is_job_seeker),
            $yesNo((bool) $employee->profile_completed),
            (string) ($employee->bio ?? ''),
            $cvUrl,
            $skills,
            $talentCategories,
            $experiences,
            $educations,
            $employee->created_at ? $employee->created_at->format('Y-m-d H:i') : '',
        ];
    }

    public function getCsvSettings(): array
    {
        return [
            'use_bom' => true,
            'output_encoding' => 'UTF-8',
            'delimiter' => ',',
        ];
    }
}


