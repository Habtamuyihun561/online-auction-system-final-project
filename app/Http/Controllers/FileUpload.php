<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\File;

class FileUpload extends Controller
{
    public function createForm(){
        return view('backend.files.file_upload');
        return redirect()->back();
      }
      public function fileUpload(Request $request){
       $this->validate($request,[
        'file'=>'required|file|max:4048',

        // 'file' => 'required|mimes:csv,txt,xlx,xls,pdf,ppt,pptx,doc,docx|max:4048'
       ]);
        $upload=$request->file('file');
        $path=$upload->store('public/storage');
        $file=File::create(
            [
            'name'=>$upload->getClientOriginalName(),
            'file_path'=>$path,
            ]
        );
        return back()
        ->with('success','File has been uploaded.');



        // $fileModel = new File;
        // if($req->file()) {
        //     $fileName = time().'_'.$req->file->getClientOriginalName();
        //     $filePath = $req->file('file')->storeAs('uploads', $fileName, 'public');
        //     $fileModel->name = time().'_'.$req->file->getClientOriginalName();
        //     $fileModel->file_path = '/storage/' . $filePath;
        //     $fileModel->save();
        //     return back()
        //     ->with('success','File has been uploaded.')
        //     ->with('file', $fileName);
        // }
   }
    //
}
