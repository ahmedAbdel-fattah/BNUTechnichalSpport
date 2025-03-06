@extends('layouts.master')

@section('title', 'تعديل التذكرة')

@section('css')
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">التذاكر</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل التذكرة</span>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('tickets.update', $ticket->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="title" class="form-label">عنوان التذكرة</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $ticket->title) }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="category_id" class="form-label">الفئة</label>
                                <select class="form-control select2" id="category_id" name="category_id" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $ticket->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="department_id" class="form-label">القسم</label>
                                <select class="form-control select2" id="department_id" name="department_id" disabled>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}"
                                            {{ auth()->user()->department_id == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <!-- حقل مخفي لضمان إرسال القسم عند حفظ النموذج -->
                                <input type="hidden" name="department_id" value="{{ auth()->user()->department_id }}">
                            </div>


                            @if(auth()->user()->hasRole('admin'))
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">حالة التذكرة</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="open" {{ old('status', $ticket->status) == 'open' ? 'selected' : '' }}>مفتوحة</option>
                                    <option value="in_progress" {{ old('status', $ticket->status) == 'in_progress' ? 'selected' : '' }}>قيد المعالجة</option>
                                    <option value="closed" {{ old('status', $ticket->status) == 'closed' ? 'selected' : '' }}>مغلقة</option>
                                </select>
                            </div>
                            @endif


                            <div class="col-md-6 mb-3">
                                <label for="priority" class="form-label">الأولوية</label>
                                <select class="form-control select2" id="priority" name="priority" required>
                                    <option value="low" {{ old('priority', $ticket->priority) == 'low' ? 'selected' : '' }}>منخفضة</option>
                                    <option value="medium" {{ old('priority', $ticket->priority) == 'medium' ? 'selected' : '' }}>متوسطة</option>
                                    <option value="high" {{ old('priority', $ticket->priority) == 'high' ? 'selected' : '' }}>عالية</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            <label for="description" class="form-label">الوصف</label>
                            <textarea class="form-control" id="description" name="description" required>{{ old('description', $ticket->description) }}</textarea>
                        </div>

                        <div class="col-12 mb-3">
                            <label for="attachments" class="form-label">إضافة مرفقات جديدة</label>
                            <input type="file" name="attachments[]" class="form-control" id="attachments" multiple>
                            <small class="text-muted">يمكنك رفع صور (JPG, PNG) أو فيديوهات (MP4, MOV, AVI) بحد أقصى 10MB لكل ملف.</small>
                        </div>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">🔄 تحديث التذكرة</button>
                            <a href="{{ route('tickets.index') }}" class="btn btn-secondary">↩️ إلغاء</a>
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
