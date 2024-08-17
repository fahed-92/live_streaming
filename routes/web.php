<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\Chat;
use App\Livewire\Whiteboard;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\WebRTCController;
use App\Livewire\RoomAttendance;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Apply role-based middleware for room routes
Route::middleware(['auth'])->group(function () {
    Route::get('/chat', Chat::class)->name('chat.index');
    Route::get('/room/{room}/whiteboard', Whiteboard::class)->name('room.whiteboard');


    // Routes accessible only to the 'creator' role
    Route::middleware(['role:creator'])->group(function () {
        Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
        Route::get('/rooms/create', [RoomController::class, 'create'])->name('rooms.create')->middleware('role:creator');
        Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store')->middleware('role:creator');
        Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');
        Route::post('/rooms/{room}/end', [RoomController::class, 'endMeeting'])->name('rooms.end')->middleware('role:creator');
        Route::post('/rooms/{room}/signal', [RoomController::class, 'signal'])->name('rooms.signal');
        Route::get('/roomattendance', RoomAttendance::class)->name('roomattendance');


    });

    // Routes accessible to both 'creator' and 'attendee' roles
    Route::middleware(['role:creator|attendee'])->group(function () {
        Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
        Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');
        Route::get('room/{id}', [WebRTCController::class, 'show'])->name('room.show');
        Route::post('room/{id}/signal', [WebRTCController::class, 'signal'])->name('room.signal');
    });

});

require __DIR__.'/auth.php';
