<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Setting;
use App\Models\SocialLink;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class SiteSettingsManager
{
    public const SETTINGS_CACHE_KEY = 'site.settings.public';
    public const NAVIGATION_CACHE_KEY = 'site.navigation.categories';
    public const SOCIAL_CACHE_KEY = 'site.social.links';

    public function publicSettings(): Collection
    {
        return Cache::remember(self::SETTINGS_CACHE_KEY, now()->addHour(), fn () => Setting::query()
            ->where('is_public', true)
            ->get()
            ->mapWithKeys(fn (Setting $setting) => [$setting->key => $setting->value]));
    }

    public function value(string $key, mixed $default = null): mixed
    {
        return data_get($this->publicSettings(), $key, $default);
    }

    public function set(string $key, mixed $value, string $group = 'general', string $type = 'text', bool $isPublic = true): Setting
    {
        $setting = Setting::updateOrCreate(
            ['key' => $key],
            [
                'group' => $group,
                'value' => $value,
                'type' => $type,
                'is_public' => $isPublic,
            ]
        );

        $this->clearSettingsCache();

        return $setting;
    }

    public function navigationCategories(): Collection
    {
        return Cache::remember(self::NAVIGATION_CACHE_KEY, now()->addHour(), fn () => Category::active()
            ->whereNull('parent_id')
            ->with(['childrenRecursive' => fn ($query) => $query->active()->orderBy('sort_order')])
            ->orderBy('sort_order')
            ->get());
    }

    public function socialLinks(): Collection
    {
        return Cache::remember(self::SOCIAL_CACHE_KEY, now()->addHour(), fn () => SocialLink::active()
            ->orderBy('sort_order')
            ->get());
    }

    public function clearSettingsCache(): void
    {
        Cache::forget(self::SETTINGS_CACHE_KEY);
    }

    public function clearNavigationCache(): void
    {
        Cache::forget(self::NAVIGATION_CACHE_KEY);
    }

    public function clearSocialCache(): void
    {
        Cache::forget(self::SOCIAL_CACHE_KEY);
    }

    public function clearAll(): void
    {
        $this->clearSettingsCache();
        $this->clearNavigationCache();
        $this->clearSocialCache();
    }
}
