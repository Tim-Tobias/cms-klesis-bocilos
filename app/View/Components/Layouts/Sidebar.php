<?php

namespace App\View\Components\Layouts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Sidebar extends Component
{
    private array $menus;
    /**
     * Create a new component instance.
     */
    public function __construct(array $menus = [])
    {
        $this->menus = $menus;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layouts.sidebar', [
            'menus' => $this->menus
        ]);
    }
}
