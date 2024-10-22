<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('provinces')->insert([
            ['name' => 'Villa Clara','created_at'=> now(),'updated_at'=> now()],
            ['name' => 'Cienfuegos','created_at'=> now(),'updated_at'=> now()],
            ['name' => 'Sancti Spíritus','created_at'=> now(),'updated_at'=> now()],
            ['name' => 'Ciego de Ávila','created_at'=> now(),'updated_at'=> now()],
            ['name' => 'Matanzas','created_at'=> now(),'updated_at'=> now()],
            ['name' => 'Camagüey','created_at'=> now(),'updated_at'=> now()],
            
        ]);
    }
}
