<?php

use App\Http\Controllers\ResultReportController;
use App\Http\Livewire\Admin\CollectorComponent;
use App\Http\Livewire\Admin\CourierComponent;
use App\Http\Livewire\Admin\DesignationComponent;
use App\Http\Livewire\Admin\FacilityComponent;
use App\Http\Livewire\Admin\KitComponent;
use App\Http\Livewire\Admin\LaboratoryComponent;
use App\Http\Livewire\Admin\PlatformComponent;
use App\Http\Livewire\Admin\RequesterComponent;
use App\Http\Livewire\Admin\SampleTypeComponent;
use App\Http\Livewire\Admin\StudyComponent;
use App\Http\Livewire\Admin\TestCategoryComponent;
use App\Http\Livewire\Admin\TestComponent;
use App\Http\Livewire\Admin\UserComponent;
use App\Http\Livewire\Lab\Lists\ParticipantListComponent;
use App\Http\Livewire\Lab\SampleManagement\AttachTestResultComponent;
use App\Http\Livewire\Lab\SampleManagement\SampleReceptionComponent;
use App\Http\Livewire\Lab\SampleManagement\SpecimenRequestComponent;
use App\Http\Livewire\Lab\SampleManagement\TestApprovalComponent;
use App\Http\Livewire\Lab\SampleManagement\TestReportsComponent;
use App\Http\Livewire\Lab\SampleManagement\TestRequestComponent;
use App\Http\Livewire\Lab\SampleManagement\TestReviewComponent;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [AuthenticatedSessionController::class, 'home'])->middleware('guest')->name('home');

// Route::get('/dashboard', function () {
//     return view('dashboard');'role:superadministrator|administrator|user'
// })->middleware(['auth'])->name('dashboard');

Route::group(['middleware' => ['auth'], 'prefix' => 'admin'], function () {
    Route::get('test-categories', TestCategoryComponent::class)->name('categories');
    Route::get('sample-types', SampleTypeComponent::class)->name('sampletypes');
    Route::get('test', TestComponent::class)->name('tests');
    Route::get('designations', DesignationComponent::class)->name('designations');
    Route::get('laboratories', LaboratoryComponent::class)->name('laboratories');
    Route::get('facilities', FacilityComponent::class)->name('facilities');
    Route::get('requesters', RequesterComponent::class)->name('requesters');
    Route::get('sample-collectors', CollectorComponent::class)->name('collectors');
    Route::get('kits', KitComponent::class)->name('kits');
    Route::get('platforms', PlatformComponent::class)->name('platforms');
    Route::get('studies', StudyComponent::class)->name('studies');
    Route::get('couriers', CourierComponent::class)->name('couriers');
    Route::get('user-management', UserComponent::class)->name('usermanagement');
});

Route::group(['middleware' => ['auth'], 'prefix' => 'sampleMgt'], function () {
    Route::get('reception', SampleReceptionComponent::class)->name('samplereception');
    Route::get('batch/{batch}/specimen-req', SpecimenRequestComponent::class)->name('specimen-request');
    Route::get('tests/requests', TestRequestComponent::class)->name('test-request');
    Route::get('sample/{id}/test-results', AttachTestResultComponent::class)->name('attach-test-results');
    Route::get('sample/test-review', TestReviewComponent::class)->name('test-review');
    Route::get('sample/test-approval', TestApprovalComponent::class)->name('test-approval');
    Route::get('sample/test-reports', TestReportsComponent::class)->name('test-reports');
    Route::get('sample/test-result{id}/report', [ResultReportController::class, 'show'])->name('result-report');
    Route::get('sample/test-result/{id}/attachment', [ResultReportController::class, 'download'])->name('attachment.download');
    Route::get('participants', ParticipantListComponent::class)->name('participants');
});
require __DIR__.'/auth.php';
