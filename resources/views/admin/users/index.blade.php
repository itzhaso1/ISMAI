@extends('layouts.admin')
@section('title', 'Users')
@section('page_title', 'Users')
@section('content')
<div class="admin-toolbar"><span></span><a class="btn-primary" href="{{ route('admin.users.create') }}">New User</a></div><section class="admin-panel"><div class="table-wrap"><table class="admin-table"><thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Locale</th><th>Status</th><th></th></tr></thead><tbody>@foreach($users as $user)<tr><td>{{ $user->name }}</td><td>{{ $user->email }}</td><td>{{ $user->role }}</td><td>{{ $user->locale }}</td><td>{{ $user->is_active ? 'Active' : 'Inactive' }}</td><td class="row-actions"><a href="{{ route('admin.users.edit', $user) }}">Edit</a><form method="POST" action="{{ route('admin.users.destroy', $user) }}">@csrf @method('DELETE')<button onclick="return confirm('Delete user?')">Delete</button></form></td></tr>@endforeach</tbody></table></div>{{ $users->links() }}</section>
@endsection
