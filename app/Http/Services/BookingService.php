<?php


namespace App\Http\Services;

use App\Http\Contracts\BookingInterface;
use App\User;
use App\Vehicle;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class BookingService implements BookingInterface
{   

    public function index()
    {
        $vehicles = Vehicle::all();
        return $vehicles;
    }

    public function create($credentials)
    {
        $user = User::where('id',$credentials['user_id'])->first();
        return $user->booked_vehicles()->attach($credentials['vehicle_id'],['booked_date'=> Carbon::parse($credentials['booked_date'])]);
    }

    public function delete($id)
    {
        return Auth::user()->booked_vehicles()->wherePivot('user_id', Auth::user()->id)->detach($id);
    }
}
