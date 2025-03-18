<?php

declare(strict_types=1);

namespace App\Livewire\Settings;

use App\Actions\LogoutAction;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

final class DeleteUserForm extends Component
{
    /**
     * The user's password.
     */
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(LogoutAction $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        /** @var User $user */
        $user = Auth::user();

        $logout();

        $user->delete();

        $this->redirect('/', navigate: true);
    }

    /**
     * Render the component.
     */
    public function render(): View
    {
        return view('livewire.settings.delete-user-form');
    }
}
