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
                            <i class="fas fa-plus-square"></i> สร้างข้อมูลธนาคารออมสิน 
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive-md PromptRegular16">
                    <form method="POST" action="{{-- route('bank.store') --}}"> 
                        @csrf
                        <div class="form-group row">
                            <label for="bank_code" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('หมายเลขธนาคาร :') }} <span style="color:red;">*</span></label>

                            <div class="col-md-6">
                                <input id="bank_code" type="text" class="form-control{{ $errors->has('bank_code') ? ' is-invalid' : '' }}" name="bank_code" value="{{ old('bank_code') }}" maxlength="8" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" required autofocus>

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
                                <input id="bank_name" type="text" class="form-control{{ $errors->has('bank_name') ? ' is-invalid' : '' }}" name="bank_name" value="{{ old('bank_name') }}" required autofocus>

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
                                <input id="branch_code" type="text" class="form-control{{ $errors->has('branch_code') ? ' is-invalid' : '' }}" name="branch_code" maxlength="8" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" value="{{ old('branch_code') }}" required autofocus>

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
                                <input id="branch_name" type="text" class="form-control{{ $errors->has('branch_name') ? ' is-invalid' : '' }}" name="branch_name" value="{{ old('branch_name') }}" required autofocus>

                                @if ($errors->has('branch_name'))
                                    <span class="invalid-feedback PromptRegular16">
                                        {{ $errors->first('branch_name') }}
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

{{--  ่java scripts  --}}
@push('scripts')
    
@endpush
