@extends('layouts.master')

@section('title', 'تعديل الملف الشخصي')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-4">تعديل الملف الشخصي</h4>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- صورة المستخدم -->
                    <div class="form-group">
                        <label>الصورة الشخصية</label>
                        <input type="file" name="profile_image" class="form-control @error('profile_image') is-invalid @enderror">
                        @error('profile_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        @if(auth()->user()->profile_image)
                            <div class="mt-2">
                                <img src="{{ asset('uploads/profile_images/' . auth()->user()->profile_image) }}" class="rounded-circle" width="100" height="100" alt="الصورة الشخصية">
                            </div>
                        @endif
                    </div>

                    <!-- الاسم -->
                    <div class="form-group">
                        <label>الاسم</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', auth()->user()->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- كلمة المرور -->
                    <div class="form-group">
                        <label>كلمة المرور الجديدة (اختياري)</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- تأكيد كلمة المرور -->
                    <div class="form-group">
                        <label>تأكيد كلمة المرور</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
