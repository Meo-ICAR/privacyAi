<?php

namespace Database\Seeders;

use App\Models\Mandante;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RolesAndUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create roles
        $roles = [
            'admin' => 'Admin',
            'hr' => 'HR',
            'commercial' => 'Commercial',
            'employee' => 'Employee',
        ];

        foreach ($roles as $name => $label) {
            Role::firstOrCreate([
                'name' => $name,
                'guard_name' => 'web',
            ]);
        }

        // Create admin user for each tenant
        $tenants = Mandante::all();

        foreach ($tenants as $tenant) {
            $user = User::firstOrCreate(
                [
                    'email' => 'admin@' . $tenant->domain,
                ],
                [
                    'name' => 'Admin ' . $tenant->name,
                    'password' => bcrypt('password'),
                    'mandante_id' => $tenant->id,
                ]
            );

            $user->assignRole('admin');
        }
    }
}
