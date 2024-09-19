<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Enums\RoleCode;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies
        = [
            // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();
        $this->defineRolesGates();
    }

    protected function defineRolesGates(): void
    {
        Gate::define('is_admin', fn (User $user) => $user->roles()->whereIn('code', [RoleCode::Admin])->exists());
        Gate::define('is_manager', fn (User $user) => $user->roles()->whereIn('code', [RoleCode::Admin, RoleCode::Manager])->exists());
        Gate::define('is_customer', fn (User $user) => $user->roles()->whereIn('code', [RoleCode::Admin, RoleCode::Customer])->exists());
    }
}
