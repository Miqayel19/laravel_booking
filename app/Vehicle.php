<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'type', 'brand', 'max_passenger_number','user_id'
        ];

        public function booked_vehicles(){
            return $this->belongsToMany('App\User','bookings')->withPivot('booked_date');
        }
}
