<?php

namespace App\View\Components;

use App\Models\JobCategory;
use Illuminate\View\Component;

class JobCategories extends Component
{
    /**
     * The job categories.
     *
     * @var \Illuminate\Database\Eloquent\Collection
     */
    public $categories;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->categories = JobCategory::where('is_active', true)->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.job-categories');
    }
}
