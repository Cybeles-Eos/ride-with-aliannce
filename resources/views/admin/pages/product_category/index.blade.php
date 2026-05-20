@extends('admin.layouts.base')

@section('content')
    
    <div class="row text-center">
        <div class="col-sm-12 col-lg-12">
            <a href="{{ route('admin.product_categories.create') }}" class="widget widget-hover-effect2">
                <div class="widget-extra themed-background">
                    <h4 class="widget-content-light">
                        <strong>Add New</strong>
                        Product Category
                    </h4>
                </div>
                <div class="widget-extra-full">
                    <span class="h2 text-primary animation-expandOpen">
                        <i class="fa fa-plus"></i>
                    </span>
                </div>
            </a>
        </div>
    </div>
    
    <div class="block full">
        <div class="block-title">
            <h2>
                <i class="fa fa-sliders sidebar-nav-icon"></i>
                <strong>Product Categories</strong>
            </h2>
        </div>
        <div class="alert alert-info alert-dismissable product-empty {{$product_categories->count() == 0 ? '' : 'johnCena' }}">
            <i class="fa fa-info-circle"></i> No Product Categories found.
        </div>
        <div class="table-responsive {{$product_categories->count() == 0 ? 'johnCena' : '' }}">
            <table id="products-table" class="table table-bordered table-striped table-vcenter">
                <thead>
                <tr role="row">
                    <th class="text-center">
                        IDs
                    </th>
                    <th class="text-center">
                        Title
                    </th>
                    <th class="text-center">
                        Date Created
                    </th>
                    <th class="text-center">
                        Action
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($product_categories as $product_category)
                    <tr data-product_category-id="{{$product_category->id}}">
                        <td class="text-center"><strong>{{ $product_category->id }}</strong></td>
                        <td class="text-left">{!! str_limit($product_category->title, 50) !!}</td>
                        <td class="text-center">{{ $product_category->created_at->format('F d, Y') }}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-xs">                              
                                <a href="{{ route('admin.product_categories.edit', $product_category->id) }}"
                                   data-toggle="tooltip"
                                   title=""
                                   class="btn btn-default"
                                   data-original-title="Edit"><i class="fa fa-pencil"></i>
                               </a>                               
                                <a href="javascript:void(0)" data-toggle="tooltip"
                                   title=""
                                   class="btn btn-xs btn-danger delete-product_category-btn"
                                   data-original-title="Delete"
                                   data-product_category-id="{{ $product_category->id }}"
                                   data-product_category-route="{{ route('admin.product_categories.delete', $product_category->id) }}">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('extrascripts')
    <script type="text/javascript" src="{{ asset('public/js/libraries/product_categories.js') }}"></script> 
@endpush