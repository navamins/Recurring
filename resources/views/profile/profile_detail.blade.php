@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            {{--  ข้อมความแจ้งเตือนว่า อัพเดทข้อมูลส่วนตัวสำเร็จ  --}}
            @if(\Session::has('success'))
                <div class="alert alert-success PromptRegular20" role="alert">
                    <i class="fas fa-check"></i> {{\Session::get('success')}} <i class="far fa-smile"></i>
                </div>
            @endif

             {{--  ข้อมความแจ้งเตือนว่า อัพเดทข้อมูลส่วนตัวไม่สำเร็จ  --}}
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
                <div class="card-header PromptRegular20"><i class="fas fa-user"></i> {{ __('ข้อมูลส่วนตัว') }}</div>

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
                            <label for="create_date" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('สร้างเมื่อวันที่ :') }}</label>

                            <div class="col-md-6">
                                <label for="create_date_val" class="col-md-12 col-form-label text-md-left PromptRegular16">{{ $create_date }} น.</label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="update_date" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('อัพเดทข้อมูลล่าสุด :') }}</label>

                            <div class="col-md-6">
                                <label for="update_date_val" class="col-md-12 col-form-label text-md-left PromptRegular16">{{ $update_date }} น.</label>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <a href="{{ route('owner.profile_edit') }}"><button class="btn btn-primary PromptRegular16"><i class="fas fa-edit"></i> {{ __('แก้ไขข้อมูลส่วนตัว') }}</button></a>
                                <a href="{{ route('owner.profile_edit_pw') }}"><button class="btn btn-primary PromptRegular16"><i class="fas fa-edit"></i> {{ __('แก้ไขรหัสผ่าน') }}</button></a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</div>
@endsection
