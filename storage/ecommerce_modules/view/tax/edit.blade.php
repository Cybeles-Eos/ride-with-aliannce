@extends('admin.layouts.base')

@section('content')
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="{{ route('admin.taxes.index') }}">Taxes</a></li>
        <li><span href="javascript:void(0)">Edit Tax</span></li>
    </ul>
    <div class="row">
        {{  Form::open([
            'method' => 'PUT',
            'id' => 'edit-tax',
            'route' => ['admin.taxes.update', $state->id],
            'class' => 'form-horizontal ',
            'files' => TRUE
            ])
        }}
        <div class="col-md-12">
            <div class="block">
                <div class="block-title">
                    <h2><i class="fa fa-pencil"></i> <strong>Edit Tax "{{$state->name}}"</strong></h2>
                </div>
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="tax_name">Name</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="tax_name" name="name"
                               value="{{  Request::old('name') ? : $state->name }}"
                               placeholder="Enter name.." readonly>
                        @if($errors->has('name'))
                            <span class="help-block animation-slideDown">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('tax') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="tax_tax">Tax</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control input-numeric" id="tax_tax" name="tax"
                               value="{{  Request::old('tax') ? : $state->tax }}"
                               placeholder="0.0000">
                        @if($errors->has('tax'))
                            <span class="help-block animation-slideDown">{{ $errors->first('tax') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group form-actions">
                    <div class="col-md-9 col-md-offset-3">
                        <a href="{{ route('admin.taxes.index') }}" class="btn btn-sm btn-warning">Cancel</a>
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
    <script type="text/javascript" src="{{ asset('public/js/libraries/taxes.js') }}"></script>
@endpush