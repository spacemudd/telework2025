<?php

declare(strict_types=1);

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class UsersExport implements FromCollection, WithHeadings, WithMapping, WithCustomCsvSettings
{
    /** @var Collection<int, User> */
    protected Collection $users;

    public function __construct(Collection $users)
    {
        $this->users = $users;
    }

    public function collection(): Collection
    {
        return $this->users;
    }

    public function headings(): array
    {
        return [
            // User columns
            'معرّف المستخدم',
            'الاسم',
            'البريد الإلكتروني',
            'الجوال',
            'تاريخ إنشاء المستخدم',
            // Appended Employee columns (if exists)
            'لديه ملف موظف؟',
            'معيَّن لشركة؟',
            'اسم الشركة',
            'معرّف الموظف',
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
            'تاريخ إنشاء ملف الموظف',
        ];
    }

    public function map($user): array
    {
        $yesNo = static fn ($v): string => $v ? 'نعم' : 'لا';

        $employee = $user->relationLoaded('employee') ? $user->employee : null;

        $hasEmployee = (bool) $employee;
        $assignedToCompany = $hasEmployee && (bool) $employee->company_id;
        $companyName = $hasEmployee ? (optional($employee->company)->name ?? '') : '';

        // Safely build appended employee fields
        $skills = '';
        if ($hasEmployee && $employee->relationLoaded('skills')) {
            $skillsRelation = $employee->getRelation('skills');
            $skills = $skillsRelation instanceof \Illuminate\Support\Collection
                ? $skillsRelation->pluck('name')->join(' | ')
                : '';
        } elseif ($hasEmployee && is_string($employee->skills ?? null)) {
            $skills = collect(array_map('trim', array_filter(explode(',', (string) $employee->skills))))->join(' | ');
        }

        $talentCategories = '';
        if ($hasEmployee && $employee->relationLoaded('talentCategories')) {
            $talentRelation = $employee->getRelation('talentCategories');
            $talentCategories = $talentRelation instanceof \Illuminate\Support\Collection
                ? $talentRelation->pluck('name')->join(' | ')
                : '';
        }

        $experiences = '';
        if ($hasEmployee && $employee->relationLoaded('experiences')) {
            $experiences = $employee->getRelation('experiences')->map(function ($exp) use ($yesNo) {
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
            })->join(' || ');
        }

        $educations = '';
        if ($hasEmployee && $employee->relationLoaded('educations')) {
            $educations = $employee->getRelation('educations')->map(function ($edu) use ($yesNo) {
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
            })->join(' || ');
        }

        $cvUrl = $hasEmployee && $employee->cv_path ? url($employee->cv_path) : '';

        return [
            // User columns
            (string) $user->id,
            (string) $user->name,
            (string) $user->email,
            (string) ($user->mobile ?? ''),
            $user->created_at ? $user->created_at->format('Y-m-d H:i') : '',
            // Appended Employee columns
            $yesNo($hasEmployee),
            $yesNo($assignedToCompany),
            $companyName,
            $hasEmployee ? (string) $employee->id : '',
            $hasEmployee ? (string) ($employee->position ?? '') : '',
            $hasEmployee ? (string) ($employee->identity_number ?? '') : '',
            $hasEmployee ? (string) ($employee->experience_level ?? '') : '',
            $hasEmployee ? (string) ($employee->preferred_work_type ?? '') : '',
            $hasEmployee ? $yesNo((bool) $employee->is_job_seeker) : '',
            $hasEmployee ? $yesNo((bool) $employee->profile_completed) : '',
            $hasEmployee ? (string) ($employee->bio ?? '') : '',
            $cvUrl,
            $skills,
            $talentCategories,
            $experiences,
            $educations,
            $hasEmployee && $employee->created_at ? $employee->created_at->format('Y-m-d H:i') : '',
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


