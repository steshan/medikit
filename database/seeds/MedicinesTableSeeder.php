<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MedicinesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array();
        for ($i = 1; $i <= 50; $i++) {
            array_push($data, array(
                'name' => 'medicine' . $i,
                'component' => 'component' . $i,
                'form' => 'form' . $i,
                'comment' => '',
                'expiration_date' => Carbon::create('2020', '01', $i % 30)
            ));
        }
        DB::table('medicines')->insert($data);
    }
}
