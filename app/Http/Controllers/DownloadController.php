<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function download(Request $req)
    {
        // dd($req["file_path"]);
        $file_content = Storage::disk('ftp')->get($req["file_path"]);
        // $file_content = Storage::disk('public')->get($req["file_path"]);

        return response($file_content)
            ->header('Content-Type', 'application/octet-stream')
            ->header('Content-Disposition', 'attachment; filename="' . basename($req["file_path"]) . '"');
    }
}
