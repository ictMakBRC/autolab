<?php

namespace App\Http\Livewire\Admin;

use Exception;
use Livewire\Component;
use App\Models\Facility;

class StudyComponent extends Component
{
    public $name,$type,$parent_id, $description, $is_active,$delete_id;

    public function updated($fields)
    {
        $this->validateOnly($fields,[
            'name'=>'required|unique:facilities',
            'type'=>'required',
            'is_active'=>'required',

        ]);
    }
    
    public function storeData()
    {
        $this->validate([
            'name'=>'required|unique:facilities',
            'type'=>'required',
            'is_active'=>'required',
        ]);
        
        $facility= new Facility();
        $facility->name = $this->name;
        $facility->type = $this->type;
        $facility->parent_id = $this->parent_id;
        $facility->save();
        session()->flash('success', 'Facility created successfully.');
        $this->name="";
        $this->type="";
        $this->parent_id="";
        $this->is_active="";
        $this->dispatchBrowserEvent('close-modal');
    }

    public function editdata($id)
    {  
        $facility= Facility::where('id', $id)->first();
         $this->edit_id = $facility->id;
         $this->name = $facility->name;
         $this->type = $facility->type;
         $this->parent_id = $facility->parent_id;
         $this->is_active = $facility->is_active;
        $this->dispatchBrowserEvent('edit-modal');
    }

    public function resetInputs()
    {
        $this->name="";
        $this->type="";
        $this->parent_id="";
        $this->is_active="";
    }

    public function updateData()
    {
        $this->validate([
            'name'=>'required',
        ]);
        $facility= Facility::find($this->edit_id);
        $facility->name = $this->name;
        $facility->type = $this->type;
        $facility->parent_id = $this->parent_id;
        $facility->is_active = $this->is_active;
        $facility->update();
        session()->flash('success', 'Facility updated successfully.');
        $this->name="";
        $this->type="";
        $this->parent_id="";
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
        $facility= Facility::where('id', $this->delete_id)->first();
        $facility->delete();
        $this->delete_id = '';
        $this->dispatchBrowserEvent('close-modal');
        session()->flash('success', 'Facility deleted successfully.');
        }
        catch(Exception $error){
            session()->flash('erorr', 'Facility can not be deleted !!.');
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
        $facilities = Facility::with('parent')->latest()->get();
        return view('livewire.admin.facility-component',compact('facilities'))->layout('layouts.app');
       
        
    }
}
