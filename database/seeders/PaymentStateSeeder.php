<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = array(
            [
                'name'=>'Pagado',
            'created_at' => Carbon::now()
            ],
            [
                'name'=>'Pendiente',
            'created_at' => Carbon::now()
            ]
        );

        //almacenar data
        DB::table('payment_states')->insert($data);
    }
}
