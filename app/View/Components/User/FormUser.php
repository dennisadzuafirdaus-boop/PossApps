<?php

namespace App\View\Components\User;

use Closure;
use Illuminate\Contracts\View\View;
use App\Models\User;
use Illuminate\View\Component;

class FormUser extends Component
{
    /**
     * Create a new component instance.
     */
    public  $id ,$name, $email;
    public function __construct($id = null)
    {
        if ($id) {
            $users = User::find($id);
            $this->id = $users->id;
            $this->name = $users->name;
            $this->email = $users->email;

        } else {
            $this->id = null;
            $this->name = '';
            $this->email = '';
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.user.form-user');
    }
}
