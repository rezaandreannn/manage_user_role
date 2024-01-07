<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Spatie\Permission\Models\Permission;

class CustomNav extends Component
{
    public $locations, $modules, $menus;

    public function __construct()
    {
        $this->locations = Permission::where('type', 'location')->orderBy('order')->get();
        $this->modules = Permission::where('type', 'module')->orderBy('order')->get();
        $this->menus = Permission::where('type', 'menu')->orderBy('order')->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.custom-nav');
    }
}
