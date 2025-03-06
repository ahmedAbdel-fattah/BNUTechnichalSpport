<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Category;
use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TicketsExport;
use App\Notifications\TicketUpdatedNotification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;




class TicketController extends Controller
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

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('assigned_user_id')) {
            $query->where('assigned_user_id', $request->assigned_user_id);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        $tickets = $query->latest()->paginate(10);
        $categories = Category::all();
        $departments = Department::all();
        $users = User::all();

        return view('tickets.index', compact('tickets', 'categories', 'departments', 'users'));
    }



    public function create()
    {
        $categories = Category::all();
        $departments = Department::all();
        $users = User::all();

        return view('tickets.create', compact('categories', 'departments', 'users'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'department_id' => 'required|exists:departments,id',
            'priority' => 'required|in:low,medium,high',
            'assigned_user_id' => 'nullable|exists:users,id',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov,avi|max:10240'
        ]);

        $slug = Str::slug($validatedData['title'], '-');

        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('attachments', $fileName, 'public');

                $attachments[] = $filePath;
            }
        }

        $ticket = Ticket::create([
            'user_id' => $user->id,
            'title' => $request->title,
            'slug' => $slug,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'department_id' => $request->department_id,
            'priority' => $request->priority,
            'status' => 'open',
            'assigned_user_id' => $request->assigned_user_id,
            'attachments' => json_encode($attachments),
        ]);

        return redirect()->route('tickets.index')->with('success', 'تم إنشاء التذكرة بنجاح.');
    }


    public function show(Ticket $ticket)
    {
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'staff');
        })->get();

        return view('tickets.show', compact('ticket', 'users'));
    }


    public function edit(Ticket $ticket)
    {
        $categories = Category::all();
        $departments = Department::all();
        $users = User::all();

        return view('tickets.edit', compact('ticket', 'categories', 'departments', 'users'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'department_id' => 'required|exists:departments,id',
            'priority' => 'required|in:low,medium,high',
            'status' => 'nullable|in:open,in_progress,closed',
            'assigned_user_id' => 'nullable|exists:users,id',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov,avi|max:10240',
            'remove_attachments' => 'nullable|array'
        ]);

        $attachments = json_decode($ticket->attachments, true) ?? [];

        if ($request->filled('remove_attachments')) {
            foreach ($request->remove_attachments as $removeFile) {
                if (($key = array_search($removeFile, $attachments)) !== false) {
                    unset($attachments[$key]);
                    Storage::disk('public')->delete($removeFile);
                }
            }
        }

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('attachments', $fileName, 'public');
                $attachments[] = $filePath;
            }
        }

        $ticket->update([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'department_id' => $request->department_id,
            'priority' => $request->priority,
            'status' => $request->status ?? 'open',
            'assigned_user_id' => $request->assigned_user_id,
            'attachments' => json_encode(array_values($attachments)),
        ]);

        return redirect()->route('tickets.index')->with('success', 'تم تحديث التذكرة بنجاح.');
    }

    public function assignUser(Request $request, Ticket $ticket)
{
    $request->validate([
        'assigned_user_id' => 'nullable|exists:users,id'
    ]);

    $ticket->assigned_user_id = $request->assigned_user_id;
    $ticket->save();

    return response()->json(['success' => true, 'message' => 'تم تعيين الموظف بنجاح']);
}

public function addAttachments(Request $request, Ticket $ticket)
{
    $request->validate([
        'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov,avi|max:10240',
    ]);

    $currentAttachments = $ticket->attachments ? json_decode($ticket->attachments, true) : [];

    if ($request->hasFile('attachments')) {
        foreach ($request->file('attachments') as $file) {
            $path = $file->store('attachments', 'public');
            $currentAttachments[] = $path;
        }
    }

    $ticket->update([
        'attachments' => json_encode($currentAttachments),
    ]);

    return back()->with('success', 'تمت إضافة المرفقات بنجاح.');
}
public function updateStatus(Request $request, Ticket $ticket)
{
    $request->validate([
        'status' => 'required|in:open,in_progress,closed',
    ]);

    $ticket->update(['status' => $request->status]);

    return response()->json(['success' => true, 'message' => 'تم تحديث حالة التذكرة بنجاح.']);
}

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return redirect()->route('tickets.index')->with('success', 'تم حذف التذكرة بنجاح!');
    }
}