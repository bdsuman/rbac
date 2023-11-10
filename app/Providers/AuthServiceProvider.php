<?php

namespace App\Providers;

use App\Models\Post;
use App\Policies\PostPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Post::class => PostPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

//        Gate::define('isAdmin', function ($user) {
//            return $user->role == 'admin';
//        });
//
//        Gate::define('isManager', function ($user) {
//            return $user->role == 'manager';
//        });
//
//        Gate::define('isEmployee', function ($user) {
//            return $user->role == 'employee';
//        });
        // Implicitly grant "Admin" role all permissions
        Gate::before(function ($user, $ability) {
            return $user->role == 'admin'? true : null;
        });
    }
}
