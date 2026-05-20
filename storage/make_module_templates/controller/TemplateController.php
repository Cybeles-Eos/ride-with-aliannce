<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TemplateCamelCase;
use App\Repositories\TemplateCamelCaseRepository;

/**
 * Class TemplateCamelCaseController
 * @package App\Http\Controllers
 * @author Richard Guevara
 */
class TemplateCamelCaseController extends Controller
{
    /**
     * TemplateCamelCase model instance.
     *
     * @var TemplateCamelCase
     */
    private $template_snake_case_model;

    /**
     * TemplateCamelCaseRepository repository instance.
     *
     * @var TemplateCamelCaseRepository
     */
    private $template_snake_case_repository;

    /**
     * Create a new controller instance.
     *
     * @param TemplateCamelCase $template_snake_case_model
     * @param TemplateCamelCaseRepository $template_snake_case_repository
     */
    public function __construct(TemplateCamelCase $template_snake_case_model, TemplateCamelCaseRepository $template_snake_case_repository)
    {
        /*
         * Model namespace
         * using $this->template_snake_case_model can also access $this->template_snake_case_model->where('id', 1)->get();
         * */
        $this->template_snake_case_model = $template_snake_case_model;

        /*
         * Repository namespace
         * this class may include methods that can be used by other controllers, like getting of template_snake_case_plural with other data (related tables).
         * */
        $this->template_snake_case_repository = $template_snake_case_repository;

//        $this->middleware(['isAdmin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        if (!auth()->user()->hasPermissionTo('Read DefaultTemplate')) {
            abort('401', '401');
        }

        $template_snake_case_plural = $this->template_snake_case_model->get();

        return view('admin.pages.template_snake_case.index', compact('template_snake_case_plural'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->hasPermissionTo('Create DefaultTemplate')) {
            abort('401', '401');
        }

        return view('admin.pages.template_snake_case.create');
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
        if (!auth()->user()->hasPermissionTo('Create DefaultTemplate')) {
            abort('401', '401');
        }

        $this->validate($request, [
            'name' => 'required|unique:template_snake_case_plural,name,NULL,id,deleted_at,NULL',
            'slug' => 'required|unique:template_snake_case_plural,slug,NULL,id,deleted_at,NULL',
            'content' => 'required',
            'banner_image' => 'mimes:jpg,jpeg,png',
            'file' => 'mimes:docx,doc,pdf',
        ]);

        $input = $request->all();
        $input['is_active'] = isset($input['is_active']) ? 1 : 0;
        /* if slug is hidden, generate slug automatically */
        $input['slug'] = str_slug($input['name']);

        $template_snake_case = $this->template_snake_case_model->create($input);

        if ($request->hasFile('banner_image')) {
            $file_upload_path = $this->template_snake_case_repository->uploadFile($request->file('banner_image'), /*'banner_image'*/null, 'template_snake_case_images');
            $template_snake_case->fill(['banner_image' => $file_upload_path])->save();
        }
        if ($request->hasFile('file')) {
            $file_upload_path = $this->template_snake_case_repository->uploadFile($request->file('file'), /*'file'*/null, 'template_snake_case_files');
            $template_snake_case->fill(['file' => $file_upload_path])->save();
        }

        return redirect()->route('admin.template_snake_case_plural.index')->with('flash_message', [
            'title' => '',
            'message' => 'DefaultTemplate ' . $template_snake_case->name . ' successfully added.',
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
        if (!auth()->user()->hasPermissionTo('Read DefaultTemplate')) {
            abort('401', '401');
        }

        $template_snake_case = $this->template_snake_case_model->findOrFail($id);

        return view('admin.pages.template_snake_case.show', compact('template_snake_case'));
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
        if (!auth()->user()->hasPermissionTo('Update DefaultTemplate')) {
            abort('401', '401');
        }

        $template_snake_case = $this->template_snake_case_model->findOrFail($id);

        return view('admin.pages.template_snake_case.edit', compact('template_snake_case'));
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
        if (!auth()->user()->hasPermissionTo('Update DefaultTemplate')) {
            abort('401', '401');
        }

        $this->validate($request, [
            'name' => 'required|unique:template_snake_case_plural,name,' . $id . ',id,deleted_at,NULL',
            'slug' => 'required|unique:template_snake_case_plural,slug,' . $id . ',id,deleted_at,NULL',
            'content' => 'required',
            'banner_image' => 'required_if:remove_banner_image,==,1|mimes:jpg,jpeg,png',
            'file' => 'required_if:remove_file,==,1|mimes:docx,doc,pdf',
        ]);

        $template_snake_case = $this->template_snake_case_model->findOrFail($id);
        $input = $request->all();
        $input['is_active'] = isset($input['is_active']) ? 1 : 0;
        /* if slug is hidden, generate slug automatically */
        $input['slug'] = str_slug($input['name']);

        if ($request->hasFile('banner_image')) {
            $file_upload_path = $this->template_snake_case_repository->uploadFile($request->file('banner_image'), /*'banner_image'*/null, 'template_snake_case_images');
            $input['banner_image'] = $file_upload_path;
        }
        if ($request->has('remove_banner_image') && $request->get('remove_banner_image')) {
            $input['banner_image'] = '';
        }

        if ($request->hasFile('file')) {
            $file_upload_path = $this->template_snake_case_repository->uploadFile($request->file('file'), /*'file'*/null, 'template_snake_case_files');
            $input['file'] = $file_upload_path;
        }
        if ($request->has('remove_file') && $request->get('remove_file')) {
            $input['file'] = '';
        }

        $template_snake_case->fill($input)->save();

        return redirect()->route('admin.template_snake_case_plural.index')->with('flash_message', [
            'title' => '',
            'message' => 'DefaultTemplate ' . $template_snake_case->name . ' successfully updated.',
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
        if (!auth()->user()->hasPermissionTo('Delete DefaultTemplate')) {
            abort('401', '401');
        }

        $template_snake_case = $this->template_snake_case_model->findOrFail($id);
        $template_snake_case->delete();

        $response = array(
            'status' => FALSE,
            'data' => array(),
            'message' => array(),
        );

        $response['message'][] = 'DefaultTemplate successfully deleted.';
        $response['data']['id'] = $id;
        $response['status'] = TRUE;

        return response()->json($response);
    }
}
