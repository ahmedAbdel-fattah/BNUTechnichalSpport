@extends('layouts.app')

@section('title', 'تسجيل الدخول')

@section('css')
<style>
    body {
        background: linear-gradient(135deg, #667eea, #764ba2);
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
    .login-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }
    .card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        padding: 25px;
        transition: transform 0.3s ease-in-out;
    }
    .card:hover {
        transform: scale(1.02);
    }
    .card-header {
        font-size: 1.5rem;
        font-weight: bold;
        text-align: center;
        color: #333;
    }
    .btn-primary {
        background-color: #5a67d8;
        border: none;
        transition: 0.3s;
    }
    .btn-primary:hover {
        background-color: #434190;
    }
</style>
@endsection

@section('content')
<div class="container login-container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">تسجيل الدخول</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login.post') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">البريد الإلكتروني</label>
                            <input type="email" name="email" class="form-control" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">كلمة المرور</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">تسجيل الدخول</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
