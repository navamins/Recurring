@extends('layouts.app')

{{--  CSS styles  --}}
@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('DataTables/DataTables-1.10.16/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('DataTables/Responsive-2.2.1/css/responsive.bootstrap4.min.css') }}">
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

            @foreach($agencies as $agency)
            <div class="card">
                <div class="container card-header">
                    <div class="row">
                        <div class="col order-last PromptRegular16">
                            <div class="float-right float-md-right">
                                @if($status =='Check')
                                <form method="POST" action="{{-- route('customer.update_status') --}}">
                                    @csrf
                                    <input type="hidden" name="agency" value="{{ $agency->id }}">
                                    <button type="submit" class="btn btn-outline-primary PromptRegular16" name="status" value="{{ $status }}">
                                        <i class="fas fa-download"></i> {{ __('ส่งตรวจสอบข้อมูล Cardlink') }}
                                    </button>
                                </form>
                                @elseif($status =='Pending')
                                {{-- เงื่อนไงอื่นๆ --}}
                                @endif
                            </div>
                        </div>
                        <div class="col order-first PromptRegular20">
                        <i class="far fa-list-alt"></i> ข้อมูลลูกค้าทำรายการชำระ "{{ $agency->agency_name }}"
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive-md PromptRegular16">
                    <table id="customer" class="table table-condensed table-hover responsive display nowrap" style="width:100%">
                        <thead>
                            <tr class="table-active">
                                <th scope="col">#</th>
                                <th scope="col">สถานะระบบ</th>
                                <th scope="col">บัตรเครดิต</th>
                                <th scope="col" class="text-center">หมายเลขเครื่องวัด</th>
                                <th scope="col">สถานะ 1</th>
                                <th scope="col">สถานะ 2</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customers as $key => $customer)
                            <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                                {{-- ตรวจสอบสถานะของระบบ --}}
                                @if($customer->status_register =='Pending')
                                <td>
                                    <span class="badge badge-primary">{{ $customer->status_register }}</span>                     
                                </td>
                                @elseif($customer->status_register =='Check')
                                <td>
                                    <span class="badge badge-secondary">{{ $customer->status_register }}</span>
                                </td>
                                @elseif($customer->status_register =='Waiting for correct')
                                <td>
                                    <span class="badge badge-warning">{{ $customer->status_register }}</span>
                                </td>
                                @elseif($customer->status_register =='Waiting for reply')
                                <td>
                                    <span class="badge badge-info">{{ $customer->status_register }}</span>
                                </td>
                                @elseif($customer->status_register =='Approved')
                                <td>
                                    <span class="badge badge-success">{{ $customer->status_register }}</span>
                                </td>
                                @elseif($customer->status_register =='Rejected')
                                <td>
                                    <span class="badge badge-danger">{{ $customer->status_register }}</span>
                                </td>
                                @endif
                                <td>
                                    {{ substr(Crypt::decryptString($customer->card_number), 0, 4) }}
                                    {{ substr(Crypt::decryptString($customer->card_number), 4, 4) }}
                                    {{ substr(Crypt::decryptString($customer->card_number), 8, 4) }}
                                    {{ substr(Crypt::decryptString($customer->card_number), 12, 4) }}
                                </td>
                                <td class="text-center">{{ $customer->meter_number }}</td>
                                {{-- ตรวจสอบเงื่อนไขสถานะ 1 --}}
                                @if($customer->status_action =='A')
                                <td>สมัครใหม่</td>
                                @elseif($customer->status_action =='C')
                                <td>เปลี่ยนแปลง</td>
                                @else
                                <td>ยกเลิก</td>
                                @endif
                                {{-- ตรวจสอบสถานะ 2 --}}
                                @if($customer->status_agency =='0')
                                <td>สำเร็จ</td>
                                @elseif($customer->status_agency =='1')
                                <td>ไม่สำเร็จ</td>
                                @else
                                <td>รอส่งตรวจสอบ</td>
                                @endif
                                <td>
                                    <a href="{{ route('customer.show',[Crypt::encryptString($customer->id),$agency->id]) }}">
                                        <button type="button" class="btn btn-primary"><i class="fas fa-eye"></i> รายละเอียด</button>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

{{--  ่java scripts  --}}
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#customer').DataTable({
                responsive: true
            });
        } );
    </script>
    <script type="text/javascript" src="{{ asset('DataTables/DataTables-1.10.16/js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('DataTables/Responsive-2.2.1/js/dataTables.responsive.min.js') }}"></script>
@endpush
