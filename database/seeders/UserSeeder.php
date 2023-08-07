<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      for($i = 0; $i <= 15; $i++){
        DB::table('users')->insert([
          'name' => Str::random(10),
          'email' => Str::random(10).'@gmail.com',
          'password' => Hash::make('password'),
          'type' => '2',
          'permite_dados' => '1',
          'is_employed' => random_int(0, 1),
          'ano_ingresso' => random_int(2017, 2022),
          'ano_egresso' => random_int(2023, 2029),
          'curso_id'  => random_int(1, 10),
          'status' => '0',
        ]);
      }
    }
}
