<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class VisitorLayout extends Component
{
    public function __construct(
        public SEOData $seo
    ) {}

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.visitor');
    }
}
