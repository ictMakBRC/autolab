<?php

namespace App\Http\Livewire\Admin;

use App\Models\Admin\Test;
use App\Models\SampleType;
use App\Models\TestCategory;
use App\Models\TestComment;
use App\Models\TestResults;
use App\Models\TestSampleType;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Collection;
use Validator;

class EditTestComponent extends Component
{
    public $test_id, $possible_result, $comment, $sample, $edit_id, $deleteResult_id, $possible_result2, $edit_test_id;

    public  $category_id,
    $name ,
    $short_code,
    $code,
    $price,
    $unit,
    $precautions,
    $reference_range_min,
    $reference_range_max;
    public $testid;

   
    public function mount($id)
    {
                $this->testid = $id;
        $testdata = Test::with('category')->where('id', $id)->first();
        $this->edit_test_id = $testdata->id;
        $this->category_id =$testdata->category_id;
        $this->name = $testdata->name;
        $this->short_code = $testdata->short_code;
        $this->price = $testdata->price;
        $this->unit = $testdata->unit;
        $this->precautions = $testdata->precautions;
        $this->reference_range_min = $testdata->reference_range_min;
        $this->reference_range_max = $testdata->reference_range_max;
       
     }
     public function updated($fields)
     {
         $this->validateOnly($fields,[
            // //'possible_result'=>'required|unique:test_results',
            // 'possible_result' => ['required', 'unique:test_results,test_id,'.$this->testid.',test_id,possible_result,'.$this->possible_result],
            'possible_result' => 'required',
            'comment'=>'required',
            'sample'=>'required',
         ]);
     }

     public function updateData()
     {
         $this->validate([
             'name'=>'required',
             'category_id'=>'required',
         ]);
         $testdata = Test::where('id', $this->edit_test_id)->first();
         $testdata->category_id= $this->category_id;
         $testdata->name = $this->name;
         $testdata->short_code= $this->short_code;
         $testdata->price = $this->price;
         $testdata->unit = $this->unit;
         $testdata->precautions = $this->precautions;
         $testdata->reference_range_min = $this->reference_range_min;
         $testdata->reference_range_max = $this->reference_range_max;
         $testdata->update();
         session()->flash('success', 'Record updated successfully.');
     }

     public function storeResult()
     {
         $this->validate([
            // 'possible_result'=>'required|unique:test_results',
            'possible_result' => 'required|unique:test_results,test_id,' . $this->testid .'',
             //'possible_result' => ['required|unique:test_results,id,' . $this->testid . ',id,possible_result,' . $this->possible_result],
         ]);
         $value = new TestResults();
         $value->possible_result = $this->possible_result;
         $value->test_id = $this->testid;
         $value->save();
         session()->flash('success', 'Record data created successfully.');
         $this->possible_result = '';
     }

     public function storecomment()
     {
         $this->validate([
             'comment'=>'required',
         ]);
         $value = new TestComment();
         $value->comment = $this->comment;
         $value->test_id = $this->testid;
         $value->save();
         session()->flash('success', 'Record data created successfully.');
         $this->comment = '';
     }

     public function deleteComment($id)
     {
         try {
             $value = TestComment::where('id', $id)->first();
             $value->delete();
             session()->flash('success', 'Record deleted successfully.');
         } catch(\Exception $error) {
             session()->flash('erorr', 'Record can not be deleted !!.');
         }
     }

     public function storeSampleType()
     {
         $this->validate([
             'sample' => 'required|unique:test_sample_types,test_id,'.$this->testid.'',
         ]);
         $value = new TestSampleType();
         $value->sample = $this->sample;
         $value->test_id = $this->testid;
         $value->save();
         session()->flash('success', 'Record data created successfully.');
         $this->comment = '';
     }

     public function deletesample($id)
     {
         try {
             $value = TestSampleType::where('id', $id)->first();
             $value->delete();
             session()->flash('success', 'Record deleted successfully.');
         } catch(\Exception $error) {
             session()->flash('erorr', 'Record can not be deleted !!.');
         }
     }

     public function deleteConfirmation($id)
     {
         $this->deleteResult_id = $id; //student id

         $this->dispatchBrowserEvent('delete-modal');
     }

     public function deleteData()
     {
         try {
             $value = TestResults::where('id', $this->deleteResult_id)->first();
             $value->delete();
             $this->deleteResult_id = '';
             $this->dispatchBrowserEvent('close-modal');
             session()->flash('success', 'Record deleted successfully.');
         } catch(\Exception $error) {
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
        $test = Test::with('category')->where('id', $this->testid)->first();

        $testcomments = TestComment::where('test_id', $this->testid)->get();
        $testresults = TestResults::where('test_id', $this->testid)->get();
        $testsampletypes = TestSampleType::where('test_id', $this->testid)->get();
        $sampletypes = SampleType::all();
        $categories = TestCategory::all();

        return view('livewire.admin.edit-test-component', compact('sampletypes', 'categories', 'test', 'testcomments', 'testsampletypes', 'testresults'))->layout('layouts.app');
    }
}
