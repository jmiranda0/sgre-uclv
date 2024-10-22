<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=1; $i <28 ; $i++)   {
            $j = $i>=18 && $i<=27 ? 6:4;  
            DB::table('rooms')->insert([
                ['number' => '101', 'room_capacity' => $j,'wing_id'=> $i,'created_at'=> now(),'updated_at'=> now()],
                ['number' => '102', 'room_capacity' => $j,'wing_id'=> $i,'created_at'=> now(),'updated_at'=> now()],
                ['number' => '103', 'room_capacity' => $j,'wing_id'=> $i,'created_at'=> now(),'updated_at'=> now()],
                ['number' => '104', 'room_capacity' => $j,'wing_id'=> $i,'created_at'=> now(),'updated_at'=> now()],
                ['number' => '105', 'room_capacity' => $j,'wing_id'=> $i,'created_at'=> now(),'updated_at'=> now()],
                ['number' => '106', 'room_capacity' => $j,'wing_id'=> $i,'created_at'=> now(),'updated_at'=> now()],
                ['number' => '107', 'room_capacity' => $j,'wing_id'=> $i,'created_at'=> now(),'updated_at'=> now()],
                ['number' => '108', 'room_capacity' => $j,'wing_id'=> $i,'created_at'=> now(),'updated_at'=> now()],
                ['number' => '201', 'room_capacity' => $j,'wing_id'=> $i,'created_at'=> now(),'updated_at'=> now()],
                ['number' => '202', 'room_capacity' => $j,'wing_id'=> $i,'created_at'=> now(),'updated_at'=> now()],
                ['number' => '203', 'room_capacity' => $j,'wing_id'=> $i,'created_at'=> now(),'updated_at'=> now()],
                ['number' => '204', 'room_capacity' => $j,'wing_id'=> $i,'created_at'=> now(),'updated_at'=> now()],
                ['number' => '205', 'room_capacity' => $j,'wing_id'=> $i,'created_at'=> now(),'updated_at'=> now()],
                ['number' => '206', 'room_capacity' => $j,'wing_id'=> $i,'created_at'=> now(),'updated_at'=> now()],
                ['number' => '207', 'room_capacity' => $j,'wing_id'=> $i,'created_at'=> now(),'updated_at'=> now()],
                ['number' => '208', 'room_capacity' => $j,'wing_id'=> $i,'created_at'=> now(),'updated_at'=> now()],
                ['number' => '301', 'room_capacity' => $j,'wing_id'=> $i,'created_at'=> now(),'updated_at'=> now()],
                ['number' => '302', 'room_capacity' => $j,'wing_id'=> $i,'created_at'=> now(),'updated_at'=> now()],
                ['number' => '303', 'room_capacity' => $j,'wing_id'=> $i,'created_at'=> now(),'updated_at'=> now()],
                ['number' => '304', 'room_capacity' => $j,'wing_id'=> $i,'created_at'=> now(),'updated_at'=> now()],
                ['number' => '305', 'room_capacity' => $j,'wing_id'=> $i,'created_at'=> now(),'updated_at'=> now()],
                ['number' => '306', 'room_capacity' => $j,'wing_id'=> $i,'created_at'=> now(),'updated_at'=> now()],
                ['number' => '307', 'room_capacity' => $j,'wing_id'=> $i,'created_at'=> now(),'updated_at'=> now()],
                ['number' => '308', 'room_capacity' => $j,'wing_id'=> $i,'created_at'=> now(),'updated_at'=> now()],
                
            ]);

        }
    }
}
