<?php

namespace App\Http\Controllers\Language;

use App\Http\Controllers\Controller;
use App\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $languages = Language::select(
            'languages.*'
        );

        // For crud request
        if($request->has('paginate') && !empty($request->paginate)){
            if($request->has('search') && !empty($request->search)){
                $languages = $languages->where('languages.name', 'LIKE', '%'.$request->search .'%');
            }

            $languages = $languages->paginate($this->perPage);
        }else{
            // request has type then filter by type
            if($request->has('type')){
                switch($request->type){
                    case 'active':
                        $languages = $languages->where('status', 1);
                        break;
                }
            }

            $languages = $languages->get();
            return response()->json($languages);
        }


        return response()->json([
            'languages' => $languages->items(),
            'total' => $languages->total()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $language = Language::findOrFail($id);
        return response()->json([
            'language' => $language,
            'success' => true
        ]);
    }
}
