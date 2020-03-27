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
    public function generateGuests(GuestUploadCSVRequest $request)
    {
        $file = $request->file;
        $validator = Validator::make(
            [
                'file' => $file,
                'extension' => strtolower($file->getMimeType()),
            ],
            [
                'file' => 'required',
                'extension' => 'required|in:csv'
            ]
        );

        if ($validator->failed()) {
            return response()->json([
                'success' => false
            ]);
        }

        $modifyGuests = $this->csvToArray($request->file);

        return response()->json([
            'success' => true,
            'guests' => $modifyGuests
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param UploadMultipleGuestRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UploadMultipleGuestRequest $request)
    {
        $eventId = $request->eventId;
        $guests = collect($request->guests);

        $guests->map(function ($guest) use ($eventId) {
            $guestRequest = new GuestRequest();
            $guestRequest->merge(['event_id' => $eventId]);
            foreach ($guest as $key => $value) {
                $guestRequest->merge([$key => $value]);
            }

            $guestController = new GuestStoreController($guestRequest);
            $guestController->store($guestRequest);
        });

        // Get all guest by event id
        return response()->json([
            'success' => true
        ]);
    }


    /**
     * Remove any BOM from string
     * @param $text
     * @return string|string[]|null
     */
    private function removeUtf8Bom($text) {
        $bom = pack('H*','EFBBBF');
        $text = preg_replace("/^$bom/", '', $text);
        return $text;
    }

    /**
     * Generate array from csv file
     * @param $file
     * @param string $delimiter
     * @param string $seperator
     * @return array
     */
    private function csvToArray($file, $delimiter=',', $seperator = '"') {
        $csvdata = file($file);
        $header = NULL;
        $data = array();
        foreach ($csvdata as $line) {
            $row = $this->removeUtf8Bom($line);
            $row = str_getcsv($row,$delimiter,$seperator);
            if(!$header)
                $header = $row;
            else
                $data[] = array_combine($header, $row);
        }
        return $data;
    }
}
