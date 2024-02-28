<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
                'product_name' => '箱',
                'product_description' => '入れるもの',
                'product_price' => 300,
                //'image1' => 'url1',
                //'image2' => 'url2',
                'user_id' => 1, // ユーザーの ID を指定する
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
         ]);
         DB::table('products')->insert([
                'product_name' => 'ケース',
                'product_description' => 'ケースの',
                'product_price' => 400,
                //'image1' => 'url1',
                //'image2' => 'url2',
                'user_id' => 1, // ユーザーの ID を指定する
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
         ]);
    }
}
