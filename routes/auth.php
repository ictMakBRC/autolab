<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
// use App\Http\Controllers\Auth\UserRolesPermissionsController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Models\Designation;
use App\Models\Laboratory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthenticatedSessionController::class, 'create'])->middleware('guest')->name('login');
Route::get('/login', [AuthenticatedSessionController::class, 'create'])
                ->middleware('guest')
                ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
                ->middleware('guest');

Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
                ->middleware('guest')
                ->name('password.request');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
                ->middleware('guest')
                ->name('password.email');

Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
                ->middleware('guest')
                ->name('password.reset');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
                ->middleware('guest')
                ->name('password.update');

Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])
                ->middleware('auth')
                ->name('verification.notice');

Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
                ->middleware(['auth', 'signed', 'throttle:6,1'])
                ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware(['auth', 'throttle:6,1'])
                ->name('verification.send');

Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->middleware('auth')
                ->name('password.confirm');

Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store'])
                ->middleware('auth');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
                ->middleware('auth')
                ->name('logout');

Route::group(['prefix' => 'user', 'middleware' => ['auth']], function () {
    // Route::put('settings/{id}', function (Request $request, $id) {
    //     if (User::findOrFail($id)->update($request->all())) {
    //         return redirect()->back()->with(['success' => 'Settings successfully updated']);
    //     } else {
    //         return redirect()->back()->with(['error' => 'Something went wrong and settings were not updated']);
    //     }
    // })->name('settings.update');
});

Route::group(['middleware' => ['auth', 'password_expired','suspended_user']], function () {
    Route::get('dashboard', function () {
        $users = User::latest()->get();
        $designations = Designation::latest()->get();
        $laboratories = Laboratory::latest()->get();

        return view('super-admin.dashboard', compact('users', 'designations', 'laboratories'));
    })->name('super.dashboard');

    // ->only(['index', 'create', 'store', 'edit', 'update'])
});
