<?php

namespace App\View\Components;

use Illuminate\View\Component;

class JobListings extends Component
{
    public $jobPostings;
    public $showLoadMore;
    public $title;
    public $subtitle;

    /**
     * Create a new component instance.
     */
    public function __construct($jobPostings, $showLoadMore = true, $title = null, $subtitle = null)
    {
        $this->jobPostings = $jobPostings;
        $this->showLoadMore = $showLoadMore;
        $this->title = $title ?? __('words.latest_jobs.title');
        $this->subtitle = $subtitle;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.job-listings');
    }
}
