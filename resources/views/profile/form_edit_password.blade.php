@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            {{--  ข้อมความแจ้งเตือนว่า อัพเดทข้อมูลส่วนตัวไม่สำเร็จ  --}}
            @if($errors->any())
                <div class="alert alert-danger PromptRegular16" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card">
                <div class="card-header PromptRegular20"><i class="fas fa-edit"></i> {{ __('แก้ไขรหัสผ่าน') }}</div>
                {{-- @foreach($users as $user) --}}
                    <div class="card-body">
                        <form method="POST" action="{{-- route('owner.profile_update_password',$user->id) --}}">
                            @csrf

                            <div class="form-group row">
                                <label for="password_raw" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('รหัสผ่านปัจจุบัน :') }} <span style="color:red;">*</span></label>
    
                                <div class="col-md-6">
                                    <input id="password_raw" type="password" class="form-control{{ $errors->has('password_raw') ? ' is-invalid' : '' }}" name="password_raw" required autofocus>
    
                                    @if ($errors->has('password_raw'))
                                        <span class="invalid-feedback PromptRegular16">
                                            {{ $errors->first('password_raw') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('รหัสผ่านใหม่ :') }} <span style="color:red;">*</span></label>
    
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                                    <span class="text-muted PromptRegular16">ระบุรหัสผ่านด้วยตัวเลขและตัวอักษรเช่น "Pw1234"</span>
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback PromptRegular16">
                                            {{ $errors->first('password') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('ยืนยันรหัสผ่านใหม่ :') }} <span style="color:red;">*</span></label>
    
                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary PromptRegular16">
                                        <i class="far fa-save"></i> {{ __('บันทึกข้อมูล') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                {{-- @endforeach --}}
            </div>
        </div>
    </div>
</div>
@endsection
