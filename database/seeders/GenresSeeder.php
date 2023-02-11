<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GenresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('genres')->delete();

      DB::table('genres')->insert(array(
        0 => array(
          'id' => Str::uuid()->toString(),
          'name' => 'Reggae Music',
          'created_at' => now(),
          'updated_at' => now()
        ),
        1 => array(
          'id' => Str::uuid()->toString(),
          'name' => 'Rock Music',
          'created_at' => now(),
          'updated_at' => now()
        ),
        2 => array(
          'id' => Str::uuid()->toString(),
          'name' => 'Hip hop Music',
          'created_at' => now(),
          'updated_at' => now()
        ),
        3 => array(
          'id' => Str::uuid()->toString(),
          'name' => 'Country Music',
          'created_at' => now(),
          'updated_at' => now()
        ),
        4 => array(
          'id' => Str::uuid()->toString(),
          'name' => 'Funk Music',
          'created_at' => now(),
          'updated_at' => now()
        )
      ));
    }
}
