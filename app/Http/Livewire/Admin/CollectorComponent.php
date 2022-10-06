<?php

namespace App\Http\Livewire\Admin;

use App\Models\Collector;
use App\Models\Facility;
use App\Models\Study;
use Exception;
use Livewire\Component;

class CollectorComponent extends Component
{
    public $name;

    public $email;

    public $facility_id;

    public $contact;

    public $is_active;

    public $delete_id;

    public $studies;

    public $study_id;

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => 'required',
            'contact' => 'required',
            'email' => 'required|email:filter',
            'facility_id' => 'required',
            'is_active' => 'required',

        ]);
    }

    public function getStudies()
    {
        $this->studies = Study::where('facility_id', $this->facility_id)->latest()->get();
    }

    public function mount()
    {
        $this->studies = collect();
    }

    public function storeData()
    {
        $this->validate([
            'name' => 'required',
            'contact' => 'required',
            'email' => 'required|unique:collectors|email:filter',
            'facility_id' => 'required',
            'is_active' => 'required',
        ]);

        $collector = new Collector();
        $collector->name = $this->name;
        $collector->contact = $this->contact;
        $collector->email = $this->email;
        $collector->facility_id = $this->facility_id;
        $collector->study_id = $this->study_id == '' ? null : $this->study_id;

        $collector->save();

        session()->flash('success', 'Collector created successfully.');
        $this->reset(['name', 'contact', 'facility_id', 'email', 'is_active', 'study_id']);
        $this->dispatchBrowserEvent('close-modal');
    }

    public function editdata($id)
    {
        $collector = Collector::where('id', $id)->first();
        $this->edit_id = $collector->id;
        $this->name = $collector->name;
        $this->contact = $collector->contact;
        $this->email = $collector->email;
        $this->facility_id = $collector->facility_id;
        $this->study_id = $collector->study_id;
        $this->is_active = $collector->is_active;

        $this->studies = Study::where('facility_id', $collector->facility_id)->latest()->get();

        $this->dispatchBrowserEvent('edit-modal');
    }

    public function resetInputs()
    {
        $this->reset(['name', 'contact', 'facility_id', 'email', 'is_active', 'study_id']);
    }

    public function updateData()
    {
        $this->validate([
            'name' => 'required',
            'contact' => 'required',
            'email' => 'required|email:filter',
            'facility_id' => 'required',
            'is_active' => 'required',
        ]);
        $collector = Collector::find($this->edit_id);
        $collector->name = $this->name;
        $collector->contact = $this->contact;
        $collector->email = $this->email;
        $collector->facility_id = $this->facility_id;
        $collector->study_id = $this->study_id == '' ? null : $this->study_id;
        $collector->is_active = $this->is_active;
        $collector->update();

        session()->flash('success', 'Collector updated successfully.');
        $this->reset(['name', 'contact', 'facility_id', 'email', 'is_active', 'study_id']);
        $this->dispatchBrowserEvent('close-modal');
    }

    public function deleteConfirmation($id)
    {
        $this->delete_id = $id;

        $this->dispatchBrowserEvent('delete-modal');
    }

    public function deleteData()
    {
        try {
            $collector = Collector::where('id', $this->delete_id)->first();
            $collector->delete();
            $this->delete_id = '';
            $this->dispatchBrowserEvent('close-modal');
            session()->flash('success', 'Collector deleted successfully.');
        } catch(Exception $error) {
            session()->flash('erorr', 'Collector can not be deleted !!.');
        }
    }

    public function cancel()
    {
        $this->delete_id = '';
    }

    public function close()
    {
        $this->resetInputs();
    }

    public function render()
    {
        $collectors = Collector::with('facility', 'study')->latest()->get();
        $facilities = Facility::latest()->get();

        return view('livewire.admin.collector-component', compact('collectors', 'facilities'))->layout('layouts.app');
    }
}
