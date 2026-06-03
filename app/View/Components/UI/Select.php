<?php

namespace App\View\Components\UI;

use Illuminate\View\Component;

class Select extends Component
{
    public $options;
    public $placeholder;
    public $name;
    public $value;

    public function __construct(
        $options = [],
        $placeholder = 'Select an option',
        $name = null,
        $value = null
    ) {
        $this->options = $options;
        $this->placeholder = $placeholder;
        $this->name = $name;
        $this->value = $value;
    }

    public function render()
    {
        return view('components.ui.select');
    }
}
