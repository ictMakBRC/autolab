<?php

namespace App\Http\Livewire\Layout;

use App\Models\Sample;
use Livewire\Component;
use App\Models\TestResult;
use App\Models\Participant;
use App\Models\SampleReception;

class HeaderComponent extends Component
{
    public $search;
    public $searchInputActive=false;
    public $model;
    public $placeHolder='Select search target';

    public function updatedModel(){
        $this->searchInputActive=true;
        $this->reset('search');
        if ($this->model==='Participant') {
            $this->placeHolder='Enter Participant ID';
        } elseif($this->model==='Sample') {
            $this->placeHolder='Enter Sample ID or Lab No';
        }elseif($this->model==='TestResult'){
            $this->placeHolder='Enter Test Result Tracker';
        }elseif($this->model==='SampleReception'){
            $this->placeHolder='Enter sample Batch No';
        }
    }

    public function updatedSearch(){
        
        if ($this->search!='') {
            if ($this->model==='SampleReception') {
                $sampleBatch = SampleReception::targetSearch($this->search)->first();

                if ($sampleBatch) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Sample Batch found successfully!']);
                }else{
                    $this->dispatchBrowserEvent('not-found', ['type' => 'error',  'message' => 'Oops! No Sample Batch matches your search!']);
                }

            }elseif ($this->model==='Participant') {
                $participant = Participant::targetSearch($this->search)->first();
                if ($participant) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Participant found successfully!']);
                }else{
                    $this->dispatchBrowserEvent('not-found', ['type' => 'error',  'message' => 'Oops! No participant matches your search!']);
                }
                
            } elseif($this->model==='Sample') {
                $sample = Sample::targetSearch($this->search)->first();
                if ($sample) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Sample found successfully!']);
                }else{
                    $this->dispatchBrowserEvent('not-found', ['type' => 'error',  'message' => 'Oops! No sample matches your search!']);
                }

            }elseif($this->model==='TestResult'){
                $testResult = TestResult::targetSearch($this->search)->first();
                if ($testResult) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Test Result found successfully!']);
                }else{
                    $this->dispatchBrowserEvent('not-found', ['type' => 'error',  'message' => 'Oops! No Test Result matches your search!']);
                }
                
            }
        }
    }

    public function resetData(){
        $this->reset(['search','model','placeHolder','searchInputActive']);
    }

    public function render()
    {
        return view('livewire.layout.header-component');
    }
}
