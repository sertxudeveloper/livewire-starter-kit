<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

arch('models')
    ->expect('App\Models')
    ->toHaveMethod('casts')
    ->ignoring('App\Models\Concerns')
    ->toExtend('Illuminate\Database\Eloquent\Model')
    ->ignoring('App\Models\Concerns')
    ->toOnlyBeUsedIn([
        'App\Actions',
        'App\Concerns',
        'App\Console',
        'App\Events',
        'App\Filament',
        'App\Http',
        'App\Jobs',
        'App\Livewire',
        'App\Observers',
        'App\Mail',
        'App\Models',
        'App\Notifications',
        'App\Policies',
        'App\Providers',
        'App\Queries',
        'App\Rules',
        'App\Services',
        'Database\Factories',
        'Database\Seeders',
    ])->ignoring('App\Models\Concerns');

arch('ensure factories', function () {
    $models = getModels();

    foreach ($models as $model) {
        /* @var HasFactory $model */
        expect($model::factory())
            ->toBeInstanceOf(Factory::class);
    }
});

arch('ensure datetime casts', function () {
    $models = getModels();

    foreach ($models as $model) {
        /* @var HasFactory $model */
        $instance = $model::factory()->createQuietly();

        $dates = collect($instance->getAttributes())
            ->filter(fn ($_, $key) => str_ends_with($key, '_at'));

        foreach ($dates as $key => $value) {
            expect($instance->getCasts())->toHaveKey($key, 'datetime');
        }
    }
});

/**
 * Get all models in the app/Models directory.
 *
 * @return array<int, class-string<Model>>
 */
function getModels(): array
{
    $rootModels = collect((array) glob(__DIR__.'/../../app/Models/*.php'))
        ->map(fn ($file) => 'App\Models\\'.basename($file, '.php'))
        ->toArray();

    $subModels = collect((array) glob(__DIR__.'/../../app/Models/*/*.php'))
        ->map(function ($file) {
            $path = Str::after($file, 'app/Models/');
            $path = Str::of($path)->replace('/', '\\');

            return 'App\Models\\'.Str::before($path, '.php');
        })
        ->toArray();

    return collect($rootModels)
        ->merge($subModels)
        ->filter(function ($model) {
            if ((new ReflectionClass($model))->isAbstract()) {
                return false;
            }

            return true;
        })
        ->toArray();
}
