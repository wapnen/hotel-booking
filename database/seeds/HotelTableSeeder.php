<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class HotelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('hotels')->insert([
          'name' => 'Hotel Artemis',
          'address' => 'No. 2 Rabo Close, Fwavei',
          'city' => 'Jos',
          'state' => 'Plateau',
          'country' => 'Nigeria',
          'zip_code' => '930252',
          'phone' => '0923423333',
          'email' => 'info@hotelartemis.com'
        ]);
    }
}
