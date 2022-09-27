<?php

namespace App\Http\Livewire\Admin;

//use App\Models\TestCategory;

use App\Models\TestCategory;
use Livewire\Component;

class TestCategoryComponent extends Component
{
    public $category_name, $description, $edit_id,$delete_id;

    public function updated($fields)
    {
        $this->validateOnly($fields,[
            'category_name'=>'required|unique:test_categories',
            'description'=>'required',

        ]);
    }
    
    public function storeData()
    {
        $this->validate([
            'category_name'=>'required|unique:test_categories',
            'description'=>'required',
        ]);
        $TestCategory = new TestCategory();
        $TestCategory->category_name = $this->category_name;
        $TestCategory->description = $this->description;
        $TestCategory->save();
        session()->flash('success', 'Test Category data created successfully.');
        $this->description="";
        $this->category_name="";
        $this->dispatchBrowserEvent('close-modal');
    }
    public function editdata($id)
    {  
        $TestCategory = TestCategory::where('id', $id)->first();
         $this->edit_id = $TestCategory->id;
         $this->category_name = $TestCategory->category_name;
         $this->description = $TestCategory->description;
        $this->dispatchBrowserEvent('edit-modal');
    }
    public function resetInputs()
    {
        $this->description="";
        $this->category_name="";
    }
    public function updateData()
    {
        $this->validate([
            'category_name'=>'required|unique:test_categories,category_name,'.$this->edit_id.'',
            'description'=>'required',
        ]);
        $TestCategory = TestCategory::find($this->edit_id);
        $TestCategory->category_name = $this->category_name;
        $TestCategory->description = $this->description;
        $TestCategory->update();
        session()->flash('success', 'Test Category data updated successfully.');
        $this->description="";
        $this->category_name="";
        $this->dispatchBrowserEvent('close-modal');
    }



    public function deleteConfirmation($id)
    {
        $this->delete_id = $id; //student id

        $this->dispatchBrowserEvent('delete-modal');
    }

  
    public function deleteData()
    {
        $TestCategory = TestCategory::where('id', $this->delete_id)->first();
        $TestCategory->delete();
        $this->delete_id = '';
        $this->dispatchBrowserEvent('close-modal');
        session()->flash('success', 'Category data deleted successfully.');

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
        $categories = TestCategory::all();
        return view('livewire.admin.test-category', compact('categories'))->layout('layouts.app');
    }
}

