<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Agile',
            'email' => 'suporte@agile.inf.br',
            'password' => Hash::make('sup2011@'),
            'ativo' => 1,
            'created_at' => '2022-08-16 23:47:10',
            'updated_at' => '2022-08-16 23:47:10'
        ]);
    }
}
