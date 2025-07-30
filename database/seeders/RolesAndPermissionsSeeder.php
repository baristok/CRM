<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        //spatie önbelleği temizleme
        app()[PermissionRegistrar::class]->forgetCachedPermissions();





        // //contact izinleri
        // Permission::create(['name' => 'view-contact']);
        // Permission::create(['name' => 'create-contact']);
        // Permission::create(['name' => 'edit-contact']);
        // Permission::create(['name' => 'delete-contact']);

        // //company izinleri
        // Permission::create(['name' => 'view-company']);
        // Permission::create(['name' => 'create-company']);
        // Permission::create(['name' => 'edit-company']);
        // Permission::create(['name' => 'delete-company']);

        $permissions = [
            //contact izinleri
            'view-contact',
            'create-contact',
            'edit-contact',
            'delete-contact',

            //company izinleri
            'view-company',
            'create-company',
            'edit-company',
            'delete-company',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        //admin rolü
        // $adminRole = Role::create(['name' => 'admin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin','guard_name' => 'web']);
        // $adminRole->givePermissionTo(Permission::all());
        //syncPermissions
        $adminRole->syncPermissions(Permission::all());


        //user rolü
        // $userRole = Role::create(['name' => 'user']);
        $userRole = Role::firstOrCreate(['name' => 'user','guard_name' => 'web']);
        // $userRole->givePermissionTo(['view-contact']);
        $userRole->syncPermissions(['view-contact', 'view-company']);
        
    }
}
