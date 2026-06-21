@extends('layouts.admin')
@section('title', 'Sliders')
@section('page_title', 'Hero Sliders')
@section('content')
<div class="admin-toolbar"><span></span><a class="btn-primary" href="{{ route('admin.sliders.create') }}">New Slide</a></div><section class="admin-panel"><div class="table-wrap"><table class="admin-table"><thead><tr><th>Title</th><th>CTA</th><th>Order</th><th>Status</th><th></th></tr></thead><tbody>@foreach($sliders as $slider)<tr><td><strong>{{ $slider->title_en }}</strong><small>{{ $slider->title_ar }}</small></td><td>{{ $slider->button_text_en }}</td><td>{{ $slider->sort_order }}</td><td>{{ $slider->is_active ? 'Active' : 'Inactive' }}</td><td class="row-actions"><a href="{{ route('admin.sliders.edit', $slider) }}">Edit</a><form method="POST" action="{{ route('admin.sliders.destroy', $slider) }}">@csrf @method('DELETE')<button onclick="return confirm('Delete slide?')">Delete</button></form></td></tr>@endforeach</tbody></table></div>{{ $sliders->links() }}</section>
@endsection
