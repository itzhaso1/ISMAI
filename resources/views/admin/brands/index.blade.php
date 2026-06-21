@extends('layouts.admin')
@section('title', 'العلامات التجارية')
@section('page_title', 'إدارة العلامات التجارية')
@section('content')
<div class="admin-toolbar"><span></span><a class="btn-primary" href="{{ route('admin.brands.create') }}">إضافة علامة تجارية</a></div>
<section class="admin-panel"><div class="table-wrap"><table class="admin-table"><thead><tr><th>الاسم</th><th>المنتجات</th><th>الموقع</th><th>الحالة</th><th>الإجراءات</th></tr></thead><tbody>@foreach($brands as $brand)<tr><td><strong>{{ $brand->name }}</strong><small>{{ $brand->slug }}</small></td><td>{{ $brand->products_count }}</td><td>{{ $brand->website_url ?: '-' }}</td><td>{{ $brand->is_active ? 'نشط' : 'غير نشط' }}</td><td class="row-actions"><a href="{{ route('admin.brands.edit', $brand) }}">تعديل</a><form method="POST" action="{{ route('admin.brands.destroy', $brand) }}">@csrf @method('DELETE')<button onclick="return confirm('هل تريد حذف العلامة التجارية؟')">حذف</button></form></td></tr>@endforeach</tbody></table></div>{{ $brands->links() }}</section>
@endsection
