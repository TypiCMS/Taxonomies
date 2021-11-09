<?php

namespace TypiCMS\Modules\Taxonomies\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Observers\SlugObserver;
use TypiCMS\Modules\Taxonomies\Composers\SidebarViewComposer;
use TypiCMS\Modules\Taxonomies\Facades\Taxonomies;
use TypiCMS\Modules\Taxonomies\Facades\Terms;
use TypiCMS\Modules\Taxonomies\Models\Taxonomy;
use TypiCMS\Modules\Taxonomies\Models\Term;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'typicms.taxonomies');
        $this->mergeConfigFrom(__DIR__.'/../config/permissions.php', 'typicms.permissions');
        $this->mergeConfigFrom(__DIR__.'/../config/config-terms.php', 'typicms.terms');

        $this->loadViewsFrom(__DIR__.'/../../resources/views/', 'taxonomies');

        $this->publishes([
            __DIR__.'/../../database/migrations/create_taxonomies_tables.php.stub' => getMigrationFileName('create_taxonomies_tables'),
        ], 'migrations');

        $this->publishes([
            __DIR__.'/../../resources/views' => resource_path('views/vendor/taxonomies'),
        ], 'views');

        AliasLoader::getInstance()->alias('Taxonomies', Taxonomies::class);
        AliasLoader::getInstance()->alias('Terms', Terms::class);

        // Observers
        Taxonomy::observe(new SlugObserver());
        Term::observe(new SlugObserver());

        View::composer('core::admin._sidebar', SidebarViewComposer::class);
    }

    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);

        $this->app->bind('Terms', Term::class);
        $this->app->bind('Taxonomies', Taxonomy::class);
    }
}
