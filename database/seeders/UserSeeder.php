<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
                'name' => 'KK',
                'email' => 'keigo.kusano.9v@stu.hosei.ac.jp',
                'email_verified_at' => new DateTime(),
                'password' => 'kk',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
                'delivery' => 'ddd',
         ]);
         DB::table('users')->insert([
                'name' => 'KK2',
                'email' => 'keigo.kusano.9v@stu.hosei.ac.jp',
                'email_verified_at' => new DateTime(),
                'password' => 'kk2',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
                'delivery' => 'ddd2',
         ]);
    }
}
