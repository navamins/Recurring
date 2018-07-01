@extends('layouts.app')

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
                <br />
            @endif

            <div class="card">
            <div class="card-header PromptRegular20"><i class="fas fa-eye"></i> {{ __('รายละเอียดข้อมูลธนาคารออมสิน ') }}</div>
                @foreach($banks as $bank)
                <div class="card-body">
                    <div class="form-group row">
                        <label for="edc_no_val" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('หมายเลขธนาคาร :') }}</label>

                        <div class="col-md-6">
                            <label for="edc_no_val" class="col-md-12 col-form-label text-md-left PromptRegular16">{{ $bank->bank_code }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="edc_name_val" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('ชื่อธนาคาร :') }}</label>
                        
                        <div class="col-md-6">
                            <label for="edc_name_val" class="col-md-12 col-form-label text-md-left PromptRegular16">{{ $bank->bank_name }}</span></label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="bank_name_val" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('หมายเลขสาขา :') }}</label>

                        <div class="col-md-6">
                            <label for="bank_name_val" class="col-md-12 col-form-label text-md-left PromptRegular16">{{ $bank->branch_code }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="bank_name_val" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('ชื่อสาขา :') }}</label>

                        <div class="col-md-6">
                            <label for="bank_name_val" class="col-md-12 col-form-label text-md-left PromptRegular16">{{ $bank->branch_name }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="useflag" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('สถานะความพร้อมใช้งาน :') }}</label>

                        <div class="col-md-6">
                            @if($bank->useflag =='Y')
                            <label for="useflag" class="col-md-12 col-form-label text-md-left PromptRegular16">
                                <span class="badge badge-success">Activated</span>
                            </label>
                            @else
                            <label for="useflag" class="col-md-12 col-form-label text-md-left PromptRegular16">
                                <span class="badge badge-danger">Not Activated</span>
                            </label>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="create_date" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('สร้างเมื่อวันที่ :') }}</label>

                        <div class="col-md-8">
                            <label for="create_date_val" class="col-md-12 col-form-label text-md-left PromptRegular16">{{ $create_date }} น. <span class="PromptMedium16">โดย</span> {{ $bank->create_user !=null || $bank->create_user !="" ? $bank->create_name." ".$bank->create_lastname : "" }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="update_date" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('อัพเดทข้อมูลล่าสุด :') }}</label>

                        <div class="col-md-8">
                            <label for="update_date_val" class="col-md-12 col-form-label text-md-left PromptRegular16">{{ $update_date }} น. <span class="PromptMedium16">โดย</span> {{ $bank->update_user !=null || $bank->update_user !="" ? $bank->update_name." ".$bank->update_lastname : "" }}</label>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <a href="{{ route('bank.edit',Crypt::encryptString($bank->id)) }}"><button class="btn btn-primary PromptRegular16"><i class="fas fa-edit"></i> {{ __('แก้ไขข้อมูลธนาคารออมสิน') }}</button></a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
