@extends('layouts.admin')
@section('title', 'Orders')
@section('page_title', 'Orders')
@section('content')
<section class="admin-panel"><div class="table-wrap"><table class="admin-table"><thead><tr><th>Order</th><th>Customer</th><th>Status</th><th>Total</th><th>Date</th><th></th></tr></thead><tbody>@foreach($orders as $order)<tr><td><strong>{{ $order->order_number }}</strong></td><td>{{ $order->customer_name }}<small>{{ $order->customer_phone }}</small></td><td>{{ $order->status }}</td><td>{{ number_format((float) $order->grand_total, 2) }}</td><td>{{ $order->created_at?->format('Y-m-d') }}</td><td class="row-actions"><a href="{{ route('admin.orders.show', $order) }}">View</a><a href="{{ route('admin.orders.edit', $order) }}">Edit</a><form method="POST" action="{{ route('admin.orders.destroy', $order) }}">@csrf @method('DELETE')<button onclick="return confirm('Delete order?')">Delete</button></form></td></tr>@endforeach</tbody></table></div>{{ $orders->links() }}</section>
@endsection
