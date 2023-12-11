<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ActionModal extends Component
{
    /**
     * Create a new component instance.
     */
    protected $routeEdit;
    protected $permissionEdit;
    protected $routeDelete;
    protected $permissionDelete;
    protected $title;
    protected $message;


    public function __construct($routeDelete = null, $routeEdit = null, $title = null, $message = null, $permissionEdit, $permissionDelete)
    {
        $this->title = $title;
        $this->routeEdit = $routeEdit;
        $this->permissionEdit = $permissionEdit;
        $this->routeDelete = $routeDelete;
        $this->permissionEdit = $permissionDelete;
        $this->message = $message;
    }

    /**
     * Get the view / contents that represent the component.
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.action-modal');
    }
}
