@extends('admin.layouts.base')

@section('content')
    
    <div class="row text-center">
        <div class="col-sm-12 col-lg-12">
            <a href="{{ route('admin.products.create') }}" class="widget widget-hover-effect2">
                <div class="widget-extra themed-background">
                    <h4 class="widget-content-light">
                        <strong>Add New</strong>
                        Product
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
                <strong>Products</strong>
            </h2>
        </div>
        <div class="alert alert-info alert-dismissable product-empty {{$products->count() == 0 ? '' : 'johnCena' }}">
            <i class="fa fa-info-circle"></i> No Products found.
        </div>
        <div class="table-responsive {{$products->count() == 0 ? 'johnCena' : '' }}">
            <table id="products-table" class="table table-bordered table-striped table-vcenter">
                <thead>
                <tr role="row">
                    <th class="text-center">
                        ID
                    </th>
                    <th class="text-center">
                        Background Image
                    </th>
                    <th class="text-left">
                        Content
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
                @foreach($products as $product)
                    <tr data-product-id="{{$product->id}}">
                        <td class="text-center"><strong>{{ $product->id }}</strong></td>
                        <td class="text-center">
                            {{--<a href="{{ asset($product->image) }}" class="zoom img-thumbnail" style="cursor: default !important;" data-toggle="lightbox-image">--}}
                            <img src="{{ asset($product->image) }}" alt="{{ asset($product->image) }}"
                                 class="img-responsive img-thumbnail center-block" style="max-width: 100px;">
                            {{--</a>--}}
                        </td>
                        <td class="text-left">{!! str_limit($product->title, 50) !!}</td>
                        <td class="text-center">{{ $product->created_at->format('F d, Y') }}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-xs">                              
                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                   data-toggle="tooltip"
                                   title=""
                                   class="btn btn-default"
                                   data-original-title="Edit"><i class="fa fa-pencil"></i>
                               </a>                               
                                <a href="javascript:void(0)" data-toggle="tooltip"
                                   title=""
                                   class="btn btn-xs btn-danger delete-product-btn"
                                   data-original-title="Delete"
                                   data-product-id="{{ $product->id }}"
                                   data-product-route="{{ route('admin.products.delete', $product->id) }}">
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
    <script type="text/javascript" src="{{ asset('public/js/libraries/products.js') }}"></script>
@endpush