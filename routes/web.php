<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\Api\v2\ReportController;
use App\Http\Controllers\DashboardController;

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

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::get('/report', [ReportController::class, 'makeReport']);

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'show'])
    ->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/download', [ DownloadController::class, 'download'])->name('download');
// Route::get('/download/{file_path}', [ DownloadController::class, 'download']);
// Route::get('/download', function () {
// 	return "Hello, download!";
// });

Route::get('/delete-report', [ ReportController::class, 'deleteReport'])->name('delete_report');

Route::get('/{any}', function () {
    // dd(env('FTP_HOST', ""));
    // dd(config('app.FTP_PATH'));
    return view('app-v', [ 
        'user_id' => Auth::user()->id, 
        'so_id' => Auth::user()->so_id, 
        'rem_id' => Auth::user()->rem_id,
        'bo_id' => Auth::user()->bo_id,
        'user_name' => Auth::user()->name,
    ]);
})->middleware(['auth'])->where('any', '.*');


