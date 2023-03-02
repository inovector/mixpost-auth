<?php

use Inovector\MixpostAuth\Commands\ChangeUserPassword;
use Inovector\MixpostAuth\Models\User;

it('changes user password with valid data', function () {
    $user = User::factory()->create();

    $this->artisan(ChangeUserPassword::class, [
        'email' => $user->email,
    ])
        ->expectsQuestion('What is the new password?', 'new-password')
        ->assertExitCode(0);

});

it('fails when new password is invalid', function () {
    $user = User::factory()->create();

    $this->artisan(ChangeUserPassword::class, [
        'email' => $user->email,
    ])
        ->expectsQuestion('What is the new password?', '')
        ->assertExitCode(1);
});

it('fails when user email does not exist', function () {
    $this->artisan(ChangeUserPassword::class, [
        'email' => 'nonexistent@example.com'
    ])->assertExitCode(1);
});
