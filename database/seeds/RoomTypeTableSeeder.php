<?php

use Illuminate\Database\Seeder;

class RoomTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
      
        DB::table('room_types')->insert([
          'name'=> 'Premium'
        ]);
        DB::table('room_types')->insert([
          'name'=> 'Deluxe'
        ]);
        DB::table('room_types')->insert([
          'name'=> 'Regular'
        ]);
    }
}
