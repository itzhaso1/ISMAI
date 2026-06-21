<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\SiteSettingsManager;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ContentBlockController extends Controller
{
    public function __construct(private readonly SiteSettingsManager $settings)
    {
    }

    public function index(): View
    {
        return view('admin.content-blocks.index', [
            'blocks' => Setting::where('group', 'content')->orderBy('key')->paginate(20),
        ]);
    }

    public function create(): View
    {
        return view('admin.content-blocks.form', ['block' => new Setting(['is_public' => true])]);
    }

    public function store(Request $request): RedirectResponse
    {
        Setting::create($this->validated($request));
        $this->settings->clearSettingsCache();

        return redirect()->route('admin.content-blocks.index')->with('status', 'Content block created successfully.');
    }

    public function edit(Setting $contentBlock): View
    {
        abort_unless($contentBlock->group === 'content', 404);

        return view('admin.content-blocks.form', ['block' => $contentBlock]);
    }

    public function update(Request $request, Setting $contentBlock): RedirectResponse
    {
        abort_unless($contentBlock->group === 'content', 404);

        $contentBlock->update($this->validated($request, $contentBlock));
        $this->settings->clearSettingsCache();

        return redirect()->route('admin.content-blocks.index')->with('status', 'Content block updated successfully.');
    }

    public function destroy(Setting $contentBlock): RedirectResponse
    {
        abort_unless($contentBlock->group === 'content', 404);

        $contentBlock->delete();
        $this->settings->clearSettingsCache();

        return redirect()->route('admin.content-blocks.index')->with('status', 'Content block deleted successfully.');
    }

    private function validated(Request $request, ?Setting $setting = null): array
    {
        $data = $request->validate([
            'key' => ['required', 'string', 'max:255', Rule::unique('settings', 'key')->ignore($setting)],
            'label' => ['nullable', 'string', 'max:255'],
            'value_ar' => ['nullable', 'string'],
            'value_en' => ['nullable', 'string'],
            'is_public' => ['nullable', 'boolean'],
        ]);

        return [
            'group' => 'content',
            'key' => $data['key'],
            'value' => [
                'label' => $data['label'] ?? $data['key'],
                'ar' => $data['value_ar'] ?? null,
                'en' => $data['value_en'] ?? null,
            ],
            'type' => 'localized_text',
            'is_public' => (bool) ($data['is_public'] ?? false),
        ];
    }
}
