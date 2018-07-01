@extends('layouts.app')

{{--  CSS styles  --}}
@push('styles')
    
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="container card-header">
                    <div class="row">
                        <div class="col order-first PromptRegular20">
                            <i class="far fa-times-circle"></i> ไม่สามารถทำรายการได้ 
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive-md PromptRegular16">
                    <div class="form-group row">
                        <label for="error" class="col-md-12 col-form-label text-md-center PromptMedium52" style="color:red;">{{ __('...อยู่ระหว่างการพัฒนาระบบ') }}</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{--  ่java scripts  --}}
@push('scripts')

@endpush
