<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'uuid' => \Illuminate\Support\Str::uuid(),
                'first_name' => 'System',
                'last_name' => 'Admin',
                'username' => 'systemadmin',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'phone_number' => '+12398190255',
                'email_verified_at' => now(),
                'user_type' => 'super admin'
            ],
            [
                'uuid' => \Illuminate\Support\Str::uuid(),
                'first_name' => 'Demo',
                'last_name' => 'Admin',
                'username' => 'demoadmin',
                'email' => 'demo@example.com',
                'password' => bcrypt('password'),
                'phone_number' => '+12398190255',
                'email_verified_at' => now(),
                'user_type' => 'admin'
            ],
            [
                'uuid' => \Illuminate\Support\Str::uuid(),
                'first_name' => 'John',
                'last_name' => 'User',
                'username' => 'user',
                'email' => 'user@example.com',
                'password' => bcrypt('password'),
                'phone_number' => '+12398190255',
                'email_verified_at' => now(),
                'user_type' => 'staff'
            ]
        ];
        foreach ($users as $key => $value) {
            $user = User::create([
                'uuid' => $value['uuid'],
                'username' => $value['username'],
                'first_name' => $value['first_name'],
                'last_name' => $value['last_name'],
                'email' => $value['email'],
                'phone_number' => $value['phone_number'],
                'email_verified_at' => $value['email_verified_at'],
                'password' => $value['password']
            ]);
            $user->assignRole($value['user_type']);

            $permissions = Permission::get();
            // $superAdmin = Role::where('name', 'super admin')->first();
            // if ($superAdmin) {
            //     foreach ($permissions as $permission) {
            //         $superAdmin->givePermissionTo($permission);
            //     }
            // }
        }
    }
}
