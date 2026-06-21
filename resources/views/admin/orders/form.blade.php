@extends('layouts.admin')
@section('title', 'تحديث الطلب')
@section('page_title', 'تحديث الطلب '.$order->order_number)
@section('content')
@php($statuses = ['pending' => 'قيد الانتظار', 'confirmed' => 'مؤكد', 'processing' => 'قيد المعالجة', 'completed' => 'مكتمل', 'cancelled' => 'ملغي'])
<form class="admin-panel admin-form" method="POST" action="{{ route('admin.orders.update', $order) }}">@csrf @method('PUT')<div class="form-grid"><label>الحالة<select name="status" required>@foreach($statuses as $status => $label)<option value="{{ $status }}" @selected(old('status', $order->status) === $status)>{{ $label }}</option>@endforeach</select></label><label>ملاحظات<textarea name="notes">{{ old('notes', $order->notes) }}</textarea></label></div><button class="btn-primary" type="submit">حفظ الطلب</button></form>
@endsection
