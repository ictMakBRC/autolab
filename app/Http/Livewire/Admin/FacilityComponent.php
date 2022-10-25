<?php

namespace App\Http\Livewire\Admin;

use App\Models\Facility;
use Exception;
use Livewire\Component;

class FacilityComponent extends Component
{
    public $name;

    public $type;

    public $parent_id;

    public $description;

    public $is_active;

    public $delete_id;

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => 'required|unique:facilities',
            'type' => 'required',
            'is_active' => 'required',

        ]);
    }

    public function storeData()
    {
        $this->validate([
            'name' => 'required|unique:facilities',
            'type' => 'required',
            'is_active' => 'required',
        ]);

        $facility = new Facility();
        $facility->name = $this->name;
        $facility->type = $this->type;
        $facility->parent_id = $this->parent_id;
        $facility->save();

        $this->reset(['name', 'type', 'parent_id', 'is_active']);
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Facility created successfully!']);
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function editdata($id)
    {
        $facility = Facility::where('id', $id)->first();
        $this->edit_id = $facility->id;
        $this->name = $facility->name;
        $this->type = $facility->type;
        $this->parent_id = $facility->parent_id != null ? $facility->parent_id : '';
        $this->is_active = $facility->is_active;
        $this->dispatchBrowserEvent('edit-modal');
    }

    public function resetInputs()
    {
        $this->reset(['name', 'type', 'parent_id', 'is_active']);
    }

    public function updateData()
    {
        $this->validate([
            'name' => 'required',
        ]);
        $facility = Facility::find($this->edit_id);
        $facility->name = $this->name;
        $facility->type = $this->type;
        $facility->parent_id = $this->parent_id != '' ? $this->parent_id : null;
        $facility->is_active = $this->is_active;
        $facility->update();

        $this->reset(['name', 'type', 'parent_id', 'is_active']);
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Facility updated successfully!']);
    }

    public function deleteConfirmation($id)
    {
        $this->delete_id = $id;

        $this->dispatchBrowserEvent('delete-modal');
    }

    public function deleteData()
    {
        try {
            $facility = Facility::where('creator_lab', auth()->user()->laboratory_id)->where('id', $this->delete_id)->first();
            $facility->delete();
            $this->delete_id = '';
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Facility deleted successfully!']);
        } catch(Exception $error) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => 'Facility can not be deleted!']);
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
        $facilities = Facility::where('creator_lab', auth()->user()->laboratory_id)->with('parent')->latest()->get();

        return view('livewire.admin.facility-component', compact('facilities'))->layout('layouts.app');
    }
}
