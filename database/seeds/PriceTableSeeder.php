<?php

use Illuminate\Database\Seeder;
use App\RoomType;
class PriceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $roomtypes = RoomType::all();
        $price = 5000;
        foreach ($roomtypes as $roomtype) {
          DB::table('prices')->insert([
            'price' => $price,
            'room_type_id' => $roomtype->id
          ]);
          $price = $price * 2;
        }
    }
}
