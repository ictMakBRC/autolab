<?php

namespace App\Http\Livewire\Admin;

//use App\Models\TestCategory;

use App\Models\TestCategory;
use Livewire\Component;

class TestCategoryComponent extends Component
{
    public $category_name, $description, $TestCategory_edit_id,$TestCategory_delete_id;

    public function updated($fields)
    {
        $this->validateOnly($fields,[
            'category_name'=>'required',
            'description'=>'required',

        ]);
    }
    public function storeData()
    {
        $this->validate([
            'category_name'=>'required',
            'description'=>'required',
        ]);
        $TestCategory = new TestCategory();
        $TestCategory->category_name = $this->category_name;
        $TestCategory->description = $this->description;
        $TestCategory->save();
        session()->flash('success', 'TestCategory data created successfully.');
        $this->description="";
        $this->category_name="";
        $this->dispatchBrowserEvent('close-modal');
    }
    public function editTestCategorys($id)
    {  
        $TestCategory = TestCategory::where('id', $id)->first();
        $TestCategory->category_name = $this->category_name;
        $TestCategory->description = $this->description;
        $this->dispatchBrowserEvent('edit-modal');
    }
    public function resetInputs()
    {
        $this->description="";
        $this->category_name="";
    }
    public function editTestCategoryData()
    {
        $this->validate([
            'category_name'=>'required',
            'description'=>'required',
        ]);
        $TestCategory = TestCategory::find($this->TestCategory_edit_id);
        $TestCategory->category_name = $this->category_name;
        $TestCategory->description = $this->description;
        $TestCategory->update();
        session()->flash('success', 'TestCategory data updated successfully.');
        $this->description="";
        $this->category_name="";
        $this->dispatchBrowserEvent('close-modal');
    }

    public function deleteConfirm($id)
    {
        
        $this->TestCategory_delete_id = $id;
        $this->dispatchBrowserEvent('delete-modal');
    }
    public function deleteTestCategoryData()
    {
        $TestCategory = TestCategory::find($this->TestCategory_delete_id);
        $TestCategory->delete();
        $this->dispatchBrowserEvent('close-modal');
        session()->flash('success', 'TestCategory data deleted successfully.');

    }
    public function render()
    {
        $categories = TestCategory::all();
        return view('livewire.admin.test-category', compact('categories'))->layout('layouts.app');
    }
}

