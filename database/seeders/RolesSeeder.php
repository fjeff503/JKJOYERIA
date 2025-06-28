<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = array(
            [
                'name' => 'user',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'sales',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'admin',
                'created_at' => Carbon::now()
            ]
        );

        //almacenar data
        DB::table('roles')->insert($data);
    }
}
