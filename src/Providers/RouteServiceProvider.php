<?php

namespace TypiCMS\Modules\Taxonomies\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use TypiCMS\Modules\Taxonomies\Http\Controllers\AdminController;
use TypiCMS\Modules\Taxonomies\Http\Controllers\ApiController;
use TypiCMS\Modules\Taxonomies\Http\Controllers\TermsAdminController;
use TypiCMS\Modules\Taxonomies\Http\Controllers\TermsApiController;

class RouteServiceProvider extends ServiceProvider
{
    public function map(): void
    {
        /*
         * Admin routes
         */
        Route::middleware('admin')->prefix('admin')->name('admin::')->group(function (Router $router) {
            $router->get('taxonomies', [AdminController::class, 'index'])->name('index-taxonomies')->middleware('can:read taxonomies');
            $router->get('taxonomies/export', [AdminController::class, 'export'])->name('export-taxonomies')->middleware('can:read taxonomies');
            $router->get('taxonomies/create', [AdminController::class, 'create'])->name('create-taxonomy')->middleware('can:create taxonomies');
            $router->get('taxonomies/{taxonomy}/edit', [AdminController::class, 'edit'])->name('edit-taxonomy')->middleware('can:read taxonomies');
            $router->post('taxonomies', [AdminController::class, 'store'])->name('store-taxonomy')->middleware('can:create taxonomies');
            $router->put('taxonomies/{taxonomy}', [AdminController::class, 'update'])->name('update-taxonomy')->middleware('can:update taxonomies');

            $router->get('taxonomies/{taxonomy}/terms', [TermsAdminController::class, 'index'])->name('index-terms')->middleware('can:read terms');
            $router->get('taxonomies/{taxonomy}/terms/create', [TermsAdminController::class, 'create'])->name('create-term')->middleware('can:create terms');
            $router->get('taxonomies/{taxonomy}/terms/{term}/edit', [TermsAdminController::class, 'edit'])->name('edit-term')->middleware('can:read terms');
            $router->post('taxonomies/{taxonomy}/terms', [TermsAdminController::class, 'store'])->name('store-term')->middleware('can:create terms');
            $router->put('taxonomies/{taxonomy}/terms/{term}', [TermsAdminController::class, 'update'])->name('update-term')->middleware('can:update terms');
        });

        /*
         * API routes
         */
        Route::middleware(['api', 'auth:api'])->prefix('api')->group(function (Router $router) {
            $router->get('taxonomies', [ApiController::class, 'index'])->middleware('can:read taxonomies');
            $router->patch('taxonomies/{taxonomy}', [ApiController::class, 'updatePartial'])->middleware('can:update taxonomies');
            $router->delete('taxonomies/{taxonomy}', [ApiController::class, 'destroy'])->middleware('can:delete taxonomies');
            $router->get('taxonomies/{taxonomy}/terms', [TermsApiController::class, 'index'])->middleware('can:read terms');
            $router->patch('taxonomies/{taxonomy}/terms/{term}', [TermsApiController::class, 'updatePartial'])->middleware('can:update terms');
            $router->delete('taxonomies/{taxonomy}/terms/{term}', [TermsApiController::class, 'destroy'])->middleware('can:delete terms');
        });
    }
}
