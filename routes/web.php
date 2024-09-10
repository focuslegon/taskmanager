<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// routes/web.php
use App\Http\Controllers\TaskController;

// returns task page
Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
// adds new task
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
// returns list of tasks in html
Route::get('/view', [TaskController::class, 'view'])->name('tasks.view');
// marks task as completed
Route::put('/tasks/{id}/complete', [TaskController::class, 'markAsCompleted'])->name('tasks.complete');
