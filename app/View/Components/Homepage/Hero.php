<?php

namespace App\View\Components\Homepage;

use Illuminate\View\Component;

class Hero extends Component
{
    public $cities;
    public $jobCategories;

    /**
     * Create a new component instance.
     */
    public function __construct($cities = [], $jobCategories = [])
    {
        $this->cities = $cities;
        $this->jobCategories = $jobCategories;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.homepage.hero');
    }
}
