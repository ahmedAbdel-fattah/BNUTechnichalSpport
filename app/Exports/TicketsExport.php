<?php

namespace App\Exports;

use App\Models\Ticket;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TicketsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Ticket::query();

        // تطبيق الفلاتر على التذاكر
        if ($this->request->status) {
            $query->where('status', $this->request->status);
        }

        if ($this->request->priority) {
            $query->where('priority', $this->request->priority);
        }

        if ($this->request->department_id) {
            $query->where('department_id', $this->request->department_id);
        }

        if ($this->request->category_id) {
            $query->where('category_id', $this->request->category_id);
        }

        if ($this->request->start_date && $this->request->end_date) {
            $query->whereBetween('created_at', [$this->request->start_date, $this->request->end_date]);
        }

        return $query->get();
    }

    // ✅ تعيين عناوين الأعمدة في Excel
    public function headings(): array
    {
        return ["ID", "العنوان", "الحالة", "الأولوية", "القسم", "الفئة", "تاريخ الإنشاء"];
    }

    // ✅ تنسيق البيانات لكل صف عند تصديرها
    public function map($ticket): array
    {
        return [
            $ticket->id,
            $this->convertToUtf8($ticket->title),
            $this->convertToUtf8($ticket->status),
            $this->convertToUtf8($ticket->priority),
            $this->convertToUtf8(optional($ticket->department)->name),
            $this->convertToUtf8(optional($ticket->category)->name),
            $ticket->created_at ? $ticket->created_at->format('Y-m-d') : '—',
        ];
    }

    // ✅ تحويل النصوص إلى UTF-8 لمنع مشاكل التشفير
    private function convertToUtf8($value)
    {
        return mb_convert_encoding($value, 'UTF-8', 'auto');
    }
}