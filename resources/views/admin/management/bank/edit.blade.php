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
                <div class="card-header PromptRegular20"><i class="fas fa-edit"></i> {{ __('แก้ไขข้อมูลธนาคารออมสิน') }}</div>
                    <div class="card-body PromptRegular16">
                        <form method="POST" action="{{-- route('bank.update') --}}"> 
                            @csrf
                            <input type="hidden" name="check_unique[id]" value="{{ $bank->id }}">
                            <div class="form-group row">
                                <label for="bank_code" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('หมายเลขธนาคาร :') }} <span style="color:red;">*</span></label>

                                <div class="col-md-6">
                                    <input id="bank_code" type="text" class="form-control{{ $errors->has('bank_code') ? ' is-invalid' : '' }}" name="bank_code" maxlength="8" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" value="{{ old('bank_code',$bank->bank_code) }}" required autofocus>

                                    @if ($errors->has('bank_code'))
                                        <span class="invalid-feedback PromptRegular16">
                                            {{ $errors->first('bank_code') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="bank_name" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('ชื่อธนาคาร :') }} <span style="color:red;">*</span></label>

                                <div class="col-md-6">
                                    <input id="bank_name" type="text" class="form-control{{ $errors->has('bank_name') ? ' is-invalid' : '' }}" name="bank_name" value="{{ old('bank_name',$bank->bank_name) }}" required autofocus>

                                    @if ($errors->has('bank_name'))
                                        <span class="invalid-feedback PromptRegular16">
                                            {{ $errors->first('bank_name') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="branch_code" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('หมายเลขสาขา :') }} <span style="color:red;">*</span></label>

                                <div class="col-md-6">
                                    <input id="branch_code" type="text" class="form-control{{ $errors->has('branch_code') ? ' is-invalid' : '' }}" name="branch_code" maxlength="8" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" value="{{ old('branch_code',$bank->branch_code) }}" required autofocus>

                                    @if ($errors->has('branch_code'))
                                        <span class="invalid-feedback PromptRegular16">
                                            {{ $errors->first('branch_code') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="branch_name" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('ชื่อสาขา :') }} <span style="color:red;">*</span></label>

                                <div class="col-md-6">
                                    <input id="branch_name" type="text" class="form-control{{ $errors->has('branch_name') ? ' is-invalid' : '' }}" name="branch_name" value="{{ old('branch_name',$bank->branch_name) }}" required autofocus>

                                    @if ($errors->has('branch_name'))
                                        <span class="invalid-feedback PromptRegular16">
                                            {{ $errors->first('branch_name') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="useflag" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('สถานะความพร้อมใช้งาน :') }} <span style="color:red;">*</span></label>
    
                                <div class="col-md-6">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="useflag_y" name="useflag" class="custom-control-input" value="Y" {{ $bank->useflag == 'Y' ? "checked" : "" }}>
                                        <label class="custom-control-label" for="useflag_y">Activated</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="useflag_n" name="useflag" class="custom-control-input" value="N" {{ $bank->useflag == 'N' ? "checked" : "" }}>
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
