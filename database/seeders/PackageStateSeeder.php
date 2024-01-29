<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackageStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = array(
            [
                'name' => 'Entregado',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'No Entregado',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'Reenvio',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'Extraviado',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'Dañado',
                'created_at' => Carbon::now()
            ],
        );

        //almacenar data
        DB::table('package_states')->insert($data);
    }
}
