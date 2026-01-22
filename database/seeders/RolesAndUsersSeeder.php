<?php

namespace Database\Seeders;

use App\Models\Mandante;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use League\Uri\UriString;

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
                    'email' => 'admin@' . $this->extractDomain($tenant->website),
                ],
                [
                    'name' => 'Admin ' . $tenant->ragione_sociale,
                    'password' => bcrypt('password'),
                    'mandante_id' => $tenant->id,
                ]
            );

            $user->assignRole('admin');
        }
    }

    function extractDomain($url)
    {
        try {
            $parsed = UriString::parse($url);
            $host = $parsed['host'] ?? '';
            return preg_replace('/^www\./i', '', $host);
        } catch (\Exception $e) {
            return null;
        }
    }
}
