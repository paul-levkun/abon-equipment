<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v2\DictsController;
use App\Http\Controllers\Api\v2\ReportController;

Route::resource('dicts', DictsController::class);

Route::group([], function () {
  // Route::get('reports/id', [ReportController::class, 'makeReport']);
  Route::get('report', [ReportController::class, 'makeReport']);

  Route::delete('delete-report', [ReportController::class, 'deleteReport'])/*->name('report-report')*/;
  // Route::delete('/deleteFile/{filename}', [ReportController::class, 'deleteReport']);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
