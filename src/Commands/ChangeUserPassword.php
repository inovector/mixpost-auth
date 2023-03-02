<?php

namespace Inovector\MixpostAuth\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Inovector\MixpostAuth\MixpostAuth;

class ChangeUserPassword extends Command
{
    public $signature = 'mixpost-auth:password {email}';

    public $description = 'Change user password to authenticate in to Mixpost';

    public function handle(): int
    {
        $email = $this->argument('email');

        $user = MixpostAuth::getUserClass()::where('email', $email)->first();

        if (!$user) {
            $this->error("User $email doesn't exists!");

            return self::FAILURE;
        }

        $password = $this->secret('What is the new password?');

        $validator = Validator::make(['password' => $password], [
            'password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            $this->error('The following validation errors occurred:');
            $this->error(json_encode($validator->errors(), JSON_PRETTY_PRINT));

            return self::FAILURE;
        }

        $user->update([
            'password' => bcrypt($password)
        ]);

        $this->info("Password for $user->email updated successfully!");

        return self::SUCCESS;
    }
}
