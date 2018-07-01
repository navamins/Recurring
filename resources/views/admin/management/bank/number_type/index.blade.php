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
                <br />
            @endif
            
            <div class="card">
                <div class="container card-header">
                    <div class="row">
                        <div class="col order-last PromptRegular16">
                            <div class="float-md-right">
                                <a href="{{ route('cardtype.create') }}">
                                    <button type="button" class="btn btn-outline-primary" ><i class="fas fa-plus-square"></i> สร้างข้อมูลบัตรเครดิต</button>
                                </a>
                            </div>
                        </div>
                        <div class="col">
                            {{-- Second, but unordered --}}
                        </div>
                        <div class="col order-first PromptRegular20">
                            <i class="far fa-credit-card"></i> รายการข้อมูลบัตรเครดิต 
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive-md PromptRegular16">
                    <table id="cardtype" class="table table-condensed table-hover responsive display nowrap" style="width:100%">
                        <thead>
                            <tr class="table-active">
                                <th scope="col">#</th>
                                <th scope="col">สถานะ</th>
                                <th scope="col">หมายเลขบัตรเครดิต</th>
                                <th scope="col">ชื่อบัตรเครดิต</th>
                                <th scope="col">ประเภทบัตรเครดิต</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cards as $key => $card)
                            <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                                @if($card->useflag =='Y')
                                <td><span class="badge badge-success">Activated</span></td>
                                @else
                                <td><span class="badge badge-danger">Not Activated</span></td>
                                @endif
                                <td>{{ substr($card->card_type_number, 0, 4) }} - {{ substr($card->card_type_number, 4, 4) }} - XXXX - XXXX</td>
                                <td>
                                    @if($card->card_type =='Visa') <i class="fab fa-cc-visa"></i> 
                                    @elseif($card->card_type =='Mastercard') <i class="fab fa-cc-mastercard"></i>
                                    @endif
                                    {{ $card->card_name }}
                                </td>
                                <td>{{ $card->card_type }}</td>
                                <td>
                                    <a href="{{ route('cardtype.show',Crypt::encryptString($card->id)) }}">
                                        <button type="button" class="btn btn-primary"><i class="fas fa-eye"></i> รายละเอียด</button>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{--  ่java scripts  --}}
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#cardtype').DataTable({
                responsive: true
            });
        } );
    </script>
    <script type="text/javascript" src="{{ asset('DataTables/DataTables-1.10.16/js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('DataTables/Responsive-2.2.1/js/dataTables.responsive.min.js') }}"></script>
@endpush
