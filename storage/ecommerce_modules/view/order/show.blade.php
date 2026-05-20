@extends('admin.layouts.base')

@section('content')
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="{{ route('admin.orders.index') }}">Orders</a></li>
        <li><span href="javascript:void(0)">View Order</span></li>
    </ul>
    <div class="row text-center">
        <div class="col-sm-3 col-lg-3">
            <div class="widget">
                <div class="widget-extra themed-background-success">
                    <h4 class="widget-content-light"><strong>Reference No</strong></h4>
                </div>
                <div class="widget-extra-full"><span
                            class="h2 text-success animation-expandOpen">{{ $order->reference_no }}</span></div>
            </div>
        </div>
        <div class="col-sm-3 col-lg-3">
            <div class="widget">
                <div class="widget-extra themed-background-muted">
                    <h4 class="widget-content-light"><strong>Date</strong></h4>
                </div>
                <div class="widget-extra-full"><span
                            class="h2 text-muted animation-expandOpen">{{ $order->created_at->format('F d, Y h:i A') }}</span>
                </div>
            </div>
        </div>
        <div class="col-sm-3 col-lg-3">
            <div class="widget">
                <div class="widget-extra themed-background-muted">
                    <h4 class="widget-content-light"><strong>Total</strong></h4>
                </div>
                <div class="widget-extra-full"><span
                            class="h2 text-muted animation-expandOpen">$ {{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
        </div>
        <div class="col-sm-3 col-lg-3">
            <div class="widget">
                <div class="widget-extra themed-background-muted">
                    <h4 class="widget-content-light"><strong>Status</strong>
                        <div class="widget-options pull-right">
                            <div class="btn-group btn-group-sm">
                                <a href="javascript:void(0)" class="btn btn-sm btn-default" title=""
                                   data-original-title="Update Status" data-toggle="modal"
                                   data-target="#update-status-modal"><span class="fa fa-pencil"></span></a>
                            </div>
                        </div>
                    </h4>
                </div>
                <div class="widget-extra-full"><span
                            class="h2 text-muted animation-expandOpen">{{ !empty($order->status) ? $order->status->name : '' }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="block">
                <div class="block-title">
                    <h2><i class="fa fa-credit-card"></i>
                        <strong>
                            Billing Information
                        </strong>
                    </h2>
                </div>
                <table class="table table-borderless table-striped table-vcenter">
                    <tbody>
                    <tr>
                        <td style="width: 30%" class="text-right"><strong>To</strong></td>
                        <td style="width: 70%">{{ !empty($order->billing_address) ? $order->billing_address->first_name . ' ' . $order->billing_address->last_name : '' }}</td>
                    </tr>
                    <tr>
                        <td style="width: 30%" class="text-right"><strong>Address</strong></td>
                        <td style="width: 70%">{{ !empty($order->billing_address) ? $order->billing_address->address . ' ' . $order->billing_address->address_2 . ' ' . $order->billing_address->city . ' ' . $order->billing_address->state . ' ' . $order->billing_address->postal . ' ' . $order->billing_address->country : '' }}</td>
                    </tr>
                    <tr>
                        <td style="width: 30%" class="text-right"><strong>Email</strong></td>
                        <td style="width: 70%">{{ !empty($order->billing_address) ? $order->billing_address->email : '' }}</td>
                    </tr>
                    <tr>
                        <td style="width: 30%" class="text-right"><strong>Company</strong></td>
                        <td style="width: 70%">{{ !empty($order->billing_address) ? $order->billing_address->company : '' }}</td>
                    </tr>
                    <tr>
                        <td style="width: 30%" class="text-right"><strong>Phone</strong></td>
                        <td style="width: 70%">{{ !empty($order->billing_address) ? $order->billing_address->phone : '' }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="block">
                <div class="block-title">
                    <h2><i class="fa fa-map-marker"></i>
                        <strong>
                            Shipping Information
                        </strong>
                    </h2>
                </div>
                <table class="table table-borderless table-striped table-vcenter">
                    <tbody>
                    <tr>
                        <td style="width: 30%" class="text-right"><strong>To</strong></td>
                        <td style="width: 70%">{{ !empty($order->shipping_address) ? $order->shipping_address->first_name . ' ' . $order->shipping_address->last_name : '' }}</td>
                    </tr>
                    <tr>
                        <td style="width: 30%" class="text-right"><strong>Address</strong></td>
                        <td style="width: 70%">{{ !empty($order->shipping_address) ? $order->shipping_address->address . ' ' . $order->shipping_address->address_2 . ' ' . $order->shipping_address->city . ' ' . $order->shipping_address->state . ' ' . $order->shipping_address->postal . ' ' . $order->shipping_address->country : '' }}</td>
                    </tr>
                    <tr>
                        <td style="width: 30%" class="text-right"><strong>Email</strong></td>
                        <td style="width: 70%">{{ !empty($order->shipping_address) ? $order->shipping_address->email : '' }}</td>
                    </tr>
                    <tr>
                        <td style="width: 30%" class="text-right"><strong>Company</strong></td>
                        <td style="width: 70%">{{ !empty($order->shipping_address) ? $order->shipping_address->company : '' }}</td>
                    </tr>
                    <tr>
                        <td style="width: 30%" class="text-right"><strong>Phone</strong></td>
                        <td style="width: 70%">{{ !empty($order->shipping_address) ? $order->shipping_address->phone : '' }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="block">
                <div class="block-title">
                    <h2><i class="fa fa-bars"></i> <strong>Additional</strong> Details</h2>
                </div>
                <table class="table table-borderless table-striped table-vcenter">
                    <tbody>
                    <tr>
                        <td style="width: 30%" class="text-right"><strong>Payment Method</strong></td>
                        <td style="width: 70%">
                            {{ $order->payment_details->gateway }}
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 30%" class="text-right"><strong>Shipping Method</strong></td>
                        <td style="width: 70%">
                            {{ $order->shipping_details->shipping_method }}
                        </td>
                    </tr>
                    @if (!empty($order->coupon_details))
                        <tr>
                            <td style="width: 30%" class="text-right"><strong>Coupon Code</strong></td>
                            <td style="width: 70%">
                                {{ $order->coupon_details->coupon_code }}
                                {{ !empty($order->coupon_details->coupon) ?
                                    ($order->coupon_details->coupon->type == 1 ?
                                        '(-' . $order->coupon_details->coupon->value . '%)'
                                        : '(-$ ' . $order->coupon_details->coupon->value . ')' )
                                 : '' }}
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <td style="width: 30%" class="text-right"><strong>Notes</strong></td>
                        <td style="width: 70%">
                            {!! $order->notes !!}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="block full">
                <div class="block-title">
                    <h2><i class="fa fa-shopping-cart sidebar-nav-icon"></i>&nbsp;<strong>Products</strong></h2>
                </div>
                <div class="row">
                    <table class="table table-striped table-vcenter">
                        <thead>
                        <tr>
                            <th>
                                Product
                            </th>
                            <th>
                                Total
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (!empty($order->items))
                            @foreach($order->items as $item_key => $item)
                                <tr>
                                    <td>
                                        <b>{{ $item->name }}</b>
                                        <br>
                                        <div style="margin-left: 15px">
                                            <span>Qty: {{ $item->quantity }}</span>
                                            <br>
                                            <span>Price: $ {{ number_format($item->price, 2) }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        $ {{ number_format($item->total, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        <tr>
                            <td class="text-right">
                                <strong>Subtotal</strong>
                            </td>
                            <td>
                                $ {{ number_format($order->subtotal_amount, 2) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right">
                                <strong>Shipping</strong>
                            </td>
                            <td>
                                $ {{ number_format($order->shipping_details->total_amount, 2) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right">
                                <strong>Tax</strong>
                            </td>
                            <td>
                                $ {{ number_format($order->tax_details->total_amount, 2) }}
                            </td>
                        </tr>
                        @if (!empty($order->coupon_details))
                            <tr>
                                <td class="text-right">
                                    <strong>Discount</strong>
                                </td>
                                <td>
                                    - $ {{ number_format($order->coupon_details->total_amount, 2) }}
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td class="text-right">
                                <strong>Total</strong>
                            </td>
                            <td>
                                $ {{ number_format($order->total_amount, 2) }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="update-status-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"
         data-backdrop="static" data-keyboard="false" style="top: 100px !important">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h2 class="modal-title">Update Status</h2>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        {{  Form::open([
                            'method' => 'POST',
                            'id' => 'update-status',
                            'route' => ['admin.orders.update_status', $order->id],
                            'class' => 'form-horizontal form-bordered',
                            'files' => TRUE,
                            ])
                        }}
                        <fieldset>
                            <div class="form-group">
                                <div class="col-md-12">
                                    @if (!empty($statuses))
                                        <select name="order_status_id" class="form-control select-select2"
                                                data-width="100%" data-minimum-results-for-search="-1">
                                            @foreach($statuses as $status)
                                                <option value="{{ $status->id }}" {{ !empty($order->status) ?
                                                    ($status->id == $order->status->id ? 'selected' : '') : '' }}>{{ $status->name }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                            </div>
                        </fieldset>
                        <div class="form-group form-actions">
                            <div class="col-xs-12 text-right">
                                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancel
                                </button>
                                <button type="submit" class="btn btn-sm btn-primary">Save</button>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('extrascripts')
<script type="text/javascript" src="{{ asset('public/js/libraries/orders.js') }}"></script>
@endpush