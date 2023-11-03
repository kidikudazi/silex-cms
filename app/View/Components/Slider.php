<?php

namespace App\View\Components;

use App\Models\Slider as ModelsSlider;
use Illuminate\View\Component;

class Slider extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $sliders = ModelsSlider::orderBy('created_at', 'DESC')->get();
        return view('components.slider')->with(['sliders' => $sliders ]);
    }
}