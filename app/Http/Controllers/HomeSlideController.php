<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomeSlide;
use App\Repositories\HomeSlideRepository;

/**
 * Class HomeSlideController
 * @package App\Http\Controllers
 * @author Richard Guevara
 */
class HomeSlideController extends Controller
{
    /**
     * HomeSlide model instance.
     *
     * @var HomeSlide
     */
    private $home_slide_model;

    /**
     * HomeSlideRepository repository instance.
     *
     * @var HomeSlideRepository
     */
    private $home_slide_repository;

    /**
     * Create a new controller instance.
     *
     * @param HomeSlide $home_slide_model
     * @param HomeSlideRepository $home_slide_repository
     */
    public function __construct(HomeSlide $home_slide_model, HomeSlideRepository $home_slide_repository)
    {
        /*
         * Model namespace
         * using $this->home_slide_model can also access $this->home_slide_model->where('id', 1)->get();
         * */
        $this->home_slide_model = $home_slide_model;

        /*
         * Repository namespace
         * this class may include methods that can be used by other controllers, like getting of home_slides with other data (related tables).
         * */
        $this->home_slide_repository = $home_slide_repository;

//        $this->middleware(['isAdmin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        if (!auth()->user()->hasPermissionTo('Read Home Slide')) {
            abort('401', '401');
        }

        $home_slides = $this->home_slide_model->get();

        return view('admin.pages.home_slide.index', compact('home_slides'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->hasPermissionTo('Create Home Slide')) {
            abort('401', '401');
        }

        return view('admin.pages.home_slide.create');
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
        if (!auth()->user()->hasPermissionTo('Create Home Slide')) {
            abort('401', '401');
        }

        $this->validate($request, [
            'name' => 'required',
            'button_label' => 'required',
            'button_link' => 'required',
            'background_image' => 'mimes:jpg,jpeg,png',
        ]);

        $input = $request->all();
        $input['is_active'] = isset($input['is_active']) ? 1 : 0;

        $home_slide = $this->home_slide_model->create($input);

        if ($request->hasFile('background_image')) {
            $file_upload_path = $this->home_slide_repository->uploadFile($request->file('background_image'), $home_slide);
            $home_slide->fill(['background_image' => $file_upload_path])->save();
        }

        return redirect()->route('admin.home_slides.index')->with('flash_message', [
            'title' => '',
            'message' => 'Home Slide ' . $home_slide->title . ' successfully added.',
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
        return redirect()->route('admin.home_slides.index');
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
        if (!auth()->user()->hasPermissionTo('Update Home Slide')) {
            abort('401', '401');
        }

        $home_slide = $this->home_slide_model->findOrFail($id);

        return view('admin.pages.home_slide.edit', compact('home_slide'));
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
        if (!auth()->user()->hasPermissionTo('Update Home Slide')) {
            abort('401', '401');
        }

        $this->validate($request, [
            'name' => 'required',
            'button_label' => 'required',
            'button_link' => 'required',
            'background_image' => 'required_if:remove_background_image,==,1|mimes:jpg,jpeg,png',
        ]);

        $home_slide = $this->home_slide_model->findOrFail($id);
        $input = $request->all();
        $input['is_active'] = isset($input['is_active']) ? 1 : 0;

        if ($request->hasFile('background_image')) {
            $file_upload_path = $this->home_slide_repository->uploadFile($request->file('background_image'), $home_slide);
            $input['background_image'] = $file_upload_path;
        }

        $home_slide->fill($input)->save();

        return redirect()->route('admin.home_slides.index')->with('flash_message', [
            'title' => '',
            'message' => 'Home Slide ' . $home_slide->title . ' successfully updated.',
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
        if (!auth()->user()->hasPermissionTo('Delete Home Slide')) {
            abort('401', '401');
        }

        $home_slide = $this->home_slide_model->findOrFail($id);
        $home_slide->delete();

        $response = array(
            'status' => FALSE,
            'data' => array(),
            'message' => array(),
        );

        $response['message'][] = 'Home Slide successfully deleted.';
        $response['data']['id'] = $id;
        $response['status'] = TRUE;

        return response()->json($response);
    }
}
