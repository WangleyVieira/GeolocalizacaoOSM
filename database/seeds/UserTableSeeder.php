<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $uuid1 = Uuid::uuid4();

        DB::table('users')->insert([
            'id' => $uuid1,
            'name' => 'Teste',
            'email' => 'suporte@teste.com.br',
            'password' => Hash::make('teste@'),
            'ativo' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
