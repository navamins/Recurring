@extends('layouts.app')

{{--  CSS styles  --}}
@push('styles')
    
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            {{--  ข้อมความแจ้งเตือนว่า อัพเดทข้อมูลสำเร็จ  --}}
            @if(\Session::has('success'))
                <div class="alert alert-success PromptRegular20" role="alert">
                    <i class="fas fa-check"></i> {{\Session::get('success')}} <i class="far fa-smile"></i>
                </div>
            @endif
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
                        <div class="col">
                            {{-- Second, but unordered --}}
                        </div>
                        <div class="col order-first PromptRegular20">
                            <i class="far fa-id-card"></i> ตรวจสอบหมายเลขบัตรประชาชน 
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive-md PromptRegular16">
                    <form method="get" action="{{ route('register.verify_id_card') }}"> 
                        @csrf
                        <div class="form-group row">
                            <label for="id_card" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('หมายเลขบัตรประชาชน 13 หลัก :') }} <span style="color:red;">*</span></label>

                            <div class="col-md-6">
                                <input id="id_card" type="text" class="form-control{{ $errors->has('id_card') ? ' is-invalid' : '' }}" name="id_card" value="{{ old('id_card') }}" maxlength="13" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" autofocus>

                                @if ($errors->has('id_card'))
                                    <span class="invalid-feedback PromptRegular16">
                                        {{ $errors->first('id_card') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="recurring_type" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('ประเภทรายการชำระ :') }} <span style="color:red;">*</span></label>

                            <div class="col-md-6">
                                <select id="recurring_type" name="recurring_type" class="custom-select{{ $errors->has('recurring_type') ? ' is-invalid' : '' }}" autofocus>
                                    <option value=null selected disabled hidden>กรุณาเลือกประเภทรายการชำระ</option>
                                    @foreach($recurring_types as $recurring_type)
                                    <option value="{{ $recurring_type->id }}" {{ old('recurring_type') == $recurring_type->id ? "selected":"" }} > {{ $recurring_type->name_type }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('recurring_type'))
                                    <span class="invalid-feedback PromptRegular16">
                                        {{ $errors->first('recurring_type') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary PromptRegular16">
                                    <i class="far fa-hand-point-right"></i> {{ __('ตรวจสอบข้อมูล') }}
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
