<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Region;
use App\Models\Commune;
use Str;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Customer::truncate();
        $faker = \Faker\Factory::create();

        $cant = 49;

        $this->command->getOutput()->writeln("Creando clientes:");
        $this->command->getOutput()->progressStart($cant);

        for($i = 0; $i <= $cant; $i++)
        {
            $dni = Str::upper(Str::random(16));
            $c = Customer::where('dni',$dni)->first();
            if(!$c)
            {
                $id_reg = Region::inRandomOrder()->limit(1)->first();
                $id_com = Commune::where('id_reg',$id_reg->id)->inRandomOrder()->limit(1)->first();

                Customer::create([
                    'dni' => $dni,
                    'id_reg' => $id_com->id_reg,
                    'id_com' => $id_com->id,
                    'email' => $faker->email,
                    'name' => $faker->name,
                    'last_name' => $faker->lastName,
                    'address' => $faker->address,
                    'date_reg' => date('Y-m-d H:i:s'),
                    'status' => $faker->randomElement(['A','I'])
                ]);


            }
            $this->command->getOutput()->progressAdvance();
        }

        $this->command->getOutput()->progressFinish();
        $this->command->getOutput()->writeln("Clientes creados:");

    }
}
