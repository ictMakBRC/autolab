<?php

namespace App\Http\Livewire\Layout;

use Livewire\Component;

class HeaderComponent extends Component
{
    // protected $listeners=['refresh-nav'=>'$refresh'];
    public function render()
    {
        return view('livewire.layout.header-component');
    }
}
