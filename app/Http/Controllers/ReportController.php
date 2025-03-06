<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TicketsExport;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Category;
use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class ReportController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Ticket::with(['category', 'department', 'user', 'assignedUser']);

        if ($user->hasRole('staff')) {
            $query->where('assigned_user_id', $user->id);
        } elseif ($user->hasRole('client')) {
            $query->where('user_id', $user->id);
        }

        $filters = ['status', 'priority', 'department_id', 'category_id', 'assigned_user_id'];
        foreach ($filters as $filter) {
            if ($request->filled($filter)) {
                $query->where($filter, $request->$filter);
            }
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        $tickets = $query->latest()->paginate(10);
        $categories = Category::all();
        $departments = Department::all();
        $users = User::all();

        return view('reports.index', compact('tickets', 'categories', 'departments', 'users'));
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new TicketsExport($request), 'tickets_report.xlsx');
    }

    public function exportPDF(Request $request)
    {
        $tickets = Ticket::query();

        if ($request->filled('status')) {
            $tickets->where('status', $request->status);
        }
        if ($request->filled('priority')) {
            $tickets->where('priority', $request->priority);
        }
        if ($request->filled('department_id')) {
            $tickets->where('department_id', $request->department_id);
        }
        if ($request->filled('category_id')) {
            $tickets->where('category_id', $request->category_id);
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $tickets->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        $tickets = $tickets->get();

        $pdf = Pdf::loadView('reports.tickets_pdf', compact('tickets'))
                 ->setPaper('a4', 'portrait')
                 ->setOptions([
                     'defaultFont' => 'dejavu sans',
                     'isHtml5ParserEnabled' => true,
                     'isRemoteEnabled' => true,
                 ]);

        return $pdf->download('tickets_report.pdf');
    }
}
