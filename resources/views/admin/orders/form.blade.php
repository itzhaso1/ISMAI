@extends('layouts.admin')
@section('title', 'Update Order')
@section('page_title', 'Update Order '.$order->order_number)
@section('content')
<form class="admin-panel admin-form" method="POST" action="{{ route('admin.orders.update', $order) }}">@csrf @method('PUT')<div class="form-grid"><label>Status<select name="status" required>@foreach(['pending','confirmed','processing','completed','cancelled'] as $status)<option value="{{ $status }}" @selected(old('status', $order->status) === $status)>{{ ucfirst($status) }}</option>@endforeach</select></label><label>Notes<textarea name="notes">{{ old('notes', $order->notes) }}</textarea></label></div><button class="btn-primary" type="submit">Save Order</button></form>
@endsection
