<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\TicketUpdatedNotification;
use Illuminate\Support\Facades\Notification;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'comment_text' => 'required|string',
        ]);

        $ticket = Ticket::findOrFail($request->ticket_id);

        $comment = new Comment();
        $comment->ticket_id = $ticket->id;
        $comment->user_id = auth()->id();
        $comment->comment_text = $request->comment_text;
        $comment->save();

        $usersToNotify = collect([$ticket->user]);

        if ($ticket->assigned_user_id) {
            $assignedUser = User::find($ticket->assigned_user_id);
            if ($assignedUser) {
                $usersToNotify->push($assignedUser);
            }
        }

        Notification::send($usersToNotify, new TicketUpdatedNotification($ticket, 'تم إضافة تعليق جديد على التذكرة: ' . $ticket->title));

        return back()->with('success', 'تمت إضافة التعليق بنجاح.');
    }
}
