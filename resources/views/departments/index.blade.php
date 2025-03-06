@extends('layouts.master')

@section('css')
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('title', 'إدارة الأقسام')

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الأقسام</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ إدارة الأقسام</span>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <a href="{{ route('departments.create') }}" class="btn btn-primary mb-3">إضافة قسم جديد</a>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="departmentsTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>اسم القسم</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($departments as $department)
                                    <tr>
                                        <td>{{ $department->id }}</td>
                                        <td>{{ $department->name }}</td>
                                        <td>
                                            <a href="{{ route('departments.show', $department->id) }}" class="btn btn-info btn-sm">عرض</a>
                                            <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-warning btn-sm">تعديل</a>
                                            <form action="{{ route('departments.destroy', $department->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد من حذف هذا القسم؟')">حذف</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#departmentsTable').DataTable();
        });
    </script>
@endsection
