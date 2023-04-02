<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'nama' => 'Administrator',
            'email' => 'admin@admin.com',
            'role' => 'admin',
            'password' => bcrypt('admin'),
            'status' => 'aktif',
            'last_login' => now()
        ]);

        User::factory()->count(50)->create();
    }
}

?>