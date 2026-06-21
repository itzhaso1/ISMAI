@extends('layouts.admin')
@section('title', 'الطلبات')
@section('page_title', 'إدارة الطلبات')
@section('content')
@php($statuses = ['pending' => 'قيد الانتظار', 'confirmed' => 'مؤكد', 'processing' => 'قيد المعالجة', 'completed' => 'مكتمل', 'cancelled' => 'ملغي'])
<section class="admin-panel"><div class="table-wrap"><table class="admin-table"><thead><tr><th>رقم الطلب</th><th>العميل</th><th>الحالة</th><th>الإجمالي</th><th>التاريخ</th><th>الإجراءات</th></tr></thead><tbody>@foreach($orders as $order)<tr><td><strong>{{ $order->order_number }}</strong></td><td>{{ $order->customer_name }}<small>{{ $order->customer_phone }}</small></td><td>{{ $statuses[$order->status] ?? $order->status }}</td><td>{{ number_format((float) $order->grand_total, 2) }}</td><td>{{ $order->created_at?->format('Y-m-d') }}</td><td class="row-actions"><a href="{{ route('admin.orders.show', $order) }}">عرض</a><a href="{{ route('admin.orders.edit', $order) }}">تعديل</a><form method="POST" action="{{ route('admin.orders.destroy', $order) }}">@csrf @method('DELETE')<button onclick="return confirm('هل تريد حذف الطلب؟')">حذف</button></form></td></tr>@endforeach</tbody></table></div>{{ $orders->links() }}</section>
@endsection
