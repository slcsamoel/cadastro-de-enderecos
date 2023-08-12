<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('enderecos')->insert([
            'cep'=> '01001000',
            'logradouro' => 'Praça da Sé',
            'bairro' => 'Sé',
            'cidade' => 'São Paulo',
            'uf' => 'SP',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('enderecos')->insert([
            'cep'=> '91420270',
            'logradouro' => 'Rua São Domingos',
            'bairro' => 'Bom Jesus',
            'cidade' => 'Porto Alegre',
            'uf' => 'RS',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}
