<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rolesList = [
            ['name' => 'super-admin', 'guard_name' => 'web'],
            ['name' => 'admin', 'guard_name' => 'web'],
            ['name' => 'author', 'guard_name' => 'web'],
            ['name' => 'user', 'guard_name' => 'web'],
        ];

        // insert roles
        DB::table('roles')->insert($rolesList);

        // user assign role
        $model_has_roles = [
            ['role_id' => 1, 'model_type' => 'App\Models\User', 'model_id' => 1],
            ['role_id' => 4, 'model_type' => 'App\Models\User', 'model_id' => 2],
            ['role_id' => 3, 'model_type' => 'App\Models\User', 'model_id' => 3],
        ];

        DB::table('model_has_roles')->insert($model_has_roles);
    }
}
