@extends('layouts.index')
@section('content')
    <div class="card info-card sales-card p-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="pagetitle">
                    <h4>แบรนด์</h4>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">หน้าหลัก</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('groups') }}">จัดการกลุ่มอุปกรณ์</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('type', ['groupsId' => $groups->groups_id, 'typeId' => $type->type_id]) }}">จัดการชนิดอุปกรณ์</a>
                            </li>
                            <li class="breadcrumb-item active"><u>แบรนด์</u></li>
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
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBrand"><i
                            class="bi bi-plus-lg me-2"></i>เพิ่มแบรนด์</button>
                    <!-- Modal -->
                    <div class="modal fade" id="addBrand" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                        aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <form id="frm-add-brand">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">ชื่อแบรนด์</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">ชื่อ</span>
                                            <input type="text" class="form-control" name="brand_name"
                                                placeholder="พิมพ์ชื่อแบรนด์" aria-label="พิมพ์ชื่อแบรนด์"
                                                aria-describedby="basic-addon1" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" value="{{ $type->type_id }}" name="type_id">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                                                class="bi bi-x-square me-2"></i>ยกเลิก</button>
                                        <button type="submit" class="btn btn-success"><i
                                                class="bi bi-plus-square me-2"></i>เพิ่มข้อมูล</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <script>
                        $(document).ready(function() {
                            $("#frm-add-brand").submit(function(e) {
                                e.preventDefault();

                                var formData = $(this).serialize();

                                $.ajax({
                                    url: "{{ route('frmAddBrand') }}",
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
                </div>
            </div>
        </div>
    </div>

    <div class="card info-card sales-card p-4">

        <div class="col-sm-12">
            <div class="pagetitle">
                <h6><u>{{ $groups->groups_name }}</u> > <u>{{ $type->type_name }}</u></h6>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover" id="data-table">
                <thead>
                    <tr class="text-center">
                        <th scope="col">#</th>
                        <th scope="col">ชื่อแบรนด์</th>
                        <th scope="col">เพิ่มโมเดล</th>
                        <th scope="col">แก้ไข</th>
                        <th scope="col">ลบ</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 0;
                    @endphp
                    @foreach ($brand as $b)
                        @php
                            $i++;
                        @endphp
                        <tr>
                            <th scope="row" class="text-center">{{ $i }}</th>
                            <td class="searchable-column">{{ $b->brand_name }}</td>
                            <td class="text-center">
                                <a href="{{ route('model', ['groupsId' => $groups->groups_id, 'typeId' => $b->type_id, 'brandId' => $b->brand_id]) }}"
                                    class="btn btn-secondary btn-sm">
                                    <i class="bi bi-plus-lg"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editBrand{{ $i }}"><i class="bi bi-pencil"></i></button>
                                <!-- Modal -->
                                <div class="modal fade" id="editBrand{{ $i }}" data-bs-backdrop="static"
                                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form id="frm-edit-brand{{ $i }}">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">แก้ไข
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="basic-addon1">ชื่อ</span>
                                                        <input type="text" class="form-control" name="edit_brand_name"
                                                            value="{{ $b->brand_name }}" aria-describedby="basic-addon1">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="hidden" value="{{ $b->brand_id }}"
                                                        name="edit_brand_id">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal"><i
                                                            class="bi bi-x-square me-2"></i>ยกเลิก</button>
                                                    <button type="submit" class="btn btn-success"><i
                                                            class="bi bi-plus-square me-2"></i>แก้ไขข้อมูล</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        $("#frm-edit-brand" + <?php echo $i; ?>).submit(function(e) {
                                            e.preventDefault();

                                            var formData = $(this).serialize();

                                            $.ajax({
                                                url: "{{ route('frmEditBrand') }}",
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
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger btn-sm delete-group-btn"
                                    data-id="{{ $b->brand_id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                                <script>
                                    $(document).ready(function() {
                                        $('.delete-group-btn').on('click', function() {
                                            var brandId = $(this).data('id');

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
                                                        url: "{{ route('frmDeleteBrand') }}",
                                                        type: "POST",
                                                        data: {
                                                            _token: "{{ csrf_token() }}",
                                                            brand_id: brandId
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
