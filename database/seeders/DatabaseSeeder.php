<?php

namespace Database\Seeders;

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
        DB::table('users')->insert([
            'nama' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123'),
            'auth' => 'admin',
        ]);

        DB::table('users')->insert([
            'nama' => 'Ambativasi',
            'email' => 'amba@gmail.com',
            'password' => bcrypt('123'),
            'auth' => 'customer',
        ]);

        DB::table('category')->insert([
            'nama' => 'Pakaian',
            'harga' => '7000',
            'icon' => 'img/shirt.png'
        ]);
        DB::table('category')->insert([
            'nama' => 'Seprai',
            'harga' => '35000',
            'icon' => 'img/bed.png'
        ]);
        DB::table('category')->insert([
            'nama' => 'Sepatu',
            'harga' => '3500',
            'icon' => 'img/shoes.png'
        ]);

        DB::table('category')->insert([
            'nama' => 'Handuk',
            'harga' => '5000',
            'icon' => 'img/towel.png'
        ]);
        DB::table('category')->insert([
            'nama' => 'Jas',
            'harga' => '15000',
            'icon' => 'img/suit.png'
        ]);
        DB::table('category')->insert([
            'nama' => 'Jaket',
            'harga' => '12000',
            'icon' => 'img/jacket.png'
        ]);
        DB::table('category')->insert([
            'nama' => 'Tas',
            'harga' => '20000',
            'icon' => 'img/backpack.png'
        ]);
        DB::table('category')->insert([
            'nama' => 'Gulungan Karpet',
            'harga' => '25000',
            'icon' => 'img/carpet.png'
        ]);
        DB::table('category')->insert([
            'nama' => 'Celana',
            'harga' => '12000',
            'icon' => 'img/celana.png'
        ]);
        DB::table('category')->insert([
            'nama' => 'Dress',
            'harga' => '25000',
            'icon' => 'img/dress.png'
        ]);
        DB::table('category')->insert([
            'nama' => 'Setelan Olahraga',
            'harga' => '18000',
            'icon' => 'img/sportswear.png'
        ]);
        DB::table('category')->insert([
            'nama' => 'Topi',
            'harga' => '5000',
            'icon' => 'img/topi.png'
        ]);
    }
}
