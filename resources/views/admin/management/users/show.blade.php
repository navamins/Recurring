@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            {{--  ข้อมความแจ้งเตือนว่า อัพเดทข้อมูลสำเร็จ  --}}
            @if(\Session::has('success'))
                <div class="alert alert-success PromptRegular20" role="alert">
                    <i class="fas fa-check"></i> {{\Session::get('success')}} <i class="far fa-smile"></i>
                </div>
            @endif

             {{--  ข้อมความแจ้งเตือนว่า อัพเดทข้อมูลไม่สำเร็จ  --}}
             @if($errors->any())
                <div class="alert alert-danger PromptRegular16" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <br />
            @endif

            <div class="card">
            <div class="card-header PromptRegular20"><i class="fas fa-eye"></i> {{ __('รายละเอียดข้อมูลผู้ใช้งานระบบ') }}</div>
                @foreach($users as $user)
                <div class="card-body">
                    <div class="form-group row">
                        <label for="emp_code" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('รหัสพนักงาน :') }}</label>
                        
                        <div class="col-md-6">
                            <label for="emp_code_val" class="col-md-4 col-form-label text-md-left PromptRegular16">{{ $user->emp_code }}</span></label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('ชื่อ - นามสกุล :') }}</label>

                        <div class="col-md-6">
                            <label for="name_val" class="col-md-12 col-form-label text-md-left PromptRegular16">{{ $user->name }} {{ $user->lastname }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('อีเมล์ :') }}</label>

                        <div class="col-md-6">
                            <label for="email_val" class="col-md-12 col-form-label text-md-left PromptRegular16">{{ $user->email }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="role" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('สิทธิ์เข้าใช้งาน :') }}</label>

                        <div class="col-md-6">
                            @if($user->role == 'admin')
                                <label for="role_val" class="col-md-12 col-form-label text-md-left PromptRegular16">{{ __('Administrator') }}</label>
                            @elseif($user->role == 'user')
                                <label for="role_val" class="col-md-12 col-form-label text-md-left PromptRegular16">{{ __('User') }}</label>
                            @else
                                <label for="role_val" class="col-md-12 col-form-label text-md-left PromptRegular16">{{ __('Unknown') }}</label>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="useflag" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('สถานะความพร้อมใช้งาน :') }}</label>

                        <div class="col-md-6">
                            @if($user->useflag =='Y')
                            <label for="useflag" class="col-md-12 col-form-label text-md-left PromptRegular16">
                                <span class="badge badge-success">Activated</span>
                            </label>
                            @else
                            <label for="useflag" class="col-md-12 col-form-label text-md-left PromptRegular16">
                                <span class="badge badge-danger">Not Activated</span>
                            </label>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="create_date" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('สร้างเมื่อวันที่ :') }}</label> {{-- $user->useflag == 'N' ? "checked" : "" --}}

                        <div class="col-md-8">
                            <label for="create_date_val" class="col-md-12 col-form-label text-md-left PromptRegular16">{{ $create_date }} น. <span class="PromptMedium16">โดย</span> {{ $user->create_by_name !=null ? $user->create_by_name." ".$user->create_by_lastname : "การลงทะเบียนเข้าใช้งาน" }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="update_date" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('อัพเดทข้อมูลล่าสุด :') }}</label>

                        <div class="col-md-8">
                            <label for="update_date_val" class="col-md-12 col-form-label text-md-left PromptRegular16">{{ $update_date }} น. <span class="PromptMedium16">โดย</span> {{ $user->update_by_name }} {{ $user->update_by_lastname }}</label>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <a href="{{ route('user.edit',Crypt::encryptString($user->id)) }}"><button class="btn btn-primary PromptRegular16"><i class="fas fa-edit"></i> {{ __('แก้ไขข้อมูลผู้ใช้งานระบบ') }}</button></a>
                            <a href="{{ route('user.edit_password',Crypt::encryptString($user->id)) }}"><button class="btn btn-primary PromptRegular16"><i class="fas fa-edit"></i> {{ __('แก้ไขรหัสผ่านผู้ใช้งานระบบ') }}</button></a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
