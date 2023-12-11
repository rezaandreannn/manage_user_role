<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AddFormButton extends Component
{
    /**
     * Create a new component instance.
     */
    protected $route;
    protected $title;
    public function __construct($route = null, $title = null)
    {
        $this->route = $route;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.add-form-button');
    }
}
