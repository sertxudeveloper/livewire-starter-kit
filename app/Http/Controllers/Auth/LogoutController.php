<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Actions\LogoutAction;
use Illuminate\Http\RedirectResponse;

final readonly class LogoutController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LogoutAction $logout): RedirectResponse
    {
        $logout();

        return redirect('/');
    }
}
