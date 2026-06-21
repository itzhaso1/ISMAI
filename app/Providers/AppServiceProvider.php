<?php

namespace App\Providers;

use App\Services\SiteSettingsManager;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Throwable;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        View::composer('*', function ($view): void {
            $view->with([
                'navigationCategories' => $this->navigationCategories(),
                'publicSettings' => $this->publicSettings(),
                'socialLinks' => $this->socialLinks(),
            ]);
        });
    }

    private function navigationCategories(): Collection
    {
        try {
            return app(SiteSettingsManager::class)->navigationCategories();
        } catch (Throwable) {
            return collect();
        }
    }

    private function publicSettings(): Collection
    {
        try {
            return app(SiteSettingsManager::class)->publicSettings();
        } catch (Throwable) {
            return collect();
        }
    }

    private function socialLinks(): Collection
    {
        try {
            return app(SiteSettingsManager::class)->socialLinks();
        } catch (Throwable) {
            return collect();
        }
    }
}
