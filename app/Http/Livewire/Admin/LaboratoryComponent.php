<?php

namespace App\Http\Livewire\Admin;

use Exception;
use Livewire\Component;
use App\Models\Laboratory;

class LaboratoryComponent extends Component
{
    public $laboratory_name,$short_code, $description, $is_active,$delete_id;

    public function updated($fields)
    {
        $this->validateOnly($fields,[
            'laboratory_name'=>'required|unique:laboratories',
            'is_active'=>'required',

        ]);
    }
    
    public function storeData()
    {
        $this->validate([
            'laboratory_name'=>'required|unique:laboratories',
            'short_code'=>'unique:laboratories',
        ]);
        
        $laboratory = new Laboratory();
        $laboratory->laboratory_name = $this->laboratory_name;
        $laboratory->short_code = $this->short_code;
        $laboratory->description = $this->description;
        $laboratory->save();
        session()->flash('success', 'Laboratory created successfully.');
        $this->description="";
        $this->laboratory_name="";
        $this->short_code="";
        $this->dispatchBrowserEvent('close-modal');
    }

    public function editdata($id)
    {  
        $laboratory = Laboratory::where('id', $id)->first();
         $this->edit_id = $laboratory->id;
         $this->laboratory_name = $laboratory->laboratory_name;
         $this->short_code = $laboratory->short_code;
         $this->description = $laboratory->description;
         $this->is_active = $laboratory->is_active;
        $this->dispatchBrowserEvent('edit-modal');
    }

    public function resetInputs()
    {
        $this->description="";
        $this->laboratory_name="";
    }

    public function updateData()
    {
        $this->validate([
            'laboratory_name'=>'required',
        ]);
        $laboratory = Laboratory::find($this->edit_id);
        $laboratory->laboratory_name = $this->laboratory_name;
        $laboratory->short_code = $this->short_code;
        $laboratory->description = $this->description;
        $laboratory->is_active = $this->is_active;
        $laboratory->update();
        session()->flash('success', 'Laboratory updated successfully.');
        $this->description="";
        $this->laboratory_name="";
        $this->short_code="";
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
        $laboratory = Laboratory::where('id', $this->delete_id)->first();
        $laboratory->delete();
        $this->delete_id = '';
        $this->dispatchBrowserEvent('close-modal');
        session()->flash('success', 'Laboratory deleted successfully.');
        }
        catch(Exception $error){
            session()->flash('erorr', 'Laboratory can not be deleted !!.');
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
        $laboratories = Laboratory::latest()->get();
        return view('livewire.admin.laboratory-component',compact('laboratories'))->layout('layouts.app');
       
        
    }
}
