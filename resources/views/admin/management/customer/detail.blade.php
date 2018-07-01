@extends('layouts.app')

{{--  CSS styles  --}}
@push('styles')

@endpush

@section('content')
<div class="container">
    <div class="row justify-content">
        <div class="col-md-12">
            <div class="card mb-3" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                @foreach($customers as $customer)
                <div class="card-body">
                    <h5 class="card-title PromptRegular20"><i class="fas fa-user-circle"></i> {{ __('รายละเอียดข้อมูลผู้ลงทะเบียนชำระค่าสาธารณูปโภค') }}</h5>
                    <div class="form-group row">
                        <label for="title_name_lastname" class="col-md-2 col-form-label text-md-right PromptMedium16">{{ __('ชื่อ - นามสกุล :') }}</label>

                        <div class="col-md-4">
                            <label for="title_name_lastname" class="col-md-12 col-form-label text-md-left PromptRegular16">{{ $customer->name_title.$customer->name.' '.$customer->lastname }}</label>
                        </div>

                        <label for="id_card" class="col-md-2 col-form-label text-md-right PromptMedium16">{{ __('เลขที่บัตรประชาชน :') }}</label>

                        <div class="col-md-4">
                            <label for="id_card" class="col-md-12 col-form-label text-md-left PromptRegular16">{{ $customer->id_card }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="customer_create_date" class="col-md-2 col-form-label text-md-right PromptMedium16">{{ __('สร้างเมื่อวันที่ :') }}</label>

                        <div class="col-md-4">
                            <label for="customer_create_date" class="col-md-12 col-form-label text-md-left PromptRegular16">{{ $customer_create_date }} น.</label>
                            <label for="customer_create_date" class="col-md-12 col-form-label text-md-left PromptRegular16"><span class="PromptMedium16">โดย</span> {{ $customer->create_user !=null || $customer->create_user !="" ? $customer->create_name." ".$customer->create_lastname : "" }}</label>
                        </div>

                        <label for="customer_update_date" class="col-md-2 col-form-label text-md-right PromptMedium16">{{ __('อัพเดทข้อมูลล่าสุด :') }}</label>

                        <div class="col-md-4">
                            <label for="customer_update_date" class="col-md-12 col-form-label text-md-left PromptRegular16">{{ $customer_update_date }} น.</label>
                            <label for="customer_update_date" class="col-md-12 col-form-label text-md-left PromptRegular16"><span class="PromptMedium16">โดย</span> {{ $customer->update_user !=null || $customer->update_user !="" ? $customer->create_name." ".$customer->create_lastname : "" }}</label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-outline-secondary PromptRegular16"><i class="fas fa-edit"></i> แก้ไขข้อมูล</button>
                        </div>
                        <small class="text-muted">Update : {{ \Carbon\Carbon::parse($customer->update_date)->format('d/m/Y H:i:s') }}</small>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        @foreach($recurring_transaction as $key => $transaction)
        <div class="col-md-6">
            <div class="card mb-3 box-shadow">
                <div class="card-body text-dark" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                    <h5 class="card-title PromptRegular20"><i class="far fa-credit-card"></i> เลขที่บัตรเครดิต :
                        {{ substr(Crypt::decryptString($transaction->card_number), 0, 4) }}
                       - {{ substr(Crypt::decryptString($transaction->card_number), 4, 4) }}
                       - {{ substr(Crypt::decryptString($transaction->card_number), 8, 4) }}
                       - {{ substr(Crypt::decryptString($transaction->card_number), 12, 4) }}
                    </h5>
                    <img class="card-img-top d-flex flex-column justify-content-between" src="{{ asset('pic/premium.png') }}" style="width: 50%;margin-left: auto;margin-right: auto;">

                    <div class="row">
                        <div class="col-md-6">
                            <dl class="dl-horizontal">
                                <dt class="PromptRegular16">วันที่สมัคร :</dt>
                                <dd class="PromptRegular16">{{ \Carbon\Carbon::parse($transaction->apply_date)->formatLocalized('%A %d %B %Y') }}</dd>
                                <dt class="PromptRegular16">ประเภทรายการชำระ :</dt>
                                <dd class="PromptRegular16">{{ $transaction->name_type }}</dd>
                                <dt class="PromptRegular16">สถานะระบบ :</dt>
                                <dd>{{-- ตรวจสอบสถานะของระบบ --}}
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
                                </dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl class="dl-horizontal">
                                <dt class="PromptRegular16">หน่วยงาน :</dt>
                                <dd class="PromptRegular16">{{ $transaction->agency_name }}</dd>
                                <dt class="PromptRegular16">เลขที่สัญญา :</dt>
                                <dd class="PromptRegular16">{{ $transaction->contact_account }}</dd>
                                <dt class="PromptRegular16">หมายเลขเครื่องวัด :</dt>
                                <dd class="PromptRegular16">{{ $transaction->meter_number }}</dd>
                            </dl>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-outline-secondary PromptRegular16" data-toggle="modal" data-target="#view{{ $transaction->recurring_transaction_id }}"><i class="fas fa-eye"></i> รายละเอียด</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary PromptRegular16" data-toggle="modal" data-target="#edit{{ $transaction->recurring_transaction_id }}"><i class="fas fa-edit"></i> แก้ไข</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary PromptRegular16" data-toggle="modal" data-target="#del{{ $transaction->recurring_transaction_id }}"><i class="fas fa-ban"></i> ยกเลิก</button>
                        </div>
                        <small class="text-muted">Update : {{ \Carbon\Carbon::parse($transaction->update_date)->format('d/m/Y H:i:s') }}</small>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Modal View -->
@foreach($recurring_transaction as $key => $transaction)
<div class="modal fade" id="view{{ $transaction->recurring_transaction_id }}" tabindex="-1" role="dialog" aria-labelledby="ModalView" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title PromptRegular20" id="ModalView"><i class="far fa-credit-card"></i> เลขที่บัตรเครดิต :
                      {{ substr(Crypt::decryptString($transaction->card_number), 0, 4) }}
                    - {{ substr(Crypt::decryptString($transaction->card_number), 4, 4) }}
                    - {{ substr(Crypt::decryptString($transaction->card_number), 8, 4) }}
                    - {{ substr(Crypt::decryptString($transaction->card_number), 12, 4) }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <dl class="dl-horizontal">
                            <img class="card-img-top d-flex flex-column justify-content-between" src="{{ asset('pic/premium.png') }}" style="width: 80%;margin-left: auto;margin-right: auto;">
                        </dl>
                    </div>
                    <div class="col-md-4">
                        <dl class="dl-horizontal">
                            <dt class="PromptRegular16">วันที่สมัคร :</dt>
                            <dd class="PromptRegular16">{{ \Carbon\Carbon::parse($transaction->apply_date)->formatLocalized('%A %d %B %Y') }}</dd>
                            <dt class="PromptRegular16">ประเภทรายการชำระ :</dt>
                            <dd class="PromptRegular16">{{ $transaction->name_type }}</dd>
                            <dt class="PromptRegular16">สถานะระบบ :</dt>
                            <dd>{{-- ตรวจสอบสถานะของระบบ --}}
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
                            </dd>
                            <dt class="PromptRegular16">ที่อยู่ :</dt>
                            <dd class="PromptRegular16">
                                {{ $transaction->address1 }} {{ $transaction->address2 }} {{ $transaction->address3 }} {{ $transaction->provinces }} {{ $transaction->zipcode }}
                            </dd>
                            <dt class="PromptRegular16">หมายเลขโทรศัพท์มือถือ :</dt>
                            <dd class="PromptRegular16">{{ $transaction->telephone }}</dd>
                        </dl>
                    </div>
                    <div class="col-md-4">
                        <dl class="dl-horizontal">
                            <dt class="PromptRegular16">หน่วยงาน :</dt>
                            <dd class="PromptRegular16">{{ $transaction->agency_name }}</dd>
                            <dt class="PromptRegular16">เลขที่สัญญา :</dt>
                            <dd class="PromptRegular16">{{ $transaction->contact_account }}</dd>
                            <dt class="PromptRegular16">หมายเลขเครื่องวัด :</dt>
                            <dd class="PromptRegular16">{{ $transaction->meter_number }}</dd>
                            <dt class="PromptRegular16">สถานะการลงทะเบียน :</dt>
                            <dd class="PromptRegular16">
                                {{-- ตรวจสอบเงื่อนไขสถานะการลงทะเบียน --}}
                                @if($transaction->status_action =='A')
                                สมัครใหม่ ({{ $transaction->status_action }})
                                @elseif($customer->status_action =='C')
                                เปลี่ยนแปลง ({{ $transaction->status_action }})
                                @else
                                ยกเลิก ({{ $transaction->status_action }})
                                @endif
                            </dd>
                            <dt class="PromptRegular16">สถานะตรวจสอบกับหน่วยงานพันธมิตร :</dt>
                            <dd class="PromptRegular16">
                                {{-- ตรวจสอบเงื่อนไขสถานะตรวจสอบกับหน่วยงานพันธมิตร --}}
                                @if($transaction->status_agency =='0')
                                สำเร็จ ({{ $transaction->status_agency }})
                                @elseif($transaction->status_agency =='1')
                                ไม่สำเร็จ ({{ $transaction->status_agency }})
                                @else
                                รอส่งตรวจสอบ ({{ $transaction->status_agency }})
                                @endif
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary PromptRegular16" data-dismiss="modal"><i class="far fa-window-close"></i> ปิด</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Modal Edit -->
@foreach($recurring_transaction as $key => $transaction)
<div class="modal fade" id="edit{{ $transaction->recurring_transaction_id }}" tabindex="-1" role="dialog" aria-labelledby="ModalEdit" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title PromptRegular20" id="ModalEdit"><i class="far fa-credit-card"></i> เลขที่บัตรเครดิต :
                      {{ substr(Crypt::decryptString($transaction->card_number), 0, 4) }}
                    - {{ substr(Crypt::decryptString($transaction->card_number), 4, 4) }}
                    - {{ substr(Crypt::decryptString($transaction->card_number), 8, 4) }}
                    - {{ substr(Crypt::decryptString($transaction->card_number), 12, 4) }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('customer.update_transaction',Crypt::encryptString($transaction->recurring_transaction_id)) }}"> 
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <dl class="dl-horizontal">
                                <dt class="PromptRegular16">หมายเลขบัตรเครดิต : <span style="color:red;">*</span></dt>
                                <dd class="PromptRegular16">
                                    <div class="form-group row">                
                                        <div class="col-md-2">
                                            <input id="card_number1" type="text" class="form-control{{ $errors->has('card_number1') ? ' is-invalid' : '' }}" name="card_number1" value="{{ old('card_number1',substr(Crypt::decryptString($transaction->card_number), 0, 4)) }}" maxlength="4" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" autofocus>
                                            
                                            @if ($errors->has('card_number1'))
                                                <span class="invalid-feedback PromptRegular16">
                                                    {{ $errors->first('card_number1') }}
                                                </span>
                                            @endif
                                        </div>
                                        -
                                        <div class="col-md-2">
                                            <input id="card_number2" type="text" class="form-control{{ $errors->has('card_number2') ? ' is-invalid' : '' }}" name="card_number2" value="{{ old('card_number2',substr(Crypt::decryptString($transaction->card_number), 4, 4)) }}" maxlength="4" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" autofocus>
                                            
                                            @if ($errors->has('card_number2'))
                                                <span class="invalid-feedback PromptRegular16">
                                                    {{ $errors->first('card_number2') }}
                                                </span>
                                            @endif
                                        </div>
                                        -
                                        <div class="col-md-2">
                                            <input id="card_number3" type="text" class="form-control{{ $errors->has('card_number3') ? ' is-invalid' : '' }}" name="card_number3" value="{{ old('card_number3',substr(Crypt::decryptString($transaction->card_number), 8, 4)) }}" maxlength="4" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" autofocus>
                                            
                                            @if ($errors->has('card_number3'))
                                                <span class="invalid-feedback PromptRegular16">
                                                    {{ $errors->first('card_number3') }}
                                                </span>
                                            @endif
                                        </div>
                                        -
                                        <div class="col-md-2">
                                            <input id="card_number4" type="text" class="form-control{{ $errors->has('card_number4') ? ' is-invalid' : '' }}" name="card_number4" value="{{ old('card_number4',substr(Crypt::decryptString($transaction->card_number), 12, 4)) }}" maxlength="4" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" autofocus>
                                            
                                            @if ($errors->has('card_number4'))
                                                <span class="invalid-feedback PromptRegular16">
                                                    {{ $errors->first('card_number4') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </dd>
                            </dl>
                        </div>
                        
                        <div class="col-md-6">
                            <dl class="dl-horizontal">
                                <dt class="PromptRegular16">วันที่สมัคร (วัน/เดือน/ปี ค.ศ.) : <span style="color:red;">*</span></dt>
                                <dd class="PromptRegular16">
                                    <div class="col-md-12">
                                        <input class="form-control{{ $errors->has('applydate_01') ? ' is-invalid' : '' }}" type="date" id="applydate_01" name="applydate_01" value="{{ old('applydate_01',$transaction->apply_date) }}" autofocus>
                                        
                                        @if ($errors->has('applydate_01'))
                                            <span class="invalid-feedback PromptRegular16">
                                                {{ $errors->first('applydate_01') }}
                                            </span>
                                        @endif
                                    </div>
                                </dd>
                                <dt class="PromptRegular16">ประเภทรายการชำระ : </dt>
                                <dd class="PromptRegular16">{{ $transaction->name_type }}</dd>
                                <dt class="PromptRegular16">สถานะระบบ : </dt>
                                <dd>{{-- ตรวจสอบสถานะของระบบ --}}
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
                                </dd>
                                <dt class="PromptRegular16">ที่อยู่ : </dt>
                                <dd class="PromptRegular16">
                                    {{ $transaction->address1 }} {{ $transaction->address2 }} {{ $transaction->address3 }} {{ $transaction->provinces }} {{ $transaction->zipcode }}
                                </dd>
                                <dt class="PromptRegular16">หมายเลขโทรศัพท์มือถือ : </dt>
                                <dd class="PromptRegular16">{{ $transaction->telephone }}</dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl class="dl-horizontal">
                                <dt class="PromptRegular16">หน่วยงาน  : <span style="color:red;">*</span></dt>
                                <dd class="PromptRegular16">
                                    <div class="col-md-12">
                                        <select id="agency_id" name="agency_id" class="custom-select{{ $errors->has('agency_id_01') ? ' is-invalid' : '' }}" autofocus>
                                            <option value=null selected disabled hidden>กรุณาเลือกหน่วยงาน</option>
                                            @foreach($get_agencys as $agency)
                                            <option value="{{ $agency->id }}" {{ old('agency_id',$transaction->agency_id) == $agency->id ? "selected":"" }}> {{ $agency->agency_name }}</option>
                                            @endforeach
                                        </select>
        
                                        @if ($errors->has('agency_id'))
                                            <span class="invalid-feedback PromptRegular16">
                                                {{ $errors->first('agency_id') }}
                                            </span>
                                        @endif
                                    </div>
                                </dd>
                                <dt class="PromptRegular16">เลขที่สัญญา : <span style="color:red;">*</span></dt>
                                <dd class="PromptRegular16">
                                    <div class="col-md-12">
                                        <input id="contact_account" type="text" class="form-control{{ $errors->has('contact_account') ? ' is-invalid' : '' }}" name="contact_account" value="{{ old('contact_account',$transaction->contact_account) }}" maxlength="9" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" autofocus>
                                    
                                        @if ($errors->has('contact_account'))
                                            <span class="invalid-feedback PromptRegular16">
                                                {{ $errors->first('contact_account') }}
                                            </span>
                                        @endif
                                    </div>
                                </dd>
                                <dt class="PromptRegular16">หมายเลขเครื่องวัด : <span style="color:red;">*</span></dt>
                                <dd class="PromptRegular16">
                                    <div class="col-md-12">
                                        <input id="meter_number" type="text" class="form-control{{ $errors->has('meter_number') ? ' is-invalid' : '' }}" name="meter_number" value="{{ old('meter_number',$transaction->meter_number) }}" maxlength="8" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" autofocus>
                                    
                                        @if ($errors->has('meter_number'))
                                            <span class="invalid-feedback PromptRegular16">
                                                {{ $errors->first('meter_number') }}
                                            </span>
                                        @endif
                                    </div>
                                </dd>
                                <dt class="PromptRegular16">สถานะการลงทะเบียน :</dt>
                                <dd class="PromptRegular16">
                                    {{-- ตรวจสอบเงื่อนไขสถานะการลงทะเบียน --}}
                                    @if($transaction->status_action =='A')
                                    สมัครใหม่ ({{ $transaction->status_action }})
                                    @elseif($customer->status_action =='C')
                                    เปลี่ยนแปลง ({{ $transaction->status_action }})
                                    @else
                                    ยกเลิก ({{ $transaction->status_action }})
                                    @endif
                                </dd>
                                <dt class="PromptRegular16">สถานะตรวจสอบกับหน่วยงานพันธมิตร :</dt>
                                <dd class="PromptRegular16">
                                    {{-- ตรวจสอบเงื่อนไขสถานะตรวจสอบกับหน่วยงานพันธมิตร --}}
                                    @if($transaction->status_agency =='0')
                                    สำเร็จ ({{ $transaction->status_agency }})
                                    @elseif($transaction->status_agency =='1')
                                    ไม่สำเร็จ ({{ $transaction->status_agency }})
                                    @else
                                    รอส่งตรวจสอบ ({{ $transaction->status_agency }})
                                    @endif
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary PromptRegular16"><i class="far fa-save"></i> บันทึกข้อมูล</button>
                    <button type="button" class="btn btn-secondary PromptRegular16" data-dismiss="modal"><i class="far fa-door-closed"></i> ปิด</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach


@endsection

{{--  ่java scripts  --}}
@push('scripts')
<script>
    $('#ModalView').on('shown.bs.modal', function () {
        // $('#myInput').trigger('focus')
    })
    $('#ModalEdit').on('shown.bs.modal', function () {
        // $('#myInput').trigger('focus')
    })
</script>
@endpush
