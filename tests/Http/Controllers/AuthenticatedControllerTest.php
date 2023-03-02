<?php

use Inovector\MixpostAuth\Models\User;

test('login screen can be rendered', function () {
    $this->publishAssets();

    $response = $this->get('/mixpost/login');

    $response->assertStatus(200);
});

test('users can authenticate using the login screen', function () {
    $user = User::factory()->create();

    $response = $this->post('/mixpost/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(config('mixpost.redirect_to_url'));
});

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create();

    $this->post('/mixpost/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});
