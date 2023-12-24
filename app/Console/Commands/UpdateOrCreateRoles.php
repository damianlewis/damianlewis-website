<?php

namespace App\Console\Commands;

use Database\Seeders\RolesSeeder;
use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;

use function Laravel\Prompts\info;

class UpdateOrCreateRoles extends Command
{
    use ConfirmableTrait;

    protected $signature = 'app:update-or-create-roles
        {--force : Force the operation to run when in production.}';

    protected $description = 'Update or create the roles.';

    public function handle(): int
    {
        if (! $this->confirmToProceed()) {
            return static::FAILURE;
        }

        $result = $this->call('db:seed', [
            '--class' => RolesSeeder::class,
            '--force' => $this->option('force'),
        ]);

        if ($result !== static::SUCCESS) {
            return $result;
        }

        info('Roles seeded successfully.');

        return static::SUCCESS;
    }
}
