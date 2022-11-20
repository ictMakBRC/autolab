<?php

use App\Helpers\LoginActivity;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Admin\KitComponent;
use App\Http\Controllers\SearchController;
use App\Http\Livewire\Admin\TestComponent;
use App\Http\Livewire\Admin\UserComponent;
use App\Http\Livewire\Admin\StudyComponent;
use App\Http\Livewire\Admin\CourierComponent;
use App\Http\Livewire\Admin\FacilityComponent;
use App\Http\Livewire\Admin\PlatformComponent;
use App\Http\Livewire\Admin\CollectorComponent;
use App\Http\Livewire\Admin\RequesterComponent;
use App\Http\Controllers\ResultReportController;
use App\Http\Livewire\Admin\LaboratoryComponent;
use App\Http\Livewire\Admin\SampleTypeComponent;
use App\Http\Controllers\SearchResultsController;
use App\Http\Livewire\Admin\DesignationComponent;
use App\Http\Livewire\Admin\UserProfileComponent;
use App\Http\Controllers\Auth\UserRolesController;
use App\Http\Livewire\Admin\TestCategoryComponent;
use App\Http\Livewire\Admin\UserActivityComponent;
use App\Http\Controllers\FacilityInformationController;
use App\Http\Controllers\Auth\UserPermissionsController;
use App\Http\Livewire\Lab\Lists\ParticipantListComponent;
use App\Http\Controllers\Auth\UserRolesAssignmentController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Livewire\Admin\Dashboards\MainDashboardComponent;
use App\Http\Livewire\Lab\SampleManagement\TestReviewComponent;
use App\Http\Livewire\Lab\SampleManagement\AssignTestsComponent;
use App\Http\Livewire\Lab\SampleManagement\TestReportsComponent;
use App\Http\Livewire\Lab\SampleManagement\TestRequestComponent;
use App\Http\Livewire\Lab\SampleManagement\TestApprovalComponent;
use App\Http\Livewire\Lab\SampleManagement\SampleReceptionComponent;
use App\Http\Livewire\Lab\SampleManagement\SpecimenRequestComponent;
use App\Http\Livewire\Lab\SampleManagement\AttachTestResultComponent;

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
Route::get('generatelabno', [AuthenticatedSessionController::class, 'generate']);

Route::group(['middleware' => ['auth', 'password_expired', 'suspended_user']], function () {
    Route::group(['prefix' => 'admin'], function () {
        Route::group(['middleware' => ['permission:access-settings'], 'prefix' => 'settings'], function () {
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
        });

        Route::group(['middleware' => ['permission:manage-users'], 'prefix' => 'usermgt'], function () {
            Route::get('users', UserComponent::class)->name('usermanagement');
            Route::resource('user-roles', UserRolesController::class);
            Route::resource('user-permissions', UserPermissionsController::class);
            Route::resource('user-roles-assignment', UserRolesAssignmentController::class);
            Route::resource('facilityInformation', FacilityInformationController::class);
            Route::get('activity-trail', UserActivityComponent::class)->name('useractivity');
            Route::get('login-activity', function () {
                $logs = LoginActivity::logActivityLists();

                return view('super-admin.logActivity', compact('logs'));
            })->name('logs');
        });
    });

    Route::get('user/account', UserProfileComponent::class)->name('user.account');
    Route::get('user/my-activity', UserActivityComponent::class)->name('myactivity');

    Route::group(['prefix' => 'samplemgt'], function () {
        Route::get('reception', SampleReceptionComponent::class)->middleware('permission:create-reception-info')->name('samplereception');
        Route::get('batch/{batch}/specimen-req', SpecimenRequestComponent::class)->middleware('permission:accession-samples')->name('specimen-request');
        Route::get('test-request-assignment', AssignTestsComponent::class)->middleware('permission:assign-test-requests')->name('test-request-assignment');
        Route::get('test-requests', TestRequestComponent::class)->middleware('permission:acknowledge-test-request')->name('test-request');
        Route::get('sample/{id}/test-results', AttachTestResultComponent::class)->middleware('permission:enter-results')->name('attach-test-results');
        Route::get('test-result-review', TestReviewComponent::class)->middleware('permission:review-results')->name('test-review');
        Route::get('test-result-approval', TestApprovalComponent::class)->middleware('permission:approve-results')->name('test-approval');
        Route::get('test-result-reports', TestReportsComponent::class)->middleware('permission:view-result-reports')->name('test-reports');
        Route::get('test-result/{id}/report', [ResultReportController::class, 'show'])->name('result-report');
        Route::get('test-result/{id}/attachment', [ResultReportController::class, 'download'])->name('attachment.download');
        Route::get('participants', ParticipantListComponent::class)->middleware('permission:view-participant-info')->name('participants');

        Route::get('batch/{sampleReception}/searchresults', [SearchResultsController::class, 'batchSearchResults'])->name('batch-search-results');
        Route::get('sample/{sample}/searchresults', [SearchResultsController::class, 'sampleSearchResults'])->name('sample-search-results');
        Route::get('participant/{participant}/searchresults', [SearchResultsController::class, 'participantSearchResults'])->name('participant-search-results');
    });

    Route::group(['prefix' => 'Dashboard'], function () {
        Route::get('/', MainDashboardComponent::class)->name('dashboard');
    });
});

require __DIR__.'/auth.php';
