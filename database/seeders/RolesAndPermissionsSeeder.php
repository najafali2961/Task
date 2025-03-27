<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();


        $permissions = [

            'view tickets',
            'create tickets',
            'update tickets',
            'delete tickets',
            'assign tickets',
            'comment tickets',
            'manage dashboard',
            'manage logs',
            'manage labels',
            'manage categories',
            'manage priorities',
            'manage users',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $adminRole = Role::firstOrCreate(['name' => 'Administrator']);
        $adminRole->syncPermissions(Permission::all());

        $agentRole = Role::firstOrCreate(['name' => 'Agent']);
        $agentRole->syncPermissions([
            'view tickets',
            'update tickets',
            'comment tickets',
        ]);

        $userRole = Role::firstOrCreate(['name' => 'User']);
        $userRole->syncPermissions([
            'view tickets',
            'create tickets',
            'comment tickets',
        ]);

        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name'     => 'Admin User',
                'password' => Hash::make('1234'),
            ]
        );
        $adminUser->assignRole($adminRole);
    }
}
