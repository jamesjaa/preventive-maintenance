<table>
    <thead>
        <tr>
            <th>#</th>
            <th>PM Plan Date</th>
            <th>วันที่ PM อุปกรณ์</th>
            <th>กลุ่มอุปกรณ์</th>
            <th>ชนิดอุปกรณ์</th>
            <th>SN</th>
            <th>แบรนด์</th>
            <th>โมเดล</th>
            <th>ชื่อของอุปกรณ์</th>
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
