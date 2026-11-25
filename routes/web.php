
<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrganizersController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\TripController as AdminTripController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\BookingController as UserBookingController;
use App\Http\Controllers\User\PaymentController as UserPaymentController;
use App\Http\Controllers\User\TripController as UserTripController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('user.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Route Khusus Admin
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::resource('categories', CategoryController::class)
            ->except(['show']);

        Route::resource('organizers', OrganizersController::class)
            ->except(['show']);

        Route::resource('trips', AdminTripController::class)
            ->except(['show']);

        Route::get('/payments', [AdminPaymentController::class, 'index'])
            ->name('payments.index');

        Route::patch('/payments/{payment}', [AdminPaymentController::class, 'update'])
            ->name('payments.update');
    });

// Route Khusus User / Member
Route::middleware(['auth', 'role:user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        Route::get('/dashboard', [UserTripController::class, 'index'])
            ->name('dashboard');

        Route::get('/trips', [UserTripController::class, 'index'])
            ->name('trips.index');

        Route::get('/trips/{trip}', [UserTripController::class, 'show'])
            ->name('trips.show');

        Route::get('/bookings', [UserBookingController::class, 'index'])
            ->name('bookings.index');

        Route::post('/trips/{trip}/bookings', [UserBookingController::class, 'store'])
            ->name('bookings.store');

        // HALAMAN INSTRUKSI PEMBAYARAN
        Route::get('/bookings/{booking}/instructions', [
            UserBookingController::class,
            'instructions'
        ])->name('payments.instructions');

        // Upload bukti pembayaran
        Route::get('/bookings/{booking}/payment', [
            UserPaymentController::class,
            'create'
        ])->name('payments.create');

        Route::post('/bookings/{booking}/payment', [
            UserPaymentController::class,
            'store'
        ])->name('payments.store');
    });