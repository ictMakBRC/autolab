<?php

namespace App\Http\Livewire\Lab\Lists;

use Livewire\Component;
use App\Models\Participant;

class ParticipantListComponent extends Component
{
    public function render()
    {
        $participants = Participant::where('creator_lab',auth()->user()->laboratory_id)->withCount(['sample'])->get();
        return view('livewire.lab.lists.participant-list-component',compact('participants'));
    }
}
