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
            @endif
            
            @foreach($transactions as $key => $transaction)
            <div class="card">
            <div class="card-header bg-light text-dark PromptRegular20"><i class="fas fa-eye"></i> {{ __('รายละเอียดข้อมูลผู้ลงทะเบียนชำระค่าสาธารณูปโภคของ ') }} "{{ $transaction->agency_name }}"</div>
                <div class="card-body">
                    <div class="form-group row">
                        <label for="title_name_lastname" class="col-md-5 col-form-label text-md-right PromptMedium16">{{ __('ชื่อ - นามสกุล :') }}</label>

                        <div class="col-md-6">
                            <label for="title_name_lastname" class="col-md-12 col-form-label text-md-left PromptRegular16">{{ $transaction->name_title }}{{ $transaction->name }} {{ $transaction->lastname }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="id_card" class="col-md-5 col-form-label text-md-right PromptMedium16">{{ __('หมายเลขบัตรประชาชน :') }}</label>
                        
                        <div class="col-md-6">
                            <label for="id_card" class="col-md-12 col-form-label text-md-left PromptRegular16">
                                {{ substr($transaction->id_card,0,1) }} 
                                {{ substr($transaction->id_card,1,4) }} 
                                {{ substr($transaction->id_card,5,5) }} 
                                {{ substr($transaction->id_card,10,2) }} 
                                {{ substr($transaction->id_card,12,1) }}
                            </label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="button" class="col-md-5 col-form-label text-md-right PromptMedium16"></label>

                        <div class="col-md-6 mb-0">
                            <span col-md-12 col-form-label text-md-left PromptRegular16>
                                <a href="{{ route('customer.form_edit_customer',Crypt::encryptString($transaction->customer_id)) }}"><button class="btn btn-primary PromptRegular16"><i class="fas fa-edit"></i> {{ __('แก้ไขข้อมูลผู้ลงทะเบียน') }}</button></a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ข้อมูลรายการชำระค่าสาธารณูปโภค --}}
            <br>
            <div class="card">
            <div class="card-header bg-light text-dark PromptRegular20"><i class="far fa-credit-card"></i> {{ __('รายละเอียดข้อมูลการชำระบัตรเครดิต รายการที่ ') }} {{ $key+1 }}</div>
                <div class="card-body">
                    <div class="form-group row">
                        <label for="status_agency" class="col-md-5 col-form-label text-md-right PromptMedium16">{{ __('สถานะระบบ :') }}</label>

                        <div class="col-md-6">
                            <label for="status_agency" class="col-md-12 col-form-label text-md-left PromptRegular16">
                                {{-- ตรวจสอบสถานะของระบบ --}}
                                @if($transaction->status_register =='Pending')
                                <span class="badge badge-primary PromptRegular16">{{ $transaction->status_register }}</span> 
                                @elseif($transaction->status_register =='Check')
                                <span class="badge badge-secondary PromptRegular16">{{ $transaction->status_register }}</span>
                                @elseif($transaction->status_register =='Waiting for correct')
                                <span class="badge badge-warning PromptRegular16">{{ $transaction->status_register }}</span>
                                @elseif($transaction->status_register =='Waiting for reply')
                                <span class="badge badge-info PromptRegular16">{{ $transaction->status_register }}</span>
                                @elseif($transaction->status_register =='Approved')
                                <span class="badge badge-success PromptRegular16">{{ $transaction->status_register }}</span>
                                @elseif($transaction->status_register =='Rejected')
                                <span class="badge badge-danger PromptRegular16">{{ $transaction->status_register }}</span>
                                @endif
                            </label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="apply_date" class="col-md-5 col-form-label text-md-right PromptMedium16">{{ __('วันที่สมัคร :') }}</label>

                        <div class="col-md-6">
                            <label for="apply_date" class="col-md-12 col-form-label text-md-left PromptRegular16">{{ $apply_date_th }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="status_register" class="col-md-5 col-form-label text-md-right PromptMedium16">{{ __('สถานะการลงทะเบียน :') }}</label>

                        <div class="col-md-6">
                            <label for="status_register" class="col-md-12 col-form-label text-md-left PromptRegular16">
                                {{-- ตรวจสอบเงื่อนไขสถานะการลงทะเบียน --}}
                                @if($transaction->status_action =='A')
                                สมัครใหม่ ({{ $transaction->status_action }})
                                @elseif($customer->status_action =='C')
                                เปลี่ยนแปลง ({{ $transaction->status_action }})
                                @else
                                ยกเลิก ({{ $transaction->status_action }})
                                @endif
                            </label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="card_number" class="col-md-5 col-form-label text-md-right PromptMedium16">{{ __('หมายเลขบัตรเครดิต :') }}</label>
                        
                        <div class="col-md-6">
                            <label for="card_number" class="col-md-12 col-form-label text-md-left PromptRegular16">
                                {{ substr(Crypt::decryptString($transaction->card_number), 0, 4) }}
                                 - {{ substr(Crypt::decryptString($transaction->card_number), 4, 4) }}
                                 - {{ substr(Crypt::decryptString($transaction->card_number), 8, 4) }}
                                 - {{ substr(Crypt::decryptString($transaction->card_number), 12, 4) }}
                            </label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="address" class="col-md-5 col-form-label text-md-right PromptMedium16">{{ __('ที่อยู่ :') }}</label>

                        <div class="col-md-6">
                            <label for="address" class="col-md-12 col-form-label text-md-left PromptRegular16">
                                {{ $transaction->address1 }} {{ $transaction->address2 }} {{ $transaction->address3 }} {{ $transaction->provinces }} {{ $transaction->zipcode }}
                            </label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="telephone" class="col-md-5 col-form-label text-md-right PromptMedium16">{{ __('หมายเลขโทรศัพท์มือถือ :') }}</label>

                        <div class="col-md-6">
                            <label for="telephone" class="col-md-12 col-form-label text-md-left PromptRegular16">{{ $transaction->telephone }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="agency_type" class="col-md-5 col-form-label text-md-right PromptMedium16">{{ __('ประเภทรายการชำระ :') }}</label>

                        <div class="col-md-6">
                            <label for="agency_type" class="col-md-12 col-form-label text-md-left PromptRegular16">{{ $transaction->name_type }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="agency_name" class="col-md-5 col-form-label text-md-right PromptMedium16">{{ __('หน่วยงาน :') }}</label>

                        <div class="col-md-6">
                            <label for="agency_name" class="col-md-12 col-form-label text-md-left PromptRegular16">{{ $transaction->agency_name }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="contact_account" class="col-md-5 col-form-label text-md-right PromptMedium16">{{ __('เลขที่สัญญา :') }}</label>

                        <div class="col-md-6">
                            <label for="contact_account" class="col-md-12 col-form-label text-md-left PromptRegular16">{{ $transaction->contact_account }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="meter_number" class="col-md-5 col-form-label text-md-right PromptMedium16">{{ __('หมายเลขเครื่องวัด :') }}</label>

                        <div class="col-md-6">
                            <label for="meter_number" class="col-md-12 col-form-label text-md-left PromptRegular16">{{ $transaction->meter_number }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="status_agency" class="col-md-5 col-form-label text-md-right PromptMedium16">{{ __('สถานะตรวจสอบกับหน่วยงานพันธมิตร :') }}</label>

                        <div class="col-md-6">
                            <label for="status_agency" class="col-md-12 col-form-label text-md-left PromptRegular16">
                                {{-- ตรวจสอบเงื่อนไขสถานะตรวจสอบกับหน่วยงานพันธมิตร --}}
                                @if($transaction->status_agency =='0')
                                สำเร็จ ({{ $transaction->status_agency }})
                                @elseif($transaction->status_agency =='1')
                                ไม่สำเร็จ ({{ $transaction->status_agency }})
                                @else
                                รอส่งตรวจสอบ ({{ $transaction->status_agency }})
                                @endif
                            </label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="button" class="col-md-5 col-form-label text-md-right PromptMedium16"></label>

                        <div class="col-md-6 mb-0">
                            <span col-md-12 col-form-label text-md-left PromptRegular16>
                                <a href="{{-- route('cardtype.edit',Crypt::encryptString($get_card->id)) --}}"><button class="btn btn-primary PromptRegular16"><i class="fas fa-edit"></i> {{ __('แก้ไขข้อมูลการชำระบัตรเครดิต') }}</button></a>
                            </span>
                        </div>
                    </div>

                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
