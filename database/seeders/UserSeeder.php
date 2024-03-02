<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;


    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => static::$password ??= Hash::make('password'),
            'role' => 'admin',
        ]);
        User::factory()->create([
            'name' => 'organizer',
            'email' => 'organizer@gmail.com',
            'password' => static::$password ??= Hash::make('password'),
            'role' => 'organizer',
        ]);
        User::factory(10)->create();
    }
}
