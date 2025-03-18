<?php

declare(strict_types=1);

arch('enums')
    ->expect('App\Enums')
    ->toBeEnums()
    ->toExtendNothing()
//    ->toUseNothing() // Commented out waiting for https://github.com/pestphp/pest-plugin-arch/pull/10 and https://github.com/pestphp/pest/issues/973
    ->toOnlyBeUsedIn([
        'App\Concerns',
        'App\Console\Commands',
        'App\Http\Controllers',
        'App\Http\Requests',
        'App\Http\Resources',
        'App\Livewire',
        'App\Models',
        'Database\Factories',
    ]);
