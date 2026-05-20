@include('email.header')

<tr>
    <td bgcolor="#ffffff"
        style="padding: 10px 20px 5px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px;">
        New Order
    </td>
</tr>

<tr>
    <td bgcolor="#ffffff"
        style="padding: 10px 20px 5px 20px; color: #d84040; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px;">
        <table align="left" border="0" cellpadding="0" cellspacing="0"
               style="border-collapse: collapse; width: 50% !important;" class="content">
            <tbody>
            <tr>
                <td colspan="2" bgcolor="#ffffff"
                    style="padding: 10px 20px 5px 0px; color: #d84040; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: bold;">
                    Order <span
                            style="font-weight: bold; color: #000;">{{ $data['order_data']->reference_no }}</span>
                </td>
            </tr>
            </tbody>
        </table>
        <table align="left" border="0" cellpadding="0" cellspacing="0"
               style="border-collapse: collapse; width: 50% !important;" class="content">
            <tbody>
            <tr>
                <td colspan="2" bgcolor="#ffffff"
                    style="padding: 10px 20px 5px 0px; color: #d84040; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: bold;">
                    Order Date: <span
                            style="font-weight: bold; color: #000;">{{ $data['order_data']->created_at->format('F d, Y h:i A') }}</span>
                </td>
            </tr>
            </tbody>
        </table>
    </td>
