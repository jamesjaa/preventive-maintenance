@extends('layouts.index')
@section('content')
    <div class="card info-card sales-card p-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="pagetitle">
                    <h4>ประวัติการซ่อมบำรุง</h4>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">หน้าหลัก</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('equipment') }}">จัดการกลุ่มอุปกรณ์</a></li>
                            <li class="breadcrumb-item active"><u>ประวัติการซ่อมบำรุง</u></li>
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
        </div>
    </div>
    <div class="card info-card sales-card p-4">

        <div class="col-sm-12">
            <div class="pagetitle">
                <h6> อุปกรณ์ :
                    {{ $equipment->groups_name }}/ {{ $equipment->type_name }}/ {{ $equipment->brand_name }}/
                    {{ $equipment->model_name }}/ {{ $equipment->hw_sn }}/ {{ $equipment->hw_name }}
                </h6>
            </div>
        </div>

    </div>
@endsection
