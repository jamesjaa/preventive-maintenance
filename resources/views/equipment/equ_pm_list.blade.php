@extends('layouts.index')
@section('content')
    <div class="card info-card sales-card p-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="pagetitle">
                    <h4>ประวัติการซ่อมบำรุง (PM)</h4>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">หน้าหลัก</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('equipment') }}">บันทึกผลการซ่อมบำรุง (PM)</a></li>
                            <li class="breadcrumb-item active"><u>ประวัติการซ่อมบำรุง (PM)</u></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <form method="GET" action="">
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <label for="start_date">จากวันที่</label>
                            <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                                class="form-control">
                        </div>
                        <div class="col-sm-3">
                            <label for="end_date">ถึงวันที่</label>
                            <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                                class="form-control">
                        </div>
                        <div class="col-sm-3 align-self-end">
                            <button type="submit" class="btn btn-primary">ค้นหา</button>
                            {{-- <a href="{{ route('equipment.pm.list', $equipment->hw_id) }}"
                                class="btn btn-secondary">ล้างค่า</a> --}}
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-sm-6">
                <div class="float-end">
                    <a href="{{ route('equipment.export.excel', array_merge([$equipment->hw_id], request()->only(['start_date', 'end_date']))) }}"
                        class="btn btn-success">
                        <i class="bi bi-file-earmark-excel"></i> Export Excel
                    </a>
                    <a href="{{ route('equipment.export.pdf', array_merge([$equipment->hw_id], request()->only(['start_date', 'end_date']))) }}"
                        target="_blank" class="btn btn-danger">
                        <i class="bi bi-file-earmark-pdf"></i> Export PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="card info-card sales-card p-4">

        <div class="col-sm-12">
            <div class="pagetitle">
                <h6>ตารางประวัติการซ่อมบำรุง (PM) : {{ $equipment->hw_sn }} - {{ $equipment->hw_name }}</h6>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered datatable" id="data-table">
                <thead>
                    <tr class="text-center">
                        <th scope="col">#</th>
                        <th scope="col">วันที่ PM อุปกรณ์</th>
                        <th scope="col">สถานะ</th>
                        <th scope="col">ผู้ดำเนินการ</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 0;
                    @endphp
                    @foreach ($logs as $log)
                        <tr>
                            @php
                                $i++;
                            @endphp
                            <th class="text-center" scope="col">{{ $i }}</th>
                            <td class="text-center">{{ date('d/m/Y', strtotime($log->actual_date)) }}</td>
                            <td class="text-center">
                                @if ($log->status == 1)
                                    <span class="badge text-bg-success">ดำเนินการเรียบร้อย</span>
                                @elseif ($log->status == 2)
                                    <span class="badge text-bg-success">ไม่สามารถซ่อมไม่ได้</span>
                                @else
                                @endif
                            </td>
                            <td class="text-center">{{ $log->maintenance_name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
