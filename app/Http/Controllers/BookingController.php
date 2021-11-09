<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subscription;
use App\Http\Contracts\BookingInterface;
use App\Http\Contracts\VehicleInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class BookingController extends Controller
{
        protected $bookingService;

        public function __construct(BookingInterface $bookingService)
        {
            $this->middleware('auth');
            $this->bookingService = $bookingService;
        }


        /**
        * POST /book
        * Create Booking
        *
        * @param Request $request
        */
       public function book(Request $request,VehicleInterface $vehicleService)
       {

            $validator = Validator::make($request->all(), [
                'vehicle_id' => 'required|integer',
                'booked_date' => 'required|date',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
            }
            $user = Auth::user();
            if($user){
                $booking = $user->booked_vehicles()->where(['bookings.vehicle_id'=> $request->vehicle_id,'bookings.user_id' => $user['id'],'bookings.booked_date'=> Carbon::parse($request->booked_date)])->exists();
                if($booking){

                    Session::flash('flash_message', 'Vehicle already booked');
                    Session::flash('flash_type', 'alert-info');
                    
                    return redirect()->back();
                }else {
                    $credentials = [
                        'user_id' => $user['id'],
                        'vehicle_id' => $request->vehicle_id,
                        'booked_date' => $request->booked_date,
                    ];
                   $this->bookingService->create($credentials);
                   $newBooking = $user->booked_vehicles()->where(['bookings.vehicle_id' => $request->vehicle_id,'bookings.user_id' => $user['id'] ])->exists();
                   if ($newBooking) {
                        $bookings = $this->bookingService->index($user['id']);
                        Session::flash('flash_message', 'Vehicle booked successfully');
                        Session::flash('flash_type', 'alert-success');
                        $vehicles = $vehicleService->index();

                        return redirect('/home')->with(['vehicles' => $vehicles,'my_booked_vehicles' => $user->booked_vehicles]);
                   }
                   else {
                        Session::flash('flash_message', 'Vehicle cant be booked');
                        Session::flash('flash_type', 'alert-danger');

                        return redirect()->back();
                   }
                }
            }
            else {
                Session::flash('flash_message', 'User not found');
                Session::flash('flash_type', 'alert-danger');
                
                return redirect()->back();
           }
       }

        public function create()
        {
               return view('vehicle.create');
        }

        public function cancelBooking($book_id)
       {
           $booking = $this->bookingService->delete($book_id);

           if($booking){

                Session::flash('flash_booking_message', 'Booking canceled successfully');
                Session::flash('flash_type', 'alert-success');
               
                return redirect('/home');
           }

            Session::flash('flash_booking_message', 'Booking not canceled,try again');
            Session::flash('flash_type', 'alert-danger');

           return redirect()->back();
       }
}
