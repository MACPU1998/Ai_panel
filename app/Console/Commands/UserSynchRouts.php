<?php

namespace App\Console\Commands;

use App\Models\Role;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;

class UserSynchRouts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:usersynchrouts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync routes to permissions and roles';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $guard = 'user';

        $routes = collect(Route::getRoutes())
            ->filter(fn($route) => str_starts_with($route->getName(), 'api.user.'));

        $routeNames = $routes
            ->pluck('action.as')
            ->filter()
            ->unique();

        $existingPermissions = Permission::where('guard_name', $guard)->pluck('name')->toArray();
        $permissionsToDelete = array_diff($existingPermissions, $routeNames->toArray());


        foreach ($permissionsToDelete as $permName) {
            $permission = Permission::where('name', $permName)->where('guard_name', $guard)->first();
            if ($permission) {
                $permission->roles()->detach();
                $permission->delete();
                $this->warn("❌ Permission removed: $permName");
            }
        }

        foreach ($routes as $route) {
            $routeName = $route->getName();
            if (!$routeName) continue;

            $permission = Permission::firstOrCreate([
                'name' => $routeName,
                'guard_name' => $guard,
            ]);

            $this->info("✅ Permission synced: $routeName");

            if (isset($route->action['meta']) && $route->action['meta']['enabled']) {
                $metaRoles = collect($route->action['meta']['roles'] ?? [])
                    ->map(fn($r) => explode(':', $r))
                    ->filter(fn($r) => count($r) === 2)
                    ->map(fn($r) => ['name' => $r[0], 'guard' => $r[1]]);

                $rolesWithPermission = $permission->roles;

                // Detach roles that shouldn't have this permission anymore
                foreach ($rolesWithPermission as $role) {
                    $shouldStillHave = $metaRoles->contains(fn($metaRole) => $metaRole['name'] === $role->name && $metaRole['guard'] === $role->guard_name
                    );

                    if (!$shouldStillHave) {
                        $role->revokePermissionTo($permission);
                        $this->warn("🔓 Detached permission [$routeName] from [$role->name:$role->guard_name]");
                    }
                }

                // Attach roles that don't have it yet
                foreach ($metaRoles as $metaRole) {
                    $role = Role::where('name', $metaRole['name'])
                        ->where('guard_name', $metaRole['guard'])
                        ->first();

                    if ($role && !$role->hasPermissionTo($permission)) {
                        $role->givePermissionTo($permission);
                        $this->line("🔗 Attached permission [$routeName] to [$role->name:{$metaRole['guard']}]");
                    }
                }
            }
        }

        $this->info('🎯 User permissions and roles fully synced.');
    }
}
