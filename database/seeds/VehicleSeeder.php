<?php

use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vehicles')->insert([
            [
                'type' => 'scooter',
                'brand' =>'Peuogeot',
                'max_passenger_number' => 3,
            ],
            [
                'type' => 'scooter',
                'brand' =>'Aprillia',
                'max_passenger_number' => 5,
            ],
            [
                'type' => 'bike',
                'brand' =>'Wheeler',
                'max_passenger_number' => 6,
            ],
            [
                'type' => 'bike',
                'brand' =>'Giant',
                'max_passenger_number' => 7,
            ]
        ]);
    }
}
