<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Department;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            $users_count = User::count();
            $tickets_count = Ticket::count();
            $departments_count = Department::count();
            $categories_count = Category::count();
            $openTickets = Ticket::where('status', 'open')->count();
            $inProgressTickets = Ticket::where('status', 'in_progress')->count();
            $closedTickets = Ticket::where('status', 'closed')->count();
            $latestTickets = Ticket::where('status', 'open')->latest()->limit(10)->get();
        }

        elseif ($user->hasRole('staff')) {
            $users_count = null;
            $departments_count = null;
            $categories_count = null;

            $tickets_count = Ticket::where('assigned_user_id', $user->id)
                                   ->orWhere('user_id', $user->id)
                                   ->count();
            $openTickets = Ticket::where('status', 'open')
                                 ->where(function ($query) use ($user) {
                                     $query->where('assigned_user_id', $user->id)
                                           ->orWhere('user_id', $user->id);
                                 })->count();
            $inProgressTickets = Ticket::where('status', 'in_progress')
                                       ->where(function ($query) use ($user) {
                                           $query->where('assigned_user_id', $user->id)
                                                 ->orWhere('user_id', $user->id);
                                       })->count();
            $closedTickets = Ticket::where('status', 'closed')
                                   ->where(function ($query) use ($user) {
                                       $query->where('assigned_user_id', $user->id)
                                             ->orWhere('user_id', $user->id);
                                   })->count();
            $latestTickets = Ticket::where('status', 'open')
                                   ->where(function ($query) use ($user) {
                                       $query->where('assigned_user_id', $user->id)
                                             ->orWhere('user_id', $user->id);
                                   })
                                   ->latest()->limit(10)->get();
        }

        else {
            $users_count = null;
            $departments_count = null;
            $categories_count = null;

            $tickets_count = Ticket::where('user_id', $user->id)->count();
            $openTickets = Ticket::where('status', 'open')->where('user_id', $user->id)->count();
            $inProgressTickets = Ticket::where('status', 'in_progress')->where('user_id', $user->id)->count();
            $closedTickets = Ticket::where('status', 'closed')->where('user_id', $user->id)->count();
            $latestTickets = Ticket::where('status', 'open')
                                   ->where('user_id', $user->id)
                                   ->latest()->limit(10)->get();
        }

        return view('dashboard.index', compact(
            'users_count',
            'tickets_count',
            'departments_count',
            'categories_count',
            'openTickets',
            'inProgressTickets',
            'closedTickets',
            'latestTickets'
        ));
    }
}
