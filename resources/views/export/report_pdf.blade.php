<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <style>
        @font-face {
            font-family: "thsarabunnew";
            src: url("thsarabunnew.ttf") format("truetype");
        }

        body {
            font-family: "thsarabunnew";
            font-size: 14px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            table-layout: fixed;
            word-wrap: break-word;
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
    <h3 style="text-align: center;">รายงานการซ่อมบำรุง</h3>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>วันที่ PM แผน</th>
                <th>วันที่ PM จริง</th>
                <th>กลุ่ม</th>
                <th>ชนิด</th>
                <th>SN</th>
                <th>แบรนด์</th>
                <th>โมเดล</th>
                <th>ชื่ออุปกรณ์</th>
                <th>ค่าใช้จ่าย</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logs as $i => $log)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($log->planned_date)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($log->actual_date)->format('d/m/Y') }}</td>
                    <td>{{ $log->groups_name }}</td>
                    <td>{{ $log->type_name }}</td>
                    <td>{{ $log->hw_sn }}</td>
                    <td>{{ $log->brand_name }}</td>
                    <td>{{ $log->model_name }}</td>
                    <td>{{ $log->hw_name }}</td>
                    <td>{{ number_format($log->cost, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
