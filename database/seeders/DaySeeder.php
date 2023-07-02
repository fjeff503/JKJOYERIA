<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = array(
            [
                'name'=>'Lunes',
            'created_at' => Carbon::now()
            ],
            [
                'name'=>'Martes',
            'created_at' => Carbon::now()
            ],
            [
                'name'=>'Miercoles',
            'created_at' => Carbon::now()
            ],
            [
                'name'=>'Jueves',
            'created_at' => Carbon::now()
            ],
            [
                'name'=>'Viernes',
            'created_at' => Carbon::now()
            ],
            [
                'name'=>'Sabado',
            'created_at' => Carbon::now()
            ],
            [
                'name'=>'Domingo',
            'created_at' => Carbon::now()
            ],
        );

        //almacenar data
        DB::table('days')->insert($data);

    }
}
