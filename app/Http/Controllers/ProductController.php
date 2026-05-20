<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\DB;
use App\Models\ProductCategory;
use App\Models\CategoryPerProduct;

/**
 * Class ProductController
 * @package App\Http\Controllers
 * @author Richard Guevara
 */
class ProductController extends Controller
{
    /**
     * Product model instance.
     *
     * @var Product
     */
    private $product_model;

    /**
     * ProductRepository repository instance.
     *
     * @var ProductRepository
     */
    private $product_repository;

    /**
     * ProductCategory model instance.
     *
     * @var ProductCategoryModel
     */
    private $product_category_model;

    /**
     * CategoryPerProduct model instance.
     *
     * @var CategoryPerProductModel
     */
    private $category_per_product_model;

    /**
     * Create a new controller instance.
     *
     * @param Product $product_model
     * @param ProductRepository $product_repository
     * @param ProductCategory $product_category_model
     */
    public function __construct(Product $product_model, ProductRepository $product_repository, ProductCategory $product_category_model, CategoryPerProduct $category_per_product_model)
    {
        /*
         * Model namespace
         * using $this->product_model can also access $this->product_model->where('id', 1)->get();
         * */
        $this->product_model = $product_model;
        $this->product_category_model = $product_category_model;
        $this->category_per_product_model = $category_per_product_model;

        /*
         * Repository namespace
         * this class may include methods that can be used by other controllers, like getting of products with other data (related tables).
         * */
        $this->product_repository = $product_repository;

//        $this->middleware(['isAdmin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        if (!auth()->user()->hasPermissionTo('Read Product')) {
            abort('401', '401');
        }

        $products = $this->product_model->get();

        return view('admin.pages.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->hasPermissionTo('Create Product')) {
            abort('401', '401');
        }

        $product_categories = ProductCategory::pluck('title', 'id');
        return view('admin.pages.product.create', compact('product_categories'));

        /*return view('admin.pages.product.create');*/
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
        if (!auth()->user()->hasPermissionTo('Create Product')) {
            abort('401', '401');
        }

        $this->validate($request, [
            'title' => 'required',
            'content' => 'required',
            'image' => 'mimes:jpg,jpeg,png',
        ]);

        $input = $request->all();
        $product = $this->product_model->create($input);

        $category_per_product = $this->category_per_product_model->create([
            'product_id' => $product->id,
            'product_category_id' => $request->id,
        ]);

        if ($request->hasFile('image')) {
            $file_upload_path = $this->product_repository->uploadFile($request->file('image'), $product);
            $product->fill(['image' => $file_upload_path])->save();
        }

        return redirect()->route('admin.products.index')->with('flash_message', [
            'title' => '',
            'message' => 'Product ' . $product->title . ' successfully added.',
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
        return redirect()->route('admin.products.index');
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
        if (!auth()->user()->hasPermissionTo('Update Product')) {
            abort('401', '401');
        }

        $product = $this->product_model->findOrFail($id);
        $category_per_product = DB::table('category_per_product')->where('product_id', $product->id)->first();
        $product_categories = ProductCategory::pluck('title', 'id');

        return view('admin.pages.product.edit', compact('product', 'product_categories', 'category_per_product'));
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
        if (!auth()->user()->hasPermissionTo('Update Product')) {
            abort('401', '401');
        }

        $this->validate($request, [
            'title' => 'required',
            'content' => 'required',
            'image' => 'required_if:remove_image,==,1|mimes:jpg,jpeg,png',
        ]);

        $product = $this->product_model->findOrFail($id);
        $input = $request->all();

        if ($request->hasFile('image')) {
            $file_upload_path = $this->product_repository->uploadFile($request->file('image'), $product);
            $input['image'] = $file_upload_path;
        }

        $product->fill($input)->save();

        $category_per_product = DB::table('category_per_product')->where('product_id', $product->id)->first();

        CategoryPerProduct::where('product_id', $id)->update(array('product_category_id' => $request->id));

        return redirect()->route('admin.products.index')->with('flash_message', [
            'title' => '',
            'message' => 'Product ' . $product->title . ' successfully updated.',
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
        if (!auth()->user()->hasPermissionTo('Delete Product')) {
            abort('401', '401');
        }

        $product = $this->product_model->findOrFail($id);
        $product->delete();

        $response = array(
            'status' => FALSE,
            'data' => array(),
            'message' => array(),
        );

        $response['message'][] = 'Product successfully deleted.';
        $response['data']['id'] = $id;
        $response['status'] = TRUE;

        return response()->json($response);
    }
}
