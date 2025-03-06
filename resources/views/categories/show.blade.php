@extends('layouts.master')

@section('title', 'تفاصيل الفئة')

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الفئات</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تفاصيل الفئة</span>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-6 mx-auto">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">تفاصيل الفئة</h4>
                <p class="card-text"><strong>اسم الفئة:</strong> {{ $category->name }}</p>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary">رجوع</a>
                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning">تعديل</a>
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('هل أنت متأكد من حذف هذه الفئة؟');">حذف</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
