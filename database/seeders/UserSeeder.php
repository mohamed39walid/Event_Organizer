<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds. 
     */
    public function run(): void
    {
        /**
         * DumbUser
         */
        User::factory()->create([
            'fullname' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'role' => 'organizer',
        ]);
        User::factory(1)->create();
    }
}
