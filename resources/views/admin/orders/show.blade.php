@extends('layouts.admin')
@section('title', 'Order '.$order->order_number)
@section('page_title', 'Order '.$order->order_number)
@section('content')
<section class="admin-panel"><p><strong>Customer:</strong> {{ $order->customer_name }} | {{ $order->customer_phone }} | {{ $order->customer_email }}</p><p><strong>Status:</strong> {{ $order->status }}</p><p><strong>Total:</strong> {{ number_format((float) $order->grand_total, 2) }}</p><p>{{ $order->notes }}</p><a class="btn-primary" href="{{ route('admin.orders.edit', $order) }}">Update Status</a></section><section class="admin-panel"><h2>Items</h2><div class="table-wrap"><table class="admin-table"><thead><tr><th>Product</th><th>SKU</th><th>Qty</th><th>Unit</th><th>Total</th></tr></thead><tbody>@foreach($order->items as $item)<tr><td>{{ $item->product_name }}</td><td>{{ $item->sku }}</td><td>{{ $item->quantity }}</td><td>{{ number_format((float) $item->unit_price, 2) }}</td><td>{{ number_format((float) $item->line_total, 2) }}</td></tr>@endforeach</tbody></table></div></section>
@endsection
