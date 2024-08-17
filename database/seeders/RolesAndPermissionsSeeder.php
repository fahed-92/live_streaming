<?php

// database/seeders/RolesAndPermissionsSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Create permissions
        Permission::create(['name' => 'start meeting']);
        Permission::create(['name' => 'end meeting']);
        Permission::create(['name' => 'manage attendees']);
        Permission::create(['name' => 'view content']);
        Permission::create(['name' => 'interact']);

        // Create roles and assign existing permissions
        $creator = Role::create(['name' => 'creator']);
        $creator->givePermissionTo(['start meeting', 'end meeting', 'manage attendees', 'view content', 'interact']);

        $attendee = Role::create(['name' => 'attendee']);
        $attendee->givePermissionTo(['view content', 'interact']);
    }
}

