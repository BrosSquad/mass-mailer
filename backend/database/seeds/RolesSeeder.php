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
            'Get Applications' => 'get-applications',
            'Get Only Owned Applications' => 'get-own-applications',
            'Create Application' => 'create-application',
            'Delete Applications' => 'delete-application',
            'Delete Only Owned Applications' => 'delete-own-application',
            'Update Applications' => 'update-application',
            'Update Only Owned Applications' => 'update-own-application',

            // App keys
            'Get Application Keys' => 'get-app-keys',
            'Get Only Owned Application Keys' => 'get-own-app-keys',
            'Create Application Key' => 'create-app-keys',
            'Create Keys for Own Applications' => 'create-own-app-keys',
            'Delete Application Keys' => 'delete-app-keys',
            'Delete Only Owned Application Keys' => 'delete-own-app-keys',

            // Message
            'Create Message' => 'create-new-message',
            'Get Messages' => 'get-messages',
            'Get Only Owned Messages' => 'get-own-messages',
            'Delete Messages' => 'delete-messages',
            'Delete Only Owned Messages' => 'delete-own-messages',

            // SendGrid keys
            'Get SendGrid Keys' => 'get-sendgrid-keys',
            'Get Only Owned SendGrid Keys' => 'get-own-sendgrid-keys',
            'Delete SendGrid Keys' => 'delete-sendgrid-key',
            'Delete Only Owned SendGrid Keys' => 'delete-own-sendgrid-key',
            'Update SendGridKeys' => 'update-sendgrid-key',
            'Update Only Owned SendGrid Keys' => 'update-own-sendgrid-key',

            // Subscriptions
            'Add Subscriber' => 'create-subscriber',
            'Delete Subscriber' => 'delete-subscriber',
            'Delete Owned Subscriber' => 'delete-own-subscriber',
            'Update Subscriber' => 'update-subscriber',
            'Update Owned Subscriber' => 'update-own-subscriber',
            'Get Subscribers' => 'get-subscribers',
            'Get Owned Subscribers' => 'get-own-subscribers',

            // Users
            'Create User' => 'create-users',
            'Get Users' => 'get-users',
            'Update Own Profile' => 'update-own-profile',
            'Update Profile' => 'update-profile',
            'Delete User' => 'delete-user',
        ];

        foreach ($permissions as $description => $permission) {
            Permission::create(['name' => $permission, 'display' => $description]);
        }


        Role::create(['name' => 'administrator', 'display' => 'Administrator'])
            ->givePermissionTo($permissions);

        $applicationManager = Role::create(['name' => 'application-manager', 'display' => 'Application Manager'])
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

        Role::create(['name' => 'subscriber-manager', 'display' => 'Subscriber Manager'])
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
        Role::create(['name' => 'user-manager', 'display' => 'User Manager'])
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

        Role::create(['name' => 'messages-manager', 'display' => 'Messages Manager'])
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

        Role::create(['name' => 'user', 'display' => 'Application User'])
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
