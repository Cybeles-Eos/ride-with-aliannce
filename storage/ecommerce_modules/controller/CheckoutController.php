<?php

namespace App\Http\Controllers;

use App\Repositories\CartRepository;
use App\Repositories\CheckoutRepository;
use Illuminate\Http\Request;

/**
 * Class CheckoutController
 * @package App\Http\Controllers
 * @author Richard Guevara
 */
class CheckoutController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Checkout Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles section services
    |
    */

    /**
     * Create a new controller instance.
     *
     * @param CartRepository $cart_repository
     * @param CheckoutRepository $checkout_repository
     *
     */
    public function __construct(CartRepository $cart_repository,
                                CheckoutRepository $checkout_repository
    )
    {
        /*
         * Model namespace
         * using $this->cart_model can also access $this->cart_model->where('id', 1)->get();
         * */

        /*
         * Repository namespace
         * this class may include methods that can be used by other controllers, like getting of section services with other data (related tables).
         * */
        $this->cart_repository = $cart_repository;
        $this->checkout_repository = $checkout_repository;

//        $this->middleware(['isAdmin']);
    }

    /*
    |--------------------------------------------------------------------------
    | Checkout
    |--------------------------------------------------------------------------
    */

    public function checkout(Request $request)
    {
        $input = $request->all();

        if ($input['payment_method'] == '') {
            /* just continue process no payment */
            $carts = $this->cart_repository->getAll();
            $order = $this->checkout_repository->processCartToOrder($request->all(), $carts);
            return redirect()->to('shopping-cart')
                ->with('flash_message', [
                    'title' => '',
                    'message' => 'Order reference #' . $order->reference_no . ' successfully created.',
                    'type' => 'success'
                ]);
        } else if ($input['payment_method'] == 'paypal') {

        } else if ($input['payment_method'] == 'stripe') {

        } else if ($input['payment_method'] == 'authorize') {

        }
    }

}
