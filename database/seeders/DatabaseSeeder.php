<?php

namespace Database\Seeders;

use App\Models\Gudang;
use App\Models\role;
use App\Models\User;
use App\Models\pabrik;
use App\Models\pembeli;
use App\Models\produk;
use App\Models\Stock_produk;
use App\Models\transaksi;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Pdo\Mysql;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        pabrik::create([
            'name' => 'jelekong corp',
            'alamat' => 'kacamatan ciparay',
            'no_telepon' => '01293103910'
        ]);
        pabrik::create([
            'name' => 'ciparay corp',
            'alamat' => 'kacamatan ciparay',
            'no_telepon' => '01293103231'
        ]);
            pembeli::factory()->create([
            'name' => 'aqil',
            'alamat' => 'jawa',
            'no_telepon' => '021023012',
            'id_pabrik' => 1
        ]);
                Gudang::factory()->create([
            'id_pabrik' => 1,
            'nama' => 'gudang_sukabumi',
            'alamat' => 'sukabumi',
            'no_telepon' => '0123131'
        ]);
   transaksi::factory(10)->create();

        role::create([
            'name' => 'admin'
        ]);
        role::create([
            'name' => 'orang gudang'
        ]);
        role::create([
            'name' => 'owner'
        ]);
        role::create([
            'name' => 'super admin'
        ]);
        User::factory()->create([
            'name' => 'aqil',
            'pabrik_id' => 1,
            'role_id' => 3,
            'password' => Hash::make('password'),
            'email' => 'ayane9012@gmail.com',
            'alamat' => 'jelekong chan'
        ]);
        User::factory()->create([
            'name' => 'rasya',
            'pabrik_id' => 1,
            'role_id' => 2,
            'gudang_id' => 1,
            'password' => Hash::make('password'),
            'email' => 'rasya@gmail.com',
            'alamat' => 'jelekong chan'
        ]);
        User::factory()->create([
            'name' => 'tasnim',
            'pabrik_id' => 1,
            'role_id' => 1,
            'password' => Hash::make('password'),
            'email' => 'tasnim@gmail.com',
            'alamat' => 'jelekong chan'
        ]);
        User::factory()->create([
            'name' => 'beti',
            'pabrik_id' => 2,
            'role_id' => 1,
            'password' => Hash::make('password'),
            'email' => 'beatrice@gmail.com',
            'alamat' => 'jelekong chan'
        ]);
        User::factory()->create([
            'name' => 'Killua',
            'role_id' => 4,
            'password' => Hash::make('password'),
            'email' => 'killua@gmail.com',
            'alamat' => 'Shiranai'
        ]);
        produk::factory()->create([
            'nama' => 'deterjen',
            'deskripsi' => 'deterjen yang sangat wangi',
            'harga_modal' => 5000,
            'harga_jual' => 7000,
            'id_pabrik' => 1
        ]);
        produk::factory()->create([
            'nama' => 'tasnim',
            'deskripsi' => 'tasnim yang sangat wangi',
            'harga_modal' => 8000,
            'harga_jual' => 12000,
            'id_pabrik' => 1
        ]);
    }
}
