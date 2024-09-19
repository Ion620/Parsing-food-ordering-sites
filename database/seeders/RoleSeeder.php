<?php

namespace Database\Seeders;

use App\Models\Enums\RoleCode;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (RoleCode::cases() as $role) {
            Role::query()->create(['code' => $role->value, 'name' => $role->name]);
        }
    }
}
