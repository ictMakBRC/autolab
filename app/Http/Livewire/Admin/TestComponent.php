<?php

namespace App\Http\Livewire\Admin;

use App\Models\Admin\Test;
use App\Models\TestCategory;
use Livewire\Component;

class TestComponent extends Component
{
    public $category_name;

    public $category_id;

    public $name;

    public $short_code;

    public $price;

    public $reference_range_min;

    public $reference_range_max;

    public $status;

    public $precautions;

    public $result_type;

    public $dynamicResults = [];

    public $absolute_results = [];

    public $dynamicComments = [];

    public $comments = [];

    public $measurable_result_uom;

    public $toggleForm = false;

    public $edit_id;
    // public $delete_id;

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'category_id' => 'required|integer',
            'name' => 'required|string',
            'price' => 'required|numeric',
            'result_type' => 'required|string',
            'status' => 'required|integer',
        ]);
    }

    public function mount()
    {
        $this->dynamicResults = [
            ['result' => 'result'],
        ];

        $this->dynamicComments = [
            ['comment' => 'comment'],
        ];
    }

    public function updatedResultType()
    {
        if ($this->result_type === 'Text' || $this->result_type === 'File') {
            $this->reset(['dynamicResults', 'measurable_result_uom', 'absolute_results']);
        }
    }

    public function addResult()
    {
        $this->dynamicResults[] = ['result' => 'result'];
    }

    public function removeResult($index)
    {
        unset($this->dynamicResults[$index]);
        $this->dynamicResults = array_values($this->dynamicResults);
    }

    public function pushResults()
    {
        $results = [];
        foreach ($this->dynamicResults as $key => $result) {
            if ($result['result'] != 'result') {
                array_push($results, $result['result']);
            }
        }

        return $results;
    }

    public function addComment()
    {
        $this->dynamicComments[] = ['comment' => 'comment'];
    }

    public function removeComment($index)
    {
        unset($this->dynamicComments[$index]);
        $this->dynamicComments = array_values($this->dynamicComments);
    }

    public function pushComments()
    {
        $comments = [];
        foreach ($this->dynamicComments as $key => $comment) {
            if ($comment['comment'] != 'comment') {
                array_push($comments, $comment['comment']);
            }
        }

        return $comments;
    }

    public function storeTest()
    {
        $this->validate([
            'category_id' => 'required|integer',
            'name' => 'required|string',
            'price' => 'required|numeric',
            'result_type' => 'required|string',
        ]);
        $test = new Test();
        $test->category_id = $this->category_id;
        $test->name = $this->name;
        $test->short_code = $this->short_code;
        $test->price = $this->price;
        $test->reference_range_min = $this->reference_range_min;
        $test->reference_range_max = $this->reference_range_max;
        $test->status = $this->status;
        $test->precautions = $this->precautions;
        $test->result_type = $this->result_type;
        $test->absolute_results = count($this->pushResults()) ? $this->pushResults() : null;
        $test->measurable_result_uom = $this->measurable_result_uom;
        $test->comments = count($this->pushComments()) ? $this->pushComments() : null;
        $test->save();

        $this->resetTestInputs();
        session()->flash('success', 'Test created successfully.');
    }

    public function editTest(Test $test)
    {
        $this->edit_id = $test->id;
        $this->category_id = $test->category_id;
        $this->name = $test->name;
        $this->short_code = $test->short_code;
        $this->price = $test->price;
        $this->reference_range_min = $test->reference_range_min;
        $this->reference_range_max = $test->reference_range_max;
        $this->status = $test->status;
        $this->precautions = $test->precautions;
        $this->result_type = $test->result_type;
        $this->measurable_result_uom = $test->measurable_result_uom;

        $this->dynamicResults = [];
        $this->dynamicComments = [];
        if ($test->absolute_results != null) {
            foreach ($test->absolute_results as $key => $result) {
                if (count($test->absolute_results)) {
                    array_push($this->dynamicResults, ['result' => $result]);
                }
            }
        }
        if ($test->comments != null) {
            foreach ($test->comments as $key => $comment) {
                if (count($test->comments)) {
                    array_push($this->dynamicComments, ['comment' => $comment]);
                }
            }
        }

        $this->toggleForm = true;
    }

    public function updateTest()
    {
        $this->validate([
            'category_id' => 'required|integer',
            'name' => 'required|string',
            'price' => 'required|numeric',
            'result_type' => 'required|string',
            'status' => 'required|integer',
        ]);
        $test = Test::find($this->edit_id);
        $test->category_id = $this->category_id;
        $test->name = $this->name;
        $test->short_code = $this->short_code;
        $test->price = $this->price;
        $test->reference_range_min = $this->reference_range_min;
        $test->reference_range_max = $this->reference_range_max;
        $test->status = $this->status;
        $test->precautions = $this->precautions;
        $test->result_type = $this->result_type;
        $test->absolute_results = count($this->pushResults()) ? $this->pushResults() : null;
        $test->measurable_result_uom = $this->measurable_result_uom;
        $test->comments = count($this->pushComments()) ? $this->pushComments() : null;
        $test->update();

        $this->toggleForm = false;
        $this->resetTestInputs();
        session()->flash('success', 'Test updated successfully.');
    }

    public function resetTestInputs()
    {
        $this->reset(['category_id', 'name', 'short_code', 'price', 'reference_range_max', 'reference_range_min', 'status', 'precautions', 'result_type', 'measurable_result_uom', 'dynamicResults', 'absolute_results', 'dynamicComments']);
    }

    public function deleteConfirmation(Test $test)
    {
        $this->delete_id = $test->id;

        $this->dispatchBrowserEvent('delete-modal');
    }

    public function deleteData()
    {
        try {
            $test = Test::where('id', $this->delete_id)->first();
            $test->delete();
            $this->delete_id = '';
            $this->dispatchBrowserEvent('close-modal');
            session()->flash('success', 'Test deleted successfully.');
        } catch(\Exception $error) {
            session()->flash('erorr', 'Test can not be deleted !!.');
        }
    }

    public function cancel()
    {
        $this->delete_id = '';
    }

    public function close()
    {
        $this->toggleForm = false;
        $this->resetTestInputs();
    }

    public function render()
    {
        $tests = Test::latest()->get();
        $testCategories = TestCategory::latest()->get();
        // $this->absolute_results=$this->pushResults();
        // $this->comments=$this->pushComments();
        return view('livewire.admin.test-component', compact('tests', 'testCategories'));
    }
}