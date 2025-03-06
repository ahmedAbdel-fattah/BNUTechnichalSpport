@extends('layouts.master')

@section('title', 'إدارة المستخدمين')

@section('css')
    <!-- DataTables CSS -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
@endsection

@section('page-header')
    <!-- Breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">المستخدمون</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ إدارة المستخدمين</span>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">قائمة المستخدمين</h4>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <!-- إضافة مستخدم جديد -->
                    <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">
                        <i class="fas fa-user-plus"></i> إضافة مستخدم جديد
                    </a>

                    <div class="table-responsive">
                        <table class="table key-buttons text-md-nowrap" id="users-table">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>الاسم</th>
                                    <th>البريد الإلكتروني</th>
                                    <th>الدور</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if ($user->roles->isNotEmpty())
                                                {{ implode(', ', $user->roles->pluck('name')->toArray()) }}
                                            @else
                                                <span class="text-muted">لا يوجد دور</span>
                                            @endif
                                        </td>
                                        <td>
                                            <!-- عرض المستخدم -->
                                            <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i> عرض
                                            </a>
                                            <!-- تعديل المستخدم -->
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i> تعديل
                                            </a>
                                            <!-- حذف المستخدم -->
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد من حذف هذا المستخدم؟');">
                                                    <i class="fas fa-trash"></i> حذف
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">لا يوجد مستخدمون حتى الآن</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div> <!-- نهاية الجدول -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- DataTables JS -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>

    <!-- تهيئة DataTable -->
    <script>
        $(document).ready(function() {
            $('#users-table').DataTable({
                responsive: true,
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/Arabic.json"
                }
            });
        });
    </script>
@endsection
