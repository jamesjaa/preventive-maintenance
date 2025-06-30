@extends('layouts.index')
@section('content')
    <div class="card info-card sales-card p-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="pagetitle">
                    <h1>จัดการร์อุปกรณ์</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">หน้าหลัก</a></li>
                            <li class="breadcrumb-item active">จัดการร์อุปกรณ์</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-8">
                <div class="float-start">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-search">ค้นหา</span>
                        <input type="text" class="form-control" placeholder="ค้นหาข้อมูล..." aria-label="ค้นหาข้อมูล..."
                            id="searchInput" aria-describedby="basic-search">
                    </div>
                    <script>
                        $(document).ready(function() {
                            $("#searchInput").on("keyup", function() {
                                var value = $(this).val().toLowerCase();
                                $("table tbody tr").filter(function() {
                                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                                });
                            });
                        });
                    </script>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="float-end">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addHw"><i
                            class="bi bi-plus-lg me-2"></i>เพิ่มอุปกรณ์</button>
                    <!-- Modal -->
                    <div class="modal fade" id="addHw" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                        aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <form id="frm-add-hw">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5">เพิ่มอุปกรณ์</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row g-3">
                                            <!-- กลุ่ม -->
                                            <div class="col-md-6">
                                                <label for="groups_id" class="form-label">กลุ่มอุปกรณ์</label>
                                                <select class="form-select" id="groups_id" name="groups_id" required>
                                                    <option selected disabled value="">เลือกกลุ่มอุปกรณ์...</option>
                                                    @foreach ($groups as $g)
                                                        <option value="{{ $g->groups_id }}">{{ $g->groups_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- ประเภท -->
                                            <div class="col-md-6">
                                                <label for="type_id" class="form-label">ประเภทอุปกรณ์</label>
                                                <select class="form-select" id="type_id" name="type_id" required>
                                                    <option selected disabled value="">เลือกประเภทอุปกรณ์...</option>
                                                </select>
                                            </div>

                                            <!-- แบรนด์ -->
                                            <div class="col-md-6">
                                                <label for="brand_id" class="form-label">แบรนด์</label>
                                                <select class="form-select" id="brand_id" name="brand_id" required>
                                                    <option selected disabled value="">เลือกแบรนด์...</option>
                                                </select>
                                            </div>

                                            <!-- โมเดล -->
                                            <div class="col-md-6">
                                                <label for="model_id" class="form-label">โมเดล</label>
                                                <select class="form-select" id="model_id" name="model_id" required>
                                                    <option selected disabled value="">เลือกโมเดล...</option>
                                                </select>
                                            </div>

                                            <!-- ชื่ออุปกรณ์ -->
                                            <div class="col-12">
                                                <label for="hw_name" class="form-label">ชื่ออุปกรณ์</label>
                                                <input type="text" class="form-control" id="hw_name" name="hw_name"
                                                    required>
                                            </div>

                                            <!-- SN -->
                                            <div class="col-md-6">
                                                <label for="hw_sn" class="form-label">SN</label>
                                                <input type="text" class="form-control" id="hw_sn" name="hw_sn"
                                                    required>
                                            </div>

                                            <!-- โซน -->
                                            <div class="col-md-6">
                                                <label for="zone_id" class="form-label">โซน</label>
                                                <select class="form-select" id="zone_id" name="zone_id" required>
                                                    <option selected disabled value="">เลือกโซน...</option>
                                                    @foreach ($zone as $z)
                                                        <option value="{{ $z->zone_id }}">{{ $z->zone_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
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
                </div>
            </div>
        </div>
    </div>
    <div class="card info-card sales-card p-4">
        <div class="col-sm-12">
            <div class="pagetitle">
                <h1>อุปกรณ์ทั้งหมด</h1>
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
                        <th scope="col">ประวัติ</th>
                        <th scope="col">แก้ไข</th>
                        <th scope="col">ลบ</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 0;
                    @endphp
                    @foreach ($equipment as $equ)
                        <tr>
                            @php
                                $i++;
                            @endphp
                            <th scope="row" class="text-center">{{ $i }}</th>
                            <td class="text-center">{{ $equ->groups_name }}</td>
                            <td class="text-center">{{ $equ->type_name }}</td>
                            <td class="searchable-column">{{ $equ->hw_sn }}</td>
                            <td class="text-center">{{ $equ->brand_name }}</td>
                            <td class="text-center">{{ $equ->model_name }}</td>
                            <td>{{ $equ->hw_name }}</td>
                            <td class="text-center">
                                <a type="button" class="btn btn-primary btn-sm"
                                    href="{{ route('PmRecord', ['id' => $equ->hw_id]) }}"><i
                                        class="bi bi-card-checklist"></i></a>
                            </td>
                            <td></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger btn-sm delete-group-btn"
                                    data-id="{{ $equ->hw_id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                                <script>
                                    $(document).ready(function() {
                                        $('.delete-group-btn').on('click', function() {
                                            var hwId = $(this).data('id');

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
                                                        url: "{{ route('frmDeleteHW') }}",
                                                        type: "POST",
                                                        data: {
                                                            _token: "{{ csrf_token() }}",
                                                            hw_id: hwId
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
    <script>
        $(document).ready(function() {
            $('#groups_id').on('change', function() {
                let groupId = $(this).val();
                $('#type_id').html('<option selected disabled>กำลังโหลด...</option>');
                $.get('/getTypes/' + groupId, function(data) {
                    $('#type_id').empty().append(
                        '<option selected disabled value="">เลือกประเภทอุปกรณ์...</option>');
                    $.each(data, function(i, item) {
                        $('#type_id').append('<option value="' + item.type_id + '">' + item
                            .type_name + '</option>');
                    });
                });

                $('#brand_id').html('<option selected disabled value="">เลือกแบรนด์...</option>');
                $('#model_id').html('<option selected disabled value="">เลือกโมเดล...</option>');
            });

            $('#type_id').on('change', function() {
                let typeId = $(this).val();
                $('#brand_id').html('<option selected disabled>กำลังโหลด...</option>');
                $.get('/getBrands/' + typeId, function(data) {
                    $('#brand_id').empty().append(
                        '<option selected disabled value="">เลือกแบรนด์...</option>');
                    $.each(data, function(i, item) {
                        $('#brand_id').append('<option value="' + item.brand_id + '">' +
                            item.brand_name + '</option>');
                    });
                });
            });

            $('#brand_id').on('change', function() {
                let brandId = $(this).val();
                $('#model_id').html('<option selected disabled>กำลังโหลด...</option>');
                $.get('/getModels/' + brandId, function(data) {
                    $('#model_id').empty().append(
                        '<option selected disabled value="">เลือกโมเดล...</option>');
                    $.each(data, function(i, item) {
                        $('#model_id').append('<option value="' + item.model_id + '">' +
                            item.model_name + '</option>');
                    });
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#frm-add-hw").submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('frmAddEquipment') }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
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
                        } else if (xhr.status === 400) {
                            Swal.fire({
                                icon: 'error',
                                title: 'ข้อมูลซ้ำ',
                                text: xhr.responseJSON.message ||
                                    'ข้อมูลนี้มีอยู่แล้วในระบบ'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาด',
                                text: xhr.responseJSON.message ||
                                    'ไม่สามารถดำเนินการได้ กรุณาลองใหม่อีกครั้ง'
                            });
                        }
                    }
                });
            });
        });
    </script>
@endsection
