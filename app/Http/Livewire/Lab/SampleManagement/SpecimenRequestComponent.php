<?php

namespace App\Http\Livewire\Lab\SampleManagement;

use App\Models\Admin\Test;
use App\Models\Collector;
use App\Models\Participant;
use App\Models\Requester;
use App\Models\Sample;
use App\Models\SampleReception;
use App\Models\SampleType;
use App\Models\Study;
use App\Models\TestRequest;
use Carbon\Carbon;
use Exception;
use Livewire\Component;

class SpecimenRequestComponent extends Component
{
    //SPECIAL VARIABLES
    public $batch_no;

    public $facility_id;

    public $batch_sample_count;

    public $batch_samples_handled;

    public $sample_reception_id;

    public $participant_id;

    public $sample_id;

    public $activeParticipantTab = true;

    public $delete_id;

    public $toggleForm = false;

    public $tabToggleBtn = false;

    //PARTICIPANT INFORMATION
    public $identity;

    public $age;

    public $gender;

    public $address;

    public $contact;

    public $nok_contact;

    public $nok_address;

    public $clinical_notes;

    //Optional participant fields

    public $title;

    public $nin_number;

    public $surname;

    public $first_name;

    public $other_name;

    public $dob;

    public $nationality;

    public $district;

    public $email;

    public $birth_place;

    public $religious_affiliation;

    public $occupation;

    public $civil_status;

    public $nok;

    public $nok_relationship;

    //SAMPLE INFORMATION
    public $requested_by;

    public $date_requested;

    public $collected_by;

    public $date_collected;

    public $study_id;

    public $sample_identity;

    public $sample_is_for;

    public $priority;

    public $sample_type_id;

    public $tests_requested = [];

    public $tests;

    public function updated($fields)
    {
        $this->validateOnly($fields, [

            'identity' => 'required|string',
            'age' => 'required|integer|min:1',
            'address' => 'required|string|max:40',
            'gender' => 'required|string|max:6',
            'contact' => 'required|string',
            'nok_contact' => 'required|string',
            'nok_address' => 'required|string|max:40',
            'clinical_notes' => 'string|required',
        ]);
    }

    public function updatedSampleTypeId()
    {
        $this->reset(['tests_requested', 'tests']);
        $sampleType = SampleType::where('id', $this->sample_type_id)->first();
        $this->tests = Test::whereIn('id', (array) $sampleType->possible_tests)->orderBy('name', 'asc')->get();
    }

    public function toggleTab()
    {
        $this->activeParticipantTab = ! $this->activeParticipantTab;
    }

    public function mount($batch)
    {
        $sampleReception = SampleReception::where('batch_no', $batch)->first();
        $this->batch_no = $sampleReception->batch_no;
        $this->sample_reception_id = $sampleReception->id;
        $this->batch_sample_count = $sampleReception->samples_accepted;
        $this->batch_samples_handled = $sampleReception->samples_handled;
        $this->facility_id = $sampleReception->facility_id;

        $this->tests = collect([]);

        if ($this->batch_sample_count == $this->batch_samples_handled) {
            $this->activeParticipantTab = true;
            $this->tabToggleBtn = true;
        }
    }

    public function storeParticipant()
    {
        if ($this->batch_sample_count == $this->batch_samples_handled) {
            $this->activeParticipantTab = true;
            $this->tabToggleBtn = true;

            $this->resetParticipantInputs();
            $this->dispatchBrowserEvent('maximum-reached');
        } else {
            $this->validate([
                'identity' => 'required|string',
                'age' => 'required|integer|min:1',
                'address' => 'required|string|max:40',
                'gender' => 'required|string|max:6',
                'contact' => 'required|string',
                'nok_contact' => 'required|string',
                'nok_address' => 'required|string|max:40',
                'clinical_notes' => 'required|max:1000',
            ]);

            $participant = new Participant();
            $participant->sample_reception_id = $this->sample_reception_id;
            $participant->participant_no = $this->generateParticipantNo();
            $participant->identity = $this->identity;
            $participant->age = $this->age;
            $participant->address = $this->address;
            $participant->gender = $this->gender;
            $participant->contact = $this->contact;
            $participant->nok_contact = $this->nok_contact;
            $participant->nok_address = $this->nok_address;
            $participant->clinical_notes = $this->clinical_notes;

            $participant->title = $this->title;
            $participant->nin_number = $this->nin_number;
            $participant->surname = $this->surname;
            $participant->first_name = $this->first_name;
            $participant->other_name = $this->other_name;
            $participant->nationality = $this->nationality;
            $participant->district = $this->district;
            $participant->dob = $this->dob;
            $participant->birth_place = $this->birth_place;
            $participant->religious_affiliation = $this->religious_affiliation;
            $participant->occupation = $this->occupation;
            $participant->civil_status = $this->civil_status;
            $participant->email = $this->email;
            $participant->nok = $this->nok;
            $participant->nok_relationship = $this->nok_relationship;

            $participant->save();
            $this->participant_id = $participant->id;
            $this->activeParticipantTab = false;

            session()->flash('success', 'Participant Data Recorded successfully.');

            $this->resetParticipantInputs();
        }
    }

