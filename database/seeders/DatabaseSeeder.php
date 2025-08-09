<?php

namespace Database\Seeders;

use App\Models\role;
use App\Models\User;
use App\Models\pabrik;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
            'name' => 'bearice❤aqil'
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
            'name' => 'Killua',
            'role_id' => 4,
            'password' => Hash::make('password'),
            'email' => 'killua@gmail.com',
            'alamat' => 'Shiranai'
        ]);
    }
}
