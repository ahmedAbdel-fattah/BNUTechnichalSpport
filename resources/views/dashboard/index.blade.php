@extends('layouts.master')

@section('css')
<link href="{{ URL::asset('assets/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('assets/plugins/jqvmap/jqvmap.min.css') }}" rel="stylesheet">
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="left-content">
        <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">مرحبًا بك في نظام التذاكر!</h2>
        <p class="mg-b-0">لوحة التحكم لمتابعة حالة التذاكر</p>
    </div>
</div>
@endsection

@section('content')
<div class="row row-sm">
    <div class="col-lg-4">
        <div class="card bg-primary-gradient">
            <div class="card-body">
                <h6 class="text-white">التذاكر المفتوحة</h6>
                <h4 class="text-white">{{ $openTickets }}</h4>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card bg-warning-gradient">
            <div class="card-body">
                <h6 class="text-white">التذاكر قيد المعالجة</h6>
                <h4 class="text-white">{{ $inProgressTickets }}</h4>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card bg-success-gradient">
            <div class="card-body">
                <h6 class="text-white">التذاكر المغلقة</h6>
                <h4 class="text-white">{{ $closedTickets }}</h4>
            </div>
        </div>
    </div>
</div>

<div class="row row-sm mt-4">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">أحدث التذاكر</h4>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>العنوان</th>
                            <th>الأولوية</th>
                            <th>الحالة</th>
                            <th>مُعيّن إلى</th>
                            <th>الإجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($latestTickets as $ticket)
                            <tr>
                                <td>{{ $ticket->id }}</td>
                                <td>{{ $ticket->title }}</td>
                                <td>
                                    <span class="badge badge-{{ $ticket->priority == 'high' ? 'danger' : ($ticket->priority == 'medium' ? 'warning' : 'secondary') }}">
                                        {{ ucfirst($ticket->priority) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $ticket->status == 'open' ? 'primary' : ($ticket->status == 'in_progress' ? 'warning' : 'success') }}">
                                        {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                    </span>
                                </td>
                                <td>
                                    {{ $ticket->assignedUser ? $ticket->assignedUser->name : 'غير معيّن' }}
                                </td>
                                <td>
                                    <!-- View Button -->
                                    <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-info btn-sm">عرض</a>
                                    <!-- Edit Button -->
                                    @can('edit tickets')
                                    <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-warning btn-sm">تعديل</a>
                                    @endcan
                                    <!-- Delete Button -->
                                    @can('delete tickets')
                                    <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد من حذف هذه التذكرة؟')">حذف</button>
                                    </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ URL::asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/index.js') }}"></script>
@endsection
