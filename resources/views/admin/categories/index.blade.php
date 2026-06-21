@extends('layouts.admin')
@section('title', 'Categories')
@section('page_title', 'Categories')
@section('content')
<div class="admin-toolbar"><form><input name="q" placeholder="Search categories"></form><a class="btn-primary" href="{{ route('admin.categories.create') }}">New Category</a></div>
<section class="admin-panel"><div class="table-wrap"><table class="admin-table"><thead><tr><th>Name</th><th>Parent</th><th>Children</th><th>Products</th><th>Status</th><th></th></tr></thead><tbody>
@foreach($categories as $category)<tr><td><strong>{{ $category->name_en }}</strong><small>{{ $category->name_ar }}</small></td><td>{{ $category->parent?->name_en ?: '-' }}</td><td>{{ $category->children_count }}</td><td>{{ $category->products_count }}</td><td>{{ $category->is_active ? 'Active' : 'Inactive' }}</td><td class="row-actions"><a href="{{ route('admin.categories.edit', $category) }}">Edit</a><form method="POST" action="{{ route('admin.categories.destroy', $category) }}">@csrf @method('DELETE')<button type="submit" onclick="return confirm('Delete category?')">Delete</button></form></td></tr>@endforeach
</tbody></table></div>{{ $categories->links() }}</section>
@endsection
