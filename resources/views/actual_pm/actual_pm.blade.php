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
                <h6>ตารางบันทึกผลการซ่อมบำรุง (PM)</h6>
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
                                    <form id="frm-complete-pm-{{ $mt->pm_id }}">
                                        @csrf
                                        <input type="hidden" name="pm_id" value="{{ $mt->pm_id }}">
                                        <input type="hidden" name="hw_id" value="{{ $mt->hw_id }}">
                                        <input type="hidden" name="maintenance_id" value="1"> <!-- สมมุติ 1=PM -->
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
                                                    <label class="form-label">รายละเอียด</label>
                                                    <textarea class="form-control" name="detail" rows="2"></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">ค่าใช้จ่าย (บาท)</label>
                                                    <input type="number" class="form-control" name="cost" min="0"
                                                        value="0">
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
        {{ $maintenance->links('pagination::bootstrap-5') }}
    </div>
@endsection
