<?php

namespace App\Providers;

use App\Models\User\Role;
use App\User;
use Illuminate\Support\Facades\Gate;
use Laravel\Horizon\Horizon;
use Laravel\Horizon\HorizonApplicationServiceProvider;

class HorizonServiceProvider extends HorizonApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        // Horizon::routeSmsNotificationsTo('15556667777');
        // Horizon::routeMailNotificationsTo('example@example.com');
        // Horizon::routeSlackNotificationsTo('slack-webhook-url', '#channel');

        // Horizon::night();
    }

    /**
     * Register the Horizon gate.
     *
     * This gate determines who can access Horizon in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewHorizon', function (User $user = null) {
            $user = $this->getUser();
            if ($user === null) {
                return null;
            }

            return $user->hasRole(Role::ADMIN);
        });
    }

    /**
     * @todo костыль, перейти на session driver
     */
    private function getUser(): ?User
    {
        $userId = session('user_id');
        if (!$userId) {
            return null;
        }

        return User::query()->find($userId[0]);
    }
}
