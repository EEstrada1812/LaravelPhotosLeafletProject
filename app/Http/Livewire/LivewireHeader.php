<?php

namespace App\Http\Livewire;

use Livewire\Component;

class LivewireHeader extends Component
{
    protected $listeners = ['uploadFormMessage'];

    public function uploadFormMessage($message)
    {   
        session()->flash('message', $message);
    }
    
    public function render()
    {
        return view('livewire.livewire-header');
    }
}
