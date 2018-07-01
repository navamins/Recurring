@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header PromptRegular20"><i class="fas fa-registered"></i> {{ __('ลงทะเบียนเข้าใช้งาน') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="emp_code" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('รหัสพนักงาน :') }} <span style="color:red;">*</span></label>

                            <div class="col-md-6">
                                <input id="emp_code" type="text" class="form-control{{ $errors->has('emp_code') ? ' is-invalid' : '' }}" name="emp_code" minlength="7" maxlength="7" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" value="{{ old('emp_code') }}" required autofocus>

                                @if ($errors->has('emp_code'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('emp_code') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('ชื่อ (ระบุเป็นภาษาไทยเท่านั้น ) :') }} <span style="color:red;">*</span></label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" pattern="^[ก-๙]+$" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lastname" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('นามสกุล (ระบุเป็นภาษาไทยเท่านั้น ) :') }} <span style="color:red;">*</span></label>

                            <div class="col-md-6">
                                <input id="lastname" type="text" class="form-control{{ $errors->has('lastname') ? ' is-invalid' : '' }}" name="lastname" pattern="^[ก-๙]+$" value="{{ old('lastname') }}" required autofocus>

                                @if ($errors->has('lastname'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('lastname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('อีเมล์ :') }} <span style="color:red;">*</span></label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('รหัสผ่าน :') }} <span style="color:red;">*</span></label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" pattern="(?=^.{6,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required>
                                <span class="text-muted PromptRegular16">ระบุรหัสผ่านด้วยตัวเลขและตัวอักษรเช่น "Pw1234"</span>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('ยืนยันรหัสผ่าน :') }} <span style="color:red;">*</span></label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary PromptRegular16">
                                    {{ __('ลงทะเบียนเข้าใช้งาน') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
