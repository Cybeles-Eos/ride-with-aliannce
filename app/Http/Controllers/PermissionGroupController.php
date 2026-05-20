<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PermissionGroup;
use App\Repositories\PermissionGroupRepository;

/**
 * Class PermissionGroupController
 * @package App\Http\Controllers
 * @author Richard Guevara
 */
class PermissionGroupController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Permission Group Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles permission_groups.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @param PermissionGroup $permission_group_model
     * @param PermissionGroupRepository $permission_group_repository
     */
    public function __construct(PermissionGroup $permission_group_model,
                                PermissionGroupRepository $permission_group_repository
    )
    {
        /*
         * Model namespace
         * using $this->permission_group_model can also access $this->permission_group_model->where('id', 1)->get();
         * */
        $this->permission_group_model = $permission_group_model;

        /*
         * Repository namespace
         * this class may include methods that can be used by other controllers, like getting of permission_groups with other data (related tables).
         * */
        $this->permission_group_repository = $permission_group_repository;


//        $this->middleware(['isAdmin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        if (!auth()->user()->hasPermissionTo('Read Permission Group')) {
            abort('401', '401');
        }

        $permission_groups = $this->permission_group_repository->getAllWithPermissions();

        return view('admin.pages.permission_group.index', compact('permission_groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->hasPermissionTo('Create Permission Group')) {
            abort('401', '401');
        }

        return view('admin.pages.permission_group.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('Create Permission Group')) {
            abort('401', '401');
        }

        $this->validate($request, [
            'name' => 'required|max:75',
        ]);

        $permission_group = $this->permission_group_model->create($request->only('name'));

        return redirect()->route('admin.permission_groups.index')
            ->with('flash_message', [
                'title' => '',
                'message' => 'Permission Group ' . $permission_group->name . ' successfully added.',
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
        if (!auth()->user()->hasPermissionTo('Read Permission Group')) {
            abort('401', '401');
        }

        return redirect('admin/permission_groups');
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
        if (!auth()->user()->hasPermissionTo('Update Permission Group')) {
            abort('401', '401');
        }

        $permission_group = $this->permission_group_model->findOrFail($id);

        return view('admin.pages.permission_group.edit', compact('permission_group'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!auth()->user()->hasPermissionTo('Update Permission Group')) {
            abort('401', '401');
        }

        $this->validate($request, [
            'name' => 'required|max:75',
        ]);

        $permission_group = $this->permission_group_model->findOrFail($id);
        $input = $request->only(['name']);
        $permission_group->fill($input)->save();

        return redirect()->route('admin.permission_groups.index')
            ->with('flash_message', [
                'title' => '',
                'message' => 'Permission Group ' . $permission_group->name . ' successfully updated.',
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
        if (!auth()->user()->hasPermissionTo('Delete Permission Group')) {
            abort('401', '401');
        }

        $permission_group = $this->permission_group_model->findOrFail($id);
        $permission_group->delete();

        $response = array(
            'status' => FALSE,
            'data' => array(),
            'message' => array(),
        );

        $response['message'][] = 'Permission Group successfully deleted.';
        $response['data']['id'] = $id;
        $response['status'] = TRUE;

        return json_encode($response);
    }
}
