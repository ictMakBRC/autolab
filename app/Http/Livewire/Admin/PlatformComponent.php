<?php

namespace App\Http\Livewire\Admin;

use App\Models\Platform;
use Exception;
use Livewire\Component;

class PlatformComponent extends Component
{
    public $name;

    public $range;

    public $is_active;

    public $delete_id;

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => 'required',
            'is_active' => 'required',

        ]);
    }

    public function storeData()
    {
        $this->validate([
            'name' => 'required',
            'is_active' => 'required',
        ]);

        $platform = new Platform();
        $platform->name = $this->name;
        $platform->range = $this->range;
        $platform->is_active = $this->is_active;
        $platform->save();

        $this->reset(['name', 'range', 'is_active']);
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Platform created successfully!']);
    }

    public function editdata($id)
    {
        $platform = Platform::where('id', $id)->first();
        $this->edit_id = $platform->id;
        $this->name = $platform->name;
        $this->range = $platform->range;
        $this->is_active = $platform->is_active;
        $this->dispatchBrowserEvent('edit-modal');
    }

    public function resetInputs()
    {
        $this->reset(['name', 'range', 'is_active']);
    }

    public function updateData()
    {
        $this->validate([
            'name' => 'required',
            'is_active' => 'required',
        ]);
        $platform = Platform::find($this->edit_id);
        $platform->name = $this->name;
        $platform->range = $this->range;
        $platform->is_active = $this->is_active;
        $platform->update();

        $this->reset(['name', 'range', 'is_active']);
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Platform updated successfully!']);
    }

    public function deleteConfirmation($id)
    {
        $this->delete_id = $id;

        $this->dispatchBrowserEvent('delete-modal');
    }

    public function deleteData()
    {
        try {
            $platform = Platform::where('id', $this->delete_id)->first();
            $platform->delete();
            $this->delete_id = '';
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Platform deleted successfully!']);
        } catch(Exception $error) {
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Platform can not be deleted!']);
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
        $platforms = Platform::latest()->get();

        return view('livewire.admin.platform-component', compact('platforms'))->layout('layouts.app');
    }
}
