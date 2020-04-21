<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadMultipleUserRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserUploadController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function generateUsers(Request $request)
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

        $modifyUsers = $this->csvToArray($request->file);

        return response()->json([
            'success' => true,
            'users' => $modifyUsers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param UploadMultipleUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function confirmed(UploadMultipleUserRequest $request)
    {
        $dealershipId = $request->dealershipId;
        $users = collect($request->users);
        $type = $request->type;
        $existingUsers = [];

        $users->map(function ($user) use ($dealershipId,$type, &$existingUsers) {

            $existingUser = User::select('email')
                ->where('email', $user['email'])
                ->first();

            if ($existingUser) {
                $existingUsers[] = $user;
            } else {
                $userRequest = new Request();
                if($dealershipId){
                    $userRequest->merge(['dealershipId' => $dealershipId]);
                }

                if($type){
                    $userRequest->merge(['type' => $type]);
                }

                foreach ($user as $key => $value) {
                    if($key == 'password'){
                        $password = $string = str_replace(' ', '', $value); // remove whitespace
                        $userRequest->merge([$key => $password]);
                    }else{
                        $userRequest->merge([$key => $value]);
                    }

                }

                $userController = new RegisterController($userRequest);
                $userController->store($userRequest);
            }
        });

        // Get all guest by event id
        return response()->json([
            'success' => true,
            'existingUsers' => $existingUsers
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
