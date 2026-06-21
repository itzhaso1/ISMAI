<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialLink;
use App\Services\SiteSettingsManager;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SocialLinkController extends Controller
{
    public function __construct(private readonly SiteSettingsManager $settings)
    {
    }

    public function index(): View
    {
        return view('admin.social-links.index', [
            'socialLinks' => SocialLink::orderBy('sort_order')->paginate(20),
        ]);
    }

    public function create(): View
    {
        return view('admin.social-links.form', ['socialLink' => new SocialLink(['is_active' => true])]);
    }

    public function store(Request $request): RedirectResponse
    {
        SocialLink::create($this->validated($request));
        $this->settings->clearSocialCache();

        return redirect()->route('admin.social-links.index')->with('status', 'Social link created successfully.');
    }

    public function edit(SocialLink $socialLink): View
    {
        return view('admin.social-links.form', compact('socialLink'));
    }

    public function update(Request $request, SocialLink $socialLink): RedirectResponse
    {
        $socialLink->update($this->validated($request));
        $this->settings->clearSocialCache();

        return redirect()->route('admin.social-links.index')->with('status', 'Social link updated successfully.');
    }

    public function destroy(SocialLink $socialLink): RedirectResponse
    {
        $socialLink->delete();
        $this->settings->clearSocialCache();

        return redirect()->route('admin.social-links.index')->with('status', 'Social link deleted successfully.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'platform' => ['required', 'string', 'max:80'],
            'label' => ['required', 'string', 'max:120'],
            'url' => ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:120'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]) + ['is_active' => false, 'sort_order' => 0];
    }
}
