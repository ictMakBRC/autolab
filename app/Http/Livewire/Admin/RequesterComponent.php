<?php

namespace App\Http\Livewire\Admin;

use App\Models\Facility;
use App\Models\Requester;
use App\Models\Study;
use Exception;
use Livewire\Component;

class RequesterComponent extends Component
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
            'study_id' => 'required|unique:requesters',
            'is_active' => 'required',

        ]);
    }

    public function getStudies()
    {
        $this->studies = Study::where('creator_lab', auth()->user()->laboratory_id)->where('facility_id', $this->facility_id)->latest()->get();
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
            // 'email' => 'required|unique:requesters|email:filter',
            'email' => 'required|email:filter',
            'facility_id' => 'required',
            'study_id' => 'required|unique:requesters',
            'is_active' => 'required',
        ]);

        $requester = new Requester();
        $requester->name = $this->name;
        $requester->contact = $this->contact;
        $requester->email = $this->email;
        $requester->facility_id = $this->facility_id;
        $requester->study_id = $this->study_id == '' ? null : $this->study_id;
        $requester->save();

        $this->reset(['name', 'contact', 'facility_id', 'email', 'is_active', 'study_id']);
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Requester created successfully!']);
    }

    public function editdata($id)
    {
        $requester = Requester::where('id', $id)->first();
        $this->edit_id = $requester->id;
        $this->name = $requester->name;
        $this->contact = $requester->contact;
        $this->email = $requester->email;
        $this->facility_id = $requester->facility_id;
        $this->study_id = $requester->study_id;
        $this->is_active = $requester->is_active;

        $this->studies = Study::where('facility_id', $requester->facility_id)->latest()->get();

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
        $requester = Requester::find($this->edit_id);
        $requester->name = $this->name;
        $requester->contact = $this->contact;
        $requester->email = $this->email;
        $requester->facility_id = $this->facility_id;
        $requester->study_id = $this->study_id == '' ? null : $this->study_id;
        $requester->is_active = $this->is_active;
        $requester->update();

        $this->reset(['name', 'contact', 'facility_id', 'email', 'is_active', 'study_id']);
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Requester updated successfully!']);
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function deleteConfirmation($id)
    {
        $this->delete_id = $id;

        $this->dispatchBrowserEvent('delete-modal');
    }

    public function deleteData()
    {
        try {
            $requester = Requester::where('creator_lab', auth()->user()->laboratory_id)->where('id', $this->delete_id)->first();
            $requester->delete();
            $this->delete_id = '';
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Requester deleted successfully!']);
        } catch(Exception $error) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => 'Requester can not be deleted!']);
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
        $requesters = Requester::whereIn('study_id', auth()->user()->laboratory->associated_studies)->with('facility', 'study')->latest()->get();
        $facilities = Facility::whereIn('id', auth()->user()->laboratory->associated_facilities)->latest()->get();

        return view('livewire.admin.requester-component', compact('requesters', 'facilities'))->layout('layouts.app');
    }
}
