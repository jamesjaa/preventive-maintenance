@extends('layouts.index')

@section('content')
    <div class="card info-card sales-card p-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="pagetitle">
                    <h4>Dashboard</h4>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">หน้าหลัก</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <section class="section dashboard">
        <div class="row">

            {{-- Summary Cards --}}
            <div class="col-lg-12">
                <div class="row">
                    {{-- Card 1 --}}
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">อุปกรณ์ครบกำหนด PM วันนี้</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-exclamation-triangle"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $maintenance->count() }} รายการ</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Card 2 --}}
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card revenue-card">
                            <div class="card-body">
                                <h5 class="card-title">โซนที่มีงานค้างมากสุด</h5>
                                @php
                                    $topZone = $maintenance
                                        ->groupBy('zone_name')
                                        ->sortByDesc(fn($g) => count($g))
                                        ->keys()
                                        ->first();
                                @endphp
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-geo-alt"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $topZone ?? '-' }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Card 3 --}}
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card customers-card">
                            <div class="card-body">
                                <h5 class="card-title">ค่าใช้จ่ายรวมจริง</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cash-coin"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ number_format($totalCost, 2) }} บาท</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Data Table --}}
            <div class="col-12">
                <div class="card recent-sales overflow-auto">
                    <div class="col-sm-12 p-4">
                        <div class="pagetitle">
                            <h4>ตารางแจ้งเตือนอุปกรณ์ครบกำหนด PM</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <style>
                            table.dataTable thead th {
                                text-align: center;
                            }
                        </style>
                        <table class="table table-bordered datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>โซน</th>
                                    <th>กลุ่ม</th>
                                    <th>ชนิด</th>
                                    <th>SN</th>
                                    <th>แบรนด์</th>
                                    <th>โมเดล</th>
                                    <th>ชื่ออุปกรณ์</th>
                                    <th>สถานะ</th>
                                    <th>PM Plan Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($maintenance as $i => $mt)
                                    <tr>
                                        <th class="text-center">{{ $i + 1 }}</th>
                                        <td class="text-center">{{ $mt->zone_name }}</td>
                                        <td class="text-center">{{ $mt->groups_name }}</td>
                                        <td class="text-center">{{ $mt->type_name }}</td>
                                        <td class="text-center">{{ $mt->hw_sn }}</td>
                                        <td class="text-center">{{ $mt->brand_name }}</td>
                                        <td class="text-center">{{ $mt->model_name }}</td>
                                        <td>{{ $mt->hw_name }}</td>
                                        <td class="text-center">
                                            @if ($mt->status == 1)
                                                <span class="badge text-bg-secondary">รอดำเนินการ</span>
                                            @else
                                                <span class="badge text-bg-warning">รออะไหล่</span>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ date('d-m-Y', strtotime($mt->planned_date)) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
