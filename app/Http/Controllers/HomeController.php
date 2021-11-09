<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Contracts\BookingInterface;
use App\Http\Contracts\VehicleInterface;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

        protected $bookingService;
        protected $vehicleService;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(BookingInterface $bookingService, VehicleInterface $vehicleService)
    {

        $this->bookingService = $bookingService;
        $this->vehicleService = $vehicleService;

        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $vehicles = $this->vehicleService->index();
        return view('home',compact('vehicles'));
    }
}
