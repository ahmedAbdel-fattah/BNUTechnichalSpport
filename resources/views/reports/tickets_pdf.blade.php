<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="utf-8">
    <title>تقرير التذاكر</title>
    <style>
        body {
            font-family: "DejaVu Sans", sans-serif; /* استخدم خط يدعم العربية */
            direction: rtl;
            text-align: right;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">تقرير التذاكر</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>العنوان</th>
                <th>القسم</th>
                <th>الأولوية</th>
                <th>الحالة</th>
                <th>تاريخ الإنشاء</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tickets as $ticket)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $ticket->title }}</td>
                    <td>{{ $ticket->department->name }}</td>
                    <td>{{ ucfirst($ticket->priority) }}</td>
                    <td>{{ ucfirst($ticket->status) }}</td>
                    <td>{{ $ticket->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
