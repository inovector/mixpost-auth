<?php

use Inovector\MixpostAuth\MixpostAuth;
use Inovector\MixpostAuth\Commands\DeleteUser;

it('deletes a user with valid email', function () {
    $email = 'testuser@example.com';

    MixpostAuth::getUserClass()::create([
        'name' => 'Test User',
        'email' => $email,
        'password' => bcrypt('password')
    ]);

    $this->artisan(DeleteUser::class, [
        'email' => $email,
    ])
        ->expectsConfirmation('Are you sure you want to delete this user?', 'yes')
        ->expectsOutput('User deleted successfully!')
        ->assertExitCode(0);

    $user = MixpostAuth::getUserClass()::where('email', $email)->first();

    expect($user)->toBeNull();
});

it('does not delete a user with invalid email', function () {
    $email = 'invalid-email';

    $this->artisan(DeleteUser::class, [
        'email' => $email,
    ])
        ->assertExitCode(1);
});

it('aborts deletion process if confirmation is declined', function () {
    $email = 'testuser@example.com';

    MixpostAuth::getUserClass()::create([
        'name' => 'Test User',
        'email' => $email,
        'password' => bcrypt('password')
    ]);

    $this->artisan(DeleteUser::class, [
        'email' => $email,
    ])
        ->expectsConfirmation('Are you sure you want to delete this user?', 'no')
        ->assertExitCode(1);

    $user = MixpostAuth::getUserClass()::where('email', $email)->first();

    expect($user)->not->toBeNull();
});
