<?php

use App\Http\Controllers\FileController;
use App\Http\Controllers\RabbitmqTestController;
use Illuminate\Support\Facades\Route;

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
Route::get('/test-rabbitmq', [RabbitmqTestController::class, 'testConnection']);

Route::get('/upload-file', [FileController::class, 'show'])->name('files.upload');
Route::get('/', [FileController::class, 'index'])->name('files.index');
Route::post('/upload', [FileController::class, 'store'])->name('files.store');
Route::delete('/files/{file}', [FileController::class, 'destroy'])->name('files.destroy');

