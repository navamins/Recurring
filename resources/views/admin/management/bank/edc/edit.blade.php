@extends('layouts.app')

@section('content')
<div class="container">
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
                <div class="card-header PromptRegular20"><i class="fas fa-edit"></i> {{ __('แก้ไขข้อมูลเครื่อง EDC') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{-- route('edc.update') --}}"> 
                            @csrf
                            <input type="hidden" name="check_unique[id]" value="{{ $edc->id }}">
                            <div class="form-group row">
                                <label for="edc_no" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('หมายเลขเครื่อง EDC :') }} <span style="color:red;">*</span></label>

                                <div class="col-md-6">
                                    <input id="edc_no" type="text" class="form-control{{ $errors->has('edc_no') ? ' is-invalid' : '' }}" name="edc_no" maxlength="8" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" value="{{ old('edc_no',$edc->edc_no) }}" required autofocus>

                                    @if ($errors->has('edc_no'))
                                        <span class="invalid-feedback PromptRegular16">
                                            {{ $errors->first('edc_no') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="edc_name" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('ชื่อเครื่อง EDC :') }} <span style="color:red;">*</span></label>

                                <div class="col-md-6">
                                    <input id="edc_name" type="text" class="form-control{{ $errors->has('edc_name') ? ' is-invalid' : '' }}" name="edc_name" value="{{ old('edc_name',$edc->edc_name) }}" required autofocus>

                                    @if ($errors->has('edc_name'))
                                        <span class="invalid-feedback PromptRegular16">
                                            {{ $errors->first('edc_name') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="bank_id" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('หมายเลขธนาคาร /ชื่อธนาคาร :') }} <span style="color:red;">*</span></label>

                                <div class="col-md-6">
                                    <select id="bank_id" name="bank_id" class="custom-select{{ $errors->has('bank_id') ? ' is-invalid' : '' }}" required autofocus>
                                        <option value=null selected disabled hidden>กรุณาเลือกหมายเลขธนาคาร /ชื่อธนาคาร</option>
                                        @foreach($banks as $bank)
                                    <option value="{{ $bank->id }}" {{ old('bank_id',$edc->bank_id) == $bank->id ? "selected":"" }}>{{ $bank->bank_code }} /{{ $bank->bank_name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('bank_id'))
                                        <span class="invalid-feedback PromptRegular16">
                                            {{ $errors->first('bank_id') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="useflag" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('สถานะความพร้อมใช้งาน :') }} <span style="color:red;">*</span></label>
    
                                <div class="col-md-6">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="useflag_y" name="useflag" class="custom-control-input" value="Y" {{ $edc->useflag == 'Y' ? "checked" : "" }}>
                                        <label class="custom-control-label" for="useflag_y">Activated</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="useflag_n" name="useflag" class="custom-control-input" value="N" {{ $edc->useflag == 'N' ? "checked" : "" }}>
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
