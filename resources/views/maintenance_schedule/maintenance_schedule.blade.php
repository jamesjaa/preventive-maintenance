@extends('layouts.index')
@section('content')
    <div class="card info-card sales-card p-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="pagetitle">
                    <h1>จัดการตารางซ่อมบำรุง (PM)</h1>
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
            <div class="col-sm-12">
                <div class="float-start">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-search">ค้นหา</span>
                        <input type="text" class="form-control" placeholder="ค้นหาข้อมูล..." aria-label="ค้นหาข้อมูล..."
                            id="searchInput" aria-describedby="basic-search">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card info-card sales-card p-4">

        <div class="col-sm-12">
            <div class="pagetitle">
                <h1>ตารางแผนการซ่อมบำรุง</h1>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover" id="data-table">
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
                            <td class="text-center">{{ date('d-m-Y', strtotime($mt->planned_date)) }} </td>
                            <td></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger btn-sm delete-group-btn"
                                    data-id="{{ $mt->pm_id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
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
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection
