<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;

class TicketPolicy
{
    /**
     * تحديد من يمكنه عرض قائمة التذاكر
     */
    public function viewAny(User $user)
    {
        return $user->hasRole('admin') || $user->hasRole('staff');
    }

    /**
     * تحديد من يمكنه عرض تذكرة معينة
     */
    public function view(User $user, Ticket $ticket)
    {
        return $user->hasRole('admin') ||
               $user->id === $ticket->user_id ||
               $user->id === $ticket->assigned_user_id;
    }

    /**
     * تحديد من يمكنه إنشاء تذكرة جديدة
     */
    public function create(User $user)
    {
        return $user->hasRole('client') || $user->hasRole('staff');
    }

    /**
     * تحديد من يمكنه تعديل التذكرة
     */
    public function update(User $user, Ticket $ticket)
    {
        return $user->hasRole('admin') ||
               ($user->hasRole('staff') && $user->id === $ticket->assigned_user_id);
    }

    /**
     * تحديد من يمكنه حذف التذكرة
     */
    public function delete(User $user, Ticket $ticket)
    {
        return $user->hasRole('admin');
    }
}