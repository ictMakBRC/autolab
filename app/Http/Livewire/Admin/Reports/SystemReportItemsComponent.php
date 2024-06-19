<?php

namespace App\Http\Livewire\Admin\Reports;

use App\Models\Admin\SystemReport;
use App\Models\Admin\SystemReportItem;
use Livewire\Component;

class SystemReportItemsComponent extends Component
{
    public $report;
    public $score;
    public $module;
    public $result;
    public $details;
    public function mount($code){
        $this->report = SystemReport::where('ref_code',$code)->first();
    }
    public function storeData()
    {
        $this->validate([
            'module' => 'required',
            'score' => 'required',
            'result' => 'required',
            'details' => 'nullable',
        ]);

        $SystemReport = new SystemReportItem();    
        $SystemReport->system_report_id = $this->report->id;
        $SystemReport->score = $this->score;
        $SystemReport->result = $this->result;
        $SystemReport->module = $this->module;
        $SystemReport->details = $this->details;
        $SystemReport->save();
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Record created successfully!']);
  
    }


    public function resetInputs()
    {
        $this->reset([
            'module',
            'score',
            'result',
            'details',
        ]);
    }
    public function render()
    {
        $data['reportItems'] = SystemReportItem::where('system_report_id',  $this->report->id)->get();
        return view('livewire.admin.reports.system-report-items-component', $data);
    }
}
