@extends('layouts.master')

@section('title', 'تفاصيل القسم')

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الأقسام</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تفاصيل القسم</span>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-6 mx-auto">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">تفاصيل القسم</h4>
                <p class="mt-3"><strong>اسم القسم:</strong> {{ $department->name }}</p>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('departments.index') }}" class="btn btn-secondary">رجوع</a>
                    <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-warning">تعديل</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