    public function editParticipant(Participant $participant)
    {
        $this->identity = $participant->identity;
        $this->age = $participant->age;
        $this->address = $participant->address;
        $this->gender = $participant->gender;
        $this->contact = $participant->contact;
        $this->nok_contact = $participant->nok_contact;
        $this->nok_address = $participant->nok_address;
        $this->clinical_notes = $participant->clinical_notes;

        $this->title = $participant->title;
        $this->nin_number = $participant->nin_number;
        $this->surname = $participant->surname;
        $this->first_name = $participant->first_name;
        $this->other_name = $participant->other_name;
        $this->nationality = $participant->nationality;
        $this->district = $participant->district;
        $this->dob = $participant->dob;
        $this->birth_place = $participant->birth_place;
        $this->religious_affiliation = $participant->religious_affiliation;
        $this->occupation = $participant->occupation;
        $this->civil_status = $participant->civil_status;
        $this->email = $participant->email;
        $this->nok = $participant->nok;
        $this->nok_relationship = $participant->nok_relationship;

        $this->participant_id = $participant->id;
        $this->toggleForm = true;
        $this->activeParticipantTab = true;
    }

    public function updateParticipant()
    {
        $this->validate([
            'identity' => 'required|string',
            'age' => 'required|integer|min:1',
            'address' => 'required|string|max:40',
            'gender' => 'required|string|max:6',
            'contact' => 'required|string',
            'nok_contact' => 'required|string',
            'nok_address' => 'required|string|max:40',
            'clinical_notes' => 'required|max:1000',
        ]);

        $participant = Participant::find($this->participant_id);
        $participant->identity = $this->identity;
        $participant->age = $this->age;
        $participant->address = $this->address;
        $participant->gender = $this->gender;
        $participant->contact = $this->contact;
        $participant->nok_contact = $this->nok_contact;
        $participant->nok_address = $this->nok_address;
        $participant->clinical_notes = $this->clinical_notes;

        $participant->title = $this->title;
        $participant->nin_number = $this->nin_number;
        $participant->surname = $this->surname;
        $participant->first_name = $this->first_name;
        $participant->other_name = $this->other_name;
        $participant->nationality = $this->nationality;
        $participant->district = $this->district;
        $participant->dob = $this->dob;
        $participant->birth_place = $this->birth_place;
        $participant->religious_affiliation = $this->religious_affiliation;
        $participant->occupation = $this->occupation;
        $participant->civil_status = $this->civil_status;
        $participant->email = $this->email;
        $participant->nok = $this->nok;
        $participant->nok_relationship = $this->nok_relationship;
        $participant->update();

        $this->participant_id = $participant->id; //variable needs more review/
        // $this->activeParticipantTab = false;
        $this->toggleForm = false;
        $this->resetParticipantInputs();
        session()->flash('success', 'Participant Data updated successfully.');
    }

    public function setParticipantId(Participant $participant)
    {
        $this->participant_id = $participant->id;
        $this->activeParticipantTab = false;
    }

