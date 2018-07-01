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
                                {{-- <button type="button" class="btn btn-outline-primary"><i class="fas fa-plus-square"></i> สร้างข้อมูลเครื่อง EDC </button> --}}
                            </div>
                        </div>
                        <div class="col">
                            {{-- Second, but unordered --}}
                        </div>
                        <div class="col order-first PromptRegular20">
                            <i class="fas fa-plus-square"></i> สร้างข้อมูลเครื่อง EDC  
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive-md PromptRegular16">
                    <form method="POST" action="{{ route('edc.store') }}"> 
                        @csrf
                        <div class="form-group row">
                            <label for="edc_no" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('หมายเลขเครื่อง EDC :') }} <span style="color:red;">*</span></label>

                            <div class="col-md-6">
                                <input id="edc_no" type="text" class="form-control{{ $errors->has('edc_no') ? ' is-invalid' : '' }}" name="edc_no" value="{{ old('edc_no') }}" maxlength="8" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" required autofocus>

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
                                <input id="edc_name" type="text" class="form-control{{ $errors->has('edc_name') ? ' is-invalid' : '' }}" name="edc_name" value="{{ old('edc_name') }}" required autofocus>

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
                                <option value="{{ $bank->id }}" {{ old('bank_id') == $bank->id ? "selected":"" }}>{{ $bank->bank_code }} /{{ $bank->bank_name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('bank_id'))
                                    <span class="invalid-feedback PromptRegular16">
                                        {{ $errors->first('bank_id') }}
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
