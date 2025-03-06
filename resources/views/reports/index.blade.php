@extends('layouts.master')

@section('title', 'تقرير التذاكر - نظام إدارة التذاكر')

@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.css') }}" rel="stylesheet">
@endsection

@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">التقارير</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0"> / تقرير التذاكر</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <button aria-label="Close" class="close" data-dismiss="alert" type="button">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>خطأ:</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- فلترة التذاكر -->
<form action="{{ url()->current() }}" method="GET" class="mb-3">
    <div class="row">
        @php
            $filters = [
                ['name' => 'status', 'label' => 'الحالة', 'options' => ['open' => 'مفتوحة', 'in_progress' => 'قيد التنفيذ', 'closed' => 'مغلقة']],
                ['name' => 'priority', 'label' => 'الأولوية', 'options' => ['low' => 'منخفضة', 'medium' => 'متوسطة', 'high' => 'عالية']],
                ['name' => 'department_id', 'label' => 'القسم', 'options' => $departments->pluck('name', 'id')->toArray()],
                ['name' => 'category_id', 'label' => 'الفئة', 'options' => $categories->pluck('name', 'id')->toArray()]
            ];
        @endphp

        @foreach ($filters as $filter)
            <div class="col-lg-2 col-md-4 mb-2">
                <select name="{{ $filter['name'] }}" class="form-control">
                    <option value="">{{ $filter['label'] }}</option>
                    @foreach ($filter['options'] as $key => $value)
                        <option value="{{ $key }}" {{ request($filter['name']) == $key ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        @endforeach

        <div class="col-lg-2 col-md-4 mb-2">
            <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}" placeholder="تاريخ البداية">
        </div>
        <div class="col-lg-2 col-md-4 mb-2">
            <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}" placeholder="تاريخ النهاية">
        </div>
    </div>
    <div class="mt-2">
        <button type="submit" class="btn btn-primary">🔍 تطبيق الفلاتر</button>
        <a href="{{ route('reports.index') }}" class="btn btn-secondary">♻️ إعادة التعيين</a>
    </div>
</form>

<!-- قائمة التذاكر -->
<div class="row">
    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="ticketsTable" class="table key-buttons text-md-nowrap" style="text-align: center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>عنوان التذكرة</th>
                                <th>القسم</th>
                                <th>الحالة</th>
                                <th>الأولوية</th>
                                <th>تاريخ الإنشاء</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tickets as $ticket)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $ticket->title }}</td>
                                    <td>{{ $ticket->department->name ?? 'غير محدد' }}</td>
                                    <td>{{ ucfirst($ticket->status) }}</td>
                                    <td>{{ ucfirst($ticket->priority) }}</td>
                                    <td>{{ $ticket->created_at ? $ticket->created_at->format('Y-m-d') : 'غير متوفر' }}</td>
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
<!-- Internal Data tables -->
<script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
<script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#ticketsTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '📥 تصدير Excel',
                    className: 'btn btn-success'
                },
                {
                    extend: 'pdfHtml5',
                    text: '📄 تصدير PDF',
                    className: 'btn btn-danger',
                    orientation: 'landscape',
                    pageSize: 'A4',
                    customize: function(doc) {
                        doc.defaultStyle.alignment = 'center';
                        doc.styles.tableHeader.alignment = 'center';
                    }
                },
                {
                    extend: 'print',
                    text: '🖨️ طباعة',
                    className: 'btn btn-primary'
                }
            ],
            language: {
                search: "🔍 بحث:",
                lengthMenu: "عرض _MENU_ سجل",
                info: "عرض _START_ إلى _END_ من أصل _TOTAL_ سجل",
                paginate: {
                    first: "الأول",
                    last: "الأخير",
                    next: "التالي",
                    previous: "السابق"
                }
            }
        });
    });
</script>
@endsection
