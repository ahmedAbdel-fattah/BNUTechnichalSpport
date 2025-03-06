@extends('layouts.master')

@section('title', 'إضافة دور جديد')

@section('css')
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">إدارة الأدوار</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ إضافة دور جديد</span>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">إضافة دور جديد</h4>
                    <form action="{{ route('roles.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">اسم الدور</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <h5 class="mt-3">تعيين الصلاحيات</h5>
                        <div class="row">
                            @foreach ($permissions as $permission)
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" class="form-check-input">
                                        <label class="form-check-label">{{ $permission->name }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> حفظ</button>
                            <a href="{{ route('roles.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> إلغاء</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endsection
