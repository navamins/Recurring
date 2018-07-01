@extends('layouts.app')

{{--  CSS styles  --}}
@push('styles')
<style>
    .checkbox label:after, 
    .radio label:after {
        content: '';
        display: table;
        clear: both;
    }

    .checkbox .cr,
    .radio .cr {
        position: relative;
        display: inline-block;
        border: 1px solid #a9a9a9;
        border-radius: .25em;
        width: 1.3em;
        height: 1.3em;
        float: left;
        margin-right: .5em;
    }

    .radio .cr {
        border-radius: 50%;
    }

    .checkbox .cr .cr-icon,
    .radio .cr .cr-icon {
        position: absolute;
        font-size: .8em;
        line-height: 0;
        top: 50%;
        left: 20%;
    }

    .radio .cr .cr-icon {
        margin-left: 0.04em;
    }

    .checkbox label input[type="checkbox"],
    .radio label input[type="radio"] {
        display: none;
    }

    .checkbox label input[type="checkbox"] + .cr > .cr-icon,
    .radio label input[type="radio"] + .cr > .cr-icon {
        transform: scale(3) rotateZ(-20deg);
        opacity: 0;
        transition: all .3s ease-in;
    }

    .checkbox label input[type="checkbox"]:checked + .cr > .cr-icon,
    .radio label input[type="radio"]:checked + .cr > .cr-icon {
        transform: scale(1) rotateZ(0deg);
        opacity: 1;
    }

    .checkbox label input[type="checkbox"]:disabled + .cr,
    .radio label input[type="radio"]:disabled + .cr {
        opacity: .5;
    }
</style>
    
@endpush

