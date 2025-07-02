<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: "thsarabun";
            font-size: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px;
            text-align: center;
        }

        th {
            background-color: #f0f0f0;
        }
    </style>
</head>

<body>
    <h3>ประวัติการซ่อมบำรุงอุปกรณ์: {{ $equipment->hw_sn }} - {{ $equipment->hw_name }}</h3>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>วันที่ PM อุปกรณ์</th>
                <th>สถานะ</th>
                <th>ผู้ดำเนินการ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logs as $i => $log)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($log->actual_date)->format('d/m/Y') }}</td>
                    <td>
                        @if ($log->status == 1)
                            ดำเนินการเรียบร้อย
                        @elseif($log->status == 2)
                            ไม่สามารถซ่อมได้
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $log->maintenance_name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
