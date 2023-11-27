<?php

namespace Inovector\MixpostAuth\Commands;

use Illuminate\Console\Command;
use Inovector\MixpostAuth\MixpostAuth;

class DeleteUser extends Command
{
    public $signature = 'mixpost-auth:delete {email}';

    public $description = 'Delete a user';

    public function handle(): int
    {
        if (!MixpostAuth::getUserClass()::where('email', $this->argument('email'))->exists()) {
            return $this->userNotFound();
        }

        if (!$this->confirm('Are you sure you want to delete this user?')) {
            return self::FAILURE;
        }

        $delete = MixpostAuth::getUserClass()::where('email', $this->argument('email'))->delete();

        if (!$delete) {
            return $this->userNotFound();
        }

        $this->info('User deleted successfully!');

        return self::SUCCESS;
    }

    protected function userNotFound(): int
    {
        $this->error('User not found!');
        return self::FAILURE;
    }
}
