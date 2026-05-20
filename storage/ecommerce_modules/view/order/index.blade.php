@extends('admin.layouts.base')

@section('content')
    {{--<div class="row text-center">--}}
        {{--<div class="col-sm-12 text-center">--}}
            {{--<div href="javascript:void(0)" class="widget ">--}}
                {{--<div class="widget-extra themed-background-dark">--}}
                    {{--<h4 class="widget-content-light"><strong>Orders Total Amount</strong></h4>--}}
                {{--</div>--}}
                {{--<div class="widget-extra-full"><span class="h2 themed-color-dark animation-expandOpen">{{ (!empty($all_orders_total_amount) ? '$ ' . $all_orders_total_amount : 0) }}</span>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
    <div class="block full">
        <div class="block-title">
            <h2>
                <i class="fa fa-credit-card sidebar-nav-icon"></i>
                <strong>Orders</strong>
            </h2>
        </div>
        <div class="alert alert-info alert-dismissable order-empty {{$orders->count() == 0 ? '' : 'johnCena' }}">
            <i class="fa fa-info-circle"></i> No Orders found.
        </div>
        <div class="table-responsive {{$orders->count() == 0 ? 'johnCena' : '' }}">
            <table id="orders-table" class="table table-bordered table-striped table-vcenter">
                <thead>
                <tr role="row">
                    <th class="text-center">
                        Reference No
                    </th>
                    <th class="text-left">
                        Total Amount
                    </th>
                    <th class="text-left">
                        Order Date
                    </th>
                    <th class="text-center">
                        Order Status
                    </th>
                    <th class="text-center">
                        Action
                    </th>
                </tr>
                </thead>
                <tbody>
                {{--@foreach($orders as $order)--}}
                    {{--<tr data-order-id="{{$order->id}}">--}}
                        {{--<td class="text-center"><strong>{{ $order->reference_no }}</strong></td>--}}
                        {{--<td class="text-left">$ {{ $order->total_amount }}</td>--}}
                        {{--<td class="text-center">{{ $order->created_at->format('F d, Y h:i A') }}</td>--}}
                        {{--<td class="text-center">--}}
                            {{--<div class="btn-group btn-group-xs">--}}
                                {{--@if (auth()->user()->can('Read Order'))--}}
                                    {{--<a href="{{ route('admin.orders.show', $order->id) }}"--}}
                                       {{--data-toggle="tooltip"--}}
                                       {{--title=""--}}
                                       {{--class="btn btn-default"--}}
                                       {{--data-original-title="View"><i class="fa fa-eye"></i></a>--}}
                                {{--@endif--}}
                            {{--</div>--}}
                        {{--</td>--}}
                    {{--</tr>--}}
                {{--@endforeach--}}
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('extrascripts')
    <script type="text/javascript" src="{{ asset('public/js/libraries/orders.js') }}"></script>
@endpush