<?php

namespace App\Http\Livewire\Admin;

use App\Models\Kit;
use App\Models\Platform;
use Exception;
use Livewire\Component;

class KitComponent extends Component
{
    public $name;

    public $platform_id;

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

        $kit = new Kit();
        $kit->name = $this->name;
        $kit->platform_id = $this->platform_id;
        $kit->is_active = $this->is_active;
        $kit->save();
        session()->flash('success', 'Kit created successfully.');
        $this->reset(['name', 'platform_id', 'is_active']);
        $this->dispatchBrowserEvent('close-modal');
    }

    public function editdata($id)
    {
        $kit = Kit::where('id', $id)->first();
        $this->edit_id = $kit->id;
        $this->name = $kit->name;
        $this->platform_id = $kit->platform_id;
        $this->is_active = $kit->is_active;
        $this->dispatchBrowserEvent('edit-modal');
    }

    public function resetInputs()
    {
        $this->reset(['name', 'platform_id', 'is_active']);
    }

    public function updateData()
    {
        $this->validate([
            'name' => 'required',
            'is_active' => 'required',
        ]);
        $kit = Kit::find($this->edit_id);
        $kit->name = $this->name;
        $kit->platform_id = $this->platform_id;
        $kit->is_active = $this->is_active;
        $kit->update();
        session()->flash('success', 'Kit updated successfully.');
        $this->reset(['name', 'platform_id', 'is_active']);
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
            $kit = Kit::where('id', $this->delete_id)->first();
            $kit->delete();
            $this->delete_id = '';
            $this->dispatchBrowserEvent('close-modal');
            session()->flash('success', 'Kit deleted successfully.');
        } catch(Exception $error) {
            session()->flash('erorr', 'Kit can not be deleted !!.');
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
        $kits = Kit::with('platform')->latest()->get();
        $platforms = Platform::latest()->get();

        return view('livewire.admin.kit-component', compact('kits', 'platforms'))->layout('layouts.app');
    }
}
