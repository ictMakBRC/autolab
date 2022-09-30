<?php

namespace App\Http\Livewire\Admin;

use App\Models\SampleType;
use Livewire\Component;

class SampleTypeComponent extends Component
{
    public $sample_name,$status, $edit_id,$delete_id;

    public function updated($fields)
    {
        $this->validateOnly($fields,[
            'sample_name'=>'required|unique:sample_types',

        ]);
    }
    
    public function storeData()
    {
        $this->validate([
            'sample_name'=>'required|unique:sample_types',
        ]);
        $TestCategory = new SampleType();
        $TestCategory->sample_name = $this->sample_name;
        $TestCategory->save();
        session()->flash('success', 'Record data created successfully.');
        $this->status="";
        $this->sample_name="";
        $this->dispatchBrowserEvent('close-modal');
    }
    public function editdata($id)
    {  
        $TestCategory = SampleType::where('id', $id)->first();
         $this->edit_id = $TestCategory->id;
         $this->sample_name = $TestCategory->sample_name;
        $this->dispatchBrowserEvent('edit-modal');
    }
    public function resetInputs()
    {
        $this->status="";
        $this->sample_name="";
    }
    public function updateData()
    {
        $this->validate([
            'sample_name'=>'required|unique:sample_types,sample_name,'.$this->edit_id.'',
            'status'=>'required',
        ]);
        $TestCategory = SampleType::find($this->edit_id);
        $TestCategory->sample_name = $this->sample_name;
        $TestCategory->status = $this->status;
        $TestCategory->update();
        session()->flash('success', 'Rcord updated successfully.');
        $this->status="";
        $this->sample_name="";
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
        $value = SampleType::where('id', $this->delete_id)->first();
        $value->delete();
        $this->delete_id = '';
        $this->dispatchBrowserEvent('close-modal');
        session()->flash('success', 'Record deleted successfully.');
        }
        catch(\Exception $error){
            session()->flash('erorr', 'Record can not be deleted !!.');
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
        $sampletypes = SampleType::all();
        return view('livewire.admin.sample-type-component', compact('sampletypes'))->layout('layouts.app');
    }
}

