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
            // other
            [
                'name' => 'role',
                'title' => 'Role',
            ], //1
            [
                'name' => 'create-role',
                'title' => 'Create Role',
            ], //2
            [
                'name' => 'update-role',
                'title' => 'Update Role',
            ], //3
            [
                'name' => 'delete-role',
                'title' => 'Delete Role',
            ], //4
            [
                'name' => 'permission',
                'title' => 'Read Permission',
            ], //5
            [
                'name' => 'create-permission',
                'title' => 'Create Permission',
            ], //6
            [
                'name' => 'update-permission',
                'title' => 'Update Permission',
            ], //7
            [
                'name' => 'delete-permission',
                'title' => 'Delete Permission',
            ], //8
            [
                'name' => 'role-permission',
                'title' => 'Role Permission',
            ], //9
            [
                'name' => 'user-list',
                'title' => 'User List',
            ], //10
            [
                'name' => 'create-user',
                'title' => 'Create User',
            ], //11
            [
                'name' => 'show-user',
                'title' => 'Show User',
            ], //12
            [
                'name' => 'update-user',
                'title' => 'Update User',
            ], //13
            [
                'name' => 'delete-user',
                'title' => 'Delete user',
            ], //14
            [
                'name' => 'update-setting-permission',
                'title' => 'Update Setting Permission',
            ], //15
            // module
            [
                'name' => 'batching_plant_mj',
                'title' => 'Batching Plant',
                'type' => 'module',
                'parent_id' => '19',
                'aliases' => 'BP'
            ], //16
            [
                'name' => 'smart_monitor_mj',
                'title' => 'Smart Monitor',
                'type' => 'module',
                'parent_id' => '19',
                'aliases' => 'SM'
            ], //17
            [
                'name' => 'truck_scale_mj',
                'title' => 'Truck Scale',
                'type' => 'module',
                'parent_id' => '19',
                'aliases' => 'TS'
            ], //18
            // location
            [
                'name' => 'pabrik_mojokerto',
                'title' => 'Pabrik Mojokerto',
                'type' => 'location',
            ],  //19
            [
                'name' => 'pabrik_aceh',
                'title' => 'Pabrik Aceh',
                'type' => 'location',
            ], //20
            [
                'name' => 'pabrik_sadang',
                'title' => 'Pabrik Sadang',
                'type' => 'location',
            ],
            // menu
            [
                'name' => 'dashboard_batching_plant',
                'title' => 'Dashboard',
                'type' => 'menu',
                'parent_id' => 16,
                'url' => 'batchingplant.dashboard',
                'order' => 1
            ],
            [
                'name' => 'material_usage_batching_plant',
                'title' => 'Material Usage',
                'type' => 'menu',
                'parent_id' => 16,
                'url' => 'batchingplant.material.usage',
                'order' => 2
            ],
            [
                'name' => 'produksi_batching_plant',
                'title' => 'Produksi',
                'type' => 'menu',
                'parent_id' => 16,
                'url' => 'batchingplant.produksi',
                'order' => 3
            ],
            [
                'name' => 'dashboard_truck_scale',
                'title' => 'Dashboard',
                'type' => 'menu',
                'parent_id' => 18,
                'url' => 'truckscale.dashboard',
                'order' => 1
            ],
            [
                'name' => 'incoming_material_truck_scale',
                'title' => 'Incoming Material',
                'type' => 'menu',
                'parent_id' => 18,
                'url' => 'truckscale.incoming.material',
                'order' => 2
            ],
            [
                'name' => 'dashboard_smart_monitor',
                'title' => 'Dashboard',
                'type' => 'menu',
                'parent_id' => 17,
                'url' => 'truckscale.dashboard',
                'order' => 1
            ],
            [
                'name' => 'pemakaian_listrik',
                'title' => 'Pemakain Listrik',
                'type' => 'menu',
                'parent_id' => 17,
                'url' => 'truckscale.pemakaian.listrik',
                'order' => 2
            ],
            [
                'name' => 'pemakaian_air',
                'title' => 'Pemakaian Air',
                'type' => 'menu',
                'parent_id' => 17,
                'url' => 'truckscale.pemakain.air',
                'order' => 3
            ],
        ];

        foreach ($permissions as $value) {
            Permission::create($value);
        }
    }
}
