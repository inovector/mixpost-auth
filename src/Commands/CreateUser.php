<?php

namespace Inovector\MixpostAuth\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Inovector\MixpostAuth\MixpostAuth;

class CreateUser extends Command
{
    public $signature = 'mixpost-auth:create {--admin}';

    public $description = 'Create a new user to authenticate in to Mixpost';

    public function handle(): int
    {
        $admin = boolval($this->option('admin'));

        if (!$admin) {
            $name = $this->ask('What is the name of the new user?');
            $email = $this->ask('What is the email address of the new user?');
            $password = $this->secret('What is the password for the new user?');

            $validator = Validator::make([
                'name' => $name,
                'email' => $email,
                'password' => $password
            ], [
                'email' => ['required', 'string', 'email'],
                'password' => ['required', 'string'],
            ]);

            if ($validator->fails()) {
                $this->error('The following validation errors occurred:');
                $this->error(json_encode($validator->errors(), JSON_PRETTY_PRINT));

                return self::FAILURE;
            }
        }

        if ($admin) {
            $name = 'Admin';
            $email = 'admin@example.com';
            $password = 'changeme';
        }

        if (MixpostAuth::getUserClass()::where('email', $email)->exists()) {
            $this->error("User $email already exists!");
            return self::FAILURE;
        }

        MixpostAuth::getUserClass()::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password)
        ]);

        $this->info("User $email created successfully!");

        if ($admin) {
            $this->comment("
                - Email: $email
                - Password: $password
            ");
        }

        return self::SUCCESS;
    }
}
