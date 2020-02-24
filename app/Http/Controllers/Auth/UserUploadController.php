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

        $handle = fopen($request->file, "r");
        $users = [];
        while (($data = fgetcsv($handle)) !== FALSE) {
            $users[] = $data;
        }

        $header = array_shift($users);
        $modifyUsers = [];
        foreach ($users as $key => $value) {
            $currentUser = [];
            foreach ($value as $objectKey => $objectValue) {
                $currentUser[$header[$objectKey]] = $objectValue;
            }

            $modifyUsers[] = $currentUser;
        }

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
        $existingUsers = [];

        $users->map(function ($user) use ($dealershipId, &$existingUsers) {

            $existingUser = User::select('email')
                ->where('email', $user['email'])
                ->first();

            if ($existingUser) {
                $existingUsers[] = $user;
            } else {
                $userRequest = new Request();
                $userRequest->merge(['dealershipId' => $dealershipId]);
                foreach ($user as $key => $value) {
                    $userRequest->merge([$key => $value]);
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
}
