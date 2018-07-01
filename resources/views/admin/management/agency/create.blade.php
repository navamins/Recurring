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
                            <i class="fas fa-plus-square"></i> สร้างข้อมูลหน่วยงานพันธมิตร 
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive-md PromptRegular16">
                    <form method="POST" action="{{ route('agency.store') }}"> 
                        @csrf
                        <div class="form-group row">
                            <label for="agency_code" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('รหัสหน่วยงานพันธมิตร :') }} <span style="color:red;">*</span></label>

                            <div class="col-md-6">
                                <input id="agency_code" type="text" class="form-control{{ $errors->has('agency_code') ? ' is-invalid' : '' }}" name="agency_code" value="{{ old('agency_code') }}" required autofocus>

                                @if ($errors->has('agency_code'))
                                    <span class="invalid-feedback PromptRegular16">
                                        {{ $errors->first('agency_code') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="agency_name" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('ชื่อหน่วยงานพันธมิตร :') }} <span style="color:red;">*</span></label>

                            <div class="col-md-6">
                                <input id="agency_name" type="text" class="form-control{{ $errors->has('agency_name') ? ' is-invalid' : '' }}" name="agency_name" value="{{ old('agency_name') }}" required autofocus>

                                @if ($errors->has('agency_name'))
                                    <span class="invalid-feedback PromptRegular16">
                                        {{ $errors->first('agency_name') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="agency_detail" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('รายละเอียด :') }} <span style="color:red;">*</span></label>

                            <div class="col-md-6">
                                <textarea id="agency_detail" type="text" class="form-control{{ $errors->has('agency_detail') ? ' is-invalid' : '' }}" name="agency_detail" rows="6" required autofocus>{{ old('agency_detail') }}</textarea>

                                @if ($errors->has('agency_detail'))
                                    <span class="invalid-feedback PromptRegular16">
                                        {{ $errors->first('agency_detail') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="merchant_code" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('หมายเลขร้านค้า :') }} <span style="color:red;">*</span></label>

                            <div class="col-md-6">
                                <input id="merchant_code" type="text" class="form-control{{ $errors->has('merchant_code') ? ' is-invalid' : '' }}" name="merchant_code" maxlength="15" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" value="{{ old('merchant_code') }}" required autofocus>

                                @if ($errors->has('merchant_code'))
                                    <span class="invalid-feedback PromptRegular16">
                                        {{ $errors->first('merchant_code') }}
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
