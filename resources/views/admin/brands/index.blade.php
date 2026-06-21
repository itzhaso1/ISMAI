@extends('layouts.admin')
@section('title', 'Brands')
@section('page_title', 'Brands')
@section('content')
<div class="admin-toolbar"><span></span><a class="btn-primary" href="{{ route('admin.brands.create') }}">New Brand</a></div>
<section class="admin-panel"><div class="table-wrap"><table class="admin-table"><thead><tr><th>Name</th><th>Products</th><th>Website</th><th>Status</th><th></th></tr></thead><tbody>@foreach($brands as $brand)<tr><td><strong>{{ $brand->name }}</strong><small>{{ $brand->slug }}</small></td><td>{{ $brand->products_count }}</td><td>{{ $brand->website_url ?: '-' }}</td><td>{{ $brand->is_active ? 'Active' : 'Inactive' }}</td><td class="row-actions"><a href="{{ route('admin.brands.edit', $brand) }}">Edit</a><form method="POST" action="{{ route('admin.brands.destroy', $brand) }}">@csrf @method('DELETE')<button onclick="return confirm('Delete brand?')">Delete</button></form></td></tr>@endforeach</tbody></table></div>{{ $brands->links() }}</section>
@endsection
