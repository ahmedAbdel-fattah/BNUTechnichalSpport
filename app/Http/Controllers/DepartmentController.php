<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * عرض قائمة الأقسام
     */
    public function index()
    {
        $departments = Department::all();
        return view('departments.index', compact('departments'));
    }

    /**
     * عرض نموذج إنشاء قسم جديد
     */
    public function create()
    {
        return view('departments.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:departments,name',
        ]);

        Department::create([
            'name' => $request->name,
        ]);

        return redirect()->route('departments.index')->with('success', 'تمت إضافة القسم بنجاح!');
    }


    public function show(Department $department)
    {
        return view('departments.show', compact('department'));
    }


    public function edit(Department $department)
    {
        return view('departments.edit', compact('department'));
    }


    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:departments,name,' . $department->id,
        ]);

        $department->update([
            'name' => $request->name,
        ]);

        return redirect()->route('departments.index')->with('success', 'تم تحديث بيانات القسم بنجاح!');
    }


    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('departments.index')->with('success', 'تم حذف القسم بنجاح!');
    }
}
