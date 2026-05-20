<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryPerProduct;
use App\Repositories\CategoryPerProductRepository;

/**
 * Class CategoryPerProductController
 * @package App\Http\Controllers
 * @author Richard Guevara
 */
class CategoryPerProductController extends Controller
{
    /**
     * CategoryPerProduct model instance.
     *
     * @var CategoryPerProduct
     */
    private $category_per_product_model;

    /**
     * CategoryPerProductRepository repository instance.
     *
     * @var CategoryPerProductRepository
     */
    private $category_per_product_repository;

    /**
     * Create a new controller instance.
     *
     * @param CategoryPerProduct $category_per_product_model
     * @param CategoryPerProductRepository $category_per_product_repository
     */
    public function __construct(CategoryPerProduct $category_per_product_model, CategoryPerProductRepository $category_per_product_repository)
    {
        /*
         * Model namespace
         * using $this->category_per_product_model can also access $this->category_per_product_model->where('id', 1)->get();
         * */
        $this->category_per_product_model = $category_per_product_model;

        /*
         * Repository namespace
         * this class may include methods that can be used by other controllers, like getting of category_per_products with other data (related tables).
         * */
        $this->category_per_product_repository = $category_per_product_repository;

//        $this->middleware(['isAdmin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        if (!auth()->user()->hasPermissionTo('Read Category Per Product')) {
            abort('401', '401');
        }

        $category_per_products = $this->category_per_product_model->get();

        return view('admin.pages.category_per_product.index', compact('category_per_products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->hasPermissionTo('Create Category Per Product')) {
            abort('401', '401');
        }

        return view('admin.pages.category_per_product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('Create Category Per Product')) {
            abort('401', '401');
        }

        $this->validate($request, [
            'product_id' => 'required',
            'product_category_id' => 'required',
        ]);

        $input = $request->all();

        $category_per_product = $this->category_per_product_model->create($input);

        return redirect()->route('admin.category_per_products.index')->with('flash_message', [
            'title' => '',
            'message' => 'CategoryPerProduct ' . $category_per_product->title . ' successfully added.',
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
        return redirect()->route('admin.category_per_products.index');
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
        if (!auth()->user()->hasPermissionTo('Update Category Per Product')) {
            abort('401', '401');
        }

        $category_per_product = $this->category_per_product_model->findOrFail($id);

        return view('admin.pages.category_per_product.edit', compact('category_per_product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        if (!auth()->user()->hasPermissionTo('Update Category Per Product')) {
            abort('401', '401');
        }

        $this->validate($request, [
            'product_id' => 'required',
            'product_category_id' => 'required',
        ]);

        $category_per_product = $this->category_per_product_model->findOrFail($id);
        $input = $request->all();

        $category_per_product->fill($input)->save();

        return redirect()->route('admin.category_per_products.index')->with('flash_message', [
            'title' => '',
            'message' => 'Category Per Product ' . $category_per_product->title . ' successfully updated.',
            'type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->hasPermissionTo('Delete Category Per Product')) {
            abort('401', '401');
        }

        $category_per_product = $this->category_per_product_model->findOrFail($id);
        $category_per_product->delete();

        $response = array(
            'status' => FALSE,
            'data' => array(),
            'message' => array(),
        );

        $response['message'][] = 'Category Per Product successfully deleted.';
        $response['data']['id'] = $id;
        $response['status'] = TRUE;

        return response()->json($response);
    }
}
