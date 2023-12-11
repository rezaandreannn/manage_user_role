<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                // id 1
                'name' => 'role',
                'title' => 'Role',
            ],
            [
                'name' => 'create-role',
                'title' => 'Create Role',
                'parent_id' => 1
            ],
            [
                'name' => 'update-role',
                'title' => 'Update Role',
                'parent_id' => 1
            ],
            [
                'name' => 'delete-role',
                'title' => 'Delete Role',
                'parent_id' => 1
            ],
            [
                // id 5
                'name' => 'permission',
                'title' => 'Read Permission',
            ],
            [
                'name' => 'create-permission',
                'title' => 'Create Permission',
                'parent_id' => 5
            ],
            [
                'name' => 'update-permission',
                'title' => 'Update Permission',
                'parent_id' => 5
            ],
            [
                'name' => 'delete-permission',
                'title' => 'Delete Permission',
                'parent_id' => 5
            ],
            [
                // id 9
                'name' => 'role-permission',
                'title' => 'Role Permission',
            ],
            [
                // id 10
                'name' => 'user-list',
                'title' => 'User List',
            ],
            [
                // id 11
                'name' => 'create-user',
                'title' => 'Create User',
            ],
            [
                // id 12
                'name' => 'show-user',
                'title' => 'Show User',
            ],
            [
                'name' => 'update-user',
                'title' => 'Update User',
                'parent_id' => 10
            ],
            [
                'name' => 'delete-user',
                'title' => 'Delete user',
                'parent_id' => 10
            ],
            [
                'name' => 'update-setting-permission',
                'title' => 'Update Setting Permission',
                'parent_id' => 10
            ],
            [
                // id 20
                'name' => 'batchingplant',
                'title' => 'Batching Plant',
                'type' => 'module'
            ],
            [
                'name' => 'batchingplant-report',
                'title' => 'Batching Plant Report',
                'type' => 'module',
                'parent_id' => 20
            ],
            [
                'name' => 'batchingplant-jmf-read',
                'title' => 'Batching Plant Jmf Read',
                'type' => 'module',
                'parent_id' => 20
            ],
            [
                'name' => 'batchingplant-materialusage-read',
                'title' => 'Batching Plant Material Usage Read',
                'type' => 'module',
                'parent_id' => 20
            ],
        ];

        foreach ($permissions as $value) {
            Permission::create($value);
        }
    }
}
