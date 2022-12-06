<?php

namespace App\Providers;

use App\Filament\Resources\PermissionResource;
use App\Filament\Resources\RoleResource;
use App\Filament\Resources\UserResource;
use Filament\Facades\Filament;
use Filament\Navigation\UserMenuItem;
use Illuminate\Support\ServiceProvider;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Filament::serving(function () {
            Filament::registerViteTheme('resources/css/filament.css');
            if(auth()->user()){
                if (auth()->user()->is_admin === 1 && auth()->user()->hasAnyRole(['super-admin', 'admin', 'moderator'])) {
                    Filament::registerUserMenuItems([
                        UserMenuItem::make()
                            ->label('المستخدمين')
                            ->url(UserResource::getUrl())
                            ->icon('heroicon-s-users'),

                        UserMenuItem::make()
                            ->label('الصلاحيات')
                            ->url(RoleResource::getUrl())
                            ->icon('heroicon-s-cog'),

                        UserMenuItem::make()
                            ->label('الاذونات')
                            ->url(PermissionResource::getUrl())
                            ->icon('heroicon-s-key'),
                    ]);
                }
            }

        });
    }
}
