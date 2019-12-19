<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class EventUserListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request, $eventId, $dealershipId)
    {
        $data = [];
        $totalUsers = 0;
        $users = User::select(
            'users.*',
            'event_user.*'
        )
            ->leftJoin('event_user', 'event_user.user_id', '=', 'users.id');

        // To get the list view populate
        if ($request->has('paginate') && !empty($request->paginate)) {
            // Search dealership name
            if ($request->has('search') && !empty($request->search)) {
                $users = $users->where('users.email', 'LIKE', '%' . $request->search . '%');
            }

            // Filter by dealership, group, country & region based on
            if($request->has('filterBy') && !empty($request->filterBy)){
                switch($request->filterBy){
                    case 'dealership':
                        $users = $users->where([
                            'users.dealership_id' => $request->dealershipId,
                            'users.level' => User::USERSALEEXECUTIVE
                        ]);
                }
            }

            // If sortBy has set then, sort by region, group, country
            if ($request->has('sortBy') && !empty($request->sortBy)) {
                $sortBy = $request->sortBy;
                switch ($sortBy) {
                    case 'name':
                        $users = $users->orderBy('users.firstname');
                        break;

                    case 'email':
                        $users = $users->orderBy('users.email', 'DESC');
                        break;
                }
            } else {
                $users = $users->orderBy('users.id', 'DESC');
            }

            $users = $users->where('event_user.event_id', $eventId);

            $data = $users->paginate($this->perPage);
            $totalUsers = $data->total();
            $data = $data->items();
        } else {
            $data = $users->get();
            $totalUsers = $users->count();
        }

        return response()->json([
            'users' => $data,
            'total' => $totalUsers
        ]);
    }
}
