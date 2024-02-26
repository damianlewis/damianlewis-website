<?php

namespace App\Console\Commands;

use Database\Seeders\PermissionsSeeder;
use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;

use function Laravel\Prompts\info;

class UpdateOrCreatePermissions extends Command
{
    use ConfirmableTrait;

    protected $signature = 'app:update-or-create-permissions
        {--force : Force the operation to run when in production.}';

    protected $description = 'Update or create the permissions.';

    public function handle(): int
    {
        if (! $this->confirmToProceed()) {
            return static::FAILURE;
        }

        $result = $this->call('db:seed', [
            '--class' => PermissionsSeeder::class,
            '--force' => $this->option('force'),
        ]);

        if ($result !== static::SUCCESS) {
            return $result;
        }

        info('Permissions seeded successfully.');

        return static::SUCCESS;
    }
}
