<?php

namespace App\Http\Livewire\Lab\Lists;

use App\Exports\ParticipantsExport;
use App\Models\Participant;
use App\Models\Sample;
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

    public $export;

    protected $paginationTheme = 'bootstrap';
    // public function export()
    // {
    //     return (new CollectorsExport())->download('sample_collectors.xlsx');
    // }

    public function export()
    {
        return (new ParticipantsExport())->download('Participants.xlsx');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function render()
    {
        $participantList = Sample::select('participant_id')->where('creator_lab', auth()->user()->laboratory_id)->distinct()->get()->pluck('participant_id');
        $participants = Participant::search($this->search)
        ->whereIn('id', $participantList ?? [])->withCount(['sample', 'testResult'])->with('facility', 'study')
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);

        return view('livewire.lab.lists.participant-list-component', compact('participants'));
    }
}
