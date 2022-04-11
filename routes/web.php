<?php

use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\auth\AuthenticationController;
use App\Http\Controllers\auth\ForgotPasswordController;
use App\Http\Controllers\EmployeesController; 
use App\Http\Controllers\DepartmentsController; 
use App\Http\Controllers\SubDepartmentsController; 
use App\Http\Controllers\PositionsController; 
use App\Http\Controllers\BranchesController; 
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PermissionsController; 
use App\Http\Controllers\RolessystemsCortroller; 
use App\Http\Controllers\NotificationCortroller;  
use App\Http\Controllers\assessment\FormCortroller; 
use App\Http\Controllers\assessment\ManageassessedCortroller; 

Auth::routes();
Route::middleware(['isusers'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');  
    Route::post('ajax-sub-departmentss', [DashboardController::class, 'ajax_sub_departments'])->name('ajax.sub_departments');  
    Route::post('ajax-positions', [DashboardController::class, 'ajax_positions'])->name('ajax.positions');  
    Route::post('ajax-notifyview', [NotificationCortroller::class, 'ajaxNotifyview'])->name('ajax.notifyview');   
    
    //Profile//
    Route::get('profile', [ProfileController::class, 'profile'])->name('profile'); 
    Route::post('save-profile', [ProfileController::class, 'saveprofile'])->name('save.profile');  

    //Permissions//
    Route::get('request-access', [PermissionsController::class, 'requestAccess'])->name('request.access')->middleware('ispermissions');  
    Route::get('datatable-request-access', [PermissionsController::class, 'datatableRequestAccess'])->name('datatable.request.access');
    Route::get('permissions-add', [PermissionsController::class, 'permissionsadd'])->name('permissions.add')->middleware('ispermissions');  
    Route::get('/permissions-edit/{id}', [PermissionsController::class, 'permissionsedit'])->name('permissions.edit')->middleware('ispermissions');  
    Route::post('save-permissions', [PermissionsController::class, 'savePermissions'])->name('save.permissions');    
    Route::post('close-permissions', [PermissionsController::class, 'closePermissions'])->name('close.permissions');
    //Roles//
    Route::get('roles-list', [PermissionsController::class, 'roleslist'])->name('roles.list')->middleware('ispermissions'); 
    Route::get('roles-add', [PermissionsController::class, 'rolesadd'])->name('roles.add')->middleware('ispermissions'); 
    Route::get('/roles-edit/{id}', [PermissionsController::class, 'rolesedit'])->name('roles.edit')->middleware('ispermissions'); 
    Route::get('datatable-permissions', [PermissionsController::class, 'datatablePermissions'])->name('datatable.permissions');
    Route::get('datatable-roles', [PermissionsController::class, 'datatableRoles'])->name('datatable.roles');
    Route::post('save-roles', [PermissionsController::class, 'saveRoles'])->name('save.roles');    
    Route::post('close-roles', [PermissionsController::class, 'closeRoles'])->name('close.roles'); 
    //Roles Systems// 
    Route::get('rolessystems-list', [RolessystemsCortroller::class, 'rolessystemslist'])->name('rolessystems.list')->middleware('ispermissions');
    Route::get('rolessystems-add', [RolessystemsCortroller::class, 'rolessystemsadd'])->name('rolessystems.add')->middleware('ispermissions');
    Route::get('/rolessystems-edit/{id}', [RolessystemsCortroller::class, 'rolessystemsedit'])->name('rolessystems.edit')->middleware('ispermissions'); 
    Route::get('datatable-rolessystems', [RolessystemsCortroller::class, 'datatableRolessystems'])->name('datatable.rolessystems');
    Route::post('close-rolessystems', [RolessystemsCortroller::class, 'closeRolessystems'])->name('close.rolessystems');  
    Route::post('save-rolessystems', [RolessystemsCortroller::class, 'saveRolessystems'])->name('save.rolessystems');  

    //Employees//
    Route::get('employees-list', [EmployeesController::class, 'employeeslist'])->name('employees.list')->middleware('ispermissions'); 
    Route::get('employees-add', [EmployeesController::class, 'employeesadd'])->name('employees.add')->middleware('ispermissions');
    Route::get('employees-export', [EmployeesController::class, 'employeesexport'])->name('employees.export')->middleware('ispermissions');
    Route::get('/employees-edit/{id}', [EmployeesController::class, 'employeesedit'])->name('employees.edit')->middleware('ispermissions'); 
    Route::get('datatable-employees', [EmployeesController::class, 'datatableEmployees'])->name('datatable.employees'); 
    Route::post('save-employees', [EmployeesController::class, 'saveEmployees'])->name('save.employees');    
    Route::post('close-employees', [EmployeesController::class, 'closeEmployees'])->name('close.employees'); 
    Route::get('datatable-employees-social', [EmployeesController::class, 'datatableEmployeesSocial'])->name('datatable.employees.social');
    Route::post('close-employees-social', [EmployeesController::class, 'closeEmployeesSocial'])->name('close.employees.social');   
    
    //Departments//
    Route::get('departments-list', [DepartmentsController::class, 'departmentslist'])->name('departments.list')->middleware('ispermissions');  
    Route::get('departments-add', [DepartmentsController::class, 'departmentsadd'])->name('departments.add')->middleware('ispermissions'); 
    Route::get('/departments-edit/{id}', [DepartmentsController::class, 'departmentsedit'])->name('departments.edit')->middleware('ispermissions');  
    Route::get('datatable-departments', [DepartmentsController::class, 'datatableDepartments'])->name('datatable.departments');
    Route::post('close-departments', [DepartmentsController::class, 'closeDepartments'])->name('close.departments');  
    Route::post('save-departments', [DepartmentsController::class, 'saveDepartments'])->name('save.departments');  

    //Sub-Departments//
    Route::get('subdepartments-list', [SubDepartmentsController::class, 'subDepartmentslist'])->name('sub.departments.list')->middleware('ispermissions');  
    Route::get('subdepartments-add', [SubDepartmentsController::class, 'subDepartmentsadd'])->name('sub.departments.add')->middleware('ispermissions'); 
    Route::get('/subdepartments-edit/{id}', [SubDepartmentsController::class, 'subDepartmentsedit'])->name('sub.departments.edit')->middleware('ispermissions');  
    Route::get('datatable-sub-departments', [SubDepartmentsController::class, 'datatablesubDepartments'])->name('datatable.sub.departments');
    Route::post('close-sub-departments', [SubDepartmentsController::class, 'closesubDepartments'])->name('close.sub.departments');  
    Route::post('save-sub-departments', [SubDepartmentsController::class, 'savesubDepartments'])->name('save.sub.departments');  

    //Positions//
    Route::get('positions-list', [PositionsController::class, 'positionslist'])->name('positions.list')->middleware('ispermissions'); 
    Route::get('positions-add', [PositionsController::class, 'positionsadd'])->name('positions.add')->middleware('ispermissions');
    Route::get('/positions-edit/{id}', [PositionsController::class, 'positionsedit'])->name('positions.edit')->middleware('ispermissions'); 
    Route::get('datatable-positions', [PositionsController::class, 'datatablePositions'])->name('datatable.positions');
    Route::post('close-positions', [PositionsController::class, 'closePositions'])->name('close.positions');  
    Route::post('save-positions', [PositionsController::class, 'savePositions'])->name('save.positions');  

    //Branches//
    Route::get('branches-list', [BranchesController::class, 'brancheslist'])->name('branches.list')->middleware('ispermissions');
    Route::get('branches-add', [BranchesController::class, 'branchesadd'])->name('branches.add')->middleware('ispermissions');
    Route::get('/branches-edit/{id}', [BranchesController::class, 'branchesedit'])->name('branches.edit')->middleware('ispermissions'); 
    Route::get('datatable-branches', [BranchesController::class, 'datatableBranches'])->name('datatable.branches');
    Route::post('close-branches', [BranchesController::class, 'closeBranches'])->name('close.branches');  
    Route::post('save-branches', [BranchesController::class, 'saveBranches'])->name('save.branches');  

    // Assessment Form // 
    Route::get('assessmentform-list', [FormCortroller::class, 'assessmentformlist'])->name('assessmentform.list')->middleware('ispermissions');
    Route::get('assessmentform-add', [FormCortroller::class, 'assessmentformadd'])->name('assessmentform.add')->middleware('ispermissions');
    Route::get('/assessmentform-edit/{id}', [FormCortroller::class, 'assessmentformedit'])->name('assessmentform.edit')->middleware('ispermissions');
    Route::get('datatable-assessmentform', [FormCortroller::class, 'datatableAssessmentform'])->name('datatable.assessmentform');
    Route::get('datatable-assessmentform-detail', [FormCortroller::class, 'datatableAssessmentformDetail'])->name('datatable.assessmentform.detail');
    Route::post('close-assessmentform', [FormCortroller::class, 'closeAssessmentform'])->name('close.assessmentform'); 
    Route::post('close-assessmentform-detail', [FormCortroller::class, 'closeAssessmentformDetail'])->name('close.assessmentform.detail'); 
    Route::post('save-assessmentform', [FormCortroller::class, 'saveAssessmentform'])->name('save.assessmentform'); 

    // Assessment // 
    Route::get('assessment-list', [ManageassessedCortroller::class, 'assessmentlist'])->name('assessment.list'); 
    Route::get('assessment-add', [ManageassessedCortroller::class, 'assessmentadd'])->name('assessment.add'); 
    Route::get('/assessment-edit/{id}', [ManageassessedCortroller::class, 'assessmentedit'])->name('assessment.edit'); 
    Route::get('datatable-assessmentgroup-edit', [ManageassessedCortroller::class, 'datatableAssessmentgroupEdit'])->name('datatable.assessmentGroup.edit');
    Route::get('datatable-assessmentemp-edit', [ManageassessedCortroller::class, 'datatableAssessmentempEdit'])->name('datatable.assessmentEmp.edit');
    Route::post('close-assessment', [ManageassessedCortroller::class, 'closeAsssessment'])->name('close.assessment'); 
    Route::post('close-assessmentgroup', [ManageassessedCortroller::class, 'closeAsssessmentgroup'])->name('close.assessmentgroup'); 
    Route::post('close-assessmentemp', [ManageassessedCortroller::class, 'closeAsssessmentemp'])->name('close.assessmentemp'); 
    
    Route::get('/assessment-group-view/{id}', [ManageassessedCortroller::class, 'assessmentgroupview'])->name('assessment.group.view');
    Route::get('/assessment-emp-view/{id1}/{id2}', [ManageassessedCortroller::class, 'assessmentempview'])->name('assessment.emp.view'); 
    Route::post('save-assessment-tems', [ManageassessedCortroller::class, 'saveAssessmentTems'])->name('save.assessment.tems'); 
    Route::post('save-assessmentgroup-tems', [ManageassessedCortroller::class, 'saveAssessmentGroupTems'])->name('save.assessment.group.tems'); 
    Route::post('save-assessment', [ManageassessedCortroller::class, 'saveAssessment'])->name('save.assessment');
    Route::post('ajax-assessment_groups', [ManageassessedCortroller::class, 'ajaxassessmentGroups'])->name('ajax.assessment_groups');
    Route::get('datatable-assessment', [ManageassessedCortroller::class, 'datatableAssessment'])->name('datatable.assessment');
    Route::get('datatable-assessment-group', [ManageassessedCortroller::class, 'datatableAssessmentgroup'])->name('datatable.assessment.group');
    Route::get('datatable-assessment-emp', [ManageassessedCortroller::class, 'datatableAssessmentemp'])->name('datatable.assessment.emp');
    Route::post('ajax-assessmentForms', [ManageassessedCortroller::class, 'ajaxAssessmentForms'])->name('ajax.assessmentForms'); 

    Route::post('changestatus-assessment', [ManageassessedCortroller::class, 'changestatusAssessment'])->name('changestatus.assessment'); 
    Route::post('email-assessment', [ManageassessedCortroller::class, 'emailAssessment'])->name('email.assessment'); 
});

// Login & Register //
Route::get('/', [AuthenticationController::class, 'index'])->name('login');
Route::get('/register', [AuthenticationController::class, 'register'])->name('register');
Route::post('registration', [AuthenticationController::class, 'registration'])->name('registration'); 
Route::post('login-check', [AuthenticationController::class, 'logincheck'])->name('login-check'); 
Route::post('signOut', [AuthenticationController::class, 'signOut'])->name('signOut');

// Forget //
Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
// Route::get('/email_temp', [ForgotPasswordController::class, 'email_temp'])->name('email_temp');
 