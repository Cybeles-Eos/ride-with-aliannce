<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Repositories\CartRepository;
use Illuminate\Http\Request;

/**
 * Class CartController
 * @package App\Http\Controllers
 * @author Richard Guevara
 */
class CartController extends Controller
{
    /**
     * Cart model instance.
     *
     * @var Cart
     */
    private $cart_model;

    /**
     * CartRepository repository instance.
     *
     * @var CartRepository
     */
    private $cart_repository;

    /**
     * Create a new controller instance.
     *
     * @param Cart $cart_model
     * @param CartRepository $cart_repository
     */
    public function __construct(Cart $cart_model, CartRepository $cart_repository)
    {
        /*
         * Model namespace
         * using $this->cart_model can also access $this->cart_model->where('id', 1)->get();
         * */
        $this->cart_model = $cart_model;

        /*
         * Repository namespace
         * this class may include methods that can be used by other controllers, like getting of carts with other data (related tables).
         * */
        $this->cart_repository = $cart_repository;

//        $this->middleware(['isAdmin']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        if (auth()->check()) {
            if (!auth()->user()->hasAnyRole('Customer')) {
                abort('401', '401');
            }
        }

        $this->validate($request, [
            'product_unit_id' => 'required',
            'quantity' => 'required',
        ]);

        $input = $request->all();
        $input['user_id'] = auth()->check() ? auth()->user()->id : 0;
        $input['session_id'] = auth()->check() ? 0 : session()->getId();
        $cart = $this->cart_model->updateOrCreate([
            'user_id' => $input['user_id'],
            'session_id' => $input['session_id'],
            'product_id' => $input['product_id'],
            'product_unit_id' => $input['product_unit_id'],
            'price' => $input['price'],
        ], [
            'quantity' => \DB::raw('quantity + ' . $input['quantity']),
        ]);

        return redirect()->back()->with('flash_message', [
            'title' => '',
            'message' => 'Cart successfully added.',
            'type' => 'success'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        if (auth()->check()) {
            if (!auth()->user()->hasAnyRole('Customer')) {
                abort('401', '401');
            }
        }

        $this->validate($request, [
            'product_unit_id' => 'required',
            'quantity' => 'required',
        ]);

        $cart = $this->cart_model->findOrFail($id);

        if (auth()->check()) {
            if (auth()->user()->id != $cart->user_id) {
                abort('401', '401');
            }
        } else {
            if (session()->getId() != $cart->session_id) {
                abort('401', '401');
            }
        }

        $input = $request->all();
        $cart->fill($input)->save();

        return redirect()->back()->with('flash_message', [
            'title' => '',
            'message' => 'Cart successfully updated.',
            'type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (auth()->check()) {
            if (!auth()->user()->hasAnyRole('Customer')) {
                abort('401', '401');
            }
        }

        $cart = $this->cart_model->findOrFail($id);

        if (auth()->check()) {
            if (auth()->user()->id != $cart->user_id) {
                abort('401', '401');
            }
        } else {
            if (session()->getId() != $cart->session_id) {
                abort('401', '401');
            }
        }

        $cart->delete();

        $response = array(
            'status' => FALSE,
            'data' => array(),
            'message' => array(),
        );

        $response['message'][] = 'Cart successfully deleted.';
        $response['data']['id'] = $id;
        $response['status'] = TRUE;

        return response()->json($response);
    }
}
