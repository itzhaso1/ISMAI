@extends('layouts.admin')
@section('title', 'Social Links')
@section('page_title', 'Social Links')
@section('content')
<div class="admin-toolbar"><span></span><a class="btn-primary" href="{{ route('admin.social-links.create') }}">New Social Link</a></div><section class="admin-panel"><div class="table-wrap"><table class="admin-table"><thead><tr><th>Platform</th><th>Label</th><th>URL</th><th>Order</th><th>Status</th><th></th></tr></thead><tbody>@foreach($socialLinks as $link)<tr><td>{{ $link->platform }}</td><td>{{ $link->label }}</td><td>{{ $link->url }}</td><td>{{ $link->sort_order }}</td><td>{{ $link->is_active ? 'Active' : 'Inactive' }}</td><td class="row-actions"><a href="{{ route('admin.social-links.edit', $link) }}">Edit</a><form method="POST" action="{{ route('admin.social-links.destroy', $link) }}">@csrf @method('DELETE')<button onclick="return confirm('Delete social link?')">Delete</button></form></td></tr>@endforeach</tbody></table></div>{{ $socialLinks->links() }}</section>
@endsection
