<?php

namespace App\Providers\Filament;

use App\Filament\Resources\PasienResource;
use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Pages\Dashboard;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Althinect\FilamentSpatieRolesPermissions\FilamentSpatieRolesPermissionsPlugin;
use App\Filament\Resources\DiagnosaResource;
use App\Filament\Resources\DokterResource;
use App\Filament\Resources\JadwalDokterResource;
use App\Filament\Resources\KamarResource;
use App\Filament\Resources\PembayaranResource;
use App\Filament\Resources\PetugasResource;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandLogo(asset('images/logopoliban.png'))
            ->favicon(asset('images/logopoliban.png'))
            ->colors([
                'danger' => Color::Rose,
                'gray' => Color::Gray,
                'info' => Color::Blue,
                'primary' => Color::Indigo,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
            ])
            ->font('Lora')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugin(FilamentSpatieRolesPermissionsPlugin::make())
            ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
                return $builder->groups([
                    NavigationGroup::make()
                    ->items([
                        NavigationItem::make('Dashboard')
                        ->icon('heroicon-o-home')
                        ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.pages.dashboard'))
                        ->url(fn (): string => Dashboard::getUrl()), 
                    ]),
                    NavigationGroup::make('Pembayaran')
                    ->items([
                        ...PembayaranResource::getNavigationItems(),
                    ]),
                    NavigationGroup::make('Diagnosa')
                    ->items([
                        ...DiagnosaResource::getNavigationItems(),
                    ]),
                    NavigationGroup::make('Data SDM')
                    ->items([
                        ...PasienResource::getNavigationItems(),
                        ...DokterResource::getNavigationItems(),
                        ...PetugasResource::getNavigationItems(),
                    ]),
                    NavigationGroup::make('Data Manajemen Rumah Sakit')
                    ->items([
                        ...JadwalDokterResource::getNavigationItems(),
                        ...KamarResource::getNavigationItems(),
                    ]),
                    // NavigationGroup::make('Roles and Permissions')
                    // ->items([
                    //     NavigationItem::make('Roles')
                    //     ->icon('heroicon-o-user-group')
                    //     ->isActiveWhen(fn (): bool => request()->routeIs([
                    //         'filament.admin.resources.roles.create',
                    //         'filament.admin.resources.roles.index',
                    //         'filament.admin.resources.roles.view',
                    //         'filament.admin.resources.roles.edit',
                    //     ]))
                    //     ->url(fn (): string => '/admin/roles'),
                    //     NavigationItem::make('Permissions')
                    //     ->icon('heroicon-o-lock-closed')
                    //     ->isActiveWhen(fn (): bool => request()->routeIs([
                    //         'filament.admin.resources.permissions.create',
                    //         'filament.admin.resources.permissions.index',
                    //         'filament.admin.resources.permissions.view',
                    //         'filament.admin.resources.permissions.edit',
                    //     ]))
                    //     ->url(fn (): string => '/admin/permissions'),
                    //     NavigationItem::make('Users')
                    //     ->icon('heroicon-o-users')
                    //     ->isActiveWhen(fn (): bool => request()->routeIs([
                    //         'filament.admin.resources.users.create',
                    //         'filament.admin.resources.users.index',
                    //         'filament.admin.resources.users.view',
                    //         'filament.admin.resources.users.edit',
                    //     ]))
                    //     ->url(fn (): string => '/admin/users'),
                    // ]),
                ]);
            });
    }
}
