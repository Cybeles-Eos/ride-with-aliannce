<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Repositories\ProductCategoryRepository;

/**
 * Class ProductCategoryController
 * @package App\Http\Controllers
 * @author Richard Guevara
 */
class ProductCategoryController extends Controller
{
    /**
     * ProductCategory model instance.
     *
     * @var ProductCategory
     */
    private $product_category_model;

    /**
     * ProductCategoryRepository repository instance.
     *
     * @var ProductCategoryRepository
     */
    private $product_category_repository;

    /**
     * Create a new controller instance.
     *
     * @param ProductCategory $product_category_model
     * @param ProductCategoryRepository $product_category_repository
     */
    public function __construct(ProductCategory $product_category_model, ProductCategoryRepository $product_category_repository)
    {
        /*
         * Model namespace
         * using $this->product_category_model can also access $this->product_category_model->where('id', 1)->get();
         * */
        $this->product_category_model = $product_category_model;

        /*
         * Repository namespace
         * this class may include methods that can be used by other controllers, like getting of product_categories with other data (related tables).
         * */
        $this->product_category_repository = $product_category_repository;

//        $this->middleware(['isAdmin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        if (!auth()->user()->hasPermissionTo('Read Product Category')) {
            abort('401', '401');
        }

        $product_categories = $this->product_category_model->get();

        return view('admin.pages.product_category.index', compact('product_categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->hasPermissionTo('Create Product Category')) {
            abort('401', '401');
        }

        return view('admin.pages.product_category.create');
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
        if (!auth()->user()->hasPermissionTo('Create Product Category')) {
            abort('401', '401');
        }

        $this->validate($request, [
            'title' => 'required',
        ]);

        $input = $request->all();

        $product_category = $this->product_category_model->create($input);

        return redirect()->route('admin.product_categories.index')->with('flash_message', [
            'title' => '',
            'message' => 'ProductCategory ' . $product_category->title . ' successfully added.',
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
        return redirect()->route('admin.product_categories.index');
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
        if (!auth()->user()->hasPermissionTo('Update Product Category')) {
            abort('401', '401');
        }

        $product_category = $this->product_category_model->findOrFail($id);

        return view('admin.pages.product_category.edit', compact('product_category'));
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
        if (!auth()->user()->hasPermissionTo('Update Product Category')) {
            abort('401', '401');
        }

        $this->validate($request, [
            'title' => 'required',
        ]);

        $product_category = $this->product_category_model->findOrFail($id);
        $input = $request->all();

        $product_category->fill($input)->save();

        return redirect()->route('admin.product_categories.index')->with('flash_message', [
            'title' => '',
            'message' => 'Product Category ' . $product_category->title . ' successfully updated.',
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
        if (!auth()->user()->hasPermissionTo('Delete Product Category')) {
            abort('401', '401');
        }

        $product_category = $this->product_category_model->findOrFail($id);
        $product_category->delete();

        $response = array(
            'status' => FALSE,
            'data' => array(),
            'message' => array(),
        );

        $response['message'][] = 'Product Category successfully deleted.';
        $response['data']['id'] = $id;
        $response['status'] = TRUE;

        return response()->json($response);
    }
}
