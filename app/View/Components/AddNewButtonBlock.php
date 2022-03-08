<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AddNewButtonBlock extends Component
{
    public string $routeName = "";
    public string $buttonText = "";

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $routeName, string $buttonText)
    {
        $this->routeName = $routeName;
        $this->buttonText = $buttonText;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.add-new-button-block');
    }
}
