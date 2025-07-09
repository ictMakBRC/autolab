<?php
namespace App\Http\Livewire\Lab\Reports;

use App\Models\Laboratory;
use App\Models\TestResult;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TestsPerLabReportComponent extends Component
{
    public $startYear;
    public $endYear;
    public $selectedLabs = [];
    public $reportData   = [];
    public $years        = [];
    public $allLabs      = [];
    public $totalTests   = 0;

    public function mount()
    {
        $currentYear     = now()->year;
        $this->startYear = $currentYear - 5;
        $this->endYear   = $currentYear;

        $this->allLabs      = Laboratory::orderBy('laboratory_name')->get();
        $this->selectedLabs = $this->allLabs->pluck('id')->toArray();

        $this->generateReport();
    }

    public function generateReport()
    {
        $this->validate([
            'startYear' => 'required|integer|min:2000|max:2100',
            'endYear'   => 'required|integer|min:' . $this->startYear . '|max:2100',
        ]);

        // Generate all years in range
        $this->years = range($this->startYear, $this->endYear);

        // Get all approved test results grouped by lab and year
        $results = TestResult::query()
            ->select([
                'creator_lab',
                DB::raw('YEAR(approved_at) as year'),
                DB::raw('COUNT(*) as test_count'),
            ])
            ->whereIn('status', ['Approved', 'Reviewed', 'Pending Review'])
        // ->whereNotNull('approved_at')
            ->whereIn('creator_lab', $this->selectedLabs)
            ->whereBetween(DB::raw('YEAR(created_at)'), [$this->startYear, $this->endYear])
            ->groupBy('creator_lab', DB::raw('YEAR(created_at)'))
            ->orderBy('creator_lab')
            ->orderBy('year')
            ->get();

        // Initialize report structure
        $this->reportData = [];
        $this->totalTests = 0;

        // Initialize all labs with all years
        foreach ($this->allLabs as $lab) {
            if (! in_array($lab->id, $this->selectedLabs)) {
                continue;
            }

            $this->reportData[$lab->id] = [
                'name'  => $lab->laboratory_name,
                'years' => array_fill_keys($this->years, 0),
                'total' => 0,
            ];
        }

        // Populate with actual data
        foreach ($results as $result) {
            if (isset($this->reportData[$result->creator_lab]['years'][$result->year])) {
                $this->reportData[$result->creator_lab]['years'][$result->year] = $result->test_count;
                $this->reportData[$result->creator_lab]['total'] += $result->test_count;
                $this->totalTests += $result->test_count;
            }
        }
    }

    public function exportCsv()
    {
        $fileName = 'tests-per-lab-' . now()->format('Ymd-His') . '.csv';
        $headers  = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');

            // Header row
            $header = ['Laboratory'];
            foreach ($this->years as $year) {
                $header[] = $year;
            }
            $header[] = 'Total';
            fputcsv($file, $header);

            // Data rows
            foreach ($this->reportData as $lab) {
                $row = [$lab['name']];
                foreach ($this->years as $year) {
                    $row[] = $lab['years'][$year];
                }
                $row[] = $lab['total'];
                fputcsv($file, $row);
            }

            // Total row
            $totalRow = ['Total'];
            foreach ($this->years as $year) {
                $yearTotal = 0;
                foreach ($this->reportData as $lab) {
                    $yearTotal += $lab['years'][$year];
                }
                $totalRow[] = $yearTotal;
            }
            $totalRow[] = $this->totalTests;
            fputcsv($file, $totalRow);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function render()
    {
        return view('livewire.lab.reports.tests-per-lab-report');
    }
}
