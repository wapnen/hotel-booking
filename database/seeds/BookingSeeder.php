<?php

use Illuminate\Database\Seeder;
use App\Room;
class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $rooms = Room::all();
        foreach($rooms as $room){
            DB::table('bookings')->insert([
            'room_id' => $room->id,
            'start' => date("y-m-d", mt_rand(1, time())),
            'end' => date("y-m-d", mt_rand(1, time())),
            'customer_name' => Str::random(10),
            'customer_email' => Str::random(10).".gmail.com",
            'total_nights' => 1,
            'total_price' => 5000,
          ]);
        }
    }
}
