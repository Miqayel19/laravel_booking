<?php

namespace App\Http\Contracts;

interface BookingInterface{
    public function index();
    public function create($credentials);
}
