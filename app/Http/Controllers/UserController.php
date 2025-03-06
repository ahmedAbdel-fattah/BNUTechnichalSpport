<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;


class UserController extends Controller
{
    /**
     * عرض قائمة المستخدمين
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * عرض نموذج إنشاء مستخدم جديد
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name'); // ✅ جلب قائمة الأدوار من Spatie
        return view('users.create', compact('roles'));
    }


    /**
     * حفظ مستخدم جديد في قاعدة البيانات
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|exists:roles,name', // ✅ التأكد من أن الدور موجود في جدول الأدوار
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role); // ✅ تعيين الدور من Spatie

        return redirect()->route('users.index')->with('success', 'تمت إضافة المستخدم بنجاح!');
    }

    /**
     * عرض تفاصيل المستخدم
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * عرض نموذج تعديل المستخدم
     */
    public function edit(User $user)
    {
        $roles = Role::pluck('name', 'name');
        return view('users.edit', compact('user', 'roles'));
    }


    /**
     * تحديث بيانات المستخدم في قاعدة البيانات
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password' => 'nullable|min:6|confirmed',
            'role' => 'required|exists:roles,name', // ✅ التحقق من صحة الدور
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        $user->syncRoles([$request->role]); // ✅ تحديث الدور باستخدام Spatie

        return redirect()->route('users.index')->with('success', 'تم تحديث بيانات المستخدم بنجاح!');
    }

    /**
     * حذف المستخدم من قاعدة البيانات
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'تم حذف المستخدم بنجاح!');
    }

    public function editProfile()
{
    $user = auth()->user();
    return view('users.profile', compact('user'));
}


public function updateProfile(Request $request)
{
    $user = auth()->user();

    // التحقق من الإدخالات
    $request->validate([
        'name' => 'required|string|max:255',
        'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'password' => 'nullable|min:6|confirmed',
    ]);

    // تحديث الاسم
    $user->name = $request->name;

    // تحديث كلمة المرور إذا تم إدخالها
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    // رفع الصورة إذا تم إدخالها
    if ($request->hasFile('profile_image')) {
        $file = $request->file('profile_image');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/profile_images'), $filename);

        // حذف الصورة القديمة إن وجدت
        if ($user->profile_image && file_exists(public_path('uploads/profile_images/' . $user->profile_image))) {
            unlink(public_path('uploads/profile_images/' . $user->profile_image));
        }

        // حفظ الصورة الجديدة
        $user->profile_image = $filename;
    }

    // حفظ التعديلات
    $user->save();

    return redirect()->back()->with('success', 'تم تحديث الملف الشخصي بنجاح!');
}


}