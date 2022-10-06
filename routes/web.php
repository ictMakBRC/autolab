<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Livewire\Admin\KitComponent;
use App\Http\Livewire\Admin\UserComponent;
use App\Http\Livewire\Admin\StudyComponent;
use App\Http\Livewire\Admin\FacilityComponent;
use App\Http\Livewire\Admin\PlatformComponent;
use App\Http\Livewire\Admin\CollectorComponent;
use App\Http\Livewire\Admin\RequesterComponent;
use App\Http\Livewire\Admin\LaboratoryComponent;
use App\Http\Livewire\Admin\SampleTypeComponent;
use App\Http\Livewire\Admin\DesignationComponent;
use App\Http\Livewire\Admin\TestCategoryComponent;

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

Route::get('/updateContractStatus', [MassUpdateController::class, 'contractStatusUpdate'])->middleware('auth')->name('contractStatus.update');

// Route::get('/dashboard', function () {
//     return view('dashboard');'role:superadministrator|administrator|user'
// })->middleware(['auth'])->name('dashboard');
Route::group(['middleware' => ['auth'], 'prefix' => 'Admin'], function () {
    Route::get('categories', TestCategoryComponent::class)->name('categories');
    Route::get('sample_types', SampleTypeComponent::class)->name('sampletypes');
    Route::resource('tests', TestController::class);
    Route::get('designations', DesignationComponent::class)->name('designations');
    Route::get('laboratories', LaboratoryComponent::class)->name('laboratories');
    Route::get('facilities', FacilityComponent::class)->name('facilities');
    Route::get('requesters', RequesterComponent::class)->name('requesters');
    Route::get('sample-collectors', CollectorComponent::class)->name('collectors');
    Route::get('kits', KitComponent::class)->name('kits');
    Route::get('platforms', PlatformComponent::class)->name('platforms');
    
    Route::get('studies', StudyComponent::class)->name('studies');
    Route::get('user-management', UserComponent::class)->name('usermanagement');
});
require __DIR__.'/auth.php';
