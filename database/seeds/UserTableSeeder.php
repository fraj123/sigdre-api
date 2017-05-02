<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $registros = [
            [
                'paterno' => 'Mejia',
                'materno' => 'Luna',
                'nombres' => 'Franz Marcos',
                'username' => 'marcos.mejia',
                'password' => Hash::make('fraMARmej24'),
                'email' => 'marcos.mejia@lapaz.bo',
                'id_cargo' => '1',
                'id_estado' => '2',
            ],
        ];

        foreach($registros as $registro){
            \App\User::create($registro);
        }
    }
}
