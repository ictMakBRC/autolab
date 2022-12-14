<?php

namespace App\Http\Livewire\Lab\SampleManagement;

use App\Models\AliquotingAssignment;
use App\Models\Sample;
use App\Models\SamplesAliquot;
use App\Models\SampleType;
use Livewire\Component;

class SampleAliquotsComponent extends Component
{
    public $aliquots;

    // public $tests_performed = [];
    public $aliquots_performed = [];

    public $aliquotIdentities = [];

    public $sample;

    public $sample_id;

    public $sample_identity;

    public $lab_no;

    public $performed_by;

    public $comment;

    public function mount($id)
    {
        $sample = Sample::findOrFail($id);
        $this->sample = $sample;
        $this->sample_id = $sample->id;
        $this->sample_identity = $sample->sample_identity;
        $this->lab_no = $sample->lab_no;
        $this->aliquots = SampleType::whereIn('id', (array) $sample->tests_requested)->orderBy('id', 'asc')->get();

        foreach ($this->aliquots->pluck('id')->toArray() as $aliquot) {
            $this->aliquotIdentities[$aliquot] = '';
        }
    }

    public function storeAliquots()
    {
        if (count($this->aliquots_performed) > 0) {
            foreach ($this->aliquots_performed as $aliquot) {
                SamplesAliquot::create(['parent_id' => $this->sample_id, 'aliquot_type_id' => $aliquot, 'aliquot_identity' => $this->aliquotIdentities[$aliquot] == '' ? null : $this->aliquotIdentities[$aliquot]]);
            }

            $this->sample->update(['tests_performed' => $this->aliquots_performed, 'status' => 'Aliquoted']);
            AliquotingAssignment::where('sample_id', $this->sample_id)->update(['comment' => $this->comment, 'status' => 'Aliquoted']);
            redirect()->route('test-request');
        } else {
            $this->dispatchBrowserEvent('mismatch', ['type' => 'error',  'message' => 'No aliquots selected for this sample!']);
        }
    }

    public function render()
    {
        return view('livewire.lab.sample-management.sample-aliquots-component');
    }
}
