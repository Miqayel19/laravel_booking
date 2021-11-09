<?php

namespace App\Http\Contracts;

interface VehicleInterface{
    public function index();
    public function create($credentials);
    public function delete($id);
}
