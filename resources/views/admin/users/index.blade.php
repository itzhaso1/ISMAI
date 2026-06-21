@extends('layouts.admin')
@section('title', 'المستخدمون')
@section('page_title', 'إدارة المستخدمين')
@section('content')
<div class="admin-toolbar"><span></span><a class="btn-primary" href="{{ route('admin.users.create') }}">إضافة مستخدم</a></div><section class="admin-panel"><div class="table-wrap"><table class="admin-table"><thead><tr><th>الاسم</th><th>البريد الإلكتروني</th><th>الدور</th><th>اللغة</th><th>الحالة</th><th>الإجراءات</th></tr></thead><tbody>@foreach($users as $user)<tr><td>{{ $user->name }}</td><td>{{ $user->email }}</td><td>{{ $user->role === 'admin' ? 'مدير' : 'عميل' }}</td><td>{{ $user->locale === 'ar' ? 'العربية' : 'الإنجليزية' }}</td><td>{{ $user->is_active ? 'نشط' : 'غير نشط' }}</td><td class="row-actions"><a href="{{ route('admin.users.edit', $user) }}">تعديل</a><form method="POST" action="{{ route('admin.users.destroy', $user) }}">@csrf @method('DELETE')<button onclick="return confirm('هل تريد حذف المستخدم؟')">حذف</button></form></td></tr>@endforeach</tbody></table></div>{{ $users->links() }}</section>
@endsection
