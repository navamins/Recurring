@extends('layouts.app')

{{--  CSS styles  --}}
@push('styles')

@endpush

@section('content')
<div class="container">
    @foreach($Dashboard_name as $dashboard)
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col order-first PromptRegular20">
                            <i class="fas fa-tachometer-alt"></i> สถานะรายการ "{{ $dashboard->agency_name }}"
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    {{-- ตรวจสอบ Dashborad ของไฟฟ้า --}}
                    @if($dashboard->agency_code =='METROPOLITAN ELECTRICITY')
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="card border-dark mb-3">
                            <div class="card-header text-white bg-primary PromptRegular18"><i class="far fa-list-alt"></i> Pending</div>
                                <div class="card-body text-dark">
                                    <p class="card-title PromptRegular20">สถานะ Pending</p>
                                    <p class="card-text PromptRegular16">รายการลูกค้าที่แจ้งความประสงค์สมัครใช้บริการผ่าน Call Center <span class="text-primary">จำนวน {{ $power_num_pending }} รายการ</span></p>
                                </div>
                                <div class="card-footer bg-transparent PromptRegular16 text-right">
                                    <form method="get" action="{{ route('customer.index','notall') }}">
                                        @csrf
                                        <input type="hidden" name="agency_id" value="{{ Crypt::encryptString($agency_id) }}">
                                        <input type="hidden" name="status_register" value="{{ Crypt::encryptString('Pending') }}">
                                        
                                        <button type="submit" class="btn btn-outline-primary btn-sm PromptRegular16">
                                            {{ __('รายละเอียด') }} <i class="fas fa-arrow-alt-circle-right"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="card border-dark mb-3">
                                <div class="card-header text-white bg-secondary PromptRegular18"><i class="far fa-list-alt"></i> Check</div>
                                <div class="card-body text-dark">
                                    <p class="card-title PromptRegular20">สถานะ Check</p>
                                    <p class="card-text PromptRegular16">รายการลูกค้าที่อยู่ในสถานะตรวจสอบหมายเลขบัตรเครดิต <span class="text-secondary">จำนวน {{ $power_num_check }} รายการ</span></p>
                                </div>
                                <div class="card-footer bg-transparent PromptRegular16 text-right">
                                    <form method="get" action="{{ route('customer.index','notall') }}">
                                        @csrf
                                        <input type="hidden" name="agency_id" value="{{ Crypt::encryptString($agency_id) }}">
                                        <input type="hidden" name="status_register" value="{{ Crypt::encryptString('Check') }}">
                                        
                                        <button type="submit" class="btn btn-outline-secondary btn-sm PromptRegular16">
                                            {{ __('รายละเอียด') }} <i class="fas fa-arrow-alt-circle-right"></i>
                                        </button>
                                    </form>
                                </div>                            
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="card border-dark mb-3">
                                <div class="card-header text-white bg-warning PromptRegular18"><i class="far fa-list-alt"></i> Waiting for correct</div>
                                <div class="card-body text-dark">
                                    <p class="card-title PromptRegular20">สถานะ Waiting for correct</p>
                                    <p class="card-text PromptRegular16">รายการลูกค้าที่อยู่ในสถานะติดต่อกลับ เพื่อตรวจสอบและแก้ไขข้อมูล <span class="text-warning">จำนวน {{ $power_num_waitingforcorrect }} รายการ</span></p>
                                </div>
                                <div class="card-footer bg-transparent PromptRegular16 text-right">
                                    <form method="get" action="{{ route('customer.index','notall') }}">
                                        @csrf
                                        <input type="hidden" name="agency_id" value="{{ Crypt::encryptString($agency_id) }}">
                                        <input type="hidden" name="status_register" value="{{ Crypt::encryptString('Waiting for correct') }}">
                                        
                                        <button type="submit" class="btn btn-outline-warning btn-sm PromptRegular16">
                                            {{ __('รายละเอียด') }} <i class="fas fa-arrow-alt-circle-right"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="card border-dark mb-3">
                                <div class="card-header text-white bg-info PromptRegular18"><i class="far fa-list-alt"></i> Waiting for reply</div>
                                <div class="card-body text-dark">
                                    <p class="card-title PromptRegular20">สถานะ Waiting for reply</p>
                                    <p class="card-text PromptRegular16">รายการลูกค้าที่อยู่ในสถานะจัดส่งข้อมูลให้กับ Business partner <span class="text-info">จำนวน {{ $power_num_waitingforreply }} รายการ</span></p>
                                </div>
                                <div class="card-footer bg-transparent PromptRegular16 text-right">
                                    <form method="get" action="{{ route('customer.index','notall') }}">
                                        @csrf
                                        <input type="hidden" name="agency_id" value="{{ Crypt::encryptString($agency_id) }}">
                                        <input type="hidden" name="status_register" value="{{ Crypt::encryptString('Waiting for reply') }}">
                                        
                                        <button type="submit" class="btn btn-outline-info btn-sm PromptRegular16">
                                            {{ __('รายละเอียด') }} <i class="fas fa-arrow-alt-circle-right"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="card border-dark mb-3">
                                <div class="card-header text-white bg-success PromptRegular18"><i class="far fa-list-alt"></i> Approved</div>
                                <div class="card-body text-dark">
                                    <p class="card-title PromptRegular20">สถานะ Approved</p>
                                    <p class="card-text PromptRegular16">รายการลูกค้าที่ลงทะเบียนชำระค่าสาธารณูปโภคสำเร็จ <span class="text-success">จำนวน {{ $power_num_approved }} รายการ</span></p>
                                </div>
                                <div class="card-footer bg-transparent PromptRegular16 text-right">
                                    <form method="get" action="{{ route('customer.index','notall') }}">
                                        @csrf
                                        <input type="hidden" name="agency_id" value="{{ Crypt::encryptString($agency_id) }}">
                                        <input type="hidden" name="status_register" value="{{ Crypt::encryptString('Approved') }}">
                                        
                                        <button type="submit" class="btn btn-outline-success btn-sm PromptRegular16">
                                            {{ __('รายละเอียด') }} <i class="fas fa-arrow-alt-circle-right"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="card border-dark mb-3">
                                <div class="card-header text-white bg-danger PromptRegular18"><i class="far fa-list-alt"></i> Rejected</div>
                                <div class="card-body text-dark">
                                    <p class="card-title PromptRegular20">สถานะ Rejected</p>
                                    <p class="card-text PromptRegular16">รายการลูกค้าที่ลงทะเบียนชำระค่าสาธารณูปโภคไม่สำเร็จ <span class="text-danger">จำนวน {{ $power_num_rejected }} รายการ</span></p>
                                </div>
                                <div class="card-footer bg-transparent PromptRegular16 text-right">
                                    <form method="get" action="{{ route('customer.index','notall') }}">
                                        @csrf
                                        <input type="hidden" name="agency_id" value="{{ Crypt::encryptString($agency_id) }}">
                                        <input type="hidden" name="status_register" value="{{ Crypt::encryptString('Rejected') }}">
                                        
                                        <button type="submit" class="btn btn-outline-danger btn-sm PromptRegular16">
                                            {{ __('รายละเอียด') }} <i class="fas fa-arrow-alt-circle-right"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else

                    {{-- Dashborad อื่นๆ --}}
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="card border-dark mb-3">
                            <div class="card-header text-white bg-primary PromptRegular18"><i class="far fa-list-alt"></i> Pending</div>
                                <div class="card-body text-dark">
                                    <p class="card-title PromptRegular20">สถานะ Pending</p>
                                    <p class="card-text PromptRegular16">รายการลูกค้าที่แจ้งความประสงค์สมัครใช้บริการผ่าน Call Center <span class="text-primary">จำนวน - รายการ</span></p>
                                </div>
                                <div class="card-footer bg-transparent PromptRegular16 text-right">
                                    <form method="get" action="{{ route('customer.index','notall') }}">
                                        @csrf
                                        <input type="hidden" name="agency_id" value="{{ Crypt::encryptString($agency_id) }}">
                                        <input type="hidden" name="status_register" value="{{ Crypt::encryptString('Pending') }}">
                                        
                                        <button type="submit" class="btn btn-outline-primary btn-sm PromptRegular16">
                                            {{ __('รายละเอียด') }} <i class="fas fa-arrow-alt-circle-right"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="card border-dark mb-3">
                                <div class="card-header text-white bg-secondary PromptRegular18"><i class="far fa-list-alt"></i> Check</div>
                                <div class="card-body text-dark">
                                    <p class="card-title PromptRegular20">สถานะ Check</p>
                                    <p class="card-text PromptRegular16">รายการลูกค้าที่อยู่ในสถานะตรวจสอบหมายเลขบัตรเครดิต <span class="text-secondary">จำนวน - รายการ</span></p>
                                </div>
                                <div class="card-footer bg-transparent PromptRegular16 text-right">
                                    <form method="get" action="{{ route('customer.index','notall') }}">
                                        @csrf
                                        <input type="hidden" name="agency_id" value="{{ Crypt::encryptString($agency_id) }}">
                                        <input type="hidden" name="status_register" value="{{ Crypt::encryptString('Check') }}">
                                        
                                        <button type="submit" class="btn btn-outline-secondary btn-sm PromptRegular16">
                                            {{ __('รายละเอียด') }} <i class="fas fa-arrow-alt-circle-right"></i>
                                        </button>
                                    </form>
                                </div>                            
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="card border-dark mb-3">
                                <div class="card-header text-white bg-warning PromptRegular18"><i class="far fa-list-alt"></i> Waiting for correct</div>
                                <div class="card-body text-dark">
                                    <p class="card-title PromptRegular20">สถานะ Waiting for correct</p>
                                    <p class="card-text PromptRegular16">รายการลูกค้าที่อยู่ในสถานะติดต่อกลับ เพื่อตรวจสอบและแก้ไขข้อมูล <span class="text-warning">จำนวน - รายการ</span></p>
                                </div>
                                <div class="card-footer bg-transparent PromptRegular16 text-right">
                                    <form method="get" action="{{ route('customer.index','notall') }}">
                                        @csrf
                                        <input type="hidden" name="agency_id" value="{{ Crypt::encryptString($agency_id) }}">
                                        <input type="hidden" name="status_register" value="{{ Crypt::encryptString('Waiting for correct') }}">
                                        
                                        <button type="submit" class="btn btn-outline-warning btn-sm PromptRegular16">
                                            {{ __('รายละเอียด') }} <i class="fas fa-arrow-alt-circle-right"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="card border-dark mb-3">
                                <div class="card-header text-white bg-info PromptRegular18"><i class="far fa-list-alt"></i> Waiting for reply</div>
                                <div class="card-body text-dark">
                                    <p class="card-title PromptRegular20">สถานะ Waiting for reply</p>
                                    <p class="card-text PromptRegular16">รายการลูกค้าที่อยู่ในสถานะจัดส่งข้อมูลให้กับ Business partner <span class="text-info">จำนวน - รายการ</span></p>
                                </div>
                                <div class="card-footer bg-transparent PromptRegular16 text-right">
                                    <form method="get" action="{{ route('customer.index','notall') }}">
                                        @csrf
                                        <input type="hidden" name="agency_id" value="{{ Crypt::encryptString($agency_id) }}">
                                        <input type="hidden" name="status_register" value="{{ Crypt::encryptString('Waiting for reply') }}">
                                        
                                        <button type="submit" class="btn btn-outline-info btn-sm PromptRegular16">
                                            {{ __('รายละเอียด') }} <i class="fas fa-arrow-alt-circle-right"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="card border-dark mb-3">
                                <div class="card-header text-white bg-success PromptRegular18"><i class="far fa-list-alt"></i> Approved</div>
                                <div class="card-body text-dark">
                                    <p class="card-title PromptRegular20">สถานะ Approved</p>
                                    <p class="card-text PromptRegular16">รายการลูกค้าที่ลงทะเบียนชำระค่าสาธารณูปโภคสำเร็จ <span class="text-success">จำนวน - รายการ</span></p>
                                </div>
                                <div class="card-footer bg-transparent PromptRegular16 text-right">
                                    <form method="get" action="{{ route('customer.index','notall') }}">
                                        @csrf
                                        <input type="hidden" name="agency_id" value="{{ Crypt::encryptString($agency_id) }}">
                                        <input type="hidden" name="status_register" value="{{ Crypt::encryptString('Approved') }}">
                                        
                                        <button type="submit" class="btn btn-outline-success btn-sm PromptRegular16">
                                            {{ __('รายละเอียด') }} <i class="fas fa-arrow-alt-circle-right"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="card border-dark mb-3">
                                <div class="card-header text-white bg-danger PromptRegular18"><i class="far fa-list-alt"></i> Rejected</div>
                                <div class="card-body text-dark">
                                    <p class="card-title PromptRegular20">สถานะ Rejected</p>
                                    <p class="card-text PromptRegular16">รายการลูกค้าที่ลงทะเบียนชำระค่าสาธารณูปโภคไม่สำเร็จ <span class="text-danger">จำนวน - รายการ</span></p>
                                </div>
                                <div class="card-footer bg-transparent PromptRegular16 text-right">
                                    <form method="get" action="{{ route('customer.index','notall') }}">
                                        @csrf
                                        <input type="hidden" name="agency_id" value="{{ Crypt::encryptString($agency_id) }}">
                                        <input type="hidden" name="status_register" value="{{ Crypt::encryptString('Rejected') }}">
                                        
                                        <button type="submit" class="btn btn-outline-danger btn-sm PromptRegular16">
                                            {{ __('รายละเอียด') }} <i class="fas fa-arrow-alt-circle-right"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <br>
    @endforeach
</div>
@endsection

{{--  ่java scripts  --}}
@push('scripts')

@endpush
