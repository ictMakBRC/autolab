<?php

namespace App\Http\Livewire\Admin;

use Exception;
use Livewire\Component;
use App\Models\Facility;
use App\Models\Requester;

class RequesterComponent extends Component
{
    public $name,$email,$facility_id,$contact, $is_active,$delete_id;

    public function updated($fields)
    {
        $this->validateOnly($fields,[
            'name'=>'required',
            'contact'=>'required',
            'email'=>'required|email:filter',
            'facility_id'=>'required',
            'is_active'=>'required',

        ]);
    }
    
    public function storeData()
    {
        $this->validate([
            'name'=>'required',
            'contact'=>'required',
            'email'=>'required|unique:requesters|email:filter',
            'facility_id'=>'required',
            'is_active'=>'required',
        ]);
        
        $requester= new Requester();
        $requester->name = $this->name;
        $requester->contact = $this->contact;
        $requester->email = $this->email;
        $requester->facility_id = $this->facility_id;
        $requester->save();
        session()->flash('success', 'Requester created successfully.');
        $this->reset(['name','contact','facility_id','email','is_active']);
        $this->dispatchBrowserEvent('close-modal');
    }

    public function editdata($id)
    {  
        $requester= Requester::where('id', $id)->first();
         $this->edit_id = $requester->id;
         $this->name = $requester->name;
         $this->contact = $requester->contact;
         $this->email = $requester->email;
         $this->facility_id = $requester->facility_id;
         $this->is_active = $requester->is_active;
        $this->dispatchBrowserEvent('edit-modal');
    }

    public function resetInputs()
    {
        $this->reset(['name','contact','facility_id','email','is_active']);
    }

    public function updateData()
    {
        $this->validate([
            'name'=>'required',
            'contact'=>'required',
            'email'=>'required|email:filter',
            'facility_id'=>'required',
            'is_active'=>'required',
        ]);
        $requester= Requester::find($this->edit_id);
        $requester->name = $this->name;
        $requester->contact = $this->contact;
        $requester->email = $this->email;
        $requester->facility_id = $this->facility_id;
        $requester->is_active = $this->is_active;
        $requester->update();
        session()->flash('success', 'Requester updated successfully.');
        $this->reset(['name','contact','facility_id','email','is_active']);
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
        $requester= Requester::where('id', $this->delete_id)->first();
        $requester->delete();
        $this->delete_id = '';
        $this->dispatchBrowserEvent('close-modal');
        session()->flash('success', 'Requester deleted successfully.');
        }
        catch(Exception $error){
            session()->flash('erorr', 'Requester can not be deleted !!.');
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
        $requesters = Requester::with('facility')->latest()->get();
        $facilities = Facility::latest()->get();
        return view('livewire.admin.requester-component',compact('requesters','facilities'))->layout('layouts.app');
       
        
    }
}
