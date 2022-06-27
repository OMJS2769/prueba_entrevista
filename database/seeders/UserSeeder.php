<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Http\Controllers\MigrationController;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = MigrationController::ExcelExtraction('users.xlsx', 'app/db');

        $this->command->getOutput()->writeln("Extrayendo Usuarios:");
        $this->command->getOutput()->progressStart(count($data));

        User::truncate();

        foreach ($data as $row) {
            User::UpdateOrCreate([
                'name' => $row['name'],
                'email' => $row['email'],
                'password' => bcrypt($row['password'])
            ]);
            $this->command->getOutput()->progressAdvance();
        }
        $this->command->getOutput()->progressFinish();
        $this->command->getOutput()->writeln("Usuarios insertados:");
    }
}
