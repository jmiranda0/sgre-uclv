<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('buildings')->insert([
            ['name' => 'U1', 'campus'=>'Universitaria','created_at'=> now(),'updated_at'=> now()],
            ['name' => 'U2', 'campus'=>'Universitaria','created_at'=> now(),'updated_at'=> now()],
            ['name' => 'U3', 'campus'=>'Universitaria','created_at'=> now(),'updated_at'=> now()],
            ['name' => 'U4', 'campus'=>'Universitaria','created_at'=> now(),'updated_at'=> now()],
            ['name' => 'U5', 'campus'=>'Universitaria','created_at'=> now(),'updated_at'=> now()],
            ['name' => 'U6', 'campus'=>'Universitaria','created_at'=> now(),'updated_at'=> now()],
            ['name' => 'U7', 'campus'=>'Universitaria','created_at'=> now(),'updated_at'=> now()],
            ['name' => 'U8', 'campus'=>'Universitaria','created_at'=> now(),'updated_at'=> now()],
            ['name' => 'U9', 'campus'=>'Universitaria','created_at'=> now(),'updated_at'=> now()],
            ['name' => 'U10', 'campus'=>'Universitaria','created_at'=> now(),'updated_at'=> now()],
            ['name' => 'U11', 'campus'=>'Universitaria','created_at'=> now(),'updated_at'=> now()],
            ['name' => '900', 'campus'=>'Universitaria','created_at'=> now(),'updated_at'=> now()],
            ['name' => 'C1', 'campus'=>'Universitaria','created_at'=> now(),'updated_at'=> now()],
            ['name' => 'C2', 'campus'=>'Universitaria','created_at'=> now(),'updated_at'=> now()],
            ['name' => 'C3', 'campus'=>'Universitaria','created_at'=> now(),'updated_at'=> now()],
            ['name' => 'C4', 'campus'=>'Universitaria','created_at'=> now(),'updated_at'=> now()],
            ['name' => 'C5', 'campus'=>'Universitaria','created_at'=> now(),'updated_at'=> now()],
            ['name' => 'E1', 'campus'=>'Félix Varela','created_at'=> now(),'updated_at'=> now()],
            ['name' => 'E2', 'campus'=>'Félix Varela','created_at'=> now(),'updated_at'=> now()],
            ['name' => 'E3', 'campus'=>'Félix Varela','created_at'=> now(),'updated_at'=> now()],
            ['name' => 'E4', 'campus'=>'Félix Varela','created_at'=> now(),'updated_at'=> now()],
            ['name' => 'E5', 'campus'=>'Félix Varela','created_at'=> now(),'updated_at'=> now()],
        ]);
    }
}
