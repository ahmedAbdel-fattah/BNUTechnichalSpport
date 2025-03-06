<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Ticket;
use App\Notifications\TicketUpdatedNotification;
use Illuminate\Support\Facades\Notification;

class NotificationSeeder extends Seeder
{
    public function run()
    {
        $user = User::find(3);
        $ticket1 = Ticket::find(1);
        $ticket2 = Ticket::find(2);

        if ($user && $ticket1) {
            Notification::send($user, new TicketUpdatedNotification($ticket1, 'تم تحديث التذكرة رقم: ' . $ticket1->id));
        }

        if ($user && $ticket2) {
            Notification::send($user, new TicketUpdatedNotification($ticket2, 'تم تحديث التذكرة رقم: ' . $ticket2->id));
        }
    }
}
