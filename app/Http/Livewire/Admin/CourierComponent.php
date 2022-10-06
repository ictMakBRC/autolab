<?php

namespace App\Http\Livewire\Admin;

use App\Models\Courier;
use App\Models\Facility;
use App\Models\Study;
use Exception;
use Livewire\Component;

class CourierComponent extends Component
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
            'email' => 'required|unique:couriers|email:filter',
            'facility_id' => 'required',
            'is_active' => 'required',
        ]);

        $courier = new Courier();
        $courier->name = $this->name;
        $courier->contact = $this->contact;
        $courier->email = $this->email;
        $courier->facility_id = $this->facility_id;
        $courier->study_id = $this->study_id == '' ? null : $this->study_id;
        $courier->save();
        session()->flash('success', 'Courier created successfully.');

        $this->reset(['name', 'contact', 'facility_id', 'email', 'is_active', 'study_id']);

        $this->dispatchBrowserEvent('close-modal');
    }

    public function editdata($id)
    {
        $courier = Courier::where('id', $id)->first();
        $this->edit_id = $courier->id;
        $this->name = $courier->name;
        $this->contact = $courier->contact;
        $this->email = $courier->email;
        $this->facility_id = $courier->facility_id;
        $this->study_id = $courier->study_id;
        $this->is_active = $courier->is_active;

        $this->studies = Study::where('facility_id', $courier->facility_id)->latest()->get();

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
        $courier = Courier::find($this->edit_id);
        $courier->name = $this->name;
        $courier->contact = $this->contact;
        $courier->email = $this->email;
        $courier->facility_id = $this->facility_id;
        $courier->study_id = $this->study_id == '' ? null : $this->study_id;
        $courier->is_active = $this->is_active;
        $courier->update();

        session()->flash('success', 'Courier updated successfully.');

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
            $courier = Courier::where('id', $this->delete_id)->first();
            $courier->delete();
            $this->delete_id = '';
            $this->dispatchBrowserEvent('close-modal');
            session()->flash('success', 'Courier deleted successfully.');
        } catch(Exception $error) {
            session()->flash('erorr', 'Courier can not be deleted !!.');
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
        $couriers = Courier::with('facility', 'study')->latest()->get();
        $facilities = Facility::latest()->get();

        return view('livewire.admin.courier-component', compact('couriers', 'facilities'))->layout('layouts.app');
    }
}
