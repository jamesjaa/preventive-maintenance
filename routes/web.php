<?php

use App\Http\Controllers\ActualPmController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\GroupsController;
use App\Http\Controllers\ModelController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\MaintenanceScheduleController;
use App\Http\Controllers\MaintenanceStaffController;
use App\Http\Controllers\PmRecordController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ZoneController;
use Illuminate\Support\Facades\DB;
// Route::get('/', function () {
// echo $test = DB::connection('mysql')->table('users')->get();
// return view('welcome');
// });

Route::get('/', [LoginController::class, 'login']);
Route::post('frm-login', [LoginController::class, 'frmLogin'])->name('frmLogin');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('index', [IndexController::class, 'index'])->name('index');

Route::get('groups', [GroupsController::class, 'groups'])->name('groups');
Route::post('frmAddGroups', [GroupsController::class, 'frmAddGroups'])->name('frmAddGroups');
Route::post('frmEditGroups', [GroupsController::class, 'frmEditGroups'])->name('frmEditGroups');
Route::post('frmDeleteGroups', [GroupsController::class, 'frmDeleteGroups'])->name('frmDeleteGroups');


Route::get('type/{groupsId}', [TypeController::class, 'type'])->name('type');
Route::post('frmAddType', [TypeController::class, 'frmAddType'])->name('frmAddType');
Route::post('frmEditType', [TypeController::class, 'frmEditType'])->name('frmEditType');
Route::post('frmDeleteType', [TypeController::class, 'frmDeleteType'])->name('frmDeleteType');

Route::get('brand/{groupsId}/{typeId}', [BrandController::class, 'brand'])->name('brand');
Route::post('frmAddBrand', [BrandController::class, 'frmAddBrand'])->name('frmAddBrand');
Route::post('frmEditBrand', [BrandController::class, 'frmEditBrand'])->name('frmEditBrand');
Route::post('frmDeleteBrand', [BrandController::class, 'frmDeleteBrand'])->name('frmDeleteBrand');


Route::get('model/{groupsId}/{typeId}/{brandId}', [ModelController::class, 'model'])->name('model');
Route::post('frmAddModel', [ModelController::class, 'frmAddModel'])->name('frmAddModel');
Route::post('frmEditModel', [ModelController::class, 'frmEditModel'])->name('frmEditModel');
Route::post('frmDeleteModel', [ModelController::class, 'frmDeleteModel'])->name('frmDeleteModel');

Route::get('zone', [ZoneController::class, 'zone'])->name('zone');
Route::post('frmAddZone', [ZoneController::class, 'frmAddZone'])->name('frmAddZone');
Route::post('frmEditZone', [ZoneController::class, 'frmEditZone'])->name('frmEditZone');
Route::post('frmDeleteZone', [ZoneController::class, 'frmDeleteZone'])->name('frmDeleteZone');

Route::get('maintenance_staff', [MaintenanceStaffController::class, 'maintenance_staff'])->name('maintenance_staff');
Route::post('frmAddMaintenanceStaff', [MaintenanceStaffController::class, 'frmAddMaintenanceStaff'])->name('frmAddMaintenanceStaff');
Route::post('frmEditMaintenanceStaff', [MaintenanceStaffController::class, 'frmEditMaintenanceStaff'])->name('frmEditMaintenanceStaff');
Route::post('frmDeleteMaintenanceStaff', [MaintenanceStaffController::class, 'frmDeleteMaintenanceStaff'])->name('frmDeleteMaintenanceStaff');


Route::get('/equipment', [EquipmentController::class, 'equipment'])->name('equipment');
Route::get('/getTypes/{groupId}', [EquipmentController::class, 'getTypes']);
Route::get('/getBrands/{typeId}', [EquipmentController::class, 'getBrands']);
Route::get('/getModels/{brandId}', [EquipmentController::class, 'getModels']);
Route::post('frmAddEquipment', [EquipmentController::class, 'frmAddEquipment'])->name('frmAddEquipment');
Route::post('frmEditEquipment', [EquipmentController::class, 'frmEditEquipment'])->name('frmEditEquipment');
Route::post('frmDeleteHW', [EquipmentController::class, 'frmDeleteHW'])->name('frmDeleteHW');
Route::post('frmAddPmNew', [EquipmentController::class, 'frmAddPmNew'])->name('frmAddPmNew');

Route::get('maintenanc_schedule', [MaintenanceScheduleController::class, 'MaintenanceSchedule'])->name('MaintenanceSchedule');
Route::post('frmEditDate', [MaintenanceScheduleController::class, 'frmEditDate'])->name('frmEditDate');
Route::post('frmDeletePM', [MaintenanceScheduleController::class, 'frmDeletePM'])->name('frmDeletePM');

Route::get('actual_pm', [ActualPmController::class, 'ActualPm'])->name('ActualPm');
Route::post('frmAddPM', [ActualPmController::class, 'frmAddPM'])->name('frmAddPM');

Route::get('report', [ReportController::class, 'report'])->name('report');
Route::get('/report/export/excel', [ReportController::class, 'exportExcel'])->name('report.export.excel');
Route::get('/report/export/pdf', [ReportController::class, 'exportPdf'])->name('report.export.pdf');
