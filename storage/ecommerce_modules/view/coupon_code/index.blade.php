@extends('admin.layouts.base')

@section('content')
    @if (auth()->user()->can('Create Coupon Code'))
        <div class="row text-center">
            <div class="col-sm-12 col-lg-12">
                <a href="{{ route('admin.coupon_codes.create') }}" class="widget widget-hover-effect2">
                    <div class="widget-extra themed-background">
                        <h4 class="widget-content-light">
                            <strong>Add New</strong>
                            Coupon Code
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
    @endif
    <div class="block full">
        <div class="block-title">
            <h2>
                <i class="fa fa-ticket sidebar-nav-icon"></i>
                <strong>Coupon Codes</strong>
            </h2>
        </div>
        <div class="alert alert-info alert-dismissable coupon_code-empty {{$coupon_codes->count() == 0 ? '' : 'johnCena' }}">
            <i class="fa fa-info-circle"></i> No Coupon Codes found.
        </div>
        <div class="table-responsive {{$coupon_codes->count() == 0 ? 'johnCena' : '' }}">
            <table id="coupon_codes-table" class="table table-bordered table-striped table-vcenter">
                <thead>
                <tr role="row">
                    <th class="text-center">
                        ID
                    </th>
                    <th class="text-center">
                        Code
                    </th>
                    <th class="text-left">
                        Value
                    </th>
                    <th class="text-left">
                        Type
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
                @foreach($coupon_codes as $coupon_code)
                    <tr data-coupon_code-id="{{$coupon_code->id}}">
                        <td class="text-center"><strong>{{ $coupon_code->id }}</strong></td>
                        <td class="text-center"><strong>{{ $coupon_code->code }}</strong></td>
                        <td class="text-left">{{ $coupon_code->value }}</td>
                        <td class="text-left">{{ $coupon_code->type == 1 ? 'Percentage' : 'Amount' }}</td>
                        <td class="text-center">{{ $coupon_code->created_at->format('F d, Y') }}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-xs">
                                @if (auth()->user()->can('Update Coupon Code'))
                                    <a href="{{ route('admin.coupon_codes.edit', $coupon_code->id) }}"
                                       data-toggle="tooltip"
                                       title=""
                                       class="btn btn-default"
                                       data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                                @endif
                                @if (auth()->user()->can('Delete Coupon Code'))
                                    <a href="javascript:void(0)" data-toggle="tooltip"
                                       title=""
                                       class="btn btn-xs btn-danger delete-coupon_code-btn"
                                       data-original-title="Delete"
                                       data-coupon_code-id="{{ $coupon_code->id }}"
                                       data-coupon_code-route="{{ route('admin.coupon_codes.delete', $coupon_code->id) }}">
                                        <i class="fa fa-times"></i>
                                    </a>
                                @endif
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
    <script type="text/javascript" src="{{ asset('public/js/libraries/coupon_codes.js') }}"></script>
@endpush