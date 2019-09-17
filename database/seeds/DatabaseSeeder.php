<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UserTableSeeder::class);
         $this->call(HotelTableSeeder::class);
         $this->call(RoomTypeTableSeeder::class);
         $this->call(PriceTableSeeder::class);
         $this->call(RoomTableSeeder::class);
         $this->call(BookingSeeder::class);
    }
}