</tr>
<tr>
    <td bgcolor="#ffffff"
        style="padding: 10px 20px 5px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: bold; width: 50px;">
        <table align="left" border="0" cellpadding="0" cellspacing="0"
               style="border-collapse: collapse; width: 50% !important;" class="content">
            <tbody>
            <tr>
                <td colspan="2" bgcolor="#ffffff"
                    style="padding: 10px 0px 5px 0px; color: #d84040; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: bold;">
                    Order Total
                </td>
            </tr>
            <tr>
                <td bgcolor="#ffffff"
                    style="padding: 10px 0px 5px 0px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: bold; width: 20%;">
                    Subtotal
                </td>
                <td bgcolor="#ffffff"
                    style="padding: 10px 0px 5px 0px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: normal; width: 80%;">
                    $ {{ number_format($data['order_data']->subtotal_amount, 2) }}
                </td>
            </tr>
            <tr>
                <td bgcolor="#ffffff"
                    style="padding: 10px 0px 5px 0px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: bold; width: 20%;">
                    Shipping
                </td>
                <td bgcolor="#ffffff"
                    style="padding: 10px 0px 5px 0px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: normal; width: 80%;">
                    $ {{ number_format($data['order_data']->shipping_details->total_amount, 2) }}
                </td>
            </tr>
                <tr>
                    <td bgcolor="#ffffff"
                        style="padding: 10px 0px 5px 0px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: bold; width: 20%;">
                    Tax
                    </td>
                    <td bgcolor="#ffffff"
                        style="padding: 10px 0px 5px 0px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: normal; width: 80%;">
                    $ {{ number_format($data['order_data']->tax_details->total_amount, 2) }}
                    </td>
                </tr>
            @if (!empty($data['order_data']->coupon_details))
            <tr>
                <td bgcolor="#ffffff"
                    style="padding: 10px 0px 5px 0px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: bold; width: 20%;">
                        Discount
                </td>
                <td bgcolor="#ffffff"
                    style="padding: 10px 0px 5px 0px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: normal; width: 80%;">
                        - $ {{ number_format($data['order_data']->coupon_details->total_amount, 2) }}
                </td>
            </tr>
            @endif
            <tr>
                <td bgcolor="#ffffff"
                    style="padding: 10px 0px 5px 0px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: bold; width: 20%;">
                    Total
                </td>
                <td bgcolor="#ffffff"
                    style="padding: 10px 0px 5px 0px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: normal; width: 80%;">
                    $ {{ number_format($data['order_data']->total_amount, 2) }}
                </td>
            </tr>
            <tr>
                <td bgcolor="#ffffff"
                    style="padding: 10px 0px 5px 0px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: bold; width: 20%;">
                    Payment Method
                </td>
                <td bgcolor="#ffffff"
                    style="padding: 10px 0px 5px 0px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: normal; width: 80%;">
                    {{ $data['order_data']->payment_details->gateway }}
                </td>
            </tr>
            <tr>
                <td bgcolor="#ffffff"
                    style="padding: 10px 0px 5px 0px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: bold; width: 20%;">
                    Shipping Method
                </td>
                <td bgcolor="#ffffff"
                    style="padding: 10px 0px 5px 0px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: normal; width: 80%;">
                    {{ $data['order_data']->shipping_details->shipping_method }}
                </td>
            </tr>
            @if (!empty($data['order_data']->coupon_details))
                <tr>
                    <td bgcolor="#ffffff"
                        style="padding: 10px 0px 5px 0px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: bold; width: 20%;">
                        Coupon Code
                    </td>
                    <td bgcolor="#ffffff"
                        style="padding: 10px 0px 5px 0px; color: #555555; font-family: Arial, sans-serif; font-size: 13px; line-height: 24px; font-weight: normal; width: 80%;">
                        {{ $data['order_data']->coupon_details->coupon_code }}
                    </td>
                </tr>
            @endif
            <tr>
                <td bgcolor="#ffffff"
                    style="padding: 10px 0px 5px 0px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: bold; width: 20%;">
                    Notes
                </td>
                <td bgcolor="#ffffff"
                    style="padding: 10px 0px 5px 0px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: normal; width: 80%;">
                    {!! $data['order_data']->notes !!}
                </td>
            </tr>
            <tr>
                <td colspan="2" bgcolor="#ffffff"
                    style="padding: 10px 0px 5px 0px; color: #d84040; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: bold;">
                    Billing Details
                </td>
            </tr>
            <tr>
                <td bgcolor="#ffffff"
                    style="padding: 10px 0px 5px 0px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: bold; width: 20%;">
                    To
                </td>
                <td bgcolor="#ffffff"
                    style="padding: 10px 0px 5px 0px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: normal; width: 80%;">
                    {{ ($data['order_data']->billing_address) ? $data['order_data']->billing_address->first_name .' '. $data['order_data']->billing_address->last_name : '' }}
                </td>
            </tr>
            <tr>
                <td bgcolor="#ffffff"
                    style="padding: 10px 0px 5px 0px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: bold; width: 20%;">
                    Company
                </td>
                <td bgcolor="#ffffff"
                    style="padding: 10px 0px 5px 0px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: normal; width: 80%;">
                    {{ ($data['order_data']->billing_address) ? $data['order_data']->billing_address->company : '' }}
                </td>
            </tr>
            <tr>
                <td bgcolor="#ffffff"
                    style="padding: 10px 0px 5px 0px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: bold; width: 20%;">
                    Address
                </td>
                <td bgcolor="#ffffff"
                    style="padding: 10px 0px 5px 0px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: normal; width: 80%;">
                    {!! ($data['order_data']->billing_address) ? $data['order_data']->billing_address->address . ' ' . $data['order_data']->billing_address->address_2 . '<br> ' . $data['order_data']->billing_address->city . ' ' . $data['order_data']->billing_address->state . ' ' . $data['order_data']->billing_address->zip . ' ' . $data['order_data']->billing_address->country : '' !!}
                </td>
            </tr>
            <tr>
                <td bgcolor="#ffffff"
                    style="padding: 10px 0px 5px 0px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: bold; width: 20%;">
                    Email
                </td>
                <td bgcolor="#ffffff"
                    style="padding: 10px 0px 5px 0px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: normal; width: 80%;">
                    {{ ($data['order_data']->billing_address) ? $data['order_data']->billing_address->email : '' }}
                </td>
            </tr>
            <tr>
                <td bgcolor="#ffffff"
                    style="padding: 10px 0px 5px 0px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: bold; width: 20%;">
                    Phone
                </td>
                <td bgcolor="#ffffff"
                    style="padding: 10px 0px 5px 0px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: normal; width: 80%;">
                    {{ ($data['order_data']->billing_address) ? $data['order_data']->billing_address->phone . ' ' . $data['order_data']->billing_address->ext : '' }}
                </td>
            </tr>
            <tr>
                <td colspan="2" bgcolor="#ffffff"
                    style="padding: 10px 0px 5px 0px; color: #d84040; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: bold;">
                    Shipping Details
                </td>
            </tr>
            <tr>
                <td bgcolor="#ffffff"
                    style="padding: 10px 0px 5px 0px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: bold; width: 20%;">
                    To
                </td>
                <td bgcolor="#ffffff"
                    style="padding: 10px 0px 5px 0px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: normal; width: 80%;">
                    {{ ($data['order_data']->shipping_address) ? $data['order_data']->shipping_address->first_name .' '. $data['order_data']->shipping_address->last_name : '' }}
                </td>
            </tr>
            <tr>
                <td bgcolor="#ffffff"
                    style="padding: 10px 0px 5px 0px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: bold; width: 20%;">
                    Company
                </td>
                <td bgcolor="#ffffff"
                    style="padding: 10px 0px 5px 0px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: normal; width: 80%;">
                    {{ ($data['order_data']->shipping_address) ? $data['order_data']->shipping_address->company : '' }}
                </td>
            </tr>
            <tr>
                <td bgcolor="#ffffff"
                    style="padding: 10px 0px 5px 0px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: bold; width: 20%;">
                    Address
                </td>
                <td bgcolor="#ffffff"
                    style="padding: 10px 0px 5px 0px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: normal; width: 80%;">
                    {!! ($data['order_data']->shipping_address) ? $data['order_data']->shipping_address->address . ' ' . $data['order_data']->shipping_address->address_2 . '<br> ' . $data['order_data']->shipping_address->city . ' ' . $data['order_data']->shipping_address->state . ' ' . $data['order_data']->shipping_address->zip . ' ' . $data['order_data']->shipping_address->country : '' !!}
                </td>
            </tr>
            <tr>
                <td bgcolor="#ffffff"
                    style="padding: 10px 0px 5px 0px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: bold; width: 20%;">
                    Email
                </td>
                <td bgcolor="#ffffff"
                    style="padding: 10px 0px 5px 0px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: normal; width: 80%;">
                    {{ ($data['order_data']->shipping_address) ? $data['order_data']->shipping_address->email : '' }}
                </td>
            </tr>
            <tr>
                <td bgcolor="#ffffff"
                    style="padding: 10px 0px 5px 0px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: bold; width: 20%;">
                    Phone
                </td>
                <td bgcolor="#ffffff"
                    style="padding: 10px 0px 5px 0px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: normal; width: 80%;">
                    {{ ($data['order_data']->shipping_address) ? $data['order_data']->shipping_address->phone . ' ' . $data['order_data']->shipping_address->ext : '' }}
                </td>
            </tr>
            </tbody>
        </table>
        <table align="left" border="0" cellpadding="0" cellspacing="0"
               style="border-collapse: collapse; width: 50% !important;" class="content">
            <tbody>
            <tr>
                <td colspan="2" bgcolor="#ffffff"
                    style="padding: 10px 0px 5px 0px; color: #d84040; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: bold;">
                    Product Information
                </td>
            </tr>
            @foreach ($data['order_data']->items as $key => $item)
                <tr>
                    <td bgcolor="#ffffff"
                        style="padding: 10px 0px 5px 0px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: bold; width: 20%;">
                        Name
                    </td>
                    <td bgcolor="#ffffff"
                        style="padding: 10px 0px 5px 0px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: normal; width: 80%;">
                        {{ $item->name }}
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#ffffff"
                        style="padding: 10px 0px 5px 0px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: bold; width: 20%;">
                        Unit
                    </td>
                    <td bgcolor="#ffffff"
                        style="padding: 10px 0px 5px 0px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: normal; width: 80%;">
                        {{ $item->product_unit }}
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#ffffff"
                        style="padding: 0px 0px 0px 15px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: bold; width: 20%;">
                        Quantity
                    </td>
                    <td bgcolor="#ffffff"
                        style="padding: 0px 0px 0px 15px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: normal; width: 80%;">
                        {{ $item->quantity }}
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#ffffff"
                        style="padding: 0px 0px 0px 15px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: bold; width: 20%;">
                        Price
                    </td>
                    <td bgcolor="#ffffff"
                        style="padding: 0px 0px 0px 15px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; font-weight: normal; width: 80%;">
                        $ {{ number_format($item->price, 2) }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </td>
</tr>

<tr>
    <td bgcolor="#ffffff"
        style="padding: 10px 20px 5px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px;">
        Thank you,
    </td>
</tr>

<tr>
    <td bgcolor="#ffffff"
        style="padding: 10px 20px 20px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px; border-bottom: 1px solid #f6f6f6;">
        {!! $seo_meta['name'] !!}
    </td>
</tr>
@include('email.footer')