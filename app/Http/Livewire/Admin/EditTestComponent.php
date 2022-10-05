<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Admin\Test;
use App\Models\SampleType;
use App\Models\TestCategory;
use App\Models\TestComment;
use App\Models\TestResults;
use App\Models\TestSampleType;
use Illuminate\Database\Eloquent\Collection;

class EditTestComponent extends Component
{
    public $test_id, $possible_result, $comment, $sample, $edit_id, $deleteResult_id, $possible_result2;

    public $header = 'New Order';
    public $testid;
   
    public function mount($id)
    {
        $this->testid = $id;
       
     }
     public function updated($fields)
     {
         $this->validateOnly($fields,[
            'possible_result'=>'required|unique:test_results',
            'comment'=>'required|unique:test_comments',
            'sample'=>'required|unique:test_sample_types',
         ]);
     }
     public function updateData()
     {
         $this->validate([
             'sample_name'=>'required|unique:sample_types,sample_name,'.$this->edit_id.'',
             'status'=>'required',
         ]);
         $TestCategory = Test::find($this->edit_id);
         $TestCategory->sample_name = $this->sample_name;
         $TestCategory->status = $this->status;
         $TestCategory->update();
         session()->flash('success', 'Rcord updated successfully.');
         $this->status="";
         $this->sample_name="";
         $this->dispatchBrowserEvent('close-modal');
     }
     public function storeResult()
     {
         $this->validate([
             'possible_result'=>'required|unique:test_results',
         ]);
         $value = new TestResults();
         $value->possible_result = $this->possible_result;
         $value->test_id = $this->testid;
         $value->save();
         session()->flash('success', 'Record data created successfully.');
         $this->possible_result="";
     }
     public function storecomment()
     {
         $this->validate([
             'comment'=>'required|unique:test_comments',
         ]);
         $value = new TestComment();
         $value->comment = $this->comment;
         $value->test_id = $this->testid;
         $value->save();
         session()->flash('success', 'Record data created successfully.');
         $this->comment="";
     }

     public function deleteComment($id)
     {
        try{
            $value = TestComment::where('id', $id)->first();
            $value->delete();
            session()->flash('success', 'Record deleted successfully.');
            }
            catch(\Exception $error){
                session()->flash('erorr', 'Record can not be deleted !!.');
            }
     }

     public function storeSampleType()
     {
         $this->validate([
             'sample'=>'required|unique:test_sample_types,test_id,'.$this->testid.'',
         ]);
         $value = new TestSampleType();
         $value->sample = $this->sample;
         $value->test_id = $this->testid;
         $value->save();
         session()->flash('success', 'Record data created successfully.');
         $this->comment="";
     }

     public function deletesample($id)
     {
        try{
            $value = TestSampleType::where('id', $id)->first();
            $value->delete();
            session()->flash('success', 'Record deleted successfully.');
            }
            catch(\Exception $error){
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
         try{
         $value = TestResults::where('id', $this->deleteResult_id)->first();
         $value->delete();
         $this->deleteResult_id = '';
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
        $test = Test::with('category')->where('id', $this->testid)->first();
        $testcomments = TestComment::where('test_id', $this->testid)->get();
        $testresults = TestResults::where('test_id', $this->testid)->get();
        $testsampletypes = TestSampleType::where('test_id', $this->testid)->get();
        $sampletypes = SampleType::all();
        $categories = TestCategory::all();
        return view('livewire.admin.edit-test-component',compact('sampletypes','categories','test','testcomments','testsampletypes','testresults'))->layout('layouts.app');;
    }
}
