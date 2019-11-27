<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function uploadFiles(Request $request){
        if($request->hasFile('file')){
            $path = Storage::disk('public')->put( $request->model,$request->file('file'));

            return response()->json(asset(Storage::url($path)));
        }
        return response()->json($request->all());
    }
}
