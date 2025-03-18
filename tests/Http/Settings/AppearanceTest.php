<?php

declare(strict_types=1);

use App\Livewire\Settings\Appearance;
use Livewire\Livewire;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('can render component', function () {
    $response = Livewire::test(Appearance::class);

    $response->assertStatus(200);
});
