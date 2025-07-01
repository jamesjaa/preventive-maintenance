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
