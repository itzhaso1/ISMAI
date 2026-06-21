@props(['category'])
@if($category->childrenRecursive->isNotEmpty())
    <ul class="mega-tree">
        @foreach($category->childrenRecursive as $child)
            <li>
                <a href="{{ route('categories.show', $child) }}">{{ $child->localizedName() }}</a>
                <x-category-tree :category="$child" />
            </li>
        @endforeach
    </ul>
@endif
