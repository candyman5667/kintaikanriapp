<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;

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
Route::get('/',[AttendanceController::class,'index'])->middleware(['auth']);
//勤務開始
Route::post('/start', [AttendanceController::class, 'start_stamp'])->middleware(['auth']);
//勤務終了
Route::post('/end', [AttendanceController::class, 'end_stamp'])->middleware(['auth']);

//Route::get('/', function () {
//    return view('welcome');
//})


require __DIR__.'/auth.php';
