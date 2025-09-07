<?php

namespace App\Http\Controllers;

use App\Models\TalentCategory;
use App\Models\Employee;
use Illuminate\Http\Request;

class TalentCategoryController extends Controller
{
    public function index()
    {
        $categories = TalentCategory::active()->ordered()->get();
        
        return view('talent-categories.index', compact('categories'));
    }

    public function show(TalentCategory $category)
    {
        $jobSeekers = Employee::jobSeekers()
            ->profileCompleted()
            ->byTalentCategory($category->id)
            ->with(['user', 'talentCategories'])
            ->paginate(20);
        
        return view('talent-categories.show', compact('category', 'jobSeekers'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        $categoryId = $request->get('category_id');
        $experienceLevel = $request->get('experience_level');
        
        $jobSeekers = Employee::jobSeekers()
            ->profileCompleted()
            ->when($categoryId, function($q) use ($categoryId) {
                return $q->byTalentCategory($categoryId);
            })
            ->when($query, function($q) use ($query) {
                return $q->where(function($subQ) use ($query) {
                    $subQ->where('name', 'like', "%{$query}%")
                          ->orWhere('skills', 'like', "%{$query}%");
                });
            })
            ->when($experienceLevel, function($q) use ($experienceLevel) {
                return $q->where('experience_level', $experienceLevel);
            })
            ->with(['user', 'talentCategories'])
            ->paginate(20);
        
        if ($request->ajax()) {
            return response()->json([
                'html' => view('talent-categories.partials.job-seekers-grid', compact('jobSeekers'))->render(),
                'pagination' => $jobSeekers->links()->toHtml()
            ]);
        }
        
        return response()->json($jobSeekers);
    }
}
