@extends('admin.layouts.base')

@section('content')
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="{{ route('admin.coupon_codes.index') }}">Coupon Codes</a></li>
        <li><span href="javascript:void(0)">Add New Coupon Code</span></li>
    </ul>
    <div class="row">
        {{  Form::open([
            'method' => 'POST',
            'id' => 'create-coupon_code',
            'route' => ['admin.coupon_codes.store'],
            'class' => 'form-horizontal ',
            'files' => TRUE
            ])
        }}
        <div class="col-md-12">
            <div class="block">
                <div class="block-title">
                    <h2><i class="fa fa-pencil"></i> <strong>Add new Coupon Code</strong></h2>
                </div>
                <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="coupon_code_code">Code</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="coupon_code_code" name="code"
                               placeholder="Enter Coupon code.." value="{{ old('code') }}">
                        @if($errors->has('code'))
                            <span class="help-block animation-slideDown">{{ $errors->first('code') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="coupon_code_type">Type</label>
                    <div class="col-md-9">
                        <label class="radio-inline" for="type_1">
                            <input type="radio" id="type_1" name="type"
                                   value="1" {{ old('type') ? (old('type') == 1 ? 'checked' : '') : 'checked' }}>
                            Percentage
                        </label>
                        <label class="radio-inline" for="type_2">
                            <input type="radio" id="type_2" name="type"
                                   value="2" {{ old('type') ? (old('type') == 2 ? 'checked' : '') : '' }}> Amount
                        </label>
                        @if($errors->has('type'))
                            <span class="help-block animation-slideDown">{{ $errors->first('type') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('value') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="coupon_code_value"><span class="coupon_type"></span> Value</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control input-numeric" id="coupon_code_value" name="value"
                               placeholder="Enter Coupon Code value.." value="{{ old('value') }}">
                        @if($errors->has('value'))
                            <span class="help-block animation-slideDown">{{ $errors->first('value') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('date_start') || $errors->has('date_end') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="coupon_code_date">Date</label>
                    <div class="col-md-9">
                        <div class="input-group input-daterange" data-date-format="MM dd, yyyy" data-date-today-highlight="true">
                            <input type="text" id="date_start" name="date_start" class="form-control text-center"
                                   placeholder="From" readonly style="background-color: #fff;">
                            <span class="input-group-addon"><i class="fa fa-angle-right"></i></span>
                            <input type="text" id="date_end" name="date_end" class="form-control text-center"
                                   placeholder="To" readonly style="background-color: #fff;">
                        </div>
                        @if($errors->has('date_start') || $errors->has('date_end'))
                            <span class="help-block animation-slideDown">{{ $errors->first('date_start') }}</span>
                            <span class="help-block animation-slideDown">{{ $errors->first('date_end') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group form-actions">
                    <div class="col-md-9 col-md-offset-3">
                        <a href="{{ route('admin.coupon_codes.index') }}" class="btn btn-sm btn-warning">Cancel</a>
                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-floppy-o"></i> Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
        {{ Form::close() }}
    </div>
@endsection

@push('extrascripts')
<script type="text/javascript" src="{{ asset('public/js/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/js/libraries/coupon_codes.js') }}"></script>
@endpush