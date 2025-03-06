@extends('layouts.master')

@section('css')
    <!-- Select2 CSS -->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!-- File Upload CSS -->
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet">
    <!-- Fancy Uploader CSS -->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet">
@endsection

@section('title', 'إنشاء تذكرة جديدة')

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">التذاكر</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ إنشاء تذكرة</span>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    {{--  @if(auth()->user()->hasOpenTicket())
                        <div class="alert alert-warning">لا يمكنك إنشاء تذكرة جديدة حتى يتم إغلاق التذكرة الحالية.</div>
                    @else  --}}
                        <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            {{--  @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>  --}}

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="title" class="form-label">عنوان التذكرة</label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="category_id" class="form-label">الفئة</label>
                                    <select class="form-control select2" id="category_id" name="category_id" required>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="department_id" class="form-label">القسم</label>

                                    @if(auth()->user()->hasRole('client'))
                                        <!-- ثابت فقط للـ Client -->
                                        <select class="form-control select2" id="department_id" name="department_id" disabled>
                                            @foreach($departments as $department)
                                                <option value="{{ $department->id }}"
                                                    {{ auth()->user()->department_id == $department->id ? 'selected' : '' }}>
                                                    {{ $department->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <!-- حقل مخفي لضمان إرسال القسم عند الحفظ -->
                                        <input type="hidden" name="department_id" value="{{ auth()->user()->department_id }}">
                                    @else
                                        <!-- قابل للتعديل لباقي المستخدمين -->
                                        <select class="form-control select2" id="department_id" name="department_id" required>
                                            @foreach($departments as $department)
                                                <option value="{{ $department->id }}"
                                                    {{ old('department_id', $ticket->department_id ?? '') == $department->id ? 'selected' : '' }}>
                                                    {{ $department->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>



                                <div class="col-md-6 mb-3">
                                    <label for="priority" class="form-label">الأولوية</label>
                                    <select class="form-control select2" id="priority" name="priority" required>
                                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>منخفضة</option>
                                        <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>متوسطة</option>
                                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>عالية</option>
                                    </select>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="description" class="form-label">الوصف</label>
                                    <textarea class="form-control" id="description" name="description" required>{{ old('description') }}</textarea>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="attachments" class="form-label">المرفقات (صور أو فيديوهات)</label>
                                    <input type="file" name="attachments[]" class="form-control" id="attachments" multiple>
                                    <small class="text-muted">يمكنك رفع صور (JPG, PNG) أو فيديوهات (MP4, MOV, AVI) بحد أقصى 10MB لكل ملف.</small>
                                    @error('attachments.*')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary">إنشاء التذكرة</button>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- Select2 JS -->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endsection
