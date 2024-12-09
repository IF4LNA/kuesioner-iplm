<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data akun admin
        $admins = [
            ['username' => 'Admin Disarpus 1', 'password' => Hash::make('adm_disarpus1'), 'role' => 'admin'],
            ['username' => 'Admin Disarpus 2', 'password' => Hash::make('adm_disarpus2'), 'role' => 'admin'],
            ['username' => 'Admin Disarpus 3', 'password' => Hash::make('adm_disarpus3'), 'role' => 'admin'],
        ];

        // Data akun pustakawan
        $pustakawans = [];
        for ($i = 1; $i <= 10; $i++) {
            $pustakawans[] = [
                'username' => 'pustakawan' . $i,
                'password' => Hash::make('pustakawan123'),
                'role' => 'pustakawan',
            ];
        }

        // Insert data akun admin dan pustakawan
        User::insert($admins);
        User::insert($pustakawans);
    }
}
