<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\Wing;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $buildings = Building::all();
        foreach ($buildings as $building) {
            if ($building->campus =="Universitaria") {
                Wing::create([
                    'name' => 'A',
                    'building_id' => $building->id
                ]);
                Wing::create([
                    'name' => 'B',
                    'building_id' => $building->id
                ]);
                if($building->name == '900'){
                    Wing::create([
                    'name' => 'C',
                    'building_id' => $building->id
                ]);
                }   
            }else{
                Wing::create([
                    'name' => 'E',
                    'building_id' => $building->id
                ]);
            }    
                
            }
        }
    
}
