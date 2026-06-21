@extends('layouts.admin')
@section('title', 'طلب '.$order->order_number)
@section('page_title', 'تفاصيل الطلب '.$order->order_number)
@section('content')
@php($statuses = ['pending' => 'قيد الانتظار', 'confirmed' => 'مؤكد', 'processing' => 'قيد المعالجة', 'completed' => 'مكتمل', 'cancelled' => 'ملغي'])
<section class="admin-panel"><p><strong>العميل:</strong> {{ $order->customer_name }} | {{ $order->customer_phone }} | {{ $order->customer_email }}</p><p><strong>الحالة:</strong> {{ $statuses[$order->status] ?? $order->status }}</p><p><strong>الإجمالي:</strong> {{ number_format((float) $order->grand_total, 2) }}</p><p>{{ $order->notes }}</p><a class="btn-primary" href="{{ route('admin.orders.edit', $order) }}">تحديث الحالة</a></section><section class="admin-panel"><h2>عناصر الطلب</h2><div class="table-wrap"><table class="admin-table"><thead><tr><th>المنتج</th><th>SKU</th><th>الكمية</th><th>سعر الوحدة</th><th>الإجمالي</th></tr></thead><tbody>@foreach($order->items as $item)<tr><td>{{ $item->product_name }}</td><td>{{ $item->sku }}</td><td>{{ $item->quantity }}</td><td>{{ number_format((float) $item->unit_price, 2) }}</td><td>{{ number_format((float) $item->line_total, 2) }}</td></tr>@endforeach</tbody></table></div></section>
@endsection
