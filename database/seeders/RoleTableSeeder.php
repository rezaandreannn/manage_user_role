<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'super admin',
                'title' => 'Super Admin',
                'status' => 1,
            ],
            [
                'name' => 'admin',
                'title' => 'Admin',
                'status' => 1,
            ],
            [
                'name' => 'staff',
                'title' => 'Staff',
                'status' => 1,
            ],
            [
                'name' => 'management',
                'title' => 'Management',
                'status' => 1,
            ]
        ];

        foreach ($roles as $key => $value) {
            $role = Role::create($value);
        }
    }
}
