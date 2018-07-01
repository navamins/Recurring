@extends('layouts.app')

{{--  CSS styles  --}}
@push('styles')
    <style type="text/css">
        .image-wrapper {
        padding: 5px;
        /*border: 1px #ddd solid;*/
        height auto;
        width: 200px;
        }
        .image-wrapper img {
        max-height: 200%;
        max-width: 200%;
        /*max-width: 500px;*/
        }
    </style>
@endpush

@section('content')
<div class="container">
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
                        <div class="col">
                            {{-- Second, but unordered --}}
                        </div>
                        <div class="col order-first PromptRegular20">
                            <i class="fas fa-plus-square"></i> สร้างข้อมูลบัตรเครดิต
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive-md PromptRegular16">
                    <form method="POST" action="{{-- route('bank.store') --}}" enctype="multipart/form-data"> 
                        @csrf

                        <div class="form-group row">
                            <label for="card_name" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('ชื่อบัตรเครดิต :') }} <span style="color:red;">*</span></label>

                            <div class="col-md-6">
                                <input id="card_name" type="text" class="form-control{{ $errors->has('card_name') ? ' is-invalid' : '' }}" name="card_name" value="{{ old('card_name') }}" autofocus>

                                @if ($errors->has('card_name'))
                                    <span class="invalid-feedback PromptRegular16">
                                        {{ $errors->first('card_name') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="card_type_number" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('เลขที่บัตรเครดิต 8 หลัก (BIN 6 หลัก + Type) :') }} <span style="color:red;">*</span></label>

                            <div class="col-md-6">
                                <input id="card_type_number" type="text" class="form-control{{ $errors->has('card_type_number') ? ' is-invalid' : '' }} show" name="card_type_number" maxlength="8" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" value="{{ old('card_type_number') }}" autofocus>
                                <span style="color:#A9A9A9;" class="textshow" name="textshow"></span>
                                
                                @if ($errors->has('card_type_number'))
                                    <span class="invalid-feedback PromptRegular16">
                                        {{ $errors->first('card_type_number') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="card_type" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('ประเภทบัตรเครดิต :') }} <span style="color:red;">*</span></label>

                            <div class="col-md-6">
                                <select id="card_type" name="card_type" class="custom-select{{ $errors->has('card_type') ? ' is-invalid' : '' }}" autofocus>
                                    <option value=null selected disabled hidden>กรุณาเลือกประเภทบัตรเครดิต</option>
                                    <option value="Visa" {{ old('card_type') == "Visa" ? "selected":"" }}> Visa</option>
                                    <option value="Mastercard" {{ old('card_type') == "Mastercard" ? "selected":"" }}> Mastercard</option>
                                </select>

                                @if ($errors->has('card_type'))
                                    <span class="invalid-feedback PromptRegular16">
                                        {{ $errors->first('card_type') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="addImage" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('อัพโหลดรูปภาพ :') }} <span style="color:red;">*</span></label>

                            <div class="col-md-6">
                                <input id="addImage" name="addImage" type="file">

                                @if ($errors->has('addImage'))
                                    <span class="invalid-feedback PromptRegular16">
                                        {{ $errors->first('addImage') }}
                                    </span>
                                @endif

                                <div class="image-wrapper"></div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="card_detail" class="col-md-4 col-form-label text-md-right PromptMedium16">{{ __('รายละเอียด :') }} <span style="color:red;">*</span></label>

                            <div class="col-md-6">
                                    <textarea id="card_detail" type="text" class="form-control{{ $errors->has('card_detail') ? ' is-invalid' : '' }}" name="card_detail" rows="6" autofocus>{{ old('card_detail') }}</textarea>

                                @if ($errors->has('card_detail'))
                                    <span class="invalid-feedback PromptRegular16">
                                        {{ $errors->first('card_detail') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary PromptRegular16">
                                    <i class="far fa-save"></i> {{ __('บันทึกข้อมูล') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{--  ่java scripts  --}}
@push('scripts')
<script>
    $(document).on('keyup', '.show', function() {
        var number = $("#card_type_number").val();
        $('.textshow').text(" เลขที่บัตรเครดิต: " + number.slice(0, 4) + " - " + number.slice(4, 8) + " - XXXX - XXXX");
    });

    $('#addImage').on('change', function(evt) {
        var selectedImage = evt.currentTarget.files[0];
        var imageWrapper = document.querySelector('.image-wrapper');
        var theImage = document.createElement('img');
        imageWrapper.innerHTML = '';

        var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
        if (regex.test(selectedImage.name.toLowerCase())) {
            if (typeof(FileReader) != 'undefined') {
            var reader = new FileReader();
            reader.onload = function(e) {
                theImage.id = 'new-selected-image';
                theImage.src = e.target.result;
                imageWrapper.appendChild(theImage);
                }
                //
            reader.readAsDataURL(selectedImage);
            }else{
            //-- Let the user knwo they cannot peform this as browser out of date
            console.log('browser support issue');
            }
        }else{
            //-- no image so let the user knwo we need one...
            $(this).prop('value', null);
            console.log('please select and image file');
        }
    });
</script>

@endpush