    public function storeSampleInformation()
    {
        if ($this->batch_sample_count == $this->batch_samples_handled) {
            $this->activeParticipantTab = true;
            $this->tabToggleBtn = true;
            $this->resetParticipantInputs();
            $this->resetSampleInformationInputs();
            $this->dispatchBrowserEvent('maximum-reached');
        } else {
            $this->validate([
                'requested_by' => 'required|integer',
                'date_requested' => 'required|date',
                'collected_by' => 'required|integer',
                'date_collected' => 'required|date',
                'study_id' => 'required|integer',
                'sample_identity' => 'required|string|unique:samples',
                'sample_is_for' => 'required|string',
                'priority' => 'required|string',
                'sample_type_id' => 'integer|required',
                'tests_requested' => 'array|required',
            ]);

            $sample = new Sample();
            $sample->participant_id = $this->participant_id;
            $sample->sample_type_id = $this->sample_type_id;
            $sample->sample_no = $this->generateSampleNo();
            $sample->lab_no = $this->generateSampleNo();
            $sample->requested_by = $this->requested_by;
            $sample->date_requested = $this->date_requested;
            $sample->collected_by = $this->collected_by;
            $sample->date_collected = $this->date_collected;
            $sample->study_id = $this->study_id;
            $sample->sample_identity = $this->sample_identity;
            $sample->sample_is_for = $this->sample_is_for;
            $sample->priority = $this->priority;
            $sample->tests_requested = $this->tests_requested;

            $sample->save();

            // foreach ($this->tests_requested as $test) {
            //     $testRequest = new  TestRequest();
            //     $testRequest->sample_id = $sample->id;
            //     $testRequest->test_id = $test;
            //     $testRequest->result_status = 'Pending';
            //     $testRequest->save();
            // }
            $sampleReception = SampleReception::where('batch_no', $this->batch_no)->first();
            $sampleReception->increment('samples_handled');
            $this->batch_samples_handled = $sampleReception->samples_handled;
            $this->tests_requested = [];

            if ($this->batch_sample_count == $this->batch_samples_handled) {
                $this->activeParticipantTab = true;
                $this->tabToggleBtn = true;
            }
            $this->activeParticipantTab = true;
            $this->resetSampleInformationInputs();
            session()->flash('success', 'Sample Request Data Recorded successfully.');
        }
        // $this->resetParticipantInputs();
    }

    public function editSampleInformation(Sample $sample)
    {
        $this->sample_id = $sample->id;
        $this->sample_type_id = $sample->sample_type_id;
        $this->requested_by = $sample->requested_by;
        $this->date_requested = $sample->date_requested;
        $this->collected_by = $sample->collected_by;
        $this->date_collected = $sample->date_collected;
        $this->study_id = $sample->study_id;
        $this->sample_identity = $sample->sample_identity;
        $this->sample_is_for = $sample->sample_is_for;
        $this->priority = $sample->priority;
        $this->tests_requested = $sample->tests_requested ?? [];

        $sampleType = SampleType::where('id', $sample->sample_type_id)->first();
        $this->tests = Test::whereIn('id', (array) $sampleType->possible_tests)->orderBy('name', 'asc')->get();

        $this->toggleForm = true;
        $this->activeParticipantTab = false;
    }

    public function updateSampleInformation()
    {
        $this->validate([
            'requested_by' => 'required|integer',
            'date_requested' => 'required|date',
            'collected_by' => 'required|integer',
            'date_collected' => 'required|date',
            'study_id' => 'required|integer',
            'sample_identity' => 'required',
            'sample_is_for' => 'required|string',
            'priority' => 'required|string',
            'sample_type_id' => 'integer|required',
            'tests_requested' => 'array|required',
        ]);

        $sample = Sample::find($this->sample_id);
        $sample->sample_type_id = $this->sample_type_id;
        $sample->requested_by = $this->requested_by;
        $sample->date_requested = $this->date_requested;
        $sample->collected_by = $this->collected_by;
        $sample->date_collected = $this->date_collected;
        $sample->study_id = $this->study_id;
        $sample->sample_identity = $this->sample_identity;
        $sample->sample_is_for = $this->sample_is_for;
        $sample->priority = $this->priority;
        $sample->tests_requested = $this->tests_requested ?? [];
        $sample->update();

        $this->resetSampleInformationInputs();
        $this->resetParticipantInputs();
        $this->toggleForm = false;
        $this->activeParticipantTab = true;
        session()->flash('success', 'Sample Data updated successfully.');
    }

