@extends('layouts.app')

@section('content')
<div class="container">
    <h2>📢 الإشعارات</h2>

    <a href="{{ route('notifications.markAllAsRead') }}" class="btn btn-primary mb-3">تحديد الكل كمقروء</a>

    @if($notifications->count())
        <ul class="list-group">
            @foreach($notifications as $notification)
                <li class="list-group-item {{ $notification->read_at ? '' : 'bg-light' }}">
                    <p><strong>📌 التذكرة:</strong>
                        <a href="{{ route('tickets.show', $notification->data['ticket_id']) }}">
                            {{ $notification->data['notification_message'] }}
                        </a>
                    </p>
                    <small>{{ $notification->created_at->diffForHumans() }}</small>

                    @if(!$notification->read_at)
                        <a href="{{ route('notifications.markAsRead', $notification->id) }}" class="btn btn-sm btn-success">✔ تعليم كمقروء</a>
                    @endif
                </li>
            @endforeach
        </ul>
    @else
        <p>🚀 لا يوجد إشعارات جديدة.</p>
    @endif
</div>
@endsection
