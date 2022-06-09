<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FooterExam extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $font_color;

    public function __construct($color)
    {
        $this->font_color = $color;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.footerexam');
    }
}
