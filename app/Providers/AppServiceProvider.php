<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Setting;
use App\Models\SocialLink;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
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
            return Cache::remember('navigation.categories', now()->addMinutes(30), fn () => Category::active()
                ->whereNull('parent_id')
                ->with(['children' => fn ($query) => $query->active()->orderBy('sort_order')])
                ->orderBy('sort_order')
                ->get());
        } catch (Throwable) {
            return collect();
        }
    }

    private function publicSettings(): Collection
    {
        try {
            return Cache::remember('settings.public', now()->addMinutes(30), fn () => Setting::query()
                ->where('is_public', true)
                ->pluck('value', 'key'));
        } catch (Throwable) {
            return collect();
        }
    }

    private function socialLinks(): Collection
    {
        try {
            return Cache::remember('social.links', now()->addMinutes(30), fn () => SocialLink::active()
                ->orderBy('sort_order')
                ->get());
        } catch (Throwable) {
            return collect();
        }
    }
}
