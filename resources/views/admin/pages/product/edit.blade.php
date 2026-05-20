@extends('admin.layouts.base')

@section('content')
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="{{ route('admin.products.index') }}">Products</a></li>
        <li><span href="javascript:void(0)">Edit Product</span></li>
    </ul>
    <div class="row">
        {{  Form::open([
            'method' => 'PUT',
            'id' => 'edit-product',
            'route' => ['admin.products.update', $product->id],
            'class' => 'form-horizontal ',
            'files' => TRUE
            ])
        }}
        <div class="col-md-12">
            <div class="block">
                <div class="block-title">
                    <h2><i class="fa fa-pencil"></i> <strong>Edit Product "{{$product->title}}"</strong></h2>
                </div>
                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="product_name">Name</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="product_name" name="title"
                               value="{{  Request::old('title') ? : $product->title }}"
                               placeholder="Enter Product title..">
                        @if($errors->has('title'))
                            <span class="help-block animation-slideDown">{{ $errors->first('title') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="product_content">Content</label>

                    <div class="col-md-9">
                    <textarea id="product_content" name="content" rows="9" class="form-control ckeditor"
                              placeholder="Enter Product content..">{!! Request::old('content') ? : $product->content !!}</textarea>
                        @if($errors->has('content'))
                            <span class="help-block animation-slideDown">{{ $errors->first('content') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('product_categories') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="product_categories">Assign product_categories</label>
                    <div class="col-md-9">
                        {!! Form::open() !!}
                        {!! Form::select('id', $product_categories, $category_per_product->product_category_id, ['class' => 'form-control']) !!}
                        {!! Form::close() !!}
                        <span class="help-block animation-slideDown">{{ $errors->first('product_categories') }}</span>                  
                    </div>
                </div>
                <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="image">Background Image</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <label class="input-group-btn">
                                <span class="btn btn-primary">
                                    Choose File <input type="file" name="image" style="display: none;">
                                </span>
                            </label>
                            <input type="text" class="form-control" readonly>
                        </div>
                        @if($errors->has('image'))
                            <span class="help-block animation-slideDown">{{ $errors->first('image') }}</span>
                        @endif
                    </div>
                    <div class="col-md-offset-3 col-md-9">
                        <a href="{{ asset($product->image) }}" class="zoom img-thumbnail" style="cursor: default !important;" data-toggle="lightbox-image">
                            <img src="{{ $product->image != '' ? asset($product->image) : '' }}"
                                 alt="{{ $product->image != '' ? asset($product->image) : '' }}"
                                 class="img-responsive center-block" style="max-width: 100px;">
                        </a>
                        <br>
                        <a href="javascript:void(0)" class="btn btn-xs btn-danger remove-image-btn"
                           style="display: {{ $product->image != '' ? '' : 'none' }};"><i class="fa fa-trash"></i> Remove</a>
                        <input type="hidden" name="remove_background_image" class="remove-image" value="0">
                    </div>
                </div>
                <div class="form-group form-actions">
                    <div class="col-md-9 col-md-offset-3">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-warning">Cancel</a>
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
<script type="text/javascript" src="{{ asset('public/js/libraries/products.js') }}"></script>
@endpush