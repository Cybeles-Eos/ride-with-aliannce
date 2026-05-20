<?php

namespace App\Http\Controllers;

use App\Models\CouponCode;
use App\Repositories\CartRepository;
use App\Repositories\CouponCodeRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class CouponCodeController
 * @package App\Http\Controllers
 * @author Richard Guevara
 */
class CouponCodeController extends Controller
{
    /**
     * CouponCode model instance.
     *
     * @var CouponCode
     */
    private $coupon_code_model;

    /**
     * CouponCodeRepository repository instance.
     *
     * @var CouponCodeRepository
     */
    private $coupon_code_repository;

    /**
     * Create a new controller instance.
     *
     * @param CouponCode $coupon_code_model
     * @param CouponCodeRepository $coupon_code_repository
     * @param CartRepository $cart_repository
     */
    public function __construct(CouponCode $coupon_code_model, CouponCodeRepository $coupon_code_repository,
                                CartRepository $cart_repository
    )
    {
        /*
         * Model namespace
         * using $this->coupon_code_model can also access $this->coupon_code_model->where('id', 1)->get();
         * */
        $this->coupon_code_model = $coupon_code_model;

        /*
         * Repository namespace
         * this class may include methods that can be used by other controllers, like getting of coupon_codes with other data (related tables).
         * */
        $this->coupon_code_repository = $coupon_code_repository;
        $this->cart_repository = $cart_repository;

//        $this->middleware(['isAdmin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        if (!auth()->user()->hasPermissionTo('Read Coupon Code')) {
            abort('401', '401');
        }

        $coupon_codes = $this->coupon_code_model->get();

        return view('admin.pages.coupon_code.index', compact('coupon_codes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->hasPermissionTo('Create Coupon Code')) {
            abort('401', '401');
        }

        return view('admin.pages.coupon_code.create');
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
        if (!auth()->user()->hasPermissionTo('Create Coupon Code')) {
            abort('401', '401');
        }

        $this->validate($request, [
            'code' => 'required|unique:coupon_codes,code,NULL,id,deleted_at,NULL',
            'type' => 'required',
            'value' => 'required',
            'date_start' => 'required',
            'date_end' => 'required',
        ]);

        $input = $request->all();
        $input['user_id'] = auth()->user()->id;
        $input['date_start'] = date('Y-m-d', strtotime($input['date_start']));
        $input['date_end'] = date('Y-m-d', strtotime($input['date_end']));
        $coupon_code = $this->coupon_code_model->create($input);

        return redirect()->route('admin.coupon_codes.index')->with('flash_message', [
            'title' => '',
            'message' => 'Coupon Code ' . $coupon_code->code . ' successfully added.',
            'type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->route('admin.coupon_codes.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!auth()->user()->hasPermissionTo('Update Coupon Code')) {
            abort('401', '401');
        }

        $coupon_code = $this->coupon_code_model->findOrFail($id);

        return view('admin.pages.coupon_code.edit', compact('coupon_code'));
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
        if (!auth()->user()->hasPermissionTo('Update Coupon Code')) {
            abort('401', '401');
        }

        $this->validate($request, [
            'code' => 'required|unique:coupon_codes,code,' . $id . ',id,deleted_at,NULL',
            'type' => 'required',
            'value' => 'required',
            'date_start' => 'required',
            'date_end' => 'required',
        ]);

        $coupon_code = $this->coupon_code_model->findOrFail($id);
        $input = $request->all();
        $input['date_start'] = date('Y-m-d', strtotime($input['date_start']));
        $input['date_end'] = date('Y-m-d', strtotime($input['date_end']));
        $coupon_code->fill($input)->save();

        return redirect()->route('admin.coupon_codes.index')->with('flash_message', [
            'title' => '',
            'message' => 'Coupon Code ' . $coupon_code->code . ' successfully updated.',
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
        if (!auth()->user()->hasPermissionTo('Delete Coupon Code')) {
            abort('401', '401');
        }

        $coupon_code = $this->coupon_code_model->findOrFail($id);
        $coupon_code->delete();

        $response = array(
            'status' => FALSE,
            'data' => array(),
            'message' => array(),
        );

        $response['message'][] = 'Coupon Code successfully deleted.';
        $response['data']['id'] = $id;
        $response['status'] = TRUE;

        return response()->json($response);
    }

    public function validateCouponCode(Request $request)
    {
        $response = [
            'title' => '',
            'message' => 'Coupon is invalid.',
            'type' => 'error'
        ];

        $input = $request->all();

        $carts = $this->cart_repository->getAll();
        if (!count($carts)) {
            $response['message'] = 'Cart empty.';
        }

        if (isset($input['coupon_code']) && count($carts)) {
            $coupon_code = $this->coupon_code_model->where('code', $input['coupon_code'])
                ->whereDate('date_end', '>=', Carbon::now())
                ->whereDate('date_start', '<=', Carbon::now())
                ->first();

            if (!empty($coupon_code)) {
                session()->put('coupon_code', $coupon_code->code);
                $response['message'] = 'Coupon is valid.';
                $response['type'] = 'success';
            } else {
                session()->forget('coupon_code');
            }
        } else {
            session()->forget('coupon_code');
        }

        return redirect()->back()->with('flash_message', $response);
    }
}
