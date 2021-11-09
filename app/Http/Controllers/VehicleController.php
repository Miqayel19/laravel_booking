<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\VehicleRequest;
use App\Http\Contracts\VehicleInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;



class VehicleController extends Controller
{

        protected $vehicleService;

        public function __construct(VehicleInterface $vehicleService)
        {
            $this->vehicleService = $vehicleService;
        }

       /**
        * Add Vehicle
        *
        * @param VehicleRequest $request
        */
       public function store(VehicleRequest $request)
       {

           $credentials = [
               'type' => $request->type,
               'brand' => $request->brand,
               'max_passenger_number' => $request->max_passenger_number,
               'user_id' => Auth::user()->id
           ];
            $newVehicle = $this->vehicleService->create($credentials);
            if ($newVehicle) {

                  $vehicles = $this->vehicleService->index();

                  Session::flash('flash_message', 'Vehicle added successfully');
                  Session::flash('flash_type', 'alert-success');

                  return redirect('/home')->with('vehicles', $vehicles);
            }
            else {

                    Session::flash('flash_message', 'Vehicle can not be added');
                    Session::flash('flash_type', 'alert-danger');

                  return redirect()->back();
            }
       }

       public function destroy($id)
       {
           $vehicle = $this->vehicleService->delete($id);

           if($vehicle){

                Session::flash('flash_message', 'Vehicle deleted successfully');
                Session::flash('flash_type', 'alert-success');
               
                return redirect('/home');
           }

            Session::flash('flash_message', 'Vehicle not deleted,try again');
            Session::flash('flash_type', 'alert-danger');

           return redirect()->back();
       }
}