    public function resetParticipantInputs()
    {
        $this->reset(['identity', 'age', 'gender', 'contact', 'address',
            'nok_contact', 'nok_address', 'clinical_notes', 'title', 'nin_number', 'surname', 'first_name',
            'other_name', 'nationality', 'district', 'dob', 'email', 'birth_place', 'religious_affiliation',
            'occupation', 'civil_status', 'nok', 'nok_relationship', ]);
    }

    public function resetSampleInformationInputs()
    {
        $this->reset(['sample_id', 'participant_id', 'sample_type_id', 'sample_identity', 'requested_by',
            'date_requested', 'collected_by', 'date_collected', 'study_id', 'sample_is_for', 'priority', 'tests_requested', ]);
    }

    public function deleteConfirmation($id)
    {
        $this->delete_id = $id;
        $this->dispatchBrowserEvent('delete-modal');
    }

    public function deleteData()
    {
        try {
            $participant = Participant::where('id', $this->delete_id)->first();
            $participant->delete();
            $this->delete_id = '';
            $this->dispatchBrowserEvent('close-modal');
            session()->flash('success', 'Participant deleted successfully.');
        } catch(Exception $error) {
            session()->flash('erorr', 'Participant can not be deleted!.');
        }
    }

    public function cancel()
    {
        $this->delete_id = '';
    }

    public function close()
    {
        $this->resetParticipantInputs();
        $this->resetSampleInformationInputs();
        $this->tests = collect([]);
        $this->toggleForm = false;
        $this->activeParticipantTab = true;
    }

    public function generateParticipantNo()
    {
        $participant_no = '';
        $yearStart = Carbon::now();
        $latestParticipantNo = Participant::select('participant_no')->orderBy('id', 'desc')->first();

        if ($latestParticipantNo) {
            $participantNumberSplit = explode('-', $latestParticipantNo->participant_no);
            $participantNumberYear = (int) filter_var($participantNumberSplit[0], FILTER_SANITIZE_NUMBER_INT);

            if ($participantNumberYear == $yearStart->year) {
                $participant_no = $participantNumberSplit[0].'-'.((int) filter_var($participantNumberSplit[1], FILTER_SANITIZE_NUMBER_INT) + 1).'P';
            } else {
                $participant_no = 'BRC'.$yearStart->year.'-100P';
            }
        } else {
            $participant_no = 'BRC'.$yearStart->year.'-100P';
        }

        return $participant_no;
    }

    public function generateSampleNo()
    {
        $sample_no = '';
        $yearStart = Carbon::now();
        $latestSampleNo = Sample::select('sample_no')->orderBy('id', 'desc')->first();

        if ($latestSampleNo) {
            $sampleNumberSplit = explode('-', $latestSampleNo->sample_no);
            $sampleNumberYear = (int) filter_var($sampleNumberSplit[0], FILTER_SANITIZE_NUMBER_INT);

            if ($sampleNumberYear == $yearStart->year) {
                $sample_no = $sampleNumberSplit[0].'-'.((int) filter_var($sampleNumberSplit[1], FILTER_SANITIZE_NUMBER_INT) + 1).'S';
            } else {
                $sample_no = 'PTSP'.$yearStart->year.'-100S';
            }
        } else {
            $sample_no = 'PTSP'.$yearStart->year.'-100S';
        }

        return $sample_no;
    }

    public function render()
    {
        $collectors = Collector::where('facility_id', $this->facility_id)->orderBy('name', 'asc')->get();
        $requesters = Requester::where('facility_id', $this->facility_id)->orderBy('name', 'asc')->get();
        $studies = Study::where('facility_id', $this->facility_id)->orderBy('name', 'asc')->get();
        $sampleTypes = SampleType::orderBy('type', 'asc')->get();
        $participants = Participant::with(['sample','sample.sampleType:id,type','sample.study:id,name','sample.requester:id,name','sample.collector:id,name'])->where('sample_reception_id', $this->sample_reception_id)->latest()->get();

        return view('livewire.lab.sample-management.specimen-request-component', compact('sampleTypes', 'collectors', 'studies', 'requesters', 'participants'))->layout('layouts.app');
    }
}