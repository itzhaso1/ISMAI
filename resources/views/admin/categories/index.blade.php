@extends('layouts.admin')
@section('title', 'الأقسام')
@section('page_title', 'إدارة الأقسام')
@section('content')
<div class="admin-toolbar"><form><input name="q" placeholder="بحث في الأقسام"></form><a class="btn-primary" href="{{ route('admin.categories.create') }}">إضافة قسم</a></div>
<section class="admin-panel"><div class="table-wrap"><table class="admin-table"><thead><tr><th>القسم</th><th>القسم الأب</th><th>الأقسام الفرعية</th><th>المنتجات</th><th>الحالة</th><th>الإجراءات</th></tr></thead><tbody>
@foreach($categories as $category)<tr><td><strong>{{ $category->name_ar }}</strong><small>{{ $category->name_en }}</small></td><td>{{ $category->parent?->name_ar ?: '-' }}</td><td>{{ $category->children_count }}</td><td>{{ $category->products_count }}</td><td>{{ $category->is_active ? 'نشط' : 'غير نشط' }}</td><td class="row-actions"><a href="{{ route('admin.categories.edit', $category) }}">تعديل</a><form method="POST" action="{{ route('admin.categories.destroy', $category) }}">@csrf @method('DELETE')<button type="submit" onclick="return confirm('هل تريد حذف القسم؟')">حذف</button></form></td></tr>@endforeach
</tbody></table></div>{{ $categories->links() }}</section>
@endsection
