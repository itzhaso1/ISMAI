@extends('layouts.admin')
@section('title', 'Static Texts')
@section('page_title', 'Static Texts')
@section('content')
<div class="admin-toolbar"><span></span><a class="btn-primary" href="{{ route('admin.content-blocks.create') }}">New Text Block</a></div><section class="admin-panel"><div class="table-wrap"><table class="admin-table"><thead><tr><th>Key</th><th>Label</th><th>Arabic</th><th>English</th><th>Public</th><th></th></tr></thead><tbody>@foreach($blocks as $block)<tr><td>{{ $block->key }}</td><td>{{ data_get($block->value, 'label') }}</td><td>{{ str(data_get($block->value, 'ar'))->limit(60) }}</td><td>{{ str(data_get($block->value, 'en'))->limit(60) }}</td><td>{{ $block->is_public ? 'Yes' : 'No' }}</td><td class="row-actions"><a href="{{ route('admin.content-blocks.edit', $block) }}">Edit</a><form method="POST" action="{{ route('admin.content-blocks.destroy', $block) }}">@csrf @method('DELETE')<button onclick="return confirm('Delete text block?')">Delete</button></form></td></tr>@endforeach</tbody></table></div>{{ $blocks->links() }}</section>
@endsection
