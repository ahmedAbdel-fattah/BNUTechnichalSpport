@extends('layouts.master')

@section('title')
    تفاصيل التذكرة - {{ $ticket->title }}
@stop

@section('css')
    <style>
        .badge {
            font-size: 0.9rem;
            padding: 0.5em 0.75em;
            border-radius: 8px;
        }
        .img-thumbnail {
            max-width: 150px;
            height: auto;
            border-radius: 10px;
        }
        .alert-secondary {
            background-color: #f8f9fa;
            border-left: 5px solid #007bff;
        }
        .card-header {
            background: #007bff;
            color: white;
            font-weight: bold;
        }
    </style>
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">📌 التذاكر</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تفاصيل التذكرة</span>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="card shadow-lg">
            <div class="card-header text-center">
                <h4>{{ $ticket->title }}</h4>
            </div>
            <div class="card-body">
                <p><strong>👤 صاحب التذكرة:</strong> {{ optional($ticket->user)->name ?? 'غير معروف' }}</p>
                <p><strong>📝 الوصف:</strong> {{ $ticket->description }}</p>
                <p><strong>📂 الفئة:</strong> {{ optional($ticket->category)->name ?? 'غير محدد' }}</p>
                <p><strong>🏢 القسم:</strong> {{ optional($ticket->department)->name ?? 'غير محدد' }}</p>

                <p><strong>🔄 الحالة:</strong>
                    <span class="badge bg-{{ $ticket->status == 'open' ? 'success' : ($ticket->status == 'in_progress' ? 'warning' : 'danger') }}">
                        {{ $ticket->status == 'open' ? 'مفتوحة' : ($ticket->status == 'in_progress' ? 'قيد المعالجة' : 'مغلقة') }}
                    </span>
                </p>

                <p><strong>⚡ الأولوية:</strong>
                    <span class="badge bg-{{ $ticket->priority == 'low' ? 'primary' : ($ticket->priority == 'medium' ? 'warning' : 'danger') }}">
                        {{ $ticket->priority == 'low' ? 'منخفضة' : ($ticket->priority == 'medium' ? 'متوسطة' : 'عالية') }}
                    </span>
                </p>

                <p><strong>👨‍💼 مُعيّن إلى:</strong> {{ $ticket->assigned_user_id ? optional($ticket->assignedUser)->name : 'لم يتم التعيين' }}</p>
                <p><strong>📅 تاريخ الإنشاء:</strong> {{ optional($ticket->created_at)->format('Y-m-d H:i') ?? 'غير متوفر' }}</p>
                <p><strong>🕒 آخر تحديث:</strong> {{ optional($ticket->updated_at)->format('Y-m-d H:i') ?? 'غير متوفر' }}</p>

                @if(auth()->user()->hasRole('admin'))
                <div class="col-md-6 mb-3">
                    <label for="assigned_user_id" class="form-label">تعيين إلى</label>
                    <select class="form-control select2" id="assigned_user_id" name="assigned_user_id">
                        <option value="">اختر موظف</option>
                        @foreach($users->filter(fn($user) => $user->hasRole('staff')) as $user)
                            <option value="{{ $user->id }}" {{ $ticket->assigned_user_id == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif

                <hr>
                <h5>📎 المرفقات</h5>
                <div class="row">
                    @forelse (json_decode($ticket->attachments, true) ?? [] as $attachment)
                        <div class="col-md-3 text-center">
                            <a href="{{ asset('storage/' . $attachment) }}" target="_blank">
                                <img src="{{ asset('storage/' . $attachment) }}" class="img-thumbnail" alt="Attachment">
                            </a>
                            <p class="mt-2">
                                <a href="{{ asset('storage/' . $attachment) }}" download class="btn btn-sm btn-primary">📥 تحميل</a>
                            </p>
                        </div>
                    @empty
                        <p class="text-muted">لا توجد مرفقات لهذه التذكرة.</p>
                    @endforelse
                </div>
                <hr>
                <h5>➕ إضافة مرفقات</h5>
                <form action="{{ route('tickets.attachments', $ticket->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <input type="file" name="attachments[]" multiple class="form-control @error('attachments') is-invalid @enderror">
                        @error('attachments')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success">📤 رفع المرفقات</button>
                </form>


                <hr>

                @if(auth()->user()->hasRole('admin'))
                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label">حالة التذكرة</label>
                    <select class="form-control" id="status">
                        <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>مفتوحة</option>
                        <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>قيد المعالجة</option>
                        <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>مغلقة</option>
                    </select>
                </div>
            @endif


                <h5>💬 التعليقات</h5>
                @forelse ($ticket->comments as $comment)
                    <div class="alert alert-secondary">
                        <p>{{ $comment->comment_text }}</p>
                        <small class="text-muted">✍️ بواسطة: {{ optional($comment->user)->name ?? 'مجهول' }} - {{ optional($comment->created_at)->diffForHumans() ?? 'غير متوفر' }}</small>
                    </div>
                @empty
                    <p class="text-muted">لا توجد تعليقات بعد.</p>
                @endforelse

                <hr>

                <h5>➕ إضافة تعليق</h5>
                <form method="POST" action="{{ route('comments.store') }}">
                    @csrf
                    <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                    <div class="mb-3">
                        <textarea name="comment_text" class="form-control @error('comment_text') is-invalid @enderror" placeholder="أضف تعليقك هنا..." required></textarea>
                        @error('comment_text')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">إضافة تعليق</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let assignedUserSelect = document.getElementById('assigned_user_id');

        if (assignedUserSelect) {
            assignedUserSelect.addEventListener('change', function() {
                let assignedUserId = this.value;
                let ticketId = {{ $ticket->id }};

                fetch(`/tickets/${ticketId}/assign`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        assigned_user_id: assignedUserId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("تم تعيين الموظف بنجاح!");
                        location.reload();
                    } else {
                        alert("خطأ: " + (data.message || "يرجى المحاولة مرة أخرى"));
                    }
                })
                .catch(error => {
                    console.error("خطأ:", error);
                    alert("حدث خطأ غير متوقع.");
                });
            });
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        let statusSelect = document.getElementById('status');

        if (statusSelect) {
            statusSelect.addEventListener('change', function() {
                let newStatus = this.value;
                let ticketId = {{ $ticket->id }};

                fetch(`/tickets/${ticketId}/status`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ status: newStatus })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("✅ تم تحديث الحالة بنجاح!");
                    } else {
                        alert("❌ خطأ: " + (data.message || "يرجى المحاولة مرة أخرى"));
                    }
                })
                .catch(error => {
                    console.error("خطأ:", error);
                    alert("❌ حدث خطأ غير متوقع.");
                });
            });
        }
    });
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("commentForm").addEventListener("submit", function(event) {
            event.preventDefault();

            let commentText = document.getElementById("comment_text").value;
            let formData = new FormData(this);

            fetch("{{ route('comments.store') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    let newComment = document.createElement("div");
                    newComment.classList.add("alert", "alert-secondary");
                    newComment.innerHTML = `
                        <p>${decodeURIComponent(escape(data.comment.comment_text))}</p>
                        <small class="text-muted">✍️ بواسطة: ${decodeURIComponent(escape(data.comment.user_name))} - ${data.comment.created_at}</small>
                    `;

                    document.getElementById("commentsSection").prepend(newComment);
                    document.getElementById("comment_text").value = "";
                } else {
                    alert("❌ حدث خطأ أثناء إرسال التعليق.");
                }
            })
            .catch(error => {
                console.error("خطأ:", error);
                alert("❌ حدث خطأ غير متوقع.");
            });
        });
    });

</script>
@endsection
