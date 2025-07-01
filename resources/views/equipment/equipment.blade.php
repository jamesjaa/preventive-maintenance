@extends('layouts.index')
@section('content')
    <div class="card info-card sales-card p-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="pagetitle">
                    <h4>จัดการอุปกรณ์</h4>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">หน้าหลัก</a></li>
                            <li class="breadcrumb-item active">จัดการอุปกรณ์</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="float-end">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addHw"><i
                            class="bi bi-plus-lg me-2"></i>เพิ่มอุปกรณ์</button>
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
                                            <div class="col-md-6">
                                                <label for="groups_id" class="form-label">กลุ่มอุปกรณ์</label>
                                                <select class="form-select groups-select" id="groups_id" name="groups_id"
                                                    required>
                                                    <option selected disabled value="">เลือกกลุ่มอุปกรณ์...</option>
                                                    @foreach ($groups as $g)
                                                        <option value="{{ $g->groups_id }}">{{ $g->groups_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="type_id" class="form-label">ประเภทอุปกรณ์</label>
                                                <select class="form-select type-select" id="type_id" name="type_id"
                                                    required>
                                                    <option selected disabled value="">เลือกประเภทอุปกรณ์...</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="brand_id" class="form-label">แบรนด์</label>
                                                <select class="form-select brand-select" id="brand_id" name="brand_id"
                                                    required>
                                                    <option selected disabled value="">เลือกแบรนด์...</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="model_id" class="form-label">โมเดล</label>
                                                <select class="form-select model-select" id="model_id" name="model_id"
                                                    required>
                                                    <option selected disabled value="">เลือกโมเดล...</option>
                                                </select>
                                            </div>

                                            <div class="col-12">
                                                <label for="hw_name" class="form-label">ชื่ออุปกรณ์</label>
                                                <input type="text" class="form-control" id="hw_name" name="hw_name"
                                                    required>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="hw_sn" class="form-label">SN</label>
                                                <input type="text" class="form-control" id="hw_sn" name="hw_sn"
                                                    required>
                                            </div>

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

    <script>
        $(document).ready(function() {
            // Live search functionality
            $("#searchInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("table tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });

            $(document).on('change', '.groups-select', function() {
                let $modal = $(this).closest('.modal');
                let groupId = $(this).val();
                let $type = $modal.find('.type-select');
                let $brand = $modal.find('.brand-select');
                let $model = $modal.find('.model-select');

                $type.html('<option selected disabled>กำลังโหลด...</option>');
                $.get('/getTypes/' + groupId, function(data) {
                    $type.empty().append(
                        '<option selected disabled value="">เลือกประเภทอุปกรณ์...</option>');
                    $.each(data, function(i, item) {
                        $type.append('<option value="' + item.type_id + '">' + item
                            .type_name + '</option>');
                    });
                    $brand.empty().append(
                        '<option selected disabled value="">เลือกแบรนด์...</option>');
                    $model.empty().append(
                        '<option selected disabled value="">เลือกโมเดล...</option>');
                });
            });

            $(document).on('change', '.type-select', function() {
                let $modal = $(this).closest('.modal');
                let typeId = $(this).val();
                let $brand = $modal.find('.brand-select');
                let $model = $modal.find('.model-select');

                $brand.html('<option selected disabled>กำลังโหลด...</option>');
                $.get('/getBrands/' + typeId, function(data) {
                    $brand.empty().append(
                        '<option selected disabled value="">เลือกแบรนด์...</option>');
                    $.each(data, function(i, item) {
                        $brand.append('<option value="' + item.brand_id + '">' + item
                            .brand_name + '</option>');
                    });
                    $model.empty().append(
                        '<option selected disabled value="">เลือกโมเดล...</option>');
                });
            });

            $(document).on('change', '.brand-select', function() {
                let $modal = $(this).closest('.modal');
                let brandId = $(this).val();
                let $model = $modal.find('.model-select');

                $model.html('<option selected disabled>กำลังโหลด...</option>');
                $.get('/getModels/' + brandId, function(data) {
                    $model.empty().append(
                        '<option selected disabled value="">เลือกโมเดล...</option>');
                    $.each(data, function(i, item) {
                        $model.append('<option value="' + item.model_id + '">' + item
                            .model_name + '</option>');
                    });
                });
            });

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
                        handleAjaxError(xhr);
                    }
                });
            });

            $(document).on('submit', 'form[id^="frm-edit-hw"]', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('frmEditEquipment') }}",
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
                        handleAjaxError(xhr);
                    }
                });
            });

            $(document).on('click', '.delete-group-btn', function() {
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

            function handleAjaxError(xhr) {
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

            $('div.modal[id^="editHw"]').on('show.bs.modal', function() {
                var $modal = $(this);
                var groupsId = $modal.find('input[name="groups_id"]').val();
                var typeId = $modal.find('input[name="type_id"]').val();
                var brandId = $modal.find('input[name="brand_id"]').val();
                var modelId = $modal.find('input[name="model_id"]').val();

                var $type = $modal.find('.type-select');
                var $brand = $modal.find('.brand-select');
                var $model = $modal.find('.model-select');

                if (groupsId) {
                    $.get('/getTypes/' + groupsId, function(typeData) {
                        $type.empty().append(
                            '<option disabled value="">เลือกประเภทอุปกรณ์...</option>');
                        $.each(typeData, function(i, item) {
                            var selected = (item.type_id == typeId) ? 'selected' : '';
                            $type.append('<option value="' + item.type_id + '" ' +
                                selected + '>' + item.type_name + '</option>');
                        });

                        // Load brands based on the pre-selected type
                        if (typeId) {
                            $.get('/getBrands/' + typeId, function(brandData) {
                                $brand.empty().append(
                                    '<option disabled value="">เลือกแบรนด์...</option>');
                                $.each(brandData, function(i, item) {
                                    var selected = (item.brand_id == brandId) ?
                                        'selected' : '';
                                    $brand.append('<option value="' + item
                                        .brand_id + '" ' + selected + '>' + item
                                        .brand_name + '</option>');
                                });

                                // Load models based on the pre-selected brand
                                if (brandId) {
                                    $.get('/getModels/' + brandId, function(modelData) {
                                        $model.empty().append(
                                            '<option disabled value="">เลือกโมเดล...</option>'
                                        );
                                        $.each(modelData, function(i, item) {
                                            var selected = (item.model_id ==
                                                    modelId) ? 'selected' :
                                                '';
                                            $model.append(
                                                '<option value="' + item
                                                .model_id + '" ' +
                                                selected + '>' + item
                                                .model_name +
                                                '</option>');
                                        });
                                    });
                                }
                            });
                        }
                    });
                }
            });
            $(document).on('submit', 'form[id^="frm-add-pm-new"]', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('frmAddPmNew') }}",
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
                        handleAjaxError(xhr);
                    }
                });
            });
        });
    </script>
    <div class="card info-card sales-card p-4">
        <div class="col-sm-12">
            <div class="pagetitle">
                <h6>อุปกรณ์ทั้งหมด</h6>
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
                        <th scope="col">โซน</th>
                        <th scope="col">PM</th>
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
                            <td>{{ $equ->hw_sn }}</td>
                            <td class="text-center">{{ $equ->brand_name }}</td>
                            <td class="text-center">{{ $equ->model_name }}</td>
                            <td>{{ $equ->hw_name }}</td>
                            <td class="text-center">{{ $equ->zone_name }}</td>
                            <td class="text-center">
                                <a type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#addPmNew{{ $i }}">
                                    <i class="bi bi-plus-lg"></i>
                                </a>

                                <div class="modal fade" id="addPmNew{{ $i }}" data-bs-backdrop="static"
                                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form id="frm-add-pm-new{{ $i }}">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5">สร้างรอบการเข้าซ่อมบำรุง</h1>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><b>ท่านสามารถสร้างรอบการเข้าซ่อมบำรุ่งใหม่ได้</b></p>
                                                    <p><b>ในกรณีที่ลบแผนการซ่อมบำรุงเดิมออก</b></p>
                                                    <h4>ยืนยันการสร้างแผนหรือไม่ ?</h4>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="hidden" name="hw_id" value="{{ $equ->hw_id }}">
                                                    <input type="hidden" name="groups_id"
                                                        value="{{ $equ->groups_id }}">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">ยกเลิก</button>
                                                    <button type="submit" class="btn btn-primary">ยืนยัน</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editHw{{ $i }}"><i class="bi bi-pencil"></i></button>
                            </td>
                            {{-- Modal Edit Hardware --}}
                            <div class="modal fade" id="editHw{{ $i }}" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <form id="frm-edit-hw{{ $i }}">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5">แก้ไขอุปกรณ์</h1>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="hw_id" value="{{ $equ->hw_id }}">
                                                {{-- hidden fields for initial values --}}
                                                <input type="hidden" name="groups_id" value="{{ $equ->groups_id }}">
                                                <input type="hidden" name="type_id" value="{{ $equ->type_id }}">
                                                <input type="hidden" name="brand_id" value="{{ $equ->brand_id }}">
                                                <input type="hidden" name="model_id" value="{{ $equ->model_id }}">
                                                <div class="row g-3">
                                                    {{-- กลุ่มอุปกรณ์ (disabled) --}}
                                                    <div class="col-md-6">
                                                        <label class="form-label">กลุ่มอุปกรณ์</label>
                                                        <select class="form-select groups-select" disabled>
                                                            @foreach ($groups as $g)
                                                                <option value="{{ $g->groups_id }}"
                                                                    @if ($g->groups_id == $equ->groups_id) selected @endif>
                                                                    {{ $g->groups_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    {{-- ประเภทอุปกรณ์ --}}
                                                    <div class="col-md-6">
                                                        <label class="form-label">ประเภทอุปกรณ์</label>
                                                        <select class="form-select type-select" name="type_id" required>
                                                            <option disabled selected value="">เลือกประเภทอุปกรณ์...
                                                            </option>
                                                        </select>
                                                    </div>

                                                    {{-- แบรนด์ --}}
                                                    <div class="col-md-6">
                                                        <label class="form-label">แบรนด์</label>
                                                        <select class="form-select brand-select" name="brand_id" required>
                                                            <option disabled selected value="">เลือกแบรนด์...
                                                            </option>
                                                        </select>
                                                    </div>

                                                    {{-- โมเดล --}}
                                                    <div class="col-md-6">
                                                        <label class="form-label">โมเดล</label>
                                                        <select class="form-select model-select" name="model_id" required>
                                                            <option disabled selected value="">เลือกโมเดล...</option>
                                                        </select>
                                                    </div>

                                                    {{-- ชื่ออุปกรณ์ --}}
                                                    <div class="col-12">
                                                        <label class="form-label">ชื่ออุปกรณ์</label>
                                                        <input type="text" class="form-control" name="hw_name"
                                                            value="{{ $equ->hw_name }}" required>
                                                    </div>

                                                    {{-- SN --}}
                                                    <div class="col-md-6">
                                                        <label class="form-label">SN</label>
                                                        <input type="text" class="form-control" name="hw_sn"
                                                            value="{{ $equ->hw_sn }}" required>
                                                    </div>

                                                    {{-- โซน --}}
                                                    <div class="col-md-6">
                                                        <label class="form-label">โซน</label>
                                                        <select class="form-select" name="zone_id" required>
                                                            <option disabled value="">เลือกโซน...</option>
                                                            @foreach ($zone as $z)
                                                                <option value="{{ $z->zone_id }}"
                                                                    @if ($z->zone_id == $equ->zone_id) selected @endif>
                                                                    {{ $z->zone_name }}
                                                                </option>
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
                            <td class="text-center">
                                <button type="button" class="btn btn-danger btn-sm delete-group-btn"
                                    data-id="{{ $equ->hw_id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
