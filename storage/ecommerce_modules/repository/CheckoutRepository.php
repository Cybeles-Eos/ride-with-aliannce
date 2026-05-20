<?php

namespace App\Repositories;

use App\Http\Traits\SystemSettingTrait;
use App\Models\Order;
use File;
use Mail;

/**
 * Class CheckoutRepository
 * @package App\Repositories
 * @author Richard Guevara
 */
class CheckoutRepository
{
    use SystemSettingTrait;

    public function processCartToOrder($checkout_data = [], $carts = [])
    {
        $order = collect([]);
        if (!empty($checkout_data) && !empty($carts)) {
            $order = $this->createOrder($checkout_data);

            $items = $this->createOrderItems($order, $carts);
            $billing_address = $this->createOrderBillingAddress($order, $checkout_data);
            $shipping_address = $this->createOrderShippingAddress($order, $checkout_data);
            $shipping_details = $this->createOrderShippingDetails($order, $checkout_data);
            $payment_details = $this->createOrderPaymentDetails($order, $checkout_data);
            $tax_details = $this->createOrderTaxDetails($order, $checkout_data);
            $coupon_details = $this->createOrderCouponDetails($order, $checkout_data);
            session()->forget('coupon_code');
            if (!in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'])) {
                $emails = $this->sendEmails($order, $items, $checkout_data);
            }

            foreach ($carts as $cart) {
                $cart->delete();
            }

        }
        return $order;
    }

    public function createOrder($checkout_data = [])
    {
        $order = Order::create([
            'user_id' => (auth()->check() ? auth()->user()->id : 0),
            'session_id' => (auth()->check() ? '' : session()->getId()),
            'reference_no' => $this->createOrderReferenceNumber(),
            'subtotal_amount' => isset($checkout_data['subtotal_total']) ? $checkout_data['subtotal_total'] : '',
            'total_amount' => isset($checkout_data['total']) ? $checkout_data['total'] : '',
            'order_status_id' => 1,
            'notes' => isset($checkout_data['notes']) ? $checkout_data['notes'] : '',
        ]);
        return $order;
    }

    public function createOrderItems($order, $carts = [])
    {
        $items = [];
        foreach ($carts as $cart) {
            $items[] = $order->items()->create([
                'name' => empty($cart->product) ? 'Custom Label' : $cart->product->name,
                'product_unit' => $cart->product_unit->name,
                'quantity' => $cart->quantity,
                'price' => $cart->price,
            ]);
        }
        return $items;
    }

    public function createOrderBillingAddress($order, $checkout_data = [])
    {
        $billing_address = [];
        $billing_address[] = $order->billing_address()->create([
            'first_name' => isset($checkout_data['billing_first_name']) ? $checkout_data['billing_first_name'] : '',
            'last_name' => isset($checkout_data['billing_last_name']) ? $checkout_data['billing_last_name'] : '',
            'email' => isset($checkout_data['billing_email']) ? $checkout_data['billing_email'] : '',
            'phone' => isset($checkout_data['billing_phone']) ? $checkout_data['billing_phone'] : '',
            'ext' => isset($checkout_data['billing_ext']) ? $checkout_data['billing_ext'] : '',
            'company' => isset($checkout_data['billing_company']) ? $checkout_data['billing_company'] : '',
            'address' => isset($checkout_data['billing_address']) ? $checkout_data['billing_address'] : '',
            'address_2' => isset($checkout_data['billing_address_2']) ? $checkout_data['billing_address_2'] : '',
            'city' => isset($checkout_data['billing_city']) ? $checkout_data['billing_city'] : '',
            'state' => isset($checkout_data['billing_state']) ? $checkout_data['billing_state'] : '',
            'zip' => isset($checkout_data['billing_zip']) ? $checkout_data['billing_zip'] : '',
            'country' => isset($checkout_data['billing_country']) ? $checkout_data['billing_country'] : '',
            'type' => 1,
        ]);
        return $billing_address;
    }

    public function createOrderShippingAddress($order, $checkout_data = [])
    {
        $shipping_address = [];
        $shipping_address[] = $order->shipping_address()->create([
            'first_name' => isset($checkout_data['shipping_first_name']) ? $checkout_data['shipping_first_name'] : '',
            'last_name' => isset($checkout_data['shipping_last_name']) ? $checkout_data['shipping_last_name'] : '',
            'email' => isset($checkout_data['shipping_email']) ? $checkout_data['shipping_email'] : '',
            'phone' => isset($checkout_data['shipping_phone']) ? $checkout_data['shipping_phone'] : '',
            'ext' => isset($checkout_data['shipping_ext']) ? $checkout_data['shipping_ext'] : '',
            'company' => isset($checkout_data['shipping_company']) ? $checkout_data['shipping_company'] : '',
            'address' => isset($checkout_data['shipping_address']) ? $checkout_data['shipping_address'] : '',
            'address_2' => isset($checkout_data['shipping_address_2']) ? $checkout_data['shipping_address_2'] : '',
            'city' => isset($checkout_data['shipping_city']) ? $checkout_data['shipping_city'] : '',
            'state' => isset($checkout_data['shipping_state']) ? $checkout_data['shipping_state'] : '',
            'zip' => isset($checkout_data['shipping_zip']) ? $checkout_data['shipping_zip'] : '',
            'country' => isset($checkout_data['shipping_country']) ? $checkout_data['shipping_country'] : '',
            'type' => 2,
        ]);
        return $shipping_address;
    }