@section('content')
<div class="container">
    <form method="POST" action="{{ route('register.store') }}"> 
        @csrf
        <input type="hidden" name="check_unique[id]" value="{{ $id }}">
        <div class="row justify-content-center">
            <div class="col-md-12">

            {{--  ข้อมความแจ้งเตือนว่า อัพเดทข้อมูลไม่สำเร็จ  --}}
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
                    <div class="container card-header">
                        <div class="row">
                            <div class="col order-last PromptRegular16">
                                <div class="float-md-right">
                                    {{-- <button type="button" class="btn btn-outline-primary"><i class="fas fa-plus-square"></i> สร้างบัญชีผู้ใช้งาน</button> --}}
                                </div>
                            </div>
                            {{-- <div class="col">
                                Second, but unordered
                            </div> --}}
                            <div class="col order-first PromptRegular20">
                                <i class="far fa-registered"></i> ข้อมูลผู้ลงทะเบียนชำระค่าสาธารณูปโภค
                            </div>
                        </div>
                    </div>

                    <div class="card-body table-responsive-md PromptRegular16">
                        
                        <div class="form-group row">
                            <label for="name_title_id" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('คำนำหน้าชื่อ :') }} <span style="color:red;">*</span></label>

                            <div class="col-md-6">
                                <select id="name_title_id" name="name_title_id" class="custom-select{{ $errors->has('name_title_id') ? ' is-invalid' : '' }}" autofocus>
                                    <option value=null selected disabled hidden>กรุณาเลือกคำนำหน้าชื่อ</option>
                                    @foreach($name_title as $title)
                                <option value="{{ $title->id }}" {{ old('name_title_id',$name_title_id) == $title->id ? "selected":"" }}> {{ $title->name_title }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('name_title_id'))
                                    <span class="invalid-feedback PromptRegular16">
                                        {{ $errors->first('name_title_id') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name_lastname" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('ชื่อ - นามสกุล (ระบุเป็นภาษาไทยเท่านั้น) :') }} <span style="color:red;">*</span></label>

                            <div class="col-md-3">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name',$name) }}" autofocus>
                                
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback PromptRegular16">
                                        {{ $errors->first('name') }}
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-3">
                                <input id="lastname" type="text" class="form-control{{ $errors->has('lastname') ? ' is-invalid' : '' }}" name="lastname" value="{{ old('lastname',$lastname) }}" pattern="^[ก-๙\s]+$" autofocus>
                                
                                @if ($errors->has('lastname'))
                                    <span class="invalid-feedback PromptRegular16">
                                        {{ $errors->first('lastname') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_card" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('หมายเลขบัตรประชาชน 13 หลัก :') }} <span style="color:red;">*</span></label>

                            <div class="col-md-6">
                                <input id="id_card" type="text" class="form-control{{ $errors->has('id_card') ? ' is-invalid' : '' }}" name="id_card" value="{{ old('id_card',$id_card) }}" maxlength="13" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" autofocus>

                                @if ($errors->has('id_card'))
                                    <span class="invalid-feedback PromptRegular16">
                                        {{ $errors->first('id_card') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br>

        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">

                            {{-- รายการชำระค่าสาธารณูปโภค ลำดับที่ 1  --}}
                            <div class="container card-header">
                                <div class="row">
                                    <div class="col order-first PromptRegular20">                                        
                                        <i class="fas fa-credit-card"></i> รายการชำระค่าสาธารณูปโภค ลำดับที่ 1
                                    </div>

                                    <div class="checkbox">
                                        <label style="font-size: 1em">
                                            <input type="checkbox" id="checkbox01" name="checkbox01" value="save_01" data-toggle="collapse" data-parent="#accordion" href="#collapse1" onchange="valueChanged_checkbox01()">
                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                            <span class="PromptRegular16">กรุณาทำเครื่องหมาย <i class="fas fa-check"></i> เพื่อบันทึกข้อมูล</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div id="collapse1" class="card-body table-responsive-md PromptRegular16 panel-collapse collapse in">
                                <div class="form-group row">
                                    <label for="card_number" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('หมายเลขบัตรเครดิต :') }} <span style="color:red;">*</span></label>
        
                                    <div class="col-md-1">
                                        <input id="card_number1_01" type="text" class="form-control{{ $errors->has('card_number1_01') ? ' is-invalid' : '' }}" name="card_number1_01" value="{{ old('card_number1_01') }}" maxlength="4" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" autofocus>
                                        
                                        @if ($errors->has('card_number1_01'))
                                            <span class="invalid-feedback PromptRegular16">
                                                {{ $errors->first('card_number1_01') }}
                                            </span>
                                        @endif
                                    </div>
                                    -
                                    <div class="col-md-1">
                                        <input id="card_number2_01" type="text" class="form-control{{ $errors->has('card_number2_01') ? ' is-invalid' : '' }}" name="card_number2_01" value="{{ old('card_number2_01') }}" maxlength="4" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" autofocus>
                                        
                                        @if ($errors->has('card_number2_01'))
                                            <span class="invalid-feedback PromptRegular16">
                                                {{ $errors->first('card_number2_01') }}
                                            </span>
                                        @endif
                                    </div>
                                    -
                                    <div class="col-md-1">
                                        <input id="card_number3_01" type="text" class="form-control{{ $errors->has('card_number3_01') ? ' is-invalid' : '' }}" name="card_number3_01" value="{{ old('card_number3_01') }}" maxlength="4" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" autofocus>
                                        
                                        @if ($errors->has('card_number3_01'))
                                            <span class="invalid-feedback PromptRegular16">
                                                {{ $errors->first('card_number3_01') }}
                                            </span>
                                        @endif
                                    </div>
                                    -
                                    <div class="col-md-1">
                                        <input id="card_number4_01" type="text" class="form-control{{ $errors->has('card_number4_01') ? ' is-invalid' : '' }}" name="card_number4_01" value="{{ old('card_number4_01') }}" maxlength="4" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" autofocus>
                                        
                                        @if ($errors->has('card_number4_01'))
                                            <span class="invalid-feedback PromptRegular16">
                                                {{ $errors->first('card_number4_01') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="recurring_type_label" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('ประเภทรายการชำระ :') }} </label>
                                    <label for="recurring_type_name" class="col-md-4 col-form-label text-md-left PromptRegular16"> {{ $recurring_type_name->name_type }} </label>
                                    <input id="recurring_type_id01" type="text" name="recurring_type_id01" value="{{ $recurring_type_name->id }}" hidden>
                                </div>

                                <div class="form-group row">
                                    <label for="agency_id_01" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('หน่วยงาน :') }} <span style="color:red;">*</span></label>
        
                                    <div class="col-md-6">
                                        <select id="agency_id_01" name="agency_id_01" class="custom-select{{ $errors->has('agency_id_01') ? ' is-invalid' : '' }}" autofocus>
                                            <option value=null selected disabled hidden>กรุณาเลือกหน่วยงาน</option>
                                            @foreach($get_agency as $agency)
                                            <option value="{{ $agency->id }}" {{ old('agency_id_01') == $agency->id ? "selected":"" }}> {{ $agency->agency_name }}</option>
                                            @endforeach
                                        </select>
        
                                        @if ($errors->has('agency_id_01'))
                                            <span class="invalid-feedback PromptRegular16">
                                                {{ $errors->first('agency_id_01') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="contact_account01" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('เลขที่สัญญา :') }} <span style="color:red;">*</span></label>
        
                                    <div class="col-md-6">
                                        <input id="contact_account01" type="text" class="form-control{{ $errors->has('contact_account01') ? ' is-invalid' : '' }}" name="contact_account01" value="{{ old('contact_account01') }}" maxlength="9" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" autofocus>
                                        
                                        @if ($errors->has('contact_account01'))
                                            <span class="invalid-feedback PromptRegular16">
                                                {{ $errors->first('contact_account01') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="meter_number01" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('หมายเลขเครื่องวัด :') }} <span style="color:red;">*</span></label>
        
                                    <div class="col-md-6">
                                        <input id="meter_number01" type="text" class="form-control{{ $errors->has('meter_number01') ? ' is-invalid' : '' }}" name="meter_number01" value="{{ old('meter_number01') }}" maxlength="8" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" autofocus>
                                        
                                        @if ($errors->has('meter_number01'))
                                            <span class="invalid-feedback PromptRegular16">
                                                {{ $errors->first('meter_number01') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="applydate_01" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('วันที่สมัคร (วัน/เดือน/ปี ค.ศ.) :') }} <span style="color:red;">*</span></label>
        
                                    <div class="col-md-6">
                                        <input class="form-control{{ $errors->has('applydate_01') ? ' is-invalid' : '' }}" type="date" id="applydate_01" name="applydate_01" value="{{ old('applydate_01') }}" autofocus>
                                        
                                        @if ($errors->has('applydate_01'))
                                            <span class="invalid-feedback PromptRegular16">
                                                {{ $errors->first('applydate_01') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row mb-0" id="btn_save_01">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary PromptRegular16">
                                            <i class="far fa-save"></i> {{ __('บันทึกข้อมูล') }}
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- รายการชำระค่าสาธารณูปโภค ลำดับที่ 2  --}}
                            <div class="container card-header" id="list_02">
                                <div class="row">
                                    <div class="col order-first PromptRegular20">
                                        <i class="fas fa-credit-card"></i> รายการชำระค่าสาธารณูปโภค ลำดับที่ 2
                                    </div>

                                    <div class="checkbox">
                                        <label style="font-size: 1em">
                                            <input type="checkbox" id="checkbox02" name="checkbox02" value="save_02" data-toggle="collapse" data-parent="#accordion" href="#collapse2" onchange="valueChanged_checkbox02()">
                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                            <span class="PromptRegular16">กรุณาทำเครื่องหมาย <i class="fas fa-check"></i> เพื่อบันทึกข้อมูล</span>
                                        </label>
                                    </div>
                                </div>
                            </div>   

                            <div id="collapse2" class="card-body table-responsive-md PromptRegular16 panel-collapse collapse">
                                <div class="form-group row">
                                    <label for="card_number" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('หมายเลขบัตรเครดิต :') }} <span style="color:red;">*</span></label>
        
                                    <div class="col-md-1">
                                        <input id="card_number1_02" type="text" class="form-control{{ $errors->has('card_number1_02') ? ' is-invalid' : '' }}" name="card_number1_02" value="{{ old('card_number1_02') }}" maxlength="4" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" autofocus>
                                        
                                        @if ($errors->has('card_number1_02'))
                                            <span class="invalid-feedback PromptRegular16">
                                                {{ $errors->first('card_number1_02') }}
                                            </span>
                                        @endif
                                    </div>
                                    -
                                    <div class="col-md-1">
                                        <input id="card_number2_02" type="text" class="form-control{{ $errors->has('card_number2_02') ? ' is-invalid' : '' }}" name="card_number2_02" value="{{ old('card_number2_02') }}" maxlength="4" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" autofocus>
                                        
                                        @if ($errors->has('card_number2_02'))
                                            <span class="invalid-feedback PromptRegular16">
                                                {{ $errors->first('card_number2_02') }}
                                            </span>
                                        @endif
                                    </div>
                                    -
                                    <div class="col-md-1 PromptRegular18">
                                        <input id="card_number3_02" type="text" class="form-control{{ $errors->has('card_number3_02') ? ' is-invalid' : '' }}" name="card_number3_02" value="{{ old('card_number3_02') }}" maxlength="4" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" autofocus>
                                        
                                        @if ($errors->has('card_number3_02'))
                                            <span class="invalid-feedback PromptRegular16">
                                                {{ $errors->first('card_number3_02') }}
                                            </span>
                                        @endif
                                    </div>
                                    -
                                    <div class="col-md-1">
                                        <input id="card_number4_02" type="text" class="form-control{{ $errors->has('card_number4_02') ? ' is-invalid' : '' }}" name="card_number4_02" value="{{ old('card_number4_02') }}" maxlength="4" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" autofocus>
                                        
                                        @if ($errors->has('card_number4_02'))
                                            <span class="invalid-feedback PromptRegular16">
                                                {{ $errors->first('card_number4_02') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="recurring_type_label" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('ประเภทรายการชำระ :') }} </label>
                                    <label for="recurring_type_name" class="col-md-4 col-form-label text-md-left PromptRegular16"> {{ $recurring_type_name->name_type }} </label>
                                    <input id="recurring_type_id02" type="text" name="recurring_type_id02" value="{{ $recurring_type_name->id }}" hidden>
                                </div>

                                <div class="form-group row">
                                    <label for="agency_id_02" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('หน่วยงาน :') }} <span style="color:red;">*</span></label>
        
                                    <div class="col-md-6">
                                        <select id="agency_id_02" name="agency_id_02" class="custom-select{{ $errors->has('agency_id_02') ? ' is-invalid' : '' }}" autofocus>
                                            <option value=null selected disabled hidden>กรุณาเลือกหน่วยงาน</option>
                                            @foreach($get_agency as $agency)
                                            <option value="{{ $agency->id }}" {{ old('agency_id_02') == $agency->id ? "selected":"" }} > {{ $agency->agency_name }}</option>
                                            @endforeach
                                        </select>
        
                                        @if ($errors->has('agency_id_02'))
                                            <span class="invalid-feedback PromptRegular16">
                                                {{ $errors->first('agency_id_02') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="contact_account02" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('เลขที่สัญญา :') }} <span style="color:red;">*</span></label>
        
                                    <div class="col-md-6">
                                        <input id="contact_account02" type="text" class="form-control{{ $errors->has('contact_account02') ? ' is-invalid' : '' }}" name="contact_account02" value="{{ old('contact_account02') }}" maxlength="9" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" autofocus>
                                        
                                        @if ($errors->has('contact_account02'))
                                            <span class="invalid-feedback PromptRegular16">
                                                {{ $errors->first('contact_account02') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="meter_number02" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('หมายเลขเครื่องวัด :') }} <span style="color:red;">*</span></label>
        
                                    <div class="col-md-6">
                                        <input id="meter_number02" type="text" class="form-control{{ $errors->has('meter_number02') ? ' is-invalid' : '' }}" name="meter_number02" value="{{ old('meter_number02') }}" maxlength="8" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" autofocus>
                                        
                                        @if ($errors->has('meter_number02'))
                                            <span class="invalid-feedback PromptRegular16">
                                                {{ $errors->first('meter_number02') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="applydate_02" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('วันที่สมัคร (วัน/เดือน/ปี ค.ศ.) :') }} <span style="color:red;">*</span></label>
        
                                    <div class="col-md-6">
                                        <input class="form-control{{ $errors->has('applydate_02') ? ' is-invalid' : '' }}" type="date" id="applydate_02" name="applydate_02" value="{{ old('applydate_02') }}" autofocus>
                                        
                                        @if ($errors->has('applydate_02'))
                                            <span class="invalid-feedback PromptRegular16">
                                                {{ $errors->first('applydate_02') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row mb-0" id="btn_save_02">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary PromptRegular16">
                                            <i class="far fa-save"></i> {{ __('บันทึกข้อมูล') }}
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- รายการชำระค่าสาธารณูปโภค ลำดับที่ 3  --}}
                            <div class="container card-header" id="list_03">
                                <div class="row">
                                    <div class="col order-first PromptRegular20">
                                        <i class="fas fa-credit-card"></i> รายการชำระค่าสาธารณูปโภค ลำดับที่ 3
                                    </div>

                                    <div class="checkbox">
                                        <label style="font-size: 1em">
                                            <input type="checkbox" id="checkbox03" name="checkbox03" value="save_03" data-toggle="collapse" data-parent="#accordion" href="#collapse3" onchange="valueChanged_checkbox03()">
                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                            <span class="PromptRegular16">กรุณาทำเครื่องหมาย <i class="fas fa-check"></i> เพื่อบันทึกข้อมูล</span>
                                        </label>
                                    </div>
                                </div>
                            </div>   

                            <div id="collapse3" class="card-body table-responsive-md PromptRegular16 panel-collapse collapse">
                                <div class="form-group row">
                                    <label for="card_number" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('หมายเลขบัตรเครดิต :') }} <span style="color:red;">*</span></label>
        
                                    <div class="col-md-1">
                                        <input id="card_number1_03" type="text" class="form-control{{ $errors->has('card_number1_03') ? ' is-invalid' : '' }}" name="card_number1_03" value="{{ old('card_number1_03') }}" maxlength="4" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" autofocus>
                                        
                                        @if ($errors->has('card_number1_03'))
                                            <span class="invalid-feedback PromptRegular16">
                                                {{ $errors->first('card_number1_03') }}
                                            </span>
                                        @endif
                                    </div>
                                    -
                                    <div class="col-md-1">
                                        <input id="card_number2_03" type="text" class="form-control{{ $errors->has('card_number2_03') ? ' is-invalid' : '' }}" name="card_number2_03" value="{{ old('card_number2_03') }}" maxlength="4" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" autofocus>
                                        
                                        @if ($errors->has('card_number2_03'))
                                            <span class="invalid-feedback PromptRegular16">
                                                {{ $errors->first('card_number2_03') }}
                                            </span>
                                        @endif
                                    </div>
                                    -
                                    <div class="col-md-1 PromptRegular18">
                                        <input id="card_number3_03" type="text" class="form-control{{ $errors->has('card_number3_03') ? ' is-invalid' : '' }}" name="card_number3_03" value="{{ old('card_number3_03') }}" maxlength="4" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" autofocus>
                                        
                                        @if ($errors->has('card_number3_03'))
                                            <span class="invalid-feedback PromptRegular16">
                                                {{ $errors->first('card_number3_03') }}
                                            </span>
                                        @endif
                                    </div>
                                    -
                                    <div class="col-md-1">
                                        <input id="card_number4_03" type="text" class="form-control{{ $errors->has('card_number4_03') ? ' is-invalid' : '' }}" name="card_number4_03" value="{{ old('card_number4_03') }}" maxlength="4" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" autofocus>
                                        
                                        @if ($errors->has('card_number4_03'))
                                            <span class="invalid-feedback PromptRegular16">
                                                {{ $errors->first('card_number4_03') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="recurring_type_label" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('ประเภทรายการชำระ :') }} </label>
                                    <label for="recurring_type_name" class="col-md-4 col-form-label text-md-left PromptRegular16"> {{ $recurring_type_name->name_type }} </label>
                                    <input id="recurring_type_id03" type="text" name="recurring_type_id03" value="{{ $recurring_type_name->id }}" hidden>
                                </div>

                                <div class="form-group row">
                                    <label for="agency_id_03" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('หน่วยงาน :') }} <span style="color:red;">*</span></label>
        
                                    <div class="col-md-6">
                                        <select id="agency_id_03" name="agency_id_03" class="custom-select{{ $errors->has('agency_id_03') ? ' is-invalid' : '' }}" autofocus>
                                            <option value=null selected disabled hidden>กรุณาเลือกหน่วยงาน</option>
                                            @foreach($get_agency as $agency)
                                            <option value="{{ $agency->id }}" {{ old('agency_id_03') == $agency->id ? "selected":"" }}> {{ $agency->agency_name }}</option>
                                            @endforeach
                                        </select>
        
                                        @if ($errors->has('agency_id_03'))
                                            <span class="invalid-feedback PromptRegular16">
                                                {{ $errors->first('agency_id_03') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="contact_account03" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('เลขที่สัญญา :') }} <span style="color:red;">*</span></label>
        
                                    <div class="col-md-6">
                                        <input id="contact_account03" type="text" class="form-control{{ $errors->has('contact_account03') ? ' is-invalid' : '' }}" name="contact_account03" value="{{ old('contact_account03') }}" maxlength="9" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" autofocus>
                                        
                                        @if ($errors->has('contact_account03'))
                                            <span class="invalid-feedback PromptRegular16">
                                                {{ $errors->first('contact_account03') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="meter_number03" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('หมายเลขเครื่องวัด :') }} <span style="color:red;">*</span></label>
        
                                    <div class="col-md-6">
                                        <input id="meter_number03" type="text" class="form-control{{ $errors->has('meter_number03') ? ' is-invalid' : '' }}" name="meter_number03" value="{{ old('meter_number03') }}" maxlength="8" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" autofocus>
                                        
                                        @if ($errors->has('meter_number03'))
                                            <span class="invalid-feedback PromptRegular16">
                                                {{ $errors->first('meter_number03') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="applydate_03" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('วันที่สมัคร (วัน/เดือน/ปี ค.ศ.) :') }} <span style="color:red;">*</span></label>
        
                                    <div class="col-md-6">
                                        <input class="form-control{{ $errors->has('applydate_03') ? ' is-invalid' : '' }}" type="date" id="applydate_03" name="applydate_03" value="{{ old('applydate_03') }}" autofocus>
                                        
                                        @if ($errors->has('applydate_03'))
                                            <span class="invalid-feedback PromptRegular16">
                                                {{ $errors->first('applydate_03') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row mb-0" id="btn_save_03">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary PromptRegular16">
                                            <i class="far fa-save"></i> {{ __('บันทึกข้อมูล') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                
                            {{-- รายการชำระค่าสาธารณูปโภค ลำดับที่ 4  --}}
                            <div class="container card-header" id="list_04">
                                <div class="row">
                                    <div class="col order-first PromptRegular20">
                                        <i class="fas fa-credit-card"></i> รายการชำระค่าสาธารณูปโภค ลำดับที่ 4
                                    </div>

                                    <div class="checkbox">
                                        <label style="font-size: 1em">
                                            <input type="checkbox" id="checkbox04" name="checkbox04" value="save_04" data-toggle="collapse" data-parent="#accordion" href="#collapse4">
                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                            <span class="PromptRegular16">กรุณาทำเครื่องหมาย <i class="fas fa-check"></i> เพื่อบันทึกข้อมูล</span>
                                        </label>
                                    </div>
                                </div>
                            </div>   

                            <div id="collapse4" class="card-body table-responsive-md PromptRegular16 panel-collapse collapse">
                                <div class="form-group row">
                                    <label for="card_number" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('หมายเลขบัตรเครดิต :') }} <span style="color:red;">*</span></label>
        
                                    <div class="col-md-1">
                                        <input id="card_number1_04" type="text" class="form-control{{ $errors->has('card_number1_04') ? ' is-invalid' : '' }}" name="card_number1_04" value="{{ old('card_number1_04') }}" maxlength="4" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" autofocus>
                                        
                                        @if ($errors->has('card_number1_04'))
                                            <span class="invalid-feedback PromptRegular16">
                                                {{ $errors->first('card_number1_04') }}
                                            </span>
                                        @endif
                                    </div>
                                    -
                                    <div class="col-md-1">
                                        <input id="card_number2_04" type="text" class="form-control{{ $errors->has('card_number2_04') ? ' is-invalid' : '' }}" name="card_number2_04" value="{{ old('card_number2_04') }}" maxlength="4" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" autofocus>
                                        
                                        @if ($errors->has('card_number2_04'))
                                            <span class="invalid-feedback PromptRegular16">
                                                {{ $errors->first('card_number2_04') }}
                                            </span>
                                        @endif
                                    </div>
                                    -
                                    <div class="col-md-1 PromptRegular18">
                                        <input id="card_number3_04" type="text" class="form-control{{ $errors->has('card_number3_04') ? ' is-invalid' : '' }}" name="card_number3_04" value="{{ old('card_number3_04') }}" maxlength="4" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" autofocus>
                                        
                                        @if ($errors->has('card_number3_04'))
                                            <span class="invalid-feedback PromptRegular16">
                                                {{ $errors->first('card_number3_04') }}
                                            </span>
                                        @endif
                                    </div>
                                    -
                                    <div class="col-md-1">
                                        <input id="card_number4_04" type="text" class="form-control{{ $errors->has('card_number4_04') ? ' is-invalid' : '' }}" name="card_number4_04" value="{{ old('card_number4_04') }}" maxlength="4" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" autofocus>
                                        
                                        @if ($errors->has('card_number4_04'))
                                            <span class="invalid-feedback PromptRegular16">
                                                {{ $errors->first('card_number4_04') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="recurring_type_label" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('ประเภทรายการชำระ :') }} </label>
                                    <label for="recurring_type_name" class="col-md-4 col-form-label text-md-left PromptRegular16"> {{ $recurring_type_name->name_type }} </label>
                                    <input id="recurring_type_id04" type="text" name="recurring_type_id04" value="{{ $recurring_type_name->id }}" hidden>
                                </div>

                                <div class="form-group row">
                                    <label for="agency_id_04" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('หน่วยงาน :') }} <span style="color:red;">*</span></label>
        
                                    <div class="col-md-6">
                                        <select id="agency_id_04" name="agency_id_04" class="custom-select{{ $errors->has('agency_id_04') ? ' is-invalid' : '' }}" autofocus>
                                            <option value=null selected disabled hidden>กรุณาเลือกหน่วยงาน</option>
                                            @foreach($get_agency as $agency)
                                            <option value="{{ $agency->id }}" {{ old('agency_id_04') == $agency->id ? "selected":"" }}> {{ $agency->agency_name }}</option>
                                            @endforeach
                                        </select>
        
                                        @if ($errors->has('agency_id_04'))
                                            <span class="invalid-feedback PromptRegular16">
                                                {{ $errors->first('agency_id_04') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="contact_account04" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('เลขที่สัญญา :') }} <span style="color:red;">*</span></label>
        
                                    <div class="col-md-6">
                                        <input id="contact_account04" type="text" class="form-control{{ $errors->has('contact_account04') ? ' is-invalid' : '' }}" name="contact_account04" value="{{ old('contact_account04') }}" maxlength="9" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" autofocus>
                                        
                                        @if ($errors->has('contact_account04'))
                                            <span class="invalid-feedback PromptRegular16">
                                                {{ $errors->first('contact_account04') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="meter_number04" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('หมายเลขเครื่องวัด :') }} <span style="color:red;">*</span></label>
        
                                    <div class="col-md-6">
                                        <input id="meter_number04" type="text" class="form-control{{ $errors->has('meter_number04') ? ' is-invalid' : '' }}" name="meter_number04" value="{{ old('meter_number04') }}" maxlength="8" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" autofocus>
                                        
                                        @if ($errors->has('meter_number04'))
                                            <span class="invalid-feedback PromptRegular16">
                                                {{ $errors->first('meter_number04') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="applydate_04" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('วันที่สมัคร (วัน/เดือน/ปี ค.ศ.) :') }} <span style="color:red;">*</span></label>
        
                                    <div class="col-md-6">
                                        <input class="form-control{{ $errors->has('applydate_04') ? ' is-invalid' : '' }}" type="date" id="applydate_04" name="applydate_04" value="{{ old('applydate_04') }}" autofocus>
                                        
                                        @if ($errors->has('applydate_04'))
                                            <span class="invalid-feedback PromptRegular16">
                                                {{ $errors->first('applydate_04') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row mb-0" id="btn_save_04">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary PromptRegular16">
                                            <i class="far fa-save"></i> {{ __('บันทึกข้อมูล') }}
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    </form>
</div>
@endsection

{{--  ่java scripts  --}}
@push('scripts')
<script src="{{ asset('bootstrap-4.0.0/assets/js/vendor/popper.min.js') }}"></script>
<script src="{{ asset('bootstrap-4.0.0/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('bootstrap-4.0.0/assets/js/vendor/holder.min.js') }}"></script>

<script>
    $("#list_02").hide();
    $("#list_03").hide();
    $("#list_04").hide();

    function valueChanged_checkbox01() {
        if($("#checkbox01").is(":checked"))
            $("#list_02").show();
        else
            $("#list_02").hide();
    };

    function valueChanged_checkbox02() {
        if($("#checkbox02").is(":checked"))
            $("#list_03").show();
        else
            $("#list_03").hide();
    };

    function valueChanged_checkbox03() {
        if($("#checkbox03").is(":checked"))
            $("#list_04").show();
        else
            $("#list_04").hide();
    };
</script>
@endpush