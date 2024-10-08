<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ShiftSwapController;
use App\Http\Controllers\WelcomeController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;
use Illuminate\Support\Facades\Route;


// Route khusus untuk admin
Route::prefix('admin')->middleware(['auth', 'verified', AdminMiddleware::class])
    ->group(function () {
        Route::get('dashboard', [WelcomeController::class, 'index'])->name('admin.dashboard');
        // schedule
        Route::prefix('schedule')->group(function () {
            Route::get('/', [ScheduleController::class, 'index'])->name('admin.schedule.index');
            Route::post('/list', [ScheduleController::class, 'list'])->name('admin.schedule.list');
            Route::get('/create', [ScheduleController::class, 'create'])->name('admin.schedule.create');
            Route::post('/', [ScheduleController::class, 'store'])->name('admin.schedule.store');
            Route::get('/{id}', [ScheduleController::class, 'show'])->name('admin.schedule.show');
            Route::get('/{id}/edit', [ScheduleController::class, 'edit'])->name('admin.schedule.edit');
            Route::put('/{id}', [ScheduleController::class, 'update'])->name('admin.schedule.update');
            Route::delete('/{id}', [ScheduleController::class, 'destroy'])->name('admin.schedule.destroy'); // Perubahan di sini
        });

        // salary
        Route::prefix('salary')->group(function () {
            Route::get('/', [SalaryController::class, 'index'])->name('admin.salary.index');
            Route::post('/list', [SalaryController::class, 'list'])->name('admin.salary.list');
            Route::get('/create', [SalaryController::class, 'create'])->name('admin.salary.create');
            Route::post('/', [SalaryController::class, 'store'])->name('admin.salary.store');
            Route::get('/{id}', [SalaryController::class, 'show'])->name('admin.salary.show');
            Route::get('/{id}/edit', [SalaryController::class, 'edit'])->name('admin.salary.edit');
            Route::put('/{id}', [SalaryController::class, 'update'])->name('admin.salary.update');
            Route::delete('/{id}', [SalaryController::class, 'destroy'])->name('admin.salary.destroy'); // Perubahan di sini
        });

        // position
        Route::prefix('position')->group(function () {
            Route::get('/', action: [PositionController::class, 'index'])->name('admin.position.index');
            Route::post('/list', [PositionController::class, 'list'])->name('admin.position.list');
            Route::get('/create', [PositionController::class, 'create'])->name('admin.position.create');
            Route::post('/', [PositionController::class, 'store'])->name('admin.position.store');
            Route::get('/{id}', [PositionController::class, 'show'])->name('admin.position.show');
            Route::get('/{id}/edit', [PositionController::class, 'edit'])->name('admin.position.edit');
            Route::put('/{id}', [PositionController::class, 'update'])->name('admin.position.update');
            Route::delete('/{id}', [PositionController::class, 'destroy'])->name('admin.position.destroy'); // Perubahan di sini
        });

        // department
        Route::prefix('department')->group(function () {
            Route::get('/', action: [DepartmentController::class, 'index'])->name('admin.department.index');
            Route::post('/list', [DepartmentController::class, 'list'])->name('admin.department.list');
            Route::get('/create', [DepartmentController::class, 'create'])->name('admin.department.create');
            Route::post('/', [DepartmentController::class, 'store'])->name('admin.department.store');
            Route::get('/{id}', [DepartmentController::class, 'show'])->name('admin.department.show');
            Route::get('/{id}/edit', [DepartmentController::class, 'edit'])->name('admin.department.edit');
            Route::put('/{id}', [DepartmentController::class, 'update'])->name('admin.department.update');
            Route::delete('/{id}', [DepartmentController::class, 'destroy'])->name('admin.department.destroy'); // Perubahan di sini
        });

        //    route employees
        Route::prefix('employee')->group(function () {
            Route::get('/', [EmployeeController::class, 'index'])->name('admin.employee.index');
            Route::post('/list', [EmployeeController::class, 'list'])->name('admin.employee.list');
            Route::get('/create', [EmployeeController::class, 'create'])->name('admin.employee.create');
            Route::post('/', [EmployeeController::class, 'store'])->name('admin.employee.store');
            Route::get('/{id}', [EmployeeController::class, 'show'])->name('admin.employee.show');
            Route::get('/{id}/edit', [EmployeeController::class, 'edit'])->name('admin.employee.edit');
            Route::put('/{id}', [EmployeeController::class, 'update'])->name('admin.employee.update');
            Route::delete('/{id}', [EmployeeController::class, 'destroy'])->name('admin.employee.destroy'); // Perubahan di sini
        });
        // leave
        Route::prefix('leave')->group(function () {
            Route::get('/', action: [LeaveController::class, 'index'])->name('admin.leave.index');
            Route::post('/list', [LeaveController::class, 'list'])->name('admin.leave.list');
            Route::get('/create', [LeaveController::class, 'create'])->name('admin.leave.create');
            Route::post('/', [LeaveController::class, 'store'])->name('admin.leave.store');
            Route::get('/{id}', [LeaveController::class, 'show'])->name('admin.leave.show');
            Route::get('/{id}/edit', [LeaveController::class, 'edit'])->name('admin.leave.edit');
            Route::put('/{id}', [LeaveController::class, 'update'])->name('admin.leave.update');
            Route::delete('/{id}', [LeaveController::class, 'destroy'])->name('admin.leave.destroy'); // Perubahan di sini
        });

        // attendace
        Route::prefix('attendance')->group(function () {
            Route::get('/', action: [AttendanceController::class, 'index'])->name('admin.attendance.index');
            Route::post('/list', [AttendanceController::class, 'list'])->name('admin.attendance.list');
            Route::get('/create', [AttendanceController::class, 'create'])->name('admin.attendance.create');
            Route::post('/', [AttendanceController::class, 'store'])->name('admin.attendance.store');
            Route::get('/{id}', [AttendanceController::class, 'show'])->name('admin.attendance.show');
            Route::get('/{id}/edit', [AttendanceController::class, 'edit'])->name('admin.attendance.edit');
            Route::put('/{id}', [AttendanceController::class, 'update'])->name('admin.attendance.update');
            Route::delete('/{id}', [AttendanceController::class, 'destroy'])->name('admin.attendance.destroy'); // Perubahan di sini
        });

        Route::prefix(prefix: 'shift-changes')->group(function () {
            Route::get('/', action: [ShiftSwapController::class, 'index'])->name('admin.shift-changes.index');
            Route::post('/list', [ShiftSwapController::class, 'list'])->name('admin.shift-changes.list');
            Route::get('/create', [ShiftSwapController::class, 'create'])->name('admin.shift-changes.create');
            Route::post('/', [ShiftSwapController::class, 'store'])->name('admin.shift-changes.store');
            Route::get('/{id}', [ShiftSwapController::class, 'show'])->name('admin.shift-changes.show');
            Route::get('/{id}/edit', [ShiftSwapController::class, 'edit'])->name('admin.shift-changes.edit');
            Route::put('/{id}', [ShiftSwapController::class, 'update'])->name('admin.shift-changes.update');
            Route::delete('/{id}', [ShiftSwapController::class, 'destroy'])->name('admin.shift-changes.destroy'); // Perubahan di sini
        });

        // todo yag lainnya
        // !!yang lainnya masih ambigu
        // Shift change request
        Route::post('schedule/request-shift-change', [ScheduleController::class, 'requestShiftChange'])->name('schedule.request-shift-change');
        Route::get('schedule/approve-shift-change/{id}/{action}', [ScheduleController::class, 'approveShiftChange'])->name('schedule.approve-shift-change');

        Route::post('/attendance/checkout', [AttendanceController::class, 'checkOut']);

        // todo:baru lagi
        Route::post('/shift-swap/request', [ShiftSwapController::class, 'requestShiftSwap']);
        Route::post('/shift-swap/approve/{id}', [ShiftSwapController::class, 'approveShiftSwap']);
        Route::post('/shift-swap/reject/{id}', [ShiftSwapController::class, 'rejectShiftSwap']);
        // Show shift swap request form
        Route::get('/shift-swap/request', [ShiftSwapController::class, 'showSwapRequestForm']);

        // Submit shift swap request
        Route::post('/shift-swap/request', [ShiftSwapController::class, 'requestShiftSwap']);

        // Admin manages shift swaps
        Route::get('/shift-swap/manage', [ShiftSwapController::class, 'manageShiftSwaps']);

        // Approve or reject shift swaps
        Route::post('/shift-swap/approve/{id}', [ShiftSwapController::class, 'approveShiftSwap']);
        Route::post('/shift-swap/reject/{id}', [ShiftSwapController::class, 'rejectShiftSwap']);

        //from claude ai
        Route::put('/shift-changes/{shiftChange}/approve', [ShiftSwapController::class, 'approve']);
        Route::put('shift-changes/{shiftChange}/approve', [ShiftSwapController::class, 'approve'])->name('shift-changes.approve');
        Route::put('shift-changes/{shiftChange}/reject', [ShiftSwapController::class, 'reject'])->name('shift-changes.reject');


        // yang ini sudah benar
        Route::get('/employee-position/{id_employee}', [SalaryController::class, 'getEmployeePosition']);
    });

Route::prefix('user')
    ->middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('dashboard', [WelcomeController::class, 'userDashboard'])->name('user.dashboard');
        Route::get('schedule', [ScheduleController::class, 'showSchedule'])->name('user.schedule');
    });

// Route::get('/dashboard', function () {
//     return view('user/dashboard');
// })
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

// Route untuk tamu yang belum login
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';
