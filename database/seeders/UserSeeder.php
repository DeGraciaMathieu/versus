<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::where(['email' => 'admin@example.net'])->firstOr(function () {
            return User::factory()->create(['email' => 'admin@example.net', 'role' => 'admin']);
        });
    }
}
