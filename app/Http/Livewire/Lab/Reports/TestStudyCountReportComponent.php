<?php
namespace App\Http\Livewire\Lab\Reports;

use App\Models\Admin\Test;
use App\Models\Sample;
use App\Models\Study;
use Carbon\Carbon;
use Livewire\Component;

class TestStudyCountReportComponent extends Component
{
    public $startDate;
    public $endDate;
    public $selectedTests = [];
    public $selectedStudy;
    public $showZeroCounts = false;
    public $tests          = [];
    public $studies        = [];
    public $reportData     = [];
    public $quarterColumns = [];
    public $quarterTotals  = [];
    public $reportType     = 'test_count'; // 'test_count' or 'study_count'
    public $chartType      = 'bar';
    public $chartTitle     = 'Tests Requested Per Quarter';

    public function mount()
    {
        $this->tests   = Test::orderBy('name')->get();
        $this->studies = Study::orderBy('name')->get();

        // Set default date range to current year
        $this->startDate = now()->startOfYear()->format('Y-m-d');
        $this->endDate   = now()->endOfYear()->format('Y-m-d');
    }

    public function generateReport()
    {
        $this->validate([
            'startDate' => 'required|date',
            'endDate'   => 'required|date|after_or_equal:startDate',
        ]);

        $query = Sample::query()
            ->where('creator_lab', auth()->user()->laboratory_id)
            ->where('sample_is_for', 'Testing')
            ->whereDate('date_collected', '>=', $this->startDate)
            ->whereDate('date_collected', '<=', $this->endDate)
            ->whereNotNull('tests_requested');

        // Apply study filter
        if ($this->selectedStudy) {
            $query->where('study_id', $this->selectedStudy);
        }

        $samples = $query->get();

        // Initialize report structure
        $this->quarterColumns = $this->getQuarterColumns();
        $this->quarterTotals  = array_fill_keys($this->quarterColumns, 0);
        $report               = [];
        $testTotals           = [];

        // Initialize all tests with zero counts for all quarters
        foreach ($this->tests as $test) {
            $report[$test->id] = [
                'name'        => $test->name,
                'quarters'    => array_fill_keys($this->quarterColumns, 0),
                'study_count' => array_fill_keys($this->quarterColumns, [])
            ];
        }

        // Process samples
        foreach ($samples as $sample) {
            $testIds        = $sample->tests_requested;
            $collectionDate = Carbon::parse($sample->date_collected);
            $quarter        = 'Q' . $collectionDate->quarter . ' ' . $collectionDate->year;
            $studyId        = $sample->study_id;

            // Skip if quarter not in our columns
            if (! in_array($quarter, $this->quarterColumns)) {
                continue;
            }

            foreach ($testIds as $testId) {
                // Apply test filter
                if (! empty($this->selectedTests)) {
                    if (! in_array($testId, $this->selectedTests)) {
                        continue;
                    }
                }

                if (isset($report[$testId])) {
                    // For test count report
                    $report[$testId]['quarters'][$quarter]++;
                    $this->quarterTotals[$quarter]++;

                    // For study count report
                    if (! in_array($studyId, $report[$testId]['study_count'][$quarter])) {
                        $report[$testId]['study_count'][$quarter][] = $studyId;
                    }

                    // Initialize test total if not set
                    if (! isset($testTotals[$testId])) {
                        $testTotals[$testId] = [
                            'test_count'  => 0,
                            'study_count' => [],
                        ];
                    }

                    $testTotals[$testId]['test_count']++;

                    // Track unique studies for this test
                    if (! in_array($studyId, $testTotals[$testId]['study_count'])) {
                        $testTotals[$testId]['study_count'][] = $studyId;
                    }
                }
            }
        }

        // Prepare final report data
        $this->reportData = [];
        foreach ($report as $testId => $testData) {
            // For test count report
            $testCount  = $testTotals[$testId]['test_count'] ?? 0;
            $studyCount = count($testTotals[$testId]['study_count'] ?? []);

            // Skip tests with zero counts if not showing them
            if (! $this->showZeroCounts && $testCount === 0 && $studyCount === 0) {
                continue;
            }

            $row = [
                'test_id'           => $testId,
                'test_name'         => $testData['name'],
                'quarters'          => $testData['quarters'],
                'study_counts'      => [],
                'test_count_total'  => $testCount,
                'study_count_total' => $studyCount,
            ];

            // Prepare study count data
            foreach ($this->quarterColumns as $quarter) {
                $row['study_counts'][$quarter] = count($testData['study_count'][$quarter]);
            }

            $this->reportData[] = $row;
        }

        // Sort by test name
        usort($this->reportData, function ($a, $b) {
            return $a['test_name'] <=> $b['test_name'];
        });
    }

    protected function getQuarterColumns()
    {
        $start    = Carbon::parse($this->startDate);
        $end      = Carbon::parse($this->endDate);
        $quarters = [];

        $current = $start->copy()->startOfQuarter();

        while ($current <= $end) {
            $quarter    = 'Q' . $current->quarter . ' ' . $current->year;
            $quarters[] = $quarter;
            $current->addQuarter();
        }

        return array_unique($quarters);
    }

    public function renderChart()
    {
        if (count($this->reportData) === 0) {
            return null;
        }

        $chartModel = (new ColumnChartModel())
            ->setTitle($this->chartTitle)
            ->setAnimated(true)
            ->withOnPointClickEvent('onColumnClick')
            ->setLegendVisibility(true)
            ->setDataLabelsEnabled(true)
            ->setColumnWidth(30)
            ->setHorizontal(false);

        // Add all quarters to chart
        foreach ($this->quarterColumns as $quarter) {
            $chartModel->addColumn($quarter, 0, '#4c51bf');
        }

        // Add data for each test
        foreach ($this->reportData as $test) {
            $color    = $this->generateRandomColor();
            $testName = $test['test_name'];

            foreach ($this->quarterColumns as $quarter) {
                $value = $this->reportType === 'test_count'
                ? $test['quarters'][$quarter]
                : $test['study_counts'][$quarter];

                $chartModel->addSeriesColumn($testName, $quarter, $value, $color);
            }
        }

        return $chartModel;
    }

    protected function generateRandomColor()
    {
        return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }

    public function render()
    {
        $data['chartModel'] = $this->renderChart();

        return view('livewire.lab.reports.test-study-count-report-component', $data);
    }
}
