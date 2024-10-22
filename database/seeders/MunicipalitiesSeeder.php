<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MunicipalitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('municipalities')->insert([
            //villa clara
            ['name' => 'Caibarién', 'province_id' => '1','created_at'=> now(),'updated_at'=> now()],
            ['name' => 'Remedios', 'province_id' => '1','created_at'=> now(),'updated_at'=> now()],
            ['name' => 'Camajuaní', 'province_id' => '1','created_at'=> now(),'updated_at'=> now()],
            ['name' => 'Placetas', 'province_id' => '1','created_at'=> now(),'updated_at'=> now()],
            ['name' => 'Santo Domingo', 'province_id' => '1','created_at'=> now(),'updated_at'=> now()],
            ['name' => 'Esperanza', 'province_id' => '1','created_at'=> now(),'updated_at'=> now()],
            ['name' => 'Corralillo', 'province_id' => '1','created_at'=> now(),'updated_at'=> now()],
            ['name' => 'Sagua', 'province_id' => '1','created_at'=> now(),'updated_at'=> now()],
            ['name' => 'Manicaragua', 'province_id' => '1','created_at'=> now(),'updated_at'=> now()],
            ['name' => 'Ranchuelo', 'province_id' => '1','created_at'=> now(),'updated_at'=> now()],
            ['name' => 'Quemado', 'province_id' => '1','created_at'=> now(),'updated_at'=> now()],
            ['name' => 'Cifuentes', 'province_id' => '1','created_at'=> now(),'updated_at'=> now()],
            ['name' => 'Encrucijada', 'province_id' => '1','created_at'=> now(),'updated_at'=> now()],
            // Cienfuegos
            ['name' => 'Cienfuegos', 'province_id' => '2','created_at' => now(),'updated_at'=> now() ],
            ['name' => 'Palmira', 'province_id' => '2','created_at' => now(),'updated_at'=> now() ],
            ['name' => 'Rodas', 'province_id' => '2','created_at' => now(),'updated_at'=> now() ],
            ['name' => 'Abreus', 'province_id' => '2','created_at' => now(),'updated_at'=> now() ],
            ['name' => 'Cruces', 'province_id' => '2','created_at' => now(),'updated_at'=> now() ],
            ['name' => 'Cumanayagua', 'province_id' => '2','created_at' => now(),'updated_at'=> now() ],
            ['name' => 'Lajas', 'province_id' => '2','created_at' => now(),'updated_at'=> now() ],
            ['name' => 'Palmira', 'province_id' => '2','created_at' => now(),'updated_at'=> now() ],
            ['name' => 'Santa Isabel de las Lajas', 'province_id' => '2','created_at' => now(),'updated_at'=> now() ],
            ['name' => 'Yaguaramas', 'province_id' => '2','created_at' => now(),'updated_at'=> now() ],
            // Sancti Spíritus
            ['name' => 'Sancti Spíritus', 'province_id' => '3','created_at' => now(),'updated_at'=> now()],
            ['name' => 'Trinidad', 'province_id' => '3','created_at' => now(),'updated_at'=> now()],
            ['name' => 'Cabaiguán', 'province_id' => '3','created_at' => now(),'updated_at'=> now()],
            ['name' => 'Yaguajay', 'province_id' => '3','created_at' => now(),'updated_at'=> now()],
            ['name' => 'Jatibonico', 'province_id' => '3','created_at' => now(),'updated_at'=> now()],
            ['name' => 'Fomento', 'province_id' => '3','created_at' => now(),'updated_at'=> now()],
            ['name' => 'La Sierpe', 'province_id' => '3','created_at' => now(),'updated_at'=> now()],
            ['name' => 'Taguasco', 'province_id' => '3','created_at' => now(),'updated_at'=> now()],
            ['name' => 'Tuinucú', 'province_id' => '3','created_at' => now(),'updated_at'=> now()],
            ['name' => 'Cabaiguán', 'province_id' => '3','created_at' => now(),'updated_at'=> now()],
             // Ciego de Ávila
            ['name' => 'Ciego de Ávila', 'province_id' => '4','created_at' => now(),'updated_at'=> now()],
            ['name' => 'Baraguá', 'province_id' => '4','created_at' => now(),'updated_at'=> now()],
            ['name' => 'Morón', 'province_id' => '4','created_at' => now(),'updated_at'=> now()],
            ['name' => 'Chambas', 'province_id' => '4','created_at' => now(),'updated_at'=> now()],
            ['name' => 'Ciro Redondo', 'province_id' => '4','created_at' => now(),'updated_at'=> now()],
            ['name' => 'Florencia', 'province_id' => '4','created_at' => now(),'updated_at'=> now()],
            // Matanzas
            ['name' => 'Matanzas', 'province_id' => '5','created_at' => now(),'updated_at'=> now()],
            ['name' => 'Cárdenas', 'province_id' => '5','created_at' => now(),'updated_at'=> now()],
            ['name' => 'Varadero', 'province_id' => '5','created_at' => now(),'updated_at'=> now()],
            ['name' => 'Colón', 'province_id' => '5','created_at' => now(),'updated_at'=> now()],
            ['name' => 'Perico', 'province_id' => '5','created_at' => now(),'updated_at'=> now()],
            ['name' => 'Martí', 'province_id' => '5','created_at' => now(),'updated_at'=> now()],
            ['name' => 'Unión de Reyes', 'province_id' => '5','created_at' => now(),'updated_at'=> now()],
            ['name' => 'Pedro Betancourt', 'province_id' => '5','created_at' => now(),'updated_at'=> now()],
            ['name' => 'Limonar', 'province_id' => '5','created_at' => now(),'updated_at'=> now()],
            ['name' => 'Jagüey Grande', 'province_id' => '5','created_at' => now(),'updated_at'=> now()],
            ['name' => 'Calimete', 'province_id' => '5','created_at' => now(),'updated_at'=> now()],
            ['name' => 'Ciénaga de Zapata', 'province_id' => '5','created_at' => now(),'updated_at'=> now()],
            ['name' => 'Jovellanos', 'province_id' => '5','created_at' => now(),'updated_at'=> now()],
            ['name' => 'Los Arabos', 'province_id' => '5','created_at' => now(),'updated_at'=> now()],
             // Camagüey
            ['name' => 'Camagüey', 'province_id' => '6','created_at' => now(),'updated_at'=> now()],
            ['name' => 'Nuevitas', 'province_id' => '6','created_at' => now(),'updated_at'=> now()],
            ['name' => 'Florida', 'province_id' => '6','created_at' => now(),'updated_at'=> now()],
            ['name' => 'Esmeralda', 'province_id' => '6','created_at' => now(),'updated_at'=> now()],
            ['name' => 'Guáimaro', 'province_id' => '6','created_at' => now(),'updated_at'=> now()],
            ['name' => 'Vertientes', 'province_id' => '6','created_at' => now(),'updated_at'=> now()],
            ['name' => 'Santa Cruz del Sur', 'province_id' => '6','created_at' => now(),'updated_at'=> now()],
            ['name' => 'Sibanicú', 'province_id' => '6','created_at' => now(),'updated_at'=> now()],
            ['name' => 'Jimaguayú', 'province_id' => '6','created_at' => now(),'updated_at'=> now()],
            ['name' => 'Minas', 'province_id' => '6','created_at' => now(),'updated_at'=> now()],
            ['name' => 'Najasa', 'province_id' => '6','created_at' => now(),'updated_at'=> now()],
            ['name' => 'Carlos Manuel de Céspedes', 'province_id' => '6','created_at' => now(),'updated_at'=> now()],
            ['name' => 'Jimaguayú', 'province_id' => '6','created_at' => now(),'updated_at'=> now()],
            ['name' => 'Santa Cruz del Sur', 'province_id' => '6','created_at' => now(),'updated_at'=> now()], 
        ]);
    }
}
