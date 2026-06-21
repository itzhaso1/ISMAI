@props(['categories'])
<div class="category-strip" id="category-strip">
    <div class="category-strip-inner">
        <div class="mega-trigger">
            <span>{{ __('messages.nav.categories') }}</span>
            <strong>⌄</strong>
            <div class="mega-panel">
                @forelse($categories as $category)
                    <div class="mega-column">
                        <a class="mega-title" href="{{ route('categories.show', $category) }}">{{ $category->localizedName() }}</a>
                        <x-category-tree :category="$category" />
                    </div>
                @empty
                    <div class="mega-column">
                        <span class="mega-title">{{ __('messages.home.featured_categories') }}</span>
                        <a href="{{ route('products.index') }}">{{ __('messages.nav.products') }}</a>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="category-pills">
            @forelse($categories->take(8) as $category)
                <a href="{{ route('categories.show', $category) }}">{{ $category->localizedName() }}</a>
            @empty
                <a href="{{ route('products.index') }}">{{ __('messages.nav.products') }}</a>
            @endforelse
        </div>
    </div>
</div>
