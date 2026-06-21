@extends('layouts.admin')
@section('title', 'السلايدر')
@section('page_title', 'إدارة السلايدر الرئيسي')
@section('content')
<div class="admin-toolbar"><span></span><a class="btn-primary" href="{{ route('admin.sliders.create') }}">إضافة سلايد</a></div><section class="admin-panel"><div class="table-wrap"><table class="admin-table"><thead><tr><th>العنوان</th><th>زر الدعوة</th><th>الترتيب</th><th>الحالة</th><th>الإجراءات</th></tr></thead><tbody>@foreach($sliders as $slider)<tr><td><strong>{{ $slider->title_ar }}</strong><small>{{ $slider->title_en }}</small></td><td>{{ $slider->button_text_ar }}</td><td>{{ $slider->sort_order }}</td><td>{{ $slider->is_active ? 'نشط' : 'غير نشط' }}</td><td class="row-actions"><a href="{{ route('admin.sliders.edit', $slider) }}">تعديل</a><form method="POST" action="{{ route('admin.sliders.destroy', $slider) }}">@csrf @method('DELETE')<button onclick="return confirm('هل تريد حذف السلايد؟')">حذف</button></form></td></tr>@endforeach</tbody></table></div>{{ $sliders->links() }}</section>
@endsection
