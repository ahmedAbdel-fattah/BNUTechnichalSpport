<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Ticket;

class TicketUpdatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $ticket;
    protected $message;

    public function __construct(Ticket $ticket, $message)
    {
        $this->ticket = $ticket;
        $this->message = $message;
    }


    public function via($notifiable)
    {
        return ['mail'];
    }


    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('🔔 تحديث بخصوص التذكرة: ' . $this->ticket->title)
            ->greeting('مرحبًا ' . $notifiable->name . '،')
            ->line($this->message)
            ->action('📂 عرض التذكرة', url('/tickets/' . $this->ticket->id))
            ->line('شكراً لاستخدامك نظام الدعم الفني.');
    }


    public function toArray($notifiable)
    {
        return [
            'ticket_id' => $this->ticket->id,
            'title' => $this->ticket->title,
            'message' => $this->message,
            'url' => url('/tickets/' . $this->ticket->id),
        ];
    }
}
