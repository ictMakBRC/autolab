<?php

namespace App\Http\Livewire\Admin;

use Exception;
use Livewire\Component;
use App\Models\Designation;

class DesignationComponent extends Component
{
    public $name, $description, $is_active,$delete_id;

    public function updated($fields)
    {
        $this->validateOnly($fields,[
            'name'=>'required|unique:designations',
            'is_active'=>'required',

        ]);
    }
    
    public function storeData()
    {
        $this->validate([
            'name'=>'required|unique:designations',
        ]);
        
        $designation = new Designation();
        $designation->name = $this->name;
        $designation->description = $this->description;
        $designation->save();
        session()->flash('success', 'Designation created successfully.');
        $this->description="";
        $this->name="";
        $this->dispatchBrowserEvent('close-modal');
    }

    public function editdata($id)
    {  
        $designation = Designation::where('id', $id)->first();
         $this->edit_id = $designation->id;
         $this->name = $designation->name;
         $this->description = $designation->description;
         $this->is_active = $designation->is_active;
        $this->dispatchBrowserEvent('edit-modal');
    }

    public function resetInputs()
    {
        $this->description="";
        $this->name="";
    }

    public function updateData()
    {
        $this->validate([
            'name'=>'required',
        ]);
        $designation = Designation::find($this->edit_id);
        $designation->name = $this->name;
        $designation->description = $this->description;
        $designation->is_active = $this->is_active;
        $designation->update();
        session()->flash('success', 'Designation updated successfully.');
        $this->description="";
        $this->name="";
        $this->is_active="";
        $this->dispatchBrowserEvent('close-modal');
    }



    public function deleteConfirmation($id)
    {
        $this->delete_id = $id; //student id

        $this->dispatchBrowserEvent('delete-modal');
    }

  
    public function deleteData()
    { 
        try{
        $designation = Designation::where('id', $this->delete_id)->first();
        $designation->delete();
        $this->delete_id = '';
        $this->dispatchBrowserEvent('close-modal');
        session()->flash('success', 'Designation deleted successfully.');
        }
        catch(Exception $error){
            session()->flash('erorr', 'Designation can not be deleted !!.');
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
        $designations = Designation::all();
        return view('livewire.admin.designation-component',compact('designations'))->layout('layouts.app');
       
        
    }
}