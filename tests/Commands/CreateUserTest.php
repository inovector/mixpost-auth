<?php

use Inovector\MixpostAuth\Models\User;
use Inovector\MixpostAuth\Commands\CreateUser;

it('creates a new user with valid data', function () {
    $name = 'Test User';
    $email = 'testuser@example.com';
    $password = 'password';

    $this->artisan(CreateUser::class, [
        '--admin' => false,
    ])
        ->expectsQuestion('What is the name of the new user?', $name)
        ->expectsQuestion('What is the email address of the new user?', $email)
        ->expectsQuestion('What is the password for the new user?', $password)
        ->doesntExpectOutputToContain('- Your email:')
        ->doesntExpectOutputToContain('- Your password:')
        ->assertExitCode(0);

    $user = User::where('email', $email)->first();

    expect($user !== null)->toBeTrue()
        ->and($user->name)->toBe($name)
        ->and($user->email)->toBe($email);
});

it('does not create a new user with invalid data', function () {
    $name = 'Test User';
    $email = 'invalid-email';
    $password = '';

    $this->artisan(CreateUser::class, [
        '--admin' => false,
    ])
        ->expectsQuestion('What is the name of the new user?', $name)
        ->expectsQuestion('What is the email address of the new user?', $email)
        ->expectsQuestion('What is the password for the new user?', $password)
        ->doesntExpectOutputToContain('- Your email:')
        ->doesntExpectOutputToContain('- Your password:')
        ->assertExitCode(1);

});

it('does not create a user if one already exists by email', function () {
    $name = 'Test User';
    $email = 'testuser@example.com';
    $password = 'password';

    User::create([
        'name' => $name,
        'email' => $email,
        'password' => bcrypt($password)
    ]);

    $this->artisan(CreateUser::class, [
        '--admin' => false,
    ])
        ->expectsQuestion('What is the name of the new user?', $name)
        ->expectsQuestion('What is the email address of the new user?', $email)
        ->expectsQuestion('What is the password for the new user?', $password)
        ->doesntExpectOutputToContain('- Your email:')
        ->doesntExpectOutputToContain('- Your password:')
        ->assertExitCode(1);

});

it('creates an admin user', function () {
    $this->artisan(CreateUser::class, [
        '--admin' => true,
    ])->assertExitCode(0);
});

it('does not create an admin user if one already exists', function () {
    User::create([
        'name' => 'Admin',
        'email' => 'admin@admin.com',
        'password' => bcrypt('password')
    ]);

    $this->artisan(CreateUser::class, [
        '--admin' => true,
    ])->assertExitCode(1);
});
