<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;

Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('notifications')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('notifications.index');
        Route::get('/read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
        Route::get('/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    });

    Route::resource('tickets', TicketController::class);

Route::prefix('tickets')->group(function () {
    Route::get('/filter', [TicketController::class, 'filter'])->name('tickets.filter');
    Route::get('/export', [TicketController::class, 'export'])->name('tickets.export');
    Route::post('/{ticket}/assign', [TicketController::class, 'assignUser'])->name('tickets.assign');
    Route::post('/{ticket}/attachments', [TicketController::class, 'addAttachments'])->name('tickets.attachments');
    Route::post('/{ticket}/status', [TicketController::class, 'updateStatus'])->name('tickets.updateStatus');
});


    Route::prefix('reports')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/export/pdf', [ReportController::class, 'exportPDF'])->name('reports.export.pdf');
        Route::get('/export/excel', [ReportController::class, 'exportExcel'])->name('reports.export.excel');
    });

    Route::resource('comments', CommentController::class);

    Route::get('/profile', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('roles', RoleController::class);
});