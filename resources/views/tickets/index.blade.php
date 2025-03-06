@extends('layouts.master')

@section('title')
    قائمة التذاكر
@stop

@section('css')
    <!-- DataTables CSS -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <!-- Select2 CSS -->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <!-- Breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">التذاكر</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة التذاكر</span>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <!-- Filters and Actions -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <!-- Add Ticket Button -->
                    <a href="{{ route('tickets.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i>&nbsp; إضافة تذكرة
                    </a>
                </div>

                <div class="card-body">
                    <!-- Filter Form -->
                    @if(auth()->user()->hasRole('admin'))

                    <form action="{{ route('tickets.index') }}" method="GET" class="mb-3">
                        <div class="row">
                            <!-- Status Filter -->
                            <div class="col-lg-2 col-md-4 mb-2">
                                <select name="status" class="form-control">
                                    <option value="">الحالة</option>
                                    <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>مفتوحة</option>
                                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>قيد التنفيذ</option>
                                    <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>مغلقة</option>
                                </select>
                            </div>
                            <!-- Priority Filter -->
                            <div class="col-lg-2 col-md-4 mb-2">
                                <select name="priority" class="form-control">
                                    <option value="">الأولوية</option>
                                    <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>منخفضة</option>
                                    <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>متوسطة</option>
                                    <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>عالية</option>
                                </select>
                            </div>
                            <!-- Start Date Filter -->
                            <div class="col-lg-2 col-md-4 mb-2">
                                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}" placeholder="تاريخ البداية">
                            </div>
                            <!-- End Date Filter -->
                            <div class="col-lg-2 col-md-4 mb-2">
                                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}" placeholder="تاريخ النهاية">
                            </div>
                        </div>
                        <!-- Filter Buttons -->
                        <button type="submit" class="btn btn-primary">تطبيق الفلاتر</button>
                        <a href="{{ route('tickets.index') }}" class="btn btn-secondary">إعادة التعيين</a>
                        <!-- Export Buttons -->
                        <a href="{{ route('reports.export.pdf', request()->query()) }}" class="btn btn-danger">📄 تصدير PDF</a>
                        <a href="{{ route('reports.export.excel', request()->query()) }}" class="btn btn-success">📊 تصدير Excel</a>
                    </form>
                    @endif


                    <!-- Tickets Table -->
                    <div class="table-responsive">
                        <table class="table key-buttons text-md-nowrap" id="tickets-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>عنوان التذكرة</th>
                                    <th>القسم</th>
                                    <th>الحالة</th>
                                    <th>الأولوية</th>
                                    <th>مُعيّن إلى</th>
                                    <th>تاريخ الإنشاء</th>
                                    <th>العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tickets as $ticket)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $ticket->title }}</td>
                                        <td>{{ $ticket->department->name }}</td>
                                        <td>
                                            <span class="badge
                                                @if($ticket->status == 'open') badge-success
                                                @elseif($ticket->status == 'in_progress') badge-warning
                                                @else badge-danger
                                                @endif">
                                                {{ ucfirst($ticket->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge
                                                @if($ticket->priority == 'low') badge-info
                                                @elseif($ticket->priority == 'medium') badge-primary
                                                @else badge-danger
                                                @endif">
                                                {{ ucfirst($ticket->priority) }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ $ticket->assignedUser ? $ticket->assignedUser->name : 'غير معيّن' }}
                                        </td>
                                        <td>{{ $ticket->created_at ? $ticket->created_at->format('Y-m-d') : 'N/A' }}</td>
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
    </div>
@endsection

@section('js')
    <!-- DataTables JS -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <!-- Initialize DataTable -->
    <script>
        $(document).ready(function() {
            $('#tickets-table').DataTable({
                responsive: true,
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/Arabic.json"
                }
            });
        });
    </script>
@endsection
