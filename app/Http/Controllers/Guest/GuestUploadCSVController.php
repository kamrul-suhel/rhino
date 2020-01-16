<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Http\Requests\GuestRequest;
use App\Http\Requests\GuestUploadCSVRequest;
use App\Http\Requests\UploadMultipleGuestRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GuestUploadCSVController extends Controller
{

    /**
     * Generate and return date from csv file
     * @param GuestUploadCSVRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateGuests(GuestUploadCSVRequest $request){
        $file = $request->file;
        $validator = Validator::make(
            [
                'file'      => $file,
                'extension' => strtolower($file->getMimeType()),
            ],
            [
                'file'      => 'required',
                'extension'      => 'required|in:csv'
            ]
        );

        if($validator->failed()){
            return response()->json([
                'success' => false
            ]);
        }

        $handle = fopen($request->file, "r");
        $guests = [];
        while (($data = fgetcsv($handle)) !== FALSE) {
            $guests[] = $data;
        }

        $header = array_shift($guests);
        $modifyGuests = [];
        foreach($guests as $key => $value){
            $individualGuest = [];
            foreach($value as $objectKey => $objectValue){
                $individualGuest[$header[$objectKey]] = $objectValue;
            }

            $modifyGuests[] = $individualGuest;
        }

        return response()->json([
            'success' => true,
            'guests' => $modifyGuests
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UploadMultipleGuestRequest $request)
    {
        $eventId = $request->eventId;
        $guests = collect($request->guests);

        $guests->map(function($guest) use($eventId){
            $guestRequest = new GuestRequest();
            $guestRequest->request->add(['eventId' => $eventId]);
            dd($guestRequest->all());
        });
    }
}
