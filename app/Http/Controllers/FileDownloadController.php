<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\File;


class FileDownloadController extends Controller
{ public function index($id){
    $file=File::find($id);
    return Storage::download($file->file_path,$file->name);

    // $file=Storage::disk('public/uploads')->get($filename);
	// 	return (new Response($file, 200))
    //           ->header('Content-Type', 'pdf/txt/ppt/pptx/doc/docx/csv/txt/xlx/xls');
    // $filePath = public_path("SeminarReport.pdf");
    // $headers = ['Content-Type: application/pdf'];
    // $fileName = time().'.pdf';

    // return response()->download($filePath, $fileName, $headers);

}
public function show(){
    $file=File::get();
    return view('user.files.show_files')->with('files',$file);

}
    //
}
