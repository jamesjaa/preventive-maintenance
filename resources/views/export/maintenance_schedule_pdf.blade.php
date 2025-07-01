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
    <h3 style="text-align: center;">รายงานแผนการซ่อมบำรุง</h3>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>กลุ่ม</th>
                <th>ชนิด</th>
                <th>SN</th>
                <th>แบรนด์</th>
                <th>โมเดล</th>
                <th>ชื่อ</th>
                <th>Plan Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->groups_name }}</td>
                    <td>{{ $item->type_name }}</td>
                    <td>{{ $item->hw_sn }}</td>
                    <td>{{ $item->brand_name }}</td>
                    <td>{{ $item->model_name }}</td>
                    <td>{{ $item->hw_name }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->planned_date)->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
