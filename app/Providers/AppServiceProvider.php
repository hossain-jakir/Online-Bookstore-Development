<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        Paginator::defaultView('vendor.pagination.default');

        Blade::if('canAny', function (...$permissions) {
            foreach ($permissions as $permission) {
                if (auth()->user()->can($permission)) {
                    return true;
                }
            }
            return false;
        });
    }
}
