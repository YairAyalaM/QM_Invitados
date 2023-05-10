<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        // Establecer la posición en el ID del usuario
            DB::table('users')->get()->each(function ($user) {
            DB::table('users')->where('id', $user->id)->update(['position' => $user->id]);
        });

        // Establecer la posición para el usuario de prueba
        DB::table('users')->where('email', 'test@example.com')->update(['position' => 999]);
    }
}
