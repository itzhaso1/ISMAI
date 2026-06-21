@extends('layouts.admin')
@section('title', 'النصوص الثابتة')
@section('page_title', 'إدارة النصوص الثابتة')
@section('content')
<div class="admin-toolbar"><span></span><a class="btn-primary" href="{{ route('admin.content-blocks.create') }}">إضافة نص ثابت</a></div><section class="admin-panel"><div class="table-wrap"><table class="admin-table"><thead><tr><th>المفتاح</th><th>الاسم</th><th>العربية</th><th>الإنجليزية</th><th>عام</th><th>الإجراءات</th></tr></thead><tbody>@foreach($blocks as $block)<tr><td>{{ $block->key }}</td><td>{{ data_get($block->value, 'label') }}</td><td>{{ str(data_get($block->value, 'ar'))->limit(60) }}</td><td>{{ str(data_get($block->value, 'en'))->limit(60) }}</td><td>{{ $block->is_public ? 'نعم' : 'لا' }}</td><td class="row-actions"><a href="{{ route('admin.content-blocks.edit', $block) }}">تعديل</a><form method="POST" action="{{ route('admin.content-blocks.destroy', $block) }}">@csrf @method('DELETE')<button onclick="return confirm('هل تريد حذف النص؟')">حذف</button></form></td></tr>@endforeach</tbody></table></div>{{ $blocks->links() }}</section>
@endsection
