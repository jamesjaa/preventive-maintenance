@extends('layouts.index')
@section('content')
    <div class="card info-card sales-card p-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="pagetitle">
                    <h4>รายงานการซ่อมบำรุง</h4>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">หน้าหลัก</a></li>
                            <li class="breadcrumb-item active"><u>รายงานการซ่อมบำรุง</u></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-8">
                <form method="GET" action="{{ route('report') }}">
                    <div class="row">
                        <div class="col-sm-3 m-1">
                            <select class="form-select" name="year" onchange="this.form.submit()">
                                <option value="">เลือกปี</option>
                                @foreach (range(date('Y'), date('Y') - 5) as $y)
                                    <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-3 m-1">
                            @php
                                $thaiMonths = [
                                    1 => 'มกราคม',
                                    2 => 'กุมภาพันธ์',
                                    3 => 'มีนาคม',
                                    4 => 'เมษายน',
                                    5 => 'พฤษภาคม',
                                    6 => 'มิถุนายน',
                                    7 => 'กรกฎาคม',
                                    8 => 'สิงหาคม',
                                    9 => 'กันยายน',
                                    10 => 'ตุลาคม',
                                    11 => 'พฤศจิกายน',
                                    12 => 'ธันวาคม',
                                ];
                            @endphp
                            <select class="form-select" name="month" onchange="this.form.submit()">
                                <option value="">เลือกเดือน</option>
                                @foreach ($thaiMonths as $m => $monthName)
                                    <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                                        {{ $monthName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-sm-4">
                <div class="float-end">
                    <a href="{{ route('report.export.excel', request()->all()) }}" class="btn btn-success">
                        <i class="bi bi-file-earmark-excel"></i> Export Excel
                    </a>
                    <a href="{{ route('report.export.pdf', request()->all()) }}" target="_blank" class="btn btn-danger">
                        <i class="bi bi-file-earmark-pdf"></i> Export PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="card info-card sales-card p-4">
        <div class="col-sm-12">
            <div class="pagetitle">
                <h6>ตารางรายงานการซ่อมบำรุง</h6>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered" id="data-table">
                <thead>
                    <tr class="text-center">
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
                    @php $i = 0; @endphp
                    @foreach ($logs as $log)
                        <tr>
                            <th class="text-center">{{ ++$i }}</th>
                            <td class="text-center">{{ date('d/m/Y', strtotime($log->planned_date)) }}</td>
                            <td class="text-center">{{ date('d/m/Y', strtotime($log->actual_date)) }}</td>
                            <td class="text-center">{{ $log->groups_name }}</td>
                            <td class="text-center">{{ $log->type_name }}</td>
                            <td>{{ $log->hw_sn }}</td>
                            <td class="text-center">{{ $log->brand_name }}</td>
                            <td class="text-center">{{ $log->model_name }}</td>
                            <td>{{ $log->hw_name }}</td>
                            <td class="text-center">{{ number_format($log->cost, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @php $totalCost = $logs->sum('cost'); @endphp
        <div class="mt-3">
            <h6>ค่าใช้จ่ายรวม: <strong>{{ number_format($totalCost, 2) }} บาท</strong></h6>
        </div>
    </div>
@endsection
