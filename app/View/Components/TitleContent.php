<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TitleContent extends Component
{
    private string $title = "";
    private string $description = "";
    /**
     * Create a new component instance.
     */
    public function __construct(string $title, string $description)
    {
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.title-content', [
            "title" => $this->title,
            "description" => $this->description
        ]);
    }
}
