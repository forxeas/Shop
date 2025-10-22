<?php

namespace App\Providers;

use App\Contracts\NotifierInterface;
use App\Enums\RoleEnum;
use App\Models\User;
use App\Services\Message\LivewireNotifier;
use App\Services\Message\MessageNotifier;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use ReflectionException;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @throws ReflectionException
     */
    public function register(): void
    {
        app()->bind(NotifierInterface::class, LivewireNotifier::class);
    }

    public function boot(): void
    {
        Gate::define('AdminPanel', function(User $user) {
            return $user->role === RoleEnum::getRole(RoleEnum::ADMIN);
        });
    }
}
