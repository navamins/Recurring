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
            <div class="card-header PromptRegular20"><i class="fas fa-eye"></i> {{ __('รายละเอียดข้อมูลบัตรเครดิต ') }}</div>
                @foreach($card as $get_card)
                <div class="card-body">
                    <div class="form-group row">
                        <label for="card_name" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('ชื่อบัตรเครดิต :') }}</label>

                        <div class="col-md-6">
                            <label for="card_name" class="col-md-12 col-form-label text-md-left PromptRegular16">
                                @if($get_card->card_type =='Visa') <i class="fab fa-cc-visa"></i>
                                @elseif($get_card->card_type =='Mastercard') <i class="fab fa-cc-mastercard"></i>
                                @endif
                                {{ $get_card->card_name }}
                            </label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="card_type_number" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('เลขที่บัตรเครดิต 8 หลัก (BIN 6 หลัก + Type) :') }}</label>
                        
                        <div class="col-md-6">
                            <label for="card_type_number" class="col-md-12 col-form-label text-md-left PromptRegular16">{{ substr($get_card->card_type_number, 0, 4) }} - {{ substr($get_card->card_type_number, 4, 4) }} - XXXX - XXXX</span></label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="card_type" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('ประเภทบัตรเครดิต :') }}</label>

                        <div class="col-md-6">
                            <label for="card_type" class="col-md-12 col-form-label text-md-left PromptRegular16">{{ $get_card->card_type }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="card_detail" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('รูปภาพ :') }}</label>

                        <div class="col-md-6">
                            <img class="card-img-top d-flex flex-column justify-content-between" src="{{ asset( $get_card->pic_link.'/'.$get_card->pic_name) }}" style="width: 50%;">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="card_detail" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('รายละเอียด :') }}</label>

                        <div class="col-md-6">
                            <label for="card_detail" class="col-md-12 col-form-label text-md-left PromptRegular16">{{ $get_card->card_detail }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="useflag" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('สถานะความพร้อมใช้งาน :') }}</label>

                        <div class="col-md-6">
                            @if($get_card->useflag =='Y')
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
                            <label for="create_date_val" class="col-md-12 col-form-label text-md-left PromptRegular16">{{ $create_date }} น. <span class="PromptMedium16">โดย</span> {{ $get_card->create_user !=null || $get_card->create_user !="" ? $get_card->create_name." ".$get_card->create_lastname : "" }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="update_date" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('อัพเดทข้อมูลล่าสุด :') }}</label>

                        <div class="col-md-8">
                            <label for="update_date_val" class="col-md-12 col-form-label text-md-left PromptRegular16">{{ $update_date }} น. <span class="PromptMedium16">โดย</span> {{ $get_card->update_user !=null || $get_card->update_user !="" ? $get_card->update_name." ".$get_card->update_lastname : "" }}</label>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <a href="{{ route('cardtype.edit',Crypt::encryptString($get_card->id)) }}"><button class="btn btn-primary PromptRegular16"><i class="fas fa-edit"></i> {{ __('แก้ไขข้อมูลบัตรเครดิต') }}</button></a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
