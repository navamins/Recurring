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
                            <i class="fas fa-search"></i> ค้นหาข้อมูลลูกค้า 
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive-md PromptRegular16">
                    <form method="post" action="{{-- route('register.verify_id_card') --}}"> 
                        @csrf
                        <input type="hidden" name="search" value="search">
                        <div class="form-group row">
                            <label for="search_type" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('ค้นหาตามประเภทของข้อมูล :') }} <span style="color:red;">*</span></label>

                            <div class="col-md-6">
                                <select id="search_type" name="search_type" class="custom-select{{ $errors->has('search_type') ? ' is-invalid' : '' }}" autofocus>
                                    <option value=null selected disabled hidden>กรุณาเลือกประเภทการค้นหาข้อมูล</option>
                                    <option value="name_lastname" {{ old('recurring_type',$input_type) == 'name_lastname' ? "selected":"" }} > ชื่อ - นามสกุล</option>
                                    <option value="id_card" {{ old('recurring_type',$input_type) == 'id_card' ? "selected":"" }} > หมายเลขบัตรประชาชน</option>
                                </select>

                                @if ($errors->has('search_type'))
                                    <span class="invalid-feedback PromptRegular16">
                                        {{ $errors->first('search_type') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="search_value" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('คำค้นหาข้อมูล :') }} <span style="color:red;">*</span></label>

                            <div class="col-md-6">
                                <input id="search_value" type="text" class="form-control{{ $errors->has('search_value') ? ' is-invalid' : '' }}" name="search_value" value="{{ old('search_value',$input_value) }}" autofocus>

                                @if ($errors->has('search_value'))
                                    <span class="invalid-feedback PromptRegular16">
                                        {{ $errors->first('search_value') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary PromptRegular16">
                                    <i class="fas fa-search"></i> {{ __('ค้นหาข้อมูล') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <br>

            <div class="card">
                <div class="container card-header">
                    <div class="row">
                        <div class="col order-last PromptRegular16">
                            <div class="float-right float-md-right">
                                
                            </div>
                        </div>
                        <div class="col order-first PromptRegular20">
                            <i class="fas fa-table"></i> แสดงผลการค้นหาข้อมูลลูกค้า
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive-md PromptRegular16">
                    <table id="customer" class="table table-condensed table-hover responsive display nowrap" style="width:100%">
                        <thead>
                            <tr class="table-active">
                                <th scope="col">#</th>
                                <th scope="col" class="text-center">สถานะความพร้อมใช้งาน</th>
                                <th scope="col">ชื่อ - นามสกุล</th>
                                <th scope="col" class="text-center">บัตรประชาชน</th>
                                <th scope="col">Create</th>
                                <th scope="col">Update</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customers as $key => $customer)
                            <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                                @if($customer->useflag =='Y')
                                <td class="text-center"><span class="badge badge-success">Activated</span></td>
                                @else
                                <td class="text-center"><span class="badge badge-danger">Not Activated</span></td>
                                @endif
                                <td>{{ $customer->name_title.$customer->name.' '.$customer->lastname }}</td>
                                <td class="text-center">{{ $customer->id_card }}</td>
                                <td>{{ date('d/m/Y', strtotime($customer->create_date)) }}</td>
                                <td>{{ date('d/m/Y', strtotime($customer->update_date)) }}</td>
                                <td>
                                    <a href="{{ route('customer.search_show',Crypt::encryptString($customer->id)) }}">
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
            $('#customer').DataTable({
                responsive: true
            });
        } );
    </script>
    <script type="text/javascript" src="{{ asset('DataTables/DataTables-1.10.16/js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('DataTables/Responsive-2.2.1/js/dataTables.responsive.min.js') }}"></script>
@endpush
