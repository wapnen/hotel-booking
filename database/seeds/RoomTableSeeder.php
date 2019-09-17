<?php

use Illuminate\Database\Seeder;
use App\Hotel;
class RoomTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $hotel = Hotel::where('name', 'Hotel Artemis')->first();
        $premium = DB::table('room_types')->where('name', 'Premium')->first();
        for ($i=0; $i <=5 ; $i++) {
          DB::table('rooms')->insert([
            'name' => 'A2'.$i,
            'hotel_id' => $hotel->id,
            'room_type_id' => $premium->id,
            'image' => 'a222-1.jpg'
          ]);
        }
        $deluxe = DB::table('room_types')->where('name', 'Deluxe')->first();
        for ($i=1; $i <=5 ; $i++) {
          DB::table('rooms')->insert([
            'name' => 'A2'.$i,
            'hotel_id' => $hotel->id,
            'room_type_id' => $deluxe->id,
            'image' => 'a222-1.jpg'
          ]);
        }
    }
}
