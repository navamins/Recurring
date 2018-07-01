@extends('layouts.app')

{{--  CSS styles  --}}
@push('styles')

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
        
            <div class="card">
                <div class="container card-header">
                    <div class="row">
                        <div class="col order-first PromptRegular20">
                            <i class="fas fa-upload"></i> อัพเดทข้อมูลจาก Cardlink แบบ Manual
                        </div>
                    </div>
                </div>
                <form method="POST" action="{{-- route('customer.store_import_cardlink') --}}" accept-charset="UTF-8" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body table-responsive-md PromptRegular16">
                        
                        <div class="form-group row">
                            <label for="import_file" class="col-md-5 col-form-label text-md-right PromptMedium16">{{ __('นำเข้าข้อมูลจากระบบ Cardlink (อัพโหลดได้เฉพาะ .txt):') }} <span style="color:red;">*</span></label>

                            <div class="col-md-4">
                                <input type="file" id='import_file' name="import_file">

                                @if ($errors->has('import_file'))
                                    <span class="invalid-feedback PromptRegular16">
                                        {{ $errors->first('import_file') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        

                        <div class="form-group row mb-0" id="btn_save_01">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary PromptRegular16">
                                    <i class="far fa-save"></i> {{ __('บันทึกข้อมูล') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

{{--  ่java scripts  --}}
@push('scripts')

@endpush
