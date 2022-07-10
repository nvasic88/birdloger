<?php

namespace App\Providers;

use App\Http\ViewComposers\DashboardComposer;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Spatie\Menu\Laravel\Facades\Menu;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('role', function ($roles) {
            return auth()->user()->hasAnyRole(Arr::wrap($roles));
        });

        Blade::if('roles', function ($roles) {
            return auth()->user()->hasAllRole(Arr::wrap($roles));
        });

        View::composer('layouts.dashboard', DashboardComposer::class);

        $this->buildSidebarMenu();
        $this->buildPreferencesSidebar();
    }

    /**
     * Build sidebar menu using Spatie Menu.
     *
     * @return \Spatie\Menu\Laravel\Menu
     */
    private function buildSidebarMenu()
    {
        return Menu::macro('sidebar', function () {
            return Menu::new()
                ->setWrapperTag('aside')
                ->withoutParentTag()
                ->addClass('menu')
                ->add(
                    Menu::new()
                        ->prepend('<p class="menu-label">'.trans('navigation.public').'</p>')
                        ->addClass('menu-list')
                        ->route('contributor.public-field-observations.index', trans('navigation.field_observations'))
                        ->route('contributor.public-literature-observations.index', trans('navigation.literature_observations'))
                        ->setActiveClass('is-active')
                        ->setActiveClassOnLink()
                        ->setActiveFromRequest()
                )->add(
                    Menu::new()
                        ->prepend('<p class="menu-label">'.trans('navigation.my').'</p>')
                        ->addClass('menu-list')
                        ->route(
                            'contributor.field-observations.index',
                            trans('navigation.field_observations')
                        )->routeIf(
                            auth()->user()->hasAnyRole(['poaching']),
                            'contributor.poaching-observations.index',
                            trans('navigation.poaching_observations')
                        )->routeIf(
                            auth()->user()->hasAnyRole(['electrocution']),
                            'contributor.electrocution-observations.index',
                            trans('navigation.electrocution_observations')
                        )
                        ->setActiveClass('is-active')
                        ->setActiveClassOnLink()
                        ->setActiveFromRequest()
                )->addIf(
                    optional(auth()->user())->hasAnyRole(['admin', 'curator', 'poaching', 'electrocution']),
                    Menu::new()
                        ->prepend('<p class="menu-label">'.trans('navigation.admin').'</p>')
                        ->addClass('menu-list')
                        ->routeIfCan(
                            ['list', \App\Taxon::class],
                            'admin.taxa.index',
                            trans('navigation.taxa')
                        )->routeIf(
                            auth()->user()->hasRole('admin'),
                            'admin.field-observations.index',
                            trans('navigation.all_field_observations')
                        )->routeIf(
                            auth()->user()->hasAnyRole(['admin']),
                            'admin.poaching-observations.index',
                            trans('navigation.all_poaching_observations')
                        )->routeIf(
                            auth()->user()->hasAnyRole(['admin']),
                            'admin.electrocution-observations.index',
                            trans('navigation.all_electrocution_observations')
                        )->route(
                            'admin.literature-observations.index',
                            trans('navigation.literature_observations')
                        )->routeIfCan(
                            ['list', \App\Publication::class],
                            'admin.publications.index',
                            trans('navigation.publications')
                        )->routeIfCan(
                            ['list', \App\User::class],
                            'admin.users.index',
                            trans('navigation.users')
                        )->routeIf(
                            auth()->user()->hasRole('admin'),
                            'admin.view-groups.index',
                            trans('navigation.view_groups')
                        )->setActiveClass('is-active')
                        ->setActiveClassOnLink()
                        ->setActiveFromRequest()
                );
        });
    }

    private function buildPreferencesSidebar()
    {
        return Menu::macro('preferencesSidebar', function () {
            return Menu::new()
                ->setWrapperTag('aside')
                ->withoutParentTag()
                ->addClass('menu')
                ->add(
                    Menu::new()
                        ->addClass('menu-list')
                        ->route('preferences.general', trans('navigation.preferences.general'))
                        ->route('preferences.license', trans('navigation.preferences.license'))
                        ->route('preferences.notifications', trans('navigation.preferences.notifications'))
                        ->route('preferences.account', trans('navigation.preferences.account'))
                        ->setActiveClass('is-active')
                        ->setActiveClassOnLink()
                        ->setActiveFromRequest()
                );
        });
    }
}
