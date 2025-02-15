<?php

use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will be
| assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->prefix('dashboard')->group(function () {

    Route::middleware('admin')->group(function () {
        Route::resource('employees', EmployeeController::class);
        Route::post('/employees/search', [EmployeeController::class, 'search'])->name('employees.search');

        Route::resource('departments', DepartmentController::class);
    });

    Route::middleware('role:admin|employee')->group(function () {
        Route::resource('tasks', TaskController::class);
        Route::post('/tasks/search', [TaskController::class, 'search'])->name('tasks.search');

    });


    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
