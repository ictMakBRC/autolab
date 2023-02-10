<?php

namespace App\Http\Controllers;

use PDF;
use GuzzleHttp\Client;
use App\Models\TestResult;
use Illuminate\Support\Facades\Response;

class ResultReportController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TestResults  $testResults
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $testResult = TestResult::with(['test', 'sample', 'kit','sample.participant', 'sample.sampleReception', 'sample.sampleType:id,type', 'sample.study:id,name', 'sample.requester', 'sample.collector:id,name'])->where('id', $id)->first();
        //return View('reports.sample-management.downloadReport', compact('testResult'));
        $pdf = PDF::loadView('reports.sample-management.downloadReport', compact('testResult'));
        $pdf->setPaper('a4', 'portrait');   //horizontal
        $pdf->getDOMPdf()->set_option('isPhpEnabled', true);

        return  $pdf->stream($testResult->sample->participant->identity.rand().'.pdf');


        // return $pdf->download($testResult->sample->participant->identity.rand().'.pdf');
    }

    public function print($id)
    {
        $testResult = TestResult::with(['test', 'sample', 'kit','sample.participant', 'sample.sampleReception', 'sample.sampleType:id,type', 'sample.study:id,name', 'sample.requester', 'sample.collector:id,name'])->where('id', $id)->first();
        //return View('reports.sample-management.downloadReport', compact('testResult'));
        return View('reports.sample-management.print-report', compact('testResult'));
       
    }

    public function download($id)
    {
        $result = TestResult::findOrFail($id);
        $file = storage_path('app/').$result->attachment;

        if (file_exists($file)) {
            return Response::download($file);
        } else {
            echo 'File not found.';
        }
    }

    public function getCrsPatient()
    {
        $endpoint = "http://crs.brc.online/api/get-patient/";
        $client = new Client();
        $patient_no = 'BRC-10118P';
        $token = "ABC";

        $response = $client->request('GET', $endpoint, ['query' => [
        'pat_no' => $patient_no,
        // 'key2' => $value,
        ]]);
 
       
        $participant = json_decode($response->getBody(), true);

        foreach  ($participant as $value){
            return $value['given_name'];
        }
        
    }
}
