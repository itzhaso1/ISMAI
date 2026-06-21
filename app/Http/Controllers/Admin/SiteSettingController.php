<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SiteSettingsManager;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteSettingController extends Controller
{
    public function __construct(private readonly SiteSettingsManager $settings)
    {
    }

    public function edit(): View
    {
        return view('admin.settings.edit', [
            'settings' => $this->settings->publicSettings(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'site_name_ar' => ['required', 'string', 'max:255'],
            'site_name_en' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'max:4096'],
            'phone_numbers' => ['nullable', 'string'],
            'email' => ['nullable', 'email', 'max:255'],
            'address_ar' => ['nullable', 'string'],
            'address_en' => ['nullable', 'string'],
            'footer_description_ar' => ['nullable', 'string'],
            'footer_description_en' => ['nullable', 'string'],
            'show_featured_categories' => ['nullable', 'boolean'],
            'show_featured_products' => ['nullable', 'boolean'],
            'show_brands' => ['nullable', 'boolean'],
        ]);

        $this->settings->set('site_name', ['ar' => $data['site_name_ar'], 'en' => $data['site_name_en']], 'general', 'json');
        $this->settings->set('phone_numbers', $this->lines($data['phone_numbers'] ?? ''), 'contact', 'array');
        $this->settings->set('email', ['value' => $data['email'] ?? null], 'contact', 'email');
        $this->settings->set('address', ['ar' => $data['address_ar'] ?? null, 'en' => $data['address_en'] ?? null], 'contact', 'json');
        $this->settings->set('footer_description', ['ar' => $data['footer_description_ar'] ?? null, 'en' => $data['footer_description_en'] ?? null], 'footer', 'json');
        $this->settings->set('homepage_sections', [
            'featured_categories' => $request->boolean('show_featured_categories'),
            'featured_products' => $request->boolean('show_featured_products'),
            'brands' => $request->boolean('show_brands'),
        ], 'homepage', 'json');

        if ($request->hasFile('logo')) {
            $oldLogo = data_get($this->settings->publicSettings()->get('logo'), 'path');
            if ($oldLogo) {
                Storage::disk('public')->delete($oldLogo);
            }
            $this->settings->set('logo', ['path' => $request->file('logo')->store('settings', 'public')], 'general', 'image');
        }

        $this->settings->clearSettingsCache();

        return redirect()->route('admin.settings.edit')->with('status', 'تم تحديث إعدادات الموقع بنجاح.');
    }

    private function lines(string $value): array
    {
        return collect(preg_split('/\r\n|\r|\n/', $value))
            ->map(fn (string $line) => trim($line))
            ->filter()
            ->values()
            ->all();
    }
}
