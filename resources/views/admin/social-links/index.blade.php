@extends('layouts.admin')
@section('title', 'وسائل التواصل')
@section('page_title', 'إدارة وسائل التواصل')
@section('content')
<div class="admin-toolbar"><span></span><a class="btn-primary" href="{{ route('admin.social-links.create') }}">إضافة رابط تواصل</a></div><section class="admin-panel"><div class="table-wrap"><table class="admin-table"><thead><tr><th>المنصة</th><th>الاسم الظاهر</th><th>الرابط</th><th>الترتيب</th><th>الحالة</th><th>الإجراءات</th></tr></thead><tbody>@foreach($socialLinks as $link)<tr><td>{{ $link->platform }}</td><td>{{ $link->label }}</td><td>{{ $link->url }}</td><td>{{ $link->sort_order }}</td><td>{{ $link->is_active ? 'نشط' : 'غير نشط' }}</td><td class="row-actions"><a href="{{ route('admin.social-links.edit', $link) }}">تعديل</a><form method="POST" action="{{ route('admin.social-links.destroy', $link) }}">@csrf @method('DELETE')<button onclick="return confirm('هل تريد حذف رابط التواصل؟')">حذف</button></form></td></tr>@endforeach</tbody></table></div>{{ $socialLinks->links() }}</section>
@endsection
