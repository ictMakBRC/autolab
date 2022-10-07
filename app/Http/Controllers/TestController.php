<?php

namespace App\Http\Controllers;

//use Barryvdh\DomPDF\Facade as PDF;
use App\Models\Admin\Test;
use App\Models\SampleType;
use App\Models\TestComment;
use App\Models\TestResults;
use App\Models\TestCategory;
use Illuminate\Http\Request;
use App\Models\TestSampleType;
Use PDF;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tests = Test::with('category')->get();

        return view('super-admin.tests.index', compact('tests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = TestCategory::all();
        $sampletypes = SampleType::where('status', 1)->get();

        return view('super-admin.tests.create', compact('categories', 'sampletypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $request->validate([
            'category_id' => 'required',
            'name'=>'required|unique:tests',
            'unit'=> 'required',
            'precautions'=> 'required',

         ]);

        $test = Test::create([
            'category_id' => $request['category_id'],
            'name' => $request['name'],
            'short_code' => $request['shortcut'],
            'code' => time(),
            'price' => $request['price'],
            'unit' => $request['type'],
            'precautions' => $request['precautions'],
            'reference_range_min' => $request['reference_range_min'],
            'reference_range_max' => $request['reference_range_max'],
            'parent_id' => 0,
        ]);
        foreach ($request->comments as $value) {
            $comment = $value;
            $value = new  TestComment();
            $value->comment = $comment;
            $value->test_id = $test['id'];
            $value->save();
        }
        foreach ($request->input('sample_type') as $value) {
            $sample = $value;
            $value = new  TestSampleType();
            $value->sample = $sample;
            $value->test_id = $test['id'];
            $value->save();
        }
        if ($request->type == 'Absolute') {
            foreach ($request->results as $value) {
                $result = $value;
                $value = new  TestResults();
                $value->possible_result = $result;
                $value->test_id = $test['id'];
                $value->save();
            }
        }

        if ($request->type == 'Measurable') {
            $value = new  TestResults();
            $value->possible_result = 'Measurable';
            $value->uom = $request->uom;
            $value->test_id = $test['id'];
            $value->save();
        }

        return redirect()->route('tests.index')->with('success', 'New test has been added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $pdf = PDF::loadView('user.sample-management.downloadReport');
        // $pdf = \App::make('dompdf.wrapper');     
         $pdf->getDOMPdf()->set_option('isPhpEnabled', true); 
         return $pdf->download(rand().'.pdf');
        return view('user.sample-management.downloadReport');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function edit(Test $test)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Test $test)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function destroy(Test $test)
    {
        //
    }
}
