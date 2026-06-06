<?php

namespace App\View\Components\Alert;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class sweetalert extends Component
{
    /**
     * Create a new component instance.
     */
    //bikin alert sweetalert menjadi component
    public $type , $errors;
    public function __construct($type = 'danger', $errors = null)
    {
        $this->type = $type;
        $this->errors = $errors;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.alert.sweetalert');
    }
}
