<?php

namespace App\Http\Livewire\Lab\SampleManagement;

use App\Models\User;
use App\Models\Courier;
use Livewire\Component;
use App\Models\Facility;

class SampleReceptionComponent extends Component
{
    public $batch_no;

    public $date_delivered;

    public $delivered;

    public $facility_id;

    public $courier_id;

    public $courier_contact;

    public $accepted;

    public $rejected;

    public $rejection_reason;

    public $courier_signed;

    public $received_by;

    public $date_received;

    public function render()
    {
        $users = User::latest()->get();
        $facilities = Facility::latest()->get();
        $couriers = Courier::latest()->get();

        return view('livewire.lab.sample-management.sample-reception-component', compact('users', 'facilities','couriers'))->layout('layouts.app');
    }
}
