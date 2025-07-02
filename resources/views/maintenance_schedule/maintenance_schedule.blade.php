@extends('layouts.index')
@section('content')
    <div class="card info-card sales-card p-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="pagetitle">
                    <h4>จัดการตารางซ่อมบำรุง (PM)</h4>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">หน้าหลัก</a></li>
                            <li class="breadcrumb-item active"><u>จัดการตารางซ่อมบำรุง (PM)</u></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-8">
                <form method="GET" action="{{ route('MaintenanceSchedule') }}">
                    <div class="row">
                        <div class="col-sm-3 p-1">
                            <select class="form-select" name="year" onchange="this.form.submit()">
                                <option value="">เลือกปี</option>
                                @foreach (range(date('Y'), date('Y') - 5) as $y)
                                    <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-3 p-1">
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
                    <a href="{{ route('maintenance.export.excel', request()->all()) }}" class="btn btn-success">
                        <i class="bi bi-file-earmark-excel"></i> Export Excel
                    </a>
                    <a href="{{ route('maintenance.export.pdf', request()->all()) }}" target="_blank"
                        class="btn btn-danger">
                        <i class="bi bi-file-earmark-pdf"></i> Export PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="card info-card sales-card p-4">

        <div class="col-sm-12">
            <div class="pagetitle">
                <h6>ตารางแผนการซ่อมบำรุง</h6>
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
                        <th scope="col">แก้ไข</th>
                        <th scope="col">ลบ</th>
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
                            <td class="text-center">{{ date('d/m/Y', strtotime($mt->planned_date)) }}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editModel{{ $i }}"><i class="bi bi-pencil"></i></button>
                                <!-- Modal -->
                                <div class="modal fade" id="editModel{{ $i }}" data-bs-backdrop="static"
                                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-sm">
                                        <div class="modal-content">
                                            <form id="frm-edit-date{{ $i }}">
                                                @csrf
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">
                                                        แก้ไข PM Plan Date
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="basic-addon1">ระบุวันที่</span>
                                                        <input type="date" class="form-control" name="edit_date"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="hidden" name="pm_id" value="{{ $mt->pm_id }}">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">ยกเลิก</button>
                                                    <button type="submit" class="btn btn-success">บันทึกข้อมูล</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger btn-sm delete-group-btn"
                                    data-id="{{ $mt->pm_id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <script>
                            $(document).ready(function() {
                                $("#frm-edit-date" + <?php echo $i; ?>).submit(function(e) {
                                    e.preventDefault();

                                    var formData = $(this).serialize();

                                    $.ajax({
                                        url: "{{ route('frmEditDate') }}",
                                        type: "POST",
                                        data: formData,
                                        success: function(response) {
                                            // console.log(response);

                                            Swal.fire({
                                                icon: 'success',
                                                title: 'แจ้งเตือน!',
                                                text: response.message,
                                                showConfirmButton: false,
                                                timer: 1500
                                            }).then(() => {
                                                window.location.reload();
                                            });
                                        },
                                        error: function(xhr) {
                                            if (xhr.status === 422) {
                                                let errors = xhr.responseJSON.errors;
                                                let errorText = '';
                                                $.each(errors, function(key, value) {
                                                    errorText += value + '<br>';
                                                });

                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'ข้อมูลไม่ถูกต้อง',
                                                    html: errorText
                                                });
                                            } else {
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'เกิดข้อผิดพลาด',
                                                    text: xhr.responseJSON.message
                                                });
                                            }
                                        }
                                    });
                                });
                            });
                        </script>
                        <script>
                            $(document).ready(function() {
                                $('.delete-group-btn').on('click', function() {
                                    var pmId = $(this).data('id');

                                    Swal.fire({
                                        title: 'คุณแน่ใจหรือไม่?',
                                        text: "คุณต้องการลบข้อมูลนี้จริงหรือ?",
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#dc3545',
                                        cancelButtonColor: '#6c757d',
                                        confirmButtonText: 'ใช่, ลบเลย!',
                                        cancelButtonText: 'ยกเลิก'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            $.ajax({
                                                url: "{{ route('frmDeletePM') }}",
                                                type: "POST",
                                                data: {
                                                    _token: "{{ csrf_token() }}",
                                                    pm_id: pmId
                                                },
                                                success: function(response) {
                                                    // console.log(response);

                                                    Swal.fire({
                                                        icon: 'success',
                                                        title: 'ลบข้อมูลสำเร็จ!',
                                                        text: response.message,
                                                        showConfirmButton: false,
                                                        timer: 1500
                                                    }).then(() => {
                                                        window.location.reload();
                                                    });
                                                },
                                                error: function(xhr) {
                                                    let errorText = 'ไม่สามารถลบข้อมูลได้';

                                                    if (xhr.responseText && xhr.responseText.includes(
                                                            'Integrity constraint violation')) {
                                                        errorText =
                                                            'ข้อมูลนี้กำลังถูกใช้งานอยู่ ไม่สามารถลบได้';
                                                    } else if (xhr.responseJSON && xhr.responseJSON
                                                        .message) {
                                                        errorText = xhr.responseJSON.message;
                                                    }

                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'เกิดข้อผิดพลาด!',
                                                        text: errorText,
                                                        showConfirmButton: true
                                                    });
                                                }
                                            });
                                        }
                                    });
                                });
                            });
                        </script>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
