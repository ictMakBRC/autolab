<?php

namespace App\Http\Livewire\Admin;

//use App\Models\TestCategory;

use App\Models\TestCategory;
use Livewire\Component;

class TestCategoryComponent extends Component
{
    public $category_name;

    public $description;

    public $edit_id;

    public $delete_id;

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'category_name' => 'required|unique:test_categories',
            'description' => 'required',

        ]);
    }

    public function storeData()
    {
        $this->validate([
            'category_name' => 'required|unique:test_categories',
            'description' => 'required',
        ]);
        $TestCategory = new TestCategory();
        $TestCategory->category_name = $this->category_name;
        $TestCategory->description = $this->description;
        $TestCategory->save();

        $this->description = '';
        $this->category_name = '';
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Test Category data created successfully!']);
    }

    public function editdata($id)
    {
        $TestCategory = TestCategory::where('id', $id)->first();
        $this->edit_id = $TestCategory->id;
        $this->category_name = $TestCategory->category_name;
        $this->description = $TestCategory->description;
        $this->dispatchBrowserEvent('edit-modal');
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function resetInputs()
    {
        $this->description = '';
        $this->category_name = '';
    }

    public function updateData()
    {
        $this->validate([
            'category_name' => 'required|unique:test_categories,category_name,'.$this->edit_id.'',
            'description' => 'required',
        ]);
        $TestCategory = TestCategory::find($this->edit_id);
        $TestCategory->category_name = $this->category_name;
        $TestCategory->description = $this->description;
        $TestCategory->update();

        $this->description = '';
        $this->category_name = '';
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Test Category data updated successfully!']);
    }

    public function deleteConfirmation($id)
    {
        $this->delete_id = $id;

        $this->dispatchBrowserEvent('delete-modal');
    }

    public function deleteData()
    {
        try {
            $TestCategory = TestCategory::where('creator_lab',auth()->user()->laboratory_id)->where('id', $this->delete_id)->first();
            $TestCategory->delete();
            $this->delete_id = '';
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Category data deleted successfully!']);
        } catch(\Exception $error) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => 'Category data can not be deleted!']);
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
        $categories = TestCategory::where('creator_lab',auth()->user()->laboratory_id)->get();

        return view('livewire.admin.test-category', compact('categories'))->layout('layouts.app');
    }
}
