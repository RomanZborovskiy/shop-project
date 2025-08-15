<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PrimarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {

        $superUser = User::updateOrCreate(
            ['email' => 'superadmin@app.com'],
            [
                'name'=> 'SuperAdmin',
                'password' => bcrypt('password'),
            ]
        );

        $users = [
            [
                'name' => 'Develop',
                'email' => 'dev@app.com',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@app.com',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Client',
                'email' => 'client@app.com',
                'password' => bcrypt('password'),
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']], 
                $user
            );
        }

        $roles = [
            'SuperAdmin',
            'admin',
            'user',
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(['name' => $role]);
        }

        $permissions = [
            'manage',
            'edit',
            'delete',
			'create',
            'view',
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission]);
        }

        Role::where('name', 'SuperAdmin')->first()?->syncPermissions(Permission::all());

        Role::where('name', 'admin')->first()?->syncPermissions([
            'edit',
            'create',
			'delete',
            'view',
        ]);

        Role::where('name', 'user')->first()?->syncPermissions([
            'view',
			'create',
        ]);

        $superUser->assignRole('SuperAdmin');
    }
}
