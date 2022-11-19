<?php

namespace App\Http\Controllers;

use App\Models\Sample;
use App\Models\Participant;
use App\Models\SampleReception;

class SearchResultsController extends Controller
{
    public function batchSearchResults(SampleReception $sampleReception)
    {
        $sampleReception->load(['facility','courier','receiver','reviewer','sample','sample.participant',
        'sample.sampleType','sample.requester','sample.collector','sample.study','sample.testResult',]);
        return view('user.sample-management.batch-details', compact('sampleReception'));
    }

    public function sampleSearchResults(Sample $sample)
    {
        $sample->load(['sampleReception.facility','sampleReception.courier','sampleReception.receiver','sampleReception.reviewer','participant',
        'sampleType','requester','collector','study','testResult',]);
        return view('user.sample-management.sample-details', compact('sample'));
    }

    public function participantSearchResults(Participant $participant)
    {
        $participant->load(['facility','study','sample','sample.sampleType','sample.requester','sample.collector','sample.study','sample.testResult',]);
        return view('user.sample-management.participant-details', compact('participant'));
    }

}
