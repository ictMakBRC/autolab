<?php

namespace App\Http\Livewire\Lab\Lists;

use App\Models\Participant;
use Livewire\Component;

class ParticipantListComponent extends Component
{
    public $activeRow;

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function render()
    {
        $participants = Participant::where('creator_lab', auth()->user()->laboratory_id)->withCount(['sample', 'testResult'])->with('facility', 'study')->get();

        return view('livewire.lab.lists.participant-list-component', compact('participants'));
    }
}
