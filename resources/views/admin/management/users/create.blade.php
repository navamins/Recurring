@extends('layouts.app')

{{--  CSS styles  --}}
@push('styles')
    
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="container card-header">
                    <div class="row">
                        <div class="col order-last PromptRegular16">
                            <div class="float-md-right">
                                {{-- <button type="button" class="btn btn-outline-primary"><i class="fas fa-plus-square"></i> สร้างบัญชีผู้ใช้งาน</button> --}}
                            </div>
                        </div>
                        <div class="col">
                            {{-- Second, but unordered --}}
                        </div>
                        <div class="col order-first PromptRegular20">
                            <i class="fas fa-plus-square"></i> สร้างบัญชีผู้ใช้งานระบบ 
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive-md PromptRegular16">
                    <form method="POST" action="{{ route('user.store') }}"> 
                        @csrf
                        <div class="form-group row">
                            <label for="emp_code" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('รหัสพนักงาน :') }} <span style="color:red;">*</span></label>

                            <div class="col-md-6">
                                <input id="emp_code" type="text" class="form-control{{ $errors->has('emp_code') ? ' is-invalid' : '' }}" name="emp_code" minlength="7" maxlength="7" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" value="" required autofocus>

                                @if ($errors->has('emp_code'))
                                    <span class="invalid-feedback PromptRegular16">
                                        {{ $errors->first('emp_code') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('ชื่อ (ระบุเป็นภาษาไทยเท่านั้น) :') }} <span style="color:red;">*</span></label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" pattern="^[ก-๙]+$" value="" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback PromptRegular16">
                                        {{ $errors->first('name') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lastname" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('นามสกุล (ระบุเป็นภาษาไทยเท่านั้น) :') }} <span style="color:red;">*</span></label>

                            <div class="col-md-6">
                                <input id="lastname" type="text" class="form-control{{ $errors->has('lastname') ? ' is-invalid' : '' }}" name="lastname" pattern="^[ก-๙]+$" value="" required autofocus>

                                @if ($errors->has('lastname'))
                                    <span class="invalid-feedback PromptRegular16">
                                        {{ $errors->first('lastname') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('อีเมล์ :') }} <span style="color:red;">*</span></label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" value="" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback PromptRegular16">
                                        {{ $errors->first('email') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="role" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('ระดับสิทธิ์การเข้าใช้งานระบบ :') }} <span style="color:red;">*</span></label>

                            <div class="col-md-6">
                                <select id="role" name="role" class="custom-select{{ $errors->has('role') ? ' is-invalid' : '' }}" required autofocus>
                                    <option value=null selected disabled hidden>กรุณาเลือกระดับสิทธิ์การเข้าใช้งานระบบ</option>
                                    <option value="user">User</option>
                                    <option value="admin">Administrator</option>
                                </select>
                                @if ($errors->has('role'))
                                    <span class="invalid-feedback PromptRegular16">
                                        {{ $errors->first('role') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('รหัสผ่านใหม่ :') }} <span style="color:red;">*</span></label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required autofocus>
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
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autofocus>
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
            </div>
        </div>
    </div>
</div>
@endsection

{{--  ่java scripts  --}}
@push('scripts')
    
@endpush
