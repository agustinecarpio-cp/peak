<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedRoles();
        $this->seedGeneratedPermissions();
        $this->grantAllPermissionToAdmin();
    }

    private function seedRoles()
    {
        $userRoles = [User::ADMIN_ROLE, User::TEAM_LEADER_ROLE, User::AGENT_ROLE,];

        foreach ($userRoles as $userRole) {
            $role = Role::findOrCreate($userRole);
            $this->command->info('Added role: ' . $role->name);
        }
    }

    private function seedGeneratedPermissions()
    {
        $dir = base_path('app/Models/*');
        $slugModels = [];
        foreach (glob($dir) as $file) {
            if (!is_dir($file)) {
                $slugModels[] = $this->studlyToSlug(basename($file));
            }
        }

        // Additional models
        $slugModels[] = 'role';
        $slugModels[] = 'permission';

        $resourceMethods = ['view-any', 'view', 'create', 'delete', 'update', 'restore', 'force-delete',];

        foreach ($slugModels as $slugModel) {
            foreach ($resourceMethods as $resourceMethod) {
                \Spatie\Permission\Models\Permission::findOrCreate($resourceMethod . '-' . $slugModel, 'web');
            }
        }
    }

    private function studlyToSlug($input)
    {
        $input = str_replace('.php', '', $input);

        $arr = preg_split('/(^[^A-Z]+|[A-Z][^A-Z]+)/', $input, -1, /* no limit for replacement count */ PREG_SPLIT_NO_EMPTY /*don't return empty elements*/ | PREG_SPLIT_DELIM_CAPTURE /*don't strip anything from output array*/);

        return Str::slug(implode(' ', $arr));
    }

    private function grantAllPermissionToAdmin()
    {
        $adminRole = Role::findByName('Admin');
        $permissions = Permission::all();
        $adminRole->syncPermissions($permissions);
    }
}
