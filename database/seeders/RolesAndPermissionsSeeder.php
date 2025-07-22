<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //contact izinleri
        Permission::create(['name' => 'view-contact']);
        Permission::create(['name' => 'create-contact']);
        Permission::create(['name' => 'edit-contact']);
        Permission::create(['name' => 'delete-contact']);


        //admin rolü
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());


        //user rolü
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo(['view-contact']);
        
    }
}
