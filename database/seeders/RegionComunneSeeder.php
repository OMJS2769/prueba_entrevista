<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Http\Controllers\MigrationController;
use App\Models\Region;
use App\Models\Commune;

class RegionComunneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = MigrationController::ExcelExtraction('regions.xlsx', 'app/db');

        $this->command->getOutput()->writeln("Extrayendo regiones y comunas:");
        Commune::truncate();
        Region::truncate();

        foreach ($data as $row) {
            Region::updateOrCreate($row);
        }

        $regions = Region::all();

        foreach($regions as $region){
            $data = MigrationController::ExcelExtraction('communes.xlsx', 'app/db');
            $this->command->getOutput()->progressStart(count($data));
            foreach($data as $row){
                if($region->description == $row['reg']){

                    Commune::updateOrCreate([
                        'id_reg' => $region->id,
                        'description' => $row['description'],
                        'status' => $row['status']
                    ]);
                    $this->command->getOutput()->progressAdvance();
                }
            }
        }
        $this->command->getOutput()->progressFinish();
        $this->command->getOutput()->writeln("Regiones y comunas insertados");
    }
}
