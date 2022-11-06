<?php

namespace App\Http\Livewire\Admin;

use App\Models\Facility;
use App\Models\Laboratory;
use App\Models\Study;
use Exception;
use Livewire\Component;

class StudyComponent extends Component
{
    public $name;

    public $description;

    public $facility_id;

    public $associated_studies;

    public $is_active;

    public $delete_id;

    public $edit_id;

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => 'required|unique:studies',
            'facility_id' => 'required',
            'is_active' => 'required',

        ]);
    }

    public function mount()
    {
        $this->associated_studies = auth()->user()->laboratory->associated_studies ?? [];
    }

    public function storeData()
    {
        $this->validate([
            'name' => 'required|unique:studies',
            'facility_id' => 'required',
            'is_active' => 'required',
        ]);

        $study = new Study();
        $study->name = $this->name;
        $study->description = $this->description;
        $study->facility_id = $this->facility_id;
        $study->save();

        $this->reset(['name', 'description', 'facility_id', 'is_active']);
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Study/Project created successfully!']);
    }

    public function editdata($id)
    {
        $study = Study::where('id', $id)->first();
        $this->edit_id = $study->id;
        $this->name = $study->name;
        $this->description = $study->description;
        $this->facility_id = $study->facility_id;
        $this->is_active = $study->is_active;
        $this->dispatchBrowserEvent('edit-modal');
    }

    public function resetInputs()
    {
        $this->reset(['name', 'description', 'facility_id', 'is_active']);
    }

    public function updateData()
    {
        $this->validate([
            'name' => 'required',
        ]);
        $study = Study::find($this->edit_id);
        $study->name = $this->name;
        $study->description = $this->description;
        $study->facility_id = $this->facility_id;
        $study->is_active = $this->is_active;
        $study->update();

        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Study/Project updated successfully!']);
        $this->reset(['name', 'description', 'facility_id', 'is_active']);
        $this->dispatchBrowserEvent('close-modal');
    }

    public function associateStudy()
    {
        $this->validate([
            'associated_studies' => 'required',
        ]);
        $laboratory = Laboratory::find(auth()->user()->laboratory_id);
        $laboratory->associated_studies = $this->associated_studies;
        $laboratory->update();

        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Laboratory Information successfully updated!']);
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
            $study = Study::where('creator_lab', auth()->user()->laboratory_id)->where('id', $this->delete_id)->first();
            $study->delete();
            $this->delete_id = '';
            $this->dispatchBrowserEvent('close-modal');
            session()->flash('success', 'Study/Project deleted successfully.');
        } catch(Exception $error) {
            session()->flash('erorr', 'Study/Project can not be deleted.');
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
        $studies = Study::with('facility')->whereIn('facility_id', auth()->user()->laboratory->associated_facilities)->where('is_active', 1)->latest()->get();
        $facilities = Facility::whereIn('id', auth()->user()->laboratory->associated_facilities)->where('is_active', 1)->latest()->get();

        return view('livewire.admin.study-component', compact('studies', 'facilities'))->layout('layouts.app');
    }
}
