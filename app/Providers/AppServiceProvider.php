<?php

namespace App\Providers;

use App\Watermark;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Translation\MessageSelector;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Fixes issue with MySQL indexed string column size.
        Schema::defaultStringLength(191);

        Collection::macro('latest', function () {
            return $this->sortByDesc('created_at');
        });

        Collection::macro('getCollect', function ($key, $default = null) {
            return new static($this->get($key, $default));
        });

        Paginator::defaultView('pagination::bulma');
        Paginator::defaultSimpleView('pagination::bulma');

        $this->setCustomTranslationMessageSelector();
    }

    /**
     * Extend Laravel's Message Selector to add support for "sr-Latn".
     */
    private function setCustomTranslationMessageSelector()
    {
        Lang::setSelector(new class extends MessageSelector {
            public function getPluralIndex($locale, $number)
            {
                if ($locale === 'sr-Latn') {
                    $locale = 'sr';
                }

                return parent::getPluralIndex($locale, $number);
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Watermark::class, function () {
            return new Watermark($this->app['config']->get('biologer.watermark'));
        });
    }
}
