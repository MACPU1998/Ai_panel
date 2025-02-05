<?php

namespace App\Providers;

use App\Models\Admin\Menu;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
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
        // Implicitly grant "Super Admin" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        // Redirect Authenticated Users
        RedirectIfAuthenticated::redirectUsing(function () {
            return redirect()->route('admin.dashboard');
        });

        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });

        Gate::after(function ($user, $ability) {
            return $user->hasRole('Super Admin'); // note this returns boolean
        });

        // 🔹 ارسال منوهای فعال به همه‌ی ویوها
        View::composer('*', function ($view) {
            $menus = Menu::where('status', 1)->orderBy('parent_id')->orderBy('title')->get();
            $view->with('menus', $menus);
        });
    }
}
