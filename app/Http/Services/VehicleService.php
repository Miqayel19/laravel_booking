<?php


namespace App\Http\Services;

use App\Http\Contracts\VehicleInterface;
use App\Vehicle;

class VehicleService implements VehicleInterface
{
    public function __construct(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;
    }

    public function index()
    {
       $vehicles = Vehicle::all();
       return $vehicles;
    }

    public function create($credentials)
    {
        return $this->vehicle->create($credentials);
    }
    
    public function delete($id)
    {
        return $this->vehicle->where('id', $id)->delete();
    }
}
