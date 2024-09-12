<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('employee')->group(function () {
    Route::get('/', [EmployeeController::class, 'index'])->name('employee.index');
    Route::post('/list', [EmployeeController::class, 'list'])->name('employee.list');
    Route::get('/create', [EmployeeController::class, 'create'])->name('employee.create');
    Route::post('/', [EmployeeController::class, 'store'])->name('employee.store');
    Route::get('/{id}', [EmployeeController::class, 'show'])->name('employee.show');
    Route::get('/{id}/edit', [EmployeeController::class, 'edit'])->name('employee.edit');
    Route::put('/{id}', [EmployeeController::class, 'update'])->name('employee.update');
    Route::delete('/{id}', [EmployeeController::class, 'destroy'])->name('employee.destroy'); // Perubahan di sini
});

Route::prefix('salary')->group(function () {
    Route::get('/', [SalaryController::class, 'index'])->name('salary.index');
    Route::post('/list', [SalaryController::class, 'list'])->name('salary.list');
    Route::get('/create', [SalaryController::class, 'create'])->name('salary.create');
    Route::post('/', [SalaryController::class, 'store'])->name('salary.store');
    Route::get('/{id}', [SalaryController::class, 'show'])->name('salary.show');
    Route::get('/{id}/edit', [SalaryController::class, 'edit'])->name('salary.edit');
    Route::put('/{id}', [SalaryController::class, 'update'])->name('salary.update');
    Route::delete('/{id}', [SalaryController::class, 'destroy'])->name('salary.destroy'); // Perubahan di sini
});

Route::prefix('schedule')->group(function () {
    Route::get('/', action: [ScheduleController::class, 'index'])->name('schedule.index');
    Route::post('/list', [ScheduleController::class, 'list'])->name('schedule.list');
    Route::get('/create', [ScheduleController::class, 'create'])->name('schedule.create');
    Route::post('/', [ScheduleController::class, 'store'])->name('schedule.store');
    Route::get('/{id}', [ScheduleController::class, 'show'])->name('schedule.show');
    Route::get('/{id}/edit', [ScheduleController::class, 'edit'])->name('schedule.edit');
    Route::put('/{id}', [ScheduleController::class, 'update'])->name('schedule.update');
    Route::delete('/{id}', [ScheduleController::class, 'destroy'])->name('schedule.destroy'); // Perubahan di sini
});

Route::prefix('department')->group(function () {
    Route::get('/', action: [DepartmentController::class, 'index'])->name('department.index');
    Route::post('/list', [DepartmentController::class, 'list'])->name('department.list');
    Route::get('/create', [DepartmentController::class, 'create'])->name('department.create');
    Route::post('/', [DepartmentController::class, 'store'])->name('department.store');
    Route::get('/{id}', [DepartmentController::class, 'show'])->name('department.show');
    Route::get('/{id}/edit', [DepartmentController::class, 'edit'])->name('department.edit');
    Route::put('/{id}', [DepartmentController::class, 'update'])->name('department.update');
    Route::delete('/{id}', [DepartmentController::class, 'destroy'])->name('department.destroy'); // Perubahan di sini
});

Route::prefix('position')->group(function () {
    Route::get('/', action: [PositionController::class, 'index'])->name('position.index');
    Route::post('/list', [PositionController::class, 'list'])->name('position.list');
    Route::get('/create', [PositionController::class, 'create'])->name('position.create');
    Route::post('/', [PositionController::class, 'store'])->name('position.store');
    Route::get('/{id}', [PositionController::class, 'show'])->name('position.show');
    Route::get('/{id}/edit', [PositionController::class, 'edit'])->name('position.edit');
    Route::put('/{id}', [PositionController::class, 'update'])->name('position.update');
    Route::delete('/{id}', [PositionController::class, 'destroy'])->name('position.destroy'); // Perubahan di sini
});

Route::prefix('leave')->group(function () {
    Route::get('/', action: [LeaveController::class, 'index'])->name('leave.index');
    Route::post('/list', [LeaveController::class, 'list'])->name('leave.list');
    Route::get('/create', [LeaveController::class, 'create'])->name('leave.create');
    Route::post('/', [LeaveController::class, 'store'])->name('leave.store');
    Route::get('/{id}', [LeaveController::class, 'show'])->name('leave.show');
    Route::get('/{id}/edit', [LeaveController::class, 'edit'])->name('leave.edit');
    Route::put('/{id}', [LeaveController::class, 'update'])->name('leave.update');
    Route::delete('/{id}', [LeaveController::class, 'destroy'])->name('leave.destroy'); // Perubahan di sini
});

require __DIR__ . '/auth.php';
