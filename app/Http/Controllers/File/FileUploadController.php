<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function uploadFiles(Request $request){
        if($request->hasFile('file')){

        }
        return response()->json($request->all());
    }
}
