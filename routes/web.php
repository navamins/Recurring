<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => ['web','auth']], function(){
    Route::get('/home', 'HomeController@index')->name('home');
    // ข้อมูลส่วนตัว
    Route::get('/home/profile', 'UserController@owner_profile')->name('owner.profile'); // ข้อมูลส่วนตัว
    Route::get('/home/profile/edit', 'UserController@profile_edit')->name('owner.profile_edit'); // แก้ไขข้อมูลส่วนตัว
    Route::post('/home/profile/edit', 'UserController@profile_update')->name('owner.profile_update'); // อัพเดทข้อมูลส่วนตัว
    Route::get('/home/profile/edit/password', 'UserController@profile_edit_pw')->name('owner.profile_edit_pw'); // แก้ไขข้อมูลรหัสผ่านส่วนตัว
    Route::post('/home/profile/edit/password', 'UserController@profile_update_pw')->name('owner.profile_update_pw'); // อัพเดทข้อมูลส่วนตัว

    // การจัดการข้อมูล --> ข้อมูลผู้ใช้งานระบบ
    Route::get('/user/index', 'ManageUserController@index')->name('user.index'); // หน้าแรกข้อมูลผู้ใช้งานระบบ
    Route::get('/user/create', 'ManageUserController@create')->name('user.create'); // ฟอร์มสร้างบัญชีผู้ใช้งานระบบ
    Route::post('/user/create', 'ManageUserController@store')->name('user.store'); // สร้างบัญชีผู้ใช้งานระบบ
    Route::get('/user/show/{id}', 'ManageUserController@show')->name('user.show'); // รายละเอียดบัญชีผู้ใช้งานระบบ
    Route::get('/user/edit/{id}', 'ManageUserController@edit')->name('user.edit'); // ฟอร์มแก้ไขข้อมูลบัญชีผู้ใช้งานระบบ
    Route::post('/user/edit/{id}', 'ManageUserController@update')->name('user.update'); // อัพเดทข้อมูลบัญชีผู้ใช้งานระบบ
    Route::get('/user/edit/password/{id}', 'ManageUserController@edit_password')->name('user.edit_password'); // ฟอร์มแก้ไขข้อมูลรหัสผ่านบัญชีผู้ใช้งานระบบ
    Route::post('/user/edit/password/{id}', 'ManageUserController@update_password')->name('user.update_password'); // อัพเดทข้อมูลรหัสผ่านบัญชีผู้ใช้งานระบบ

    Route::get('/agency/index', 'ManageAgencyController@index')->name('agency.index'); // หน้าแรกข้อมูลหน่วยงานพันธมิตร
    Route::get('/agency/create', 'ManageAgencyController@create')->name('agency.create'); // ฟอร์มสร้างข้อมูลหน่วยงานพันธมิตร
    Route::post('/agency/create', 'ManageAgencyController@store')->name('agency.store'); // สร้างข้อมูลหน่วยงานพันธมิตร
    Route::get('/agency/show/{id}', 'ManageAgencyController@show')->name('agency.show'); // รายละเอียดข้อมูลหน่วยงานพันธมิตร
    Route::get('/agency/edit/{id}', 'ManageAgencyController@edit')->name('agency.edit'); // ฟอร์มแก้ไขข้อมูลหน่วยงานพันธมิตร
    Route::post('/agency/edit/{id}', 'ManageAgencyController@update')->name('agency.update'); // อัพเดทข้อมูลหน่วยงานพันธมิตร

    Route::get('/bank/index', 'ManageGsbController@index')->name('bank.index'); // หน้าแรกข้อมูลธนาคารออมสิน
    Route::get('/bank/create', 'ManageGsbController@create')->name('bank.create'); // ฟอร์มสร้างข้อมูลธนาคารออมสิน
    Route::post('/bank/create', 'ManageGsbController@store')->name('bank.store'); // สร้างข้อมูลธนาคารออมสิน
    Route::get('/bank/show/{id}', 'ManageGsbController@show')->name('bank.show'); // รายละเอียดข้อมูลธนาคารออมสิน
    Route::get('/bank/edit/{id}', 'ManageGsbController@edit')->name('bank.edit'); // ฟอร์มแก้ไขข้อมูลธนาคารออมสิน
    Route::post('/bank/edit/{id}', 'ManageGsbController@update')->name('bank.update'); // อัพเดทข้อมูลธนาคารออมสิน

    Route::get('/edc/index', 'ManageEdcController@index')->name('edc.index'); // หน้าแรกข้อมูลเครื่อง EDC
    Route::get('/edc/create', 'ManageEdcController@create')->name('edc.create'); // ฟอร์มสร้างข้อมูลเครื่อง EDC
    Route::post('/edc/create', 'ManageEdcController@store')->name('edc.store'); // สร้างข้อมูลเครื่อง EDC
    Route::get('/edc/show/{id}', 'ManageEdcController@show')->name('edc.show'); // รายละเอียดข้อมูลเครื่อง EDC
    Route::get('/edc/edit/{id}', 'ManageEdcController@edit')->name('edc.edit'); // ฟอร์มแก้ไขข้อมูลเครื่อง EDC
    Route::post('/edc/edit/{id}', 'ManageEdcController@update')->name('edc.update'); // อัพเดทข้อมูลเครื่อง EDC

    Route::get('/card/index', 'ManageNumberTypeController@index')->name('cardtype.index'); // หน้าแรกข้อมูลบัตรเครดิต
    Route::get('/card/create', 'ManageNumberTypeController@create')->name('cardtype.create'); // ฟอร์มสร้างข้อมูลบัตรเครดิต
    Route::post('/card/create', 'ManageNumberTypeController@store')->name('cardtype.store'); // สร้างข้อมูลบัตรเครดิต
    Route::get('/card/show/{id}', 'ManageNumberTypeController@show')->name('cardtype.show'); // รายละเอียดข้อมูลบัตรเครดิต
    Route::get('/card/edit/{id}', 'ManageNumberTypeController@edit')->name('cardtype.edit'); // ฟอร์มแก้ไขข้อมูลบัตรเครดิต
    Route::patch('/card/edit/{id}', 'ManageNumberTypeController@update')->name('cardtype.update'); // อัพเดทข้อมูลบัตรเครดิต

    Route::get('/register/index', 'RegisterController@index')->name('register.index'); // ฟอร์มตรวจสอบหมายเลขบัตรประชาชน 13 หลัก
    Route::get('/register/verify', 'RegisterController@verify_id_card')->name('register.verify_id_card'); // ตรวจสอบหมายเลขบัตรประชาชน 13 หลัก
    Route::get('/register/verify/ajax-amphures/{id}', 'RegisterController@ajax_amphures')->name('register.ajax_amphures'); // ajaxcall อำเภอ/เขต
    Route::get('/register/verify/ajax-districts/{id}', 'RegisterController@ajax_districts')->name('register.ajax_districts'); // ajaxcall ตำบล/แขวง
    Route::get('/register/verify/ajax-zipcode/{id}', 'RegisterController@ajax_zipcode')->name('register.ajax_zipcode'); // ajaxcall รหัสไปรษณีย์
    Route::post('/register/verify', 'RegisterController@store')->name('register.store'); // สร้างข้อมูลผู้ลงทะเบียนชำระค่าสาธารณูปโภค 
    
    Route::get('/customer/index/{sort}', 'ManageCustomerController@index')->name('customer.index'); // หน้าแรกข้อมูลลูกค้าที่ทำรายการชำระค่าสาธารณูปโภค
    Route::post('/customer/index/{sort}', 'ManageCustomerController@update_status')->name('customer.update_status'); // ปรับสถานะระบบของข้อมูลลูกค้าที่ทำรายการชำระค่าสาธารณูปโภค
    Route::get('/customer/show/{id}/{agency}', 'ManageCustomerController@show')->name('customer.show'); // รายละเอียดข้อมูลลูกค้าที่ทำรายการชำระค่าสาธารณูปโภคเฉพาะ agency นั้นๆ
    Route::get('/customer/edit/{id}', 'ManageCustomerController@form_edit_customer')->name('customer.form_edit_customer'); // ฟอร์มแก้ไขข้อมูลผู้ลงทะเบียนชำระค่าสาธารณูปโภค
    Route::get('/customer/cardlink/import/status', 'ManageCustomerController@form_import_cardlink')->name('customer.form_import_cardlink'); // ฟอร์มอัพเดทข้อมูลผู้ลงทะเบียนชำระค่าสาธารณูปโภคจากระบบ Cardlink แบบ Manual
    Route::post('/customer/cardlink/import/status', 'ManageCustomerController@store_import_cardlink')->name('customer.store_import_cardlink'); // อัพเดทข้อมูลผู้ลงทะเบียนชำระค่าสาธารณูปโภคจากระบบ Cardlink แบบ Manual

    Route::get('/customer/search', 'ManageCustomerController@search')->name('customer.search'); // หน้าแรกฟอร์มค้นหาข้อมูลลูกค้าที่ทำรายการชำระค่าสาธารณูปโภค
    Route::post('/customer/search', 'ManageCustomerController@list')->name('customer.list'); // แสดงผลลัพธ์การค้นหาข้อมูลลูกค้าที่ทำรายการชำระค่าสาธารณูปโภค
    Route::get('/customer/search/show/{id}', 'ManageCustomerController@search_show')->name('customer.search_show'); // รายละเอียดข้อมูลลูกค้าที่ทำรายการชำระค่าสาธารณูปโภคทั้งหมด
    Route::patch('/customer/search/show/update/transaction/{id}', 'ManageCustomerController@update_transaction')->name('customer.update_transaction'); // อัพเดทข้อมูลบัตรเครดิต
    // Route::get('/', function () {
    //     return view('welcome');
    // });
    // Route::get('/home', function(){
    //     if(Auth::user()->role =="admin"){
    //         return view('adminhome');
    //     }else{
    //         $users['users']= \App\User::all();
    //         return view('home', $users);
    //     }
    // });
});
