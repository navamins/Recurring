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
            <div class="card-header PromptRegular20"><i class="fas fa-eye"></i> {{ __('รายละเอียดข้อมูลหน่วยงานพันธมิตร ') }}</div>
                @foreach($agencies as $agency)
                <div class="card-body">
                    <div class="form-group row">
                        <label for="merchant_code_val" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('หมายเลขร้านค้า :') }}</label>

                        <div class="col-md-6">
                            <label for="merchant_code_val" class="col-md-12 col-form-label text-md-left PromptRegular16">{{ $agency->merchant_code }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="agency_code_val" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('รหัสหน่วยงานพันธมิตร :') }}</label>
                        
                        <div class="col-md-6">
                            <label for="agency_code_val" class="col-md-12 col-form-label text-md-left PromptRegular16">{{ $agency->agency_code }}</span></label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="agency_name_val" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('ชื่อหน่วยงานพันธมิตร :') }}</label>

                        <div class="col-md-6">
                            <label for="agency_name_val" class="col-md-12 col-form-label text-md-left PromptRegular16">{{ $agency->agency_name }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="agency_detail_val" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('รายละเอียด :') }}</label>

                        <div class="col-md-6">
                            <label for="agency_detail_val" class="col-md-12 col-form-label text-md-left PromptRegular16">{{ $agency->agency_detail }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="useflag" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('สถานะความพร้อมใช้งาน :') }}</label>

                        <div class="col-md-6">
                            @if($agency->useflag =='Y')
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
                            <label for="create_date_val" class="col-md-12 col-form-label text-md-left PromptRegular16">{{ $create_date }} น. <span class="PromptMedium16">โดย</span> {{ $agency->create_user !=null || $agency->create_user !="" ? $agency->create_name." ".$agency->create_lastname : "" }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="update_date" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('อัพเดทข้อมูลล่าสุด :') }}</label>

                        <div class="col-md-8">
                            <label for="update_date_val" class="col-md-12 col-form-label text-md-left PromptRegular16">{{ $update_date }} น. <span class="PromptMedium16">โดย</span> {{ $agency->update_user !=null || $agency->update_user !="" ? $agency->update_name." ".$agency->update_lastname : "" }}</label>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <a href="{{ route('agency.edit',Crypt::encryptString($agency->id)) }}"><button class="btn btn-primary PromptRegular16"><i class="fas fa-edit"></i> {{ __('แก้ไขข้อมูลหน่วยงานพันธมิตร') }}</button></a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
