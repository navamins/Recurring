@extends('layouts.app')

{{--  CSS styles  --}}
@push('styles')
    
@endpush

@section('content')
<div class="container">
    <form method="POST" action="{{-- route('register.store') --}}"> 
        @csrf
        <input type="hidden" name="check_unique[id]" value="{{-- $id --}}">
        <div class="row justify-content-center">
            <div class="col-md-12">

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
                            {{-- <div class="col">
                                Second, but unordered
                            </div> --}}
                            <div class="col order-first PromptRegular20">
                                <i class="fas fa-edit"></i> แก้ไขข้อมูลผู้ลงทะเบียนชำระค่าสาธารณูปโภค
                            </div>
                        </div>
                    </div>

                    <div class="card-body table-responsive-md PromptRegular16">
                        
                        <div class="form-group row">
                            <label for="name_title_id" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('คำนำหน้าชื่อ :') }} <span style="color:red;">*</span></label>

                            <div class="col-md-6">
                                <select id="name_title_id" name="name_title_id" class="custom-select{{ $errors->has('name_title_id') ? ' is-invalid' : '' }}" autofocus>
                                    <option value=null selected disabled hidden>กรุณาเลือกคำนำหน้าชื่อ</option>
                                    @foreach($name_title as $title)
                                <option value="{{ $title->id }}" {{ old('name_title_id',$customers->name_title_id) == $title->id ? "selected":"" }}> {{ $title->name_title }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('name_title_id'))
                                    <span class="invalid-feedback PromptRegular16">
                                        {{ $errors->first('name_title_id') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name_lastname" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('ชื่อ - นามสกุล (ระบุเป็นภาษาไทยเท่านั้น) :') }} <span style="color:red;">*</span></label>

                            <div class="col-md-3">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name',$customers->name) }}" autofocus>
                                
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback PromptRegular16">
                                        {{ $errors->first('name') }}
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-3">
                                <input id="lastname" type="text" class="form-control{{ $errors->has('lastname') ? ' is-invalid' : '' }}" name="lastname" value="{{ old('lastname',$customers->lastname) }}" pattern="^[ก-๙]+$" autofocus>
                                
                                @if ($errors->has('lastname'))
                                    <span class="invalid-feedback PromptRegular16">
                                        {{ $errors->first('lastname') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_card" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('หมายเลขบัตรประชาชน 13 หลัก :') }} <span style="color:red;">*</span></label>

                            <div class="col-md-6">
                                <input id="id_card" type="text" class="form-control{{ $errors->has('id_card') ? ' is-invalid' : '' }}" name="id_card" value="{{ old('id_card',$customers->id_card) }}" maxlength="13" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" autofocus>

                                @if ($errors->has('id_card'))
                                    <span class="invalid-feedback PromptRegular16">
                                        {{ $errors->first('id_card') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('ที่อยู่ :') }} <span style="color:red;">*</span></label>

                            <div class="col-md-6">
                                    <textarea id="address" type="text" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" rows="6" autofocus>{{ old('address',$customers->address) }}</textarea>

                                @if ($errors->has('address'))
                                    <span class="invalid-feedback PromptRegular16">
                                        {{ $errors->first('address') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="provinces" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('จังหวัด :') }} <span style="color:red;">*</span></label>

                            <div class="col-md-6">
                                <select id="provinces" name="provinces" class="custom-select{{ $errors->has('provinces') ? ' is-invalid' : '' }}" autofocus>
                                    <option value=null selected disabled hidden>กรุณาเลือกจังหวัด</option>
                                    @foreach($get_provinces as $get_province)
                                    <option value="{{ $get_province->id }}" {{ old('provinces',$customers->provinces) == $get_province->id ? "selected":"" }}> {{ $get_province->name_th }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('provinces'))
                                    <span class="invalid-feedback PromptRegular16">
                                        {{ $errors->first('provinces') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="amphures" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('อำเภอ/เขต :') }} <span style="color:red;">*</span></label>

                            <div class="col-md-6">
                                <select id="amphures" name="amphures" class="custom-select{{ $errors->has('amphures') ? ' is-invalid' : '' }}" autofocus>
                                    <option value=null selected disabled hidden>กรุณาเลือกอำเภอ/เขต</option>
                                </select>

                                @if ($errors->has('amphures'))
                                    <span class="invalid-feedback PromptRegular16">
                                        {{ $errors->first('amphures') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="districts" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('ตำบล/แขวง :') }} <span style="color:red;">*</span></label>

                            <div class="col-md-6">
                                <select id="districts" name="districts" class="custom-select{{ $errors->has('districts') ? ' is-invalid' : '' }}" autofocus>
                                    <option value=null selected disabled hidden>กรุณาเลือกตำบล/แขวง</option>
                                </select>

                                @if ($errors->has('districts'))
                                    <span class="invalid-feedback PromptRegular16">
                                        {{ $errors->first('districts') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="zipcode" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('รหัสไปรษณีย์ :') }} <span style="color:red;">*</span></label>

                            <div class="col-md-6">
                                <input id="zipcode" type="text" class="form-control{{ $errors->has('zipcode') ? ' is-invalid' : '' }}" name="zipcode" value="{{ old('zipcode',$customers->zipcode) }}" maxlength="5" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" autofocus>

                                @if ($errors->has('zipcode'))
                                    <span class="invalid-feedback PromptRegular16">
                                        {{ $errors->first('zipcode') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="telephone" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('หมายเลขโทรศัพท์มือถือ :') }} <span style="color:red;">*</span></label>

                            <div class="col-md-6">
                                <input id="telephone" type="text" class="form-control{{ $errors->has('telephone') ? ' is-invalid' : '' }}" name="telephone" value="{{ old('telephone',$customers->telephone) }}" maxlength="10" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" autofocus>

                                @if ($errors->has('telephone'))
                                    <span class="invalid-feedback PromptRegular16">
                                        {{ $errors->first('telephone') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0" id="btn_save">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary PromptRegular16">
                                    <i class="far fa-save"></i> {{ __('บันทึกข้อมูล') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </form>
</div>
@endsection

{{--  ่java scripts  --}}
@push('scripts')
<script src="{{ asset('bootstrap-4.0.0/assets/js/vendor/popper.min.js') }}"></script>
<script src="{{ asset('bootstrap-4.0.0/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('bootstrap-4.0.0/assets/js/vendor/holder.min.js') }}"></script>

{{-- <script>
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function(){
        var provinces_id = $('#provinces').val();
        //ajax
        $.get('verify/ajax-amphures/' + provinces_id, function(data){
            $.each(data, function(index, get_amphures){
                if(get_amphures.id == {{ $amphures_id }}){
                    $('#amphures').append('<option value ="'+ get_amphures.id +'" selected>'+ get_amphures.name_th +'</option>');
                }else if({{ $amphures_id }} == 0){
                    $('#amphures').append('<option value ="'+ get_amphures.id +'" >'+ get_amphures.name_th +'</option>');
                }else{
                    $('#amphures').append('<option value ="'+ get_amphures.id +'" >'+ get_amphures.name_th +'</option>');
                }
            });
        });

        var amphures_input_id = {{ $amphures_id }};
        //ajax
        $.get('verify/ajax-districts/' + amphures_input_id, function(data){
            $.each(data, function(index, get_districts){
                if(get_districts.id == {{ $districts_id }}){
                    $('#districts').append('<option value ="'+ get_districts.id +'" selected>'+ get_districts.name_th +'</option>');
                    $('#zipcode').val(get_districts.zip_code);
                }else{
                    $('#amphures').append('<option value ="'+ get_districts.id +'" >'+ get_districts.name_th +'</option>');
                }
            });
        });
    });

    $('#provinces').on('change', function(e){
        var provinces_id = e.target.value;
        //ajax
        $.get('verify/ajax-amphures/' + provinces_id, function(data){
            $('#amphures').empty();
            $('#amphures').append('<option value=null selected disabled hidden> กรุณาเลือกอำเภอ/เขต </option>');

            $('#districts').empty();
            $('#districts').append('<option value=null selected disabled hidden> กรุณาเลือกตำบล/แขวง </option>');
            $('#zipcode').val('');

            $.each(data, function(index, get_amphures){
                $('#amphures').append('<option value ="'+ get_amphures.id +'">'+get_amphures.name_th+'</option>');
            });
        });
    });

    $('#amphures').on('change', function(e){
        var amphures_id = e.target.value;
        //ajax
        $.get('verify/ajax-districts/' + amphures_id, function(data){
            $('#districts').empty();
            $('#districts').append('<option value=null selected disabled hidden> กรุณาเลือกตำบล/แขวง </option>');
            $('#zipcode').val('');

            $.each(data, function(index, get_districts){
                $('#districts').append('<option value=null selected disabled hidden> กรุณาเลือกตำบล/แขวง </option>');
                $('#districts').append('<option value ="'+ get_districts.id +'">'+ get_districts.name_th +'</option>');
            });
        });
    });

    $('#districts').on('change', function(e){
        $('#zipcode').val('');
        var districts_id = e.target.value;
        //ajax
        $.get('verify/ajax-zipcode/' + districts_id, function(data){
            $.each(data, function(index, get_zipcode){
                $('#zipcode').val(get_zipcode.zip_code);
            });
        });
    });
</script> --}}
@endpush