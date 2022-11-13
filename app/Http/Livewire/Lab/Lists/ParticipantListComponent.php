<?php

namespace App\Http\Livewire\Lab\Lists;

use App\Models\Participant;
use Livewire\Component;
use Livewire\WithPagination;

class ParticipantListComponent extends Component
{
    use WithPagination;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'identity';

    public $orderAsc = true;

    public $activeRow;

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function render()
    {
        $participants = Participant::search($this->search)
        ->where('creator_lab', auth()->user()->laboratory_id)->withCount(['sample', 'testResult'])->with('facility', 'study')
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->simplePaginate($this->perPage);

        return view('livewire.lab.lists.participant-list-component', compact('participants'));
    }
}
