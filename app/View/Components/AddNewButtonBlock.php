<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AddNewButtonBlock extends Component
{
    public string $routeName = "";
    public string $buttonText = "";
    public string $targetModel = "";

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $routeName, string $buttonText, string $targetModel)
    {
        $this->routeName = $routeName;
        $this->buttonText = $buttonText;
        $this->targetModel = $targetModel;
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
