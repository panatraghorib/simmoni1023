<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Role;

class AuthRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        if ($this->confirm('Do you wish to refresh migration before seeding, it will clear all old data ?')) {
            // Call the php artisan migrate:refresh
            $this->call('migrate:refresh');
            $this->warn("Data cleared, starting from blank database.");
        }

        // Confirm roles needed
        if ($this->confirm('Create Roles for user, default is superadmin and user? [y|N]', true)) {

            // Ask for roles from input
            $input_roles = $this->ask('Enter roles in comma separate format.', 'Admin,User');

            // Explode roles
            $roles_array = explode(',', $input_roles);

            // add roles
            foreach ($roles_array as $role) {
                $role = Role::firstOrCreate(['name' => trim($role)]);
            }

            $this->info('Roles ' . $input_roles . ' added successfully');
        } else {
            Role::firstOrCreate(['name' => 'User']);
            $this->info('Added only default user role.');
        }
    }
}
