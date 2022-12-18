<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                "id" => 1,
                "name" => "Admin",
                "slug" => "admin",
            ],
            [
                "id" => 2,
                "name" => "MD",
                "slug" => "md",
            ],
            [
                "id" => 3,
                "name" => "Supplier",
                "slug" => "supplier",
            ],
            [
                "id" => 4,
                "name" => "Admin Cabang",
                "slug" => "admin-cabang",
            ]
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
