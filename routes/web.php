<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TaskController;

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

Route::get('/', [ TaskController::class, 'index' ])->name('taskIndex');
Route::post('/store', [ TaskController::class, 'store' ])->name('taskStore');
Route::get('/edit', [ TaskController::class, 'edit' ])->name('taskEdit');
Route::put('/update', [ TaskController::class, 'update' ])->name('taskUpdate');
Route::delete('/destroy/{id}', [ TaskController::class, 'destroy' ])->name('taskDestroy');

Route::put('/ajax/set-new-priority', [ TaskController::class, 'ajaxSetNewPriority' ])->name('ajaxSetTaskNewPriority');
