<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesSeeder extends Seeder
{

    protected PermissionRegistrar $registrar;

    public function __construct(PermissionRegistrar $registrar)
    {
        $this->registrar = $registrar;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $this->registrar->forgetCachedPermissions();

        $permissions = [
            // Applications
            'get-applications',
            'get-own-applications',
            'create-application',
            'delete-application',
            'delete-own-application',
            'update-application',
            'update-own-application',

            // App keys
            'get-app-keys',
            'get-own-app-keys',
            'create-app-keys',
            'create-own-app-keys',
            'delete-app-keys',
            'delete-own-app-keys',

            // Message
            'create-new-message',
            'get-messages',
            'get-own-messages',
            'delete-messages',
            'delete-own-messages',

            // SendGrid keys
            'get-sendgrid-keys',
            'get-own-sendgrid-keys',
            'delete-sendgrid-key',
            'delete-own-sendgrid-key',
            'update-sendgrid-key',
            'update-own-sendgrid-key',

            // Subscriptions
            'create-subscriber',
            'delete-subscriber',
            'delete-own-subscriber',
            'update-subscriber',
            'update-own-subscriber',
            'get-subscribers',
            'get-own-subscribers',

            // Users
            'create-users',
            'get-users',
            'update-own-profile',
            'update-profile',
            'delete-user',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }


        Role::create(['name' => 'administrator'])
            ->givePermissionTo($permissions);

        $applicationManager = Role::create(['name' => 'application-manager'])
            ->givePermissionTo(
                [
                    // Applications
                    'get-applications',
                    'get-own-applications',
                    'create-application',
                    'delete-application',
                    'delete-own-application',
                    'update-application',
                    'update-own-application',
                    'update-own-profile',
                ]
            );

        Role::create(['name' => 'subscriber-manager'])
            ->givePermissionTo(
                [ // Subscriptions
                  'create-subscriber',
                  'delete-subscriber',
                  'delete-own-subscriber',
                  'update-subscriber',
                  'update-own-subscriber',
                  'get-subscribers',
                  'get-own-subscribers',
                  'update-own-profile',
                ]
            );
        Role::create(['name' => 'user-manager'])
            ->givePermissionTo(
                [
                    // Users
                    'create-users',
                    'get-users',
                    'update-own-profile',
                    'update-profile',
                    'delete-user',
                ]
            );

        Role::create(['name' => 'messages-manager'])
            ->givePermissionTo(
                [
                    // Message
                    'create-new-message',
                    'get-messages',
                    'get-own-messages',
                    'delete-messages',
                    'delete-own-messages',
                    'update-own-profile',
                ]
            );

        Role::create(['name' => 'user'])
            ->givePermissionTo(
                [
                    'get-own-applications',
                    'create-application',
                    'delete-own-application',
                    'update-own-application',
                    // App keys
                    'get-own-app-keys',
                    'create-own-app-keys',
                    'delete-own-app-keys',
                    'create-new-message',
                    'get-own-messages',
                    'delete-own-messages',
                    //Sendgrid keys
                    'get-own-sendgrid-keys',
                    'delete-own-sendgrid-key',
                    'update-own-sendgrid-key',
                    // Subscribers
                    'create-subscriber',
                    'delete-own-subscriber',
                    'update-own-subscriber',
                    'get-own-subscribers',

                    'update-own-profile',
                ]
            );
    }
}
