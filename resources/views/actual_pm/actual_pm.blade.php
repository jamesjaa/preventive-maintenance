@extends('layouts.index')
@section('content')
    <div class="card info-card sales-card p-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="pagetitle">
                    <h4>บันทึกผลการซ่อมบำรุง (PM)</h4>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">หน้าหลัก</a></li>
                            <li class="breadcrumb-item active"><u>บันทึกผลการซ่อมบำรุง (PM)</u></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <form method="GET" action="{{ route('ActualPm') }}">
                    <div class="row">
                        <div class="col-sm-3">
                            <select class="form-select" name="year" onchange="this.form.submit()">
                                <option value="">เลือกปี</option>
                                @foreach (range(date('Y'), date('Y') - 5) as $y)
                                    <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-3">
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
        </div>
    </div>
    <div class="card info-card sales-card p-4">

        <div class="col-sm-12">
            <div class="pagetitle">
                <h6>ตารางบันทึกผลการซ่อมบำรุง (PM)</h6>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered datatable" id="data-table">
                <thead>
                    <tr class="text-center">
                        <th scope="col">#</th>
                        <th scope="col">กลุ่มอุปกรณ์</th>
                        <th scope="col">ชนิด</th>
                        <th scope="col">SN อุปกรณ์</th>
                        <th scope="col">แบรนด์</th>
                        <th scope="col">โมเดล</th>
                        <th scope="col">ชื่อของอุปกรณ์</th>
                        <th scope="col">PM Plan Date</th>
                        <th scope="col">วันที่ PM อุปกรณ์</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 0;
                    @endphp
                    @foreach ($maintenance as $mt)
                        @php
                            $i++;
                        @endphp
                        <tr>
                            <th scope="row" class="text-center">{{ $i }}</th>
                            <td class="text-center">{{ $mt->groups_name }}</td>
                            <td class="text-center">{{ $mt->type_name }}</td>
                            <td class="searchable-column">{{ $mt->hw_sn }}</td>
                            <td class="text-center">{{ $mt->brand_name }}</td>
                            <td class="text-center">{{ $mt->model_name }}</td>
                            <td>{{ $mt->hw_name }}</td>
                            <td class="text-center">{{ date('d-m-Y', strtotime($mt->planned_date)) }} </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#addDetailPm">
                                    <i class="bi bi-tools"></i>
                                </button>
                            </td>
                            <!-- Modal -->
                            <div class="modal fade" id="addDetailPm" data-bs-backdrop="static" data-bs-keyboard="false"
                                tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form id="frm-actual-pm-{{ $mt->pm_id }}">
                                        @csrf
                                        <input type="hidden" name="schedule_id" value="{{ $mt->pm_id }}">
                                        <input type="hidden" name="hw_id" value="{{ $mt->hw_id }}">
                                        <input type="hidden" name="cycle_month" value="{{ $mt->groups_cycle_month }}">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">บันทึกการทำ PM:
                                                    {{ $mt->equipment->hw_name ?? '' }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">วันที่ PM จริง</label>
                                                    <input type="date" class="form-control" name="actual_date" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">สถานะการดำเนินการ</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="status"
                                                            id="statusSuccess" value="1" checked>
                                                        <label class="form-check-label" for="statusSuccess">
                                                            สำเร็จ (ซ่อมได้)
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="status"
                                                            id="statusFailed" value="2">
                                                        <label class="form-check-label" for="statusFailed">
                                                            ยกเลิก (ซ่อมไม่ได้)
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">รายละเอียด</label>
                                                    <textarea class="form-control" name="detail" rows="2"></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">ค่าใช้จ่าย (บาท)</label>
                                                    <input type="number" class="form-control" name="cost"
                                                        min="0" value="{{ $mt->groups_cost }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">ผู้ซ่อมบำรุง</label>
                                                    <select class="form-select" id="maintenance_id" name="maintenance_id"
                                                        required>
                                                        <option selected value="">เลือกผู้ซ่อมบำรุง...
                                                        </option>
                                                        @foreach ($staff as $stf)
                                                            <option value="{{ $stf->maintenance_id }}">
                                                                {{ $stf->maintenance_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">ยกเลิก</button>
                                                <button type="submit" class="btn btn-success">บันทึก</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

    <script>
        $(document).ready(function() {
            $("form[id^='frm-actual-pm-']").submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = form.serialize();

                $.ajax({
                    url: "{{ route('frmAddPM') }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'บันทึกสำเร็จ!',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด',
                            text: xhr.responseJSON.message || 'ไม่สามารถบันทึกได้'
                        });
                    }
                });
            });
        });
    </script>
@endsection
