<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('to mail', function () {
    $user = User::factory()->create();

    $notification = new VerifyEmail();

    expect($notification->toMail($user))->toBeInstanceOf(MailMessage::class);
});
