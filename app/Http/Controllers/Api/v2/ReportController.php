<?php

namespace App\Http\Controllers\Api\v2;

// require 'vendor/autoload.php';

// use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Reports\AoDetail1Service;
use App\Services\Reports\AoDetail2Service;

class ReportController extends Controller
{
	public function makeReport(Request $req) {
		switch ($req["id"]) {
			case "ao_detail1" : return (new AoDetail1Service)->makeReport(); 
			case "ao_detail2" : return (new AoDetail2Service)->makeReport(); 
			case "ao_detail3" : return (new AoDetail2Service)->makeReport(); 
		}
	}

	public function deleteReport(Request $req) {
		// $filePath = storage_path("app/public/" . $req->input('file_path'));

		// unlink($filePath); // файл іноді видаляється раніше, ніж завантажується на комп клієнта
													// мабудь краще чистити папку "вручну"
		// шось типу цього, вроді працює
		$filePath = glob(storage_path('app/public/*')); // Отримання списку всіх файлів в папці /tmp
// dd($filePath);		
		if ($filePath !== false) {
	    foreach ($filePath as $file) {
        // Видалення кожного файлу
				if (stripos($file, "xlsx") !== false) {
					if (unlink($file)) {
							// echo 'Файл ' . $file . ' успішно видалено.<br>';
					} 
					else {
							return '1 Помилка видалення файлу ' . $file . '.<br>';
					}
				}
    	}
		} 
		else {
    	return '2 Не вдалося отримати список файлів в папці /tmp.<br>';
		}
		
		// return $filePath;

		return redirect()->back();

		// if (file_exists($filePath)) {
		// 	if (unlink($filePath)) {
		// 		return response()->json(['message' => 'File deleted successfully'], 200);
		// 	} 
		// 	else {
		// 		return response()->json(['message' => 'Failed to delete file'], 500);
		// 	}
		// } 
		// else {
		// 	return response()->json(['message' => 'File not found'], 404);
		// }
	}
}

