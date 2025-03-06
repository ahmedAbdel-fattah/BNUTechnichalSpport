@extends('layouts.master')

@section('title', 'تفاصيل المستخدم')

@section('page-header')
    <!-- Breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">المستخدمون</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تفاصيل المستخدم</span>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">تفاصيل المستخدم</h4>

                    <ul class="list-group">
                        <li class="list-group-item"><strong>الاسم:</strong> {{ $user->name }}</li>
                        <li class="list-group-item"><strong>البريد الإلكتروني:</strong> {{ $user->email }}</li>
                        <li class="list-group-item">
                            <strong>الدور:</strong>
                            @if ($user->roles->isNotEmpty())
                                {{ implode(', ', $user->roles->pluck('name')->toArray()) }}
                            @else
                                <span class="text-muted">لا يوجد دور</span>
                            @endif
                        </li>
                    </ul>

                    <div class="mt-3">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> العودة للقائمة
                        </a>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> تعديل
                        </a>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('هل أنت متأكد من حذف هذا المستخدم؟');">
                                <i class="fas fa-trash"></i> حذف
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