    public function createOrderShippingDetails($order, $checkout_data = [])
    {
        $shipping_details = [];
        $shipping_details[] = $order->shipping_details()->create([
            'shipping_method' => isset($checkout_data['shipping_method']) ? $checkout_data['shipping_method'] : '',
            'reference_no' => isset($checkout_data['reference_no']) ? $checkout_data['reference_no'] : '',
            'total_amount' => isset($checkout_data['shipping_total']) ? $checkout_data['shipping_total'] : '',
        ]);
        return $shipping_details;
    }

    public function createOrderPaymentDetails($order, $checkout_data = [])
    {
        $payment_details = [];
        $payment_details[] = $order->payment_details()->create([
            'first_name' => isset($checkout_data['card_name']) ? $checkout_data['card_name'] : '',
            'last_name' => isset($checkout_data['card_name']) ? $checkout_data['card_name'] : '',
            'transaction_id' => isset($checkout_data['transaction_id']) ? $checkout_data['transaction_id'] : $order->reference_no,
            'gateway' => isset($checkout_data['payment_method']) ? $checkout_data['payment_method'] : '',
            'total_amount' => isset($checkout_data['total']) ? $checkout_data['total'] : '',
        ]);
        return $payment_details;
    }

    public function createOrderTaxDetails($order, $checkout_data = [])
    {
        $tax_details = [];
        $tax_details[] = $order->tax_details()->create([
            'tax_percentage' => isset($checkout_data['tax_percentage']) ? $checkout_data['tax_percentage'] : '',
            'total_amount' => isset($checkout_data['tax_total']) ? $checkout_data['tax_total'] : '',
        ]);
        return $tax_details;
    }

    public function createOrderCouponDetails($order, $checkout_data = [])
    {
        $coupon_details = [];
        if ($checkout_data['coupon_id']) {
            $coupon_details[] = $order->coupon_details()->create([
                'coupon_id' => isset($checkout_data['coupon_id']) ? $checkout_data['coupon_id'] : '',
                'coupon_code' => isset($checkout_data['coupon_code']) ? $checkout_data['coupon_code'] : '',
                'total_amount' => isset($checkout_data['discount_total']) ? $checkout_data['discount_total'] : '',
            ]);
        }
        return $coupon_details;
    }

    public function createOrderReferenceNumber($code = 'OR')
    {
        $max_code = $code . '00001';
        $max_id = Order::max('id');
        if ($max_id) {
            $max_code = substr($max_code, 0, -strlen($max_id)) . '' . ($max_id + 1);
        }
        return $max_code;
    }

    public function sendEmails($order, $items, $checkout_data)
    {
        $subject = 'Your Order';
        $subject_admin = 'Order';
        $attachments = [];

        $params = [
            'view' => 'email.order',
            'user' => [
                'name' => $checkout_data['billing_first_name'] . (isset($checkout_data['billing_last_name']) ? ' ' . $checkout_data['billing_last_name'] : ''),
                'email' => $checkout_data['billing_email']
            ],
            'order_data' => $order,
            'subject' => $subject,
            'attachments' => $attachments
        ];
        $mail = $this->emailOrder($params);

        $order_data = Order::find($order->id);
        $params = [
            'view' => 'email.order_admin',
            'user' => [
                'name' => $checkout_data['billing_first_name'] . (isset($checkout_data['billing_last_name']) ? ' ' . $checkout_data['billing_last_name'] : ''),
                'email' => $checkout_data['billing_email']
            ],
            'order_data' => $order_data,
            'subject' => $subject_admin,
            'attachments' => $attachments
        ];
        $mail = $this->emailOrderAdmin($params);
    }

    /**
     * Send email
     *
     * @param array $params
     *
     * @return mixed
     */
    public function emailOrder($params = null)
    {
        if (isset($params)) {
            $system_setting_name = $this->getSystemSettingByCode('SS0001');
            $system_setting_email = $this->getSystemSettingByCode('SS0002');

            $data = [
                'subject' => $params['subject'],
                'user' => [
                    'name' => $params['user']['name'],
                    'email' => $params['user']['email']
                ],
                'order_data' => $params['order_data'],
                'attachments' => $params['attachments']
            ];

            Mail::send($params['view'], compact('data'), function ($message) use ($data, $system_setting_name, $system_setting_email) {
                $message->from(/*$system_setting_email->value*/config('constants.no_reply_email'), $system_setting_name->value);
                $message->bcc(config('constants.dnr_bcc'));
                $message->to($data['user']['email'], $data['user']['name']);
                $message->subject($data['subject']);
                if (isset($data['attachments']) && count($data['attachments'])) {
                    foreach ($data['attachments'] as $attachment) {
                        if (File::exists($attachment)) {
                            $message->attach($attachment);
                        }
                    }
                }
            });
        }
    }

    /**
     * Send email to admin
     *
     * @param array $params
     *
     * @return mixed
     */
    public function emailOrderAdmin($params = null)
    {
        if (isset($params)) {
            $system_setting_name = $this->getSystemSettingByCode('SS0001');
            $system_setting_email = $this->getSystemSettingByCode('SS0002');

            $data = [
                'subject' => $params['subject'],
                'user' => [
                    'name' => $params['user']['name'],
                    'email' => $params['user']['email']
                ],
                'order_data' => $params['order_data'],
                'attachments' => $params['attachments']
            ];

            Mail::send($params['view'], compact('data'), function ($message) use ($data, $system_setting_name, $system_setting_email) {
                $message->from(/*$system_setting_email->value*/config('constants.no_reply_email'), $system_setting_name->value);
                $message->bcc(config('constants.dnr_bcc'));
                $message->to($system_setting_email->value, $system_setting_name->value);
                $message->subject($data['subject']);
                if (isset($data['attachments']) && count($data['attachments'])) {
                    foreach ($data['attachments'] as $attachment) {
                        if (File::exists($attachment)) {
                            $message->attach($attachment);
                        }
                    }
                }
            });
        }
    }
}