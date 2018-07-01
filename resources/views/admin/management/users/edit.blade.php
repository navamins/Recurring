@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header PromptRegular20"><i class="fas fa-edit"></i> {{ __('แก้ไขข้อมูลผู้ใช้งานระบบ') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{-- route('user.update') --}}"> 
                            @csrf
                            <input type="hidden" name="check_unique[id]" value="{{ $user->id }}">
                            <div class="form-group row">
                                <label for="emp_code" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('รหัสพนักงาน :') }} <span style="color:red;">*</span></label>

                                <div class="col-md-6">
                                    <input id="emp_code" type="text" class="form-control{{ $errors->has('emp_code') ? ' is-invalid' : '' }}" name="emp_code" minlength="7" maxlength="7" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" value="{{ $user->emp_code }}" autofocus>

                                    @if ($errors->has('emp_code'))
                                        <span class="invalid-feedback PromptRegular16">
                                            {{ $errors->first('emp_code') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('ชื่อ (ระบุเป็นภาษาไทยเท่านั้น ) :') }} <span style="color:red;">*</span></label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" pattern="^[ก-๙]+$" value="{{ $user->name }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback PromptRegular16">
                                            {{ $errors->first('name') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="lastname" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('นามสกุล (ระบุเป็นภาษาไทยเท่านั้น ) :') }} <span style="color:red;">*</span></label>

                                <div class="col-md-6">
                                    <input id="lastname" type="text" class="form-control{{ $errors->has('lastname') ? ' is-invalid' : '' }}" name="lastname" pattern="^[ก-๙]+$" value="{{ $user->lastname }}" required autofocus>

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
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" value="{{ $user->email }}" required>

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
                                        <option value="user" {{ $user->role == 'user' ? "selected" : "" }}>User</option>
                                        <option value="admin" {{ $user->role == 'admin' ? "selected" : "" }}>Administrator</option>
                                    </select>
                                    @if ($errors->has('role'))
                                        <span class="invalid-feedback PromptRegular16">
                                            {{ $errors->first('role') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="useflag" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('สถานะความพร้อมใช้งาน :') }} <span style="color:red;">*</span></label>
    
                                <div class="col-md-6">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="useflag_y" name="useflag" class="custom-control-input" value="Y" {{ $user->useflag == 'Y' ? "checked" : "" }}>
                                        <label class="custom-control-label" for="useflag_y">Activated</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="useflag_n" name="useflag" class="custom-control-input" value="N" {{ $user->useflag == 'N' ? "checked" : "" }}>
                                        <label class="custom-control-label" for="useflag_n">Not Activated</label>
                                    </div>

                                    @if ($errors->has('useflag'))
                                        <span class="invalid-feedback PromptRegular16">
                                            {{ $errors->first('useflag') }}
                                        </span>
                                    @endif
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
