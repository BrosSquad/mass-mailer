<?php

use Illuminate\Database\Seeder;
use Silber\Bouncer\Bouncer;
use Silber\Bouncer\Database\Role;

class RolesSeeder extends Seeder
{
    /**
     * @var Bouncer
     */
    private $bouncer;


    public function __construct(Bouncer $bouncer)
    {
        $this->bouncer = $bouncer;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->bouncer->role()->firstOrCreate([
           'name' => 'user',
           'title' => 'User'
        ]);

        $this->bouncer->role()->firstOrCreate([
           'name' => 'admin',
           'title' => 'administrator'
        ]);
    }
}
