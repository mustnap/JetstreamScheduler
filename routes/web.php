<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CalendarUserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\GroupUserController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\UserScheduleController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

//
Route::middleware('auth')->group(function () {
    Route::resource('group', GroupController::class);
    Route::resource('groupusers', GroupUserController::class);

    Route::prefix('calendar')->group(function () {
        Route::get('{year}/{month}', [CalendarUserController::class, 'edit'])->name('calendar.ym');
        Route::patch('{year}/{month}', [CalendarUserController::class, 'update'])->name('calendar.ym-patch');
    });
    Route::resource('calendar', CalendarUserController::class);

    Route::prefix('schedule')->group(function () {
        // Route::get('/schedule/listall', [ScheduleController::class, 'listall']);
        Route::get('{year}/{month}', [ScheduleController::class, 'edit'])->name('schedule.ym');
        Route::patch('{year}/{month}', [ScheduleController::class, 'update'])->name('schedule.ym-patch');
        Route::get('/test', [ScheduleController::class, 'test'])->name('schedule.test');
        Route::get('/test2', [ScheduleController::class, 'test2'])->name('schedule.test2');
    });
    Route::resource('schedule', ScheduleController::class);


    Route::prefix('userschedule')->group(function () {
        Route::get('{year}/{month}', [UserScheduleController::class, 'index'])->name('userschedule.ym');
        Route::patch('{year}/{month}', [UserScheduleController::class, 'update'])->name('userschedule.ym-patch');
    });
    Route::resource('userschedule', UserScheduleController::class);
});
