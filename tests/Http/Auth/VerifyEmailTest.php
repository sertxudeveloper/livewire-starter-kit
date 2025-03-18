<?php

declare(strict_types=1);

use App\Livewire\Auth\VerifyEmail;
use App\Models\User;
use Livewire\Livewire;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('sends email verification notification', function () {
    Notification::fake();

    $user = User::factory()->unverified()->create();

    $this->actingAs($user);

    $response = Livewire::test(VerifyEmail::class)
        ->call('sendVerification');

    $response->assertHasNoErrors();

    Notification::assertSentTo($user, Illuminate\Auth\Notifications\VerifyEmail::class);
});

test('skip sending notification if email already verified', function () {
    Notification::fake();

    $user = User::factory()->create();

    $this->actingAs($user);

    $response = Livewire::test(VerifyEmail::class)
        ->call('sendVerification');

    $response->assertHasNoErrors();

    Notification::assertNothingSent();
});

test('user can log out', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = Livewire::test(VerifyEmail::class)
        ->call('logout');

    $response->assertRedirect('/');
    $this->assertGuest();
});
