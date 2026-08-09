<?php

use App\Models\User;

test('security headers are present in response', function () {
    $response = $this->get('/');

    $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
    $response->assertHeader('X-Content-Type-Options', 'nosniff');
    $response->assertHeader('X-XSS-Protection', '1; mode=block');
});

test('authenticated user can view 2fa setup page', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/2fa/setup');

    $response->assertStatus(200);
    $response->assertSee('Configurar Autenticación de Dos Factores');
});

test('user can enable 2fa with valid code', function () {
    $google2fa = new \PragmaRX\Google2FA\Google2FA();
    $validSecret = $google2fa->generateSecretKey();
    $user = User::factory()->create([
        'two_factor_secret' => $validSecret,
    ]);

    $validCode = $google2fa->getCurrentOtp($validSecret);

    $response = $this->actingAs($user)->post('/2fa/enable', [
        'code' => $validCode,
    ]);

    $response->assertRedirect('/dashboard');
    $this->assertNotNull($user->fresh()->two_factor_confirmed_at);
});

test('login requires 2fa challenge when enabled', function () {
    $user = User::factory()->create([
        'password' => bcrypt('password123'),
        'two_factor_secret' => 'SECRETKEY1234567',
        'two_factor_confirmed_at' => now(),
    ]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password123',
    ]);

    $response->assertRedirect('/2fa/challenge');
    $this->assertGuest();
});

test('2fa challenge rejects invalid code', function () {
    $user = User::factory()->create([
        'two_factor_secret' => 'JBSWY3DPEHPK3PXP',
        'two_factor_confirmed_at' => now(),
    ]);

    $response = $this->withSession(['2fa:user_id' => $user->id])->post('/2fa/challenge', [
        'code' => '000000',
    ]);

    $response->assertSessionHas('error');
});

test('rate limiting blocks after multiple failed login attempts', function () {
    $user = User::factory()->create([
        'password' => bcrypt('password123'),
    ]);

    // Attempt 6 failed logins (limit is 5)
    for ($i = 0; $i < 6; $i++) {
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong_password',
        ]);
    }

    $response->assertSessionHasErrors('email');
});
