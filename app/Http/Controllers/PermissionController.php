<?php

namespace App\Http\Controllers;

use App\Repositories\PermissionGroupRepository;
use App\Repositories\PermissionRepository;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

/**
 * Class PermissionController
 * @package App\Http\Controllers
 * @author Richard Guevara
 */
class PermissionController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Permission Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles permissions.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @param Permission $permission_model
     * @param Role $role_model
     * @param PermissionRepository $permission_repository
     * @param PermissionGroupRepository $permission_group_repository
     */
    public function __construct(Permission $permission_model,
                                Role $role_model,
                                PermissionRepository $permission_repository,
                                PermissionGroupRepository $permission_group_repository
    )
    {
        /*
         * Model namespace
         * using $this->permission_model can also access $this->permission_model->where('id', 1)->get();
         * */
        $this->permission_model = $permission_model;
        $this->role_model = $role_model;

        /*
         * Repository namespace
         * this class may include methods that can be used by other controllers, like getting of posts with other data (related tables).
         * */
        $this->permission_repository = $permission_repository;
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
        if (!auth()->user()->hasPermissionTo('Read Permission')) {
            abort('401', '401');
        }

        $permissions = $this->permission_repository->getAllWithPermissionGroup();

        return view('admin.pages.permission.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->hasPermissionTo('Create Permission')) {
            abort('401', '401');
        }

        $roles = $this->role_model->get();
        $permission_groups = $this->permission_group_repository->getAll();

        return view('admin.pages.permission.create', compact('roles', 'permission_groups'));
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
        if (!auth()->user()->hasPermissionTo('Create Permission')) {
            abort('401', '401');
        }

        $this->validate($request, [
            'name' => 'required|unique:permissions|max:75',
            'permission_group_id' => 'required',
        ]);

        $permission = $this->permission_model->create($request->only('name', 'permission_group_id'));
//        $roles = $request['roles'];
//
//        if (!empty($request['roles'])) {
//            foreach ($roles as $role) {
//                $r = $this->role_model->where('id', '=', $role)->firstOrFail();
//                $r->givePermissionTo($permission);
//            }
//        }

        return redirect()->route('admin.permissions.index')
            ->with('flash_message', [
                'title' => '',
                'message' => 'Permission ' . $permission->name . ' successfully added.',
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
        if (!auth()->user()->hasPermissionTo('Read Permission')) {
            abort('401', '401');
        }

        return redirect('admin/permissions');
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
        if (!auth()->user()->hasPermissionTo('Update Permission')) {
            abort('401', '401');
        }

        $permission = $this->permission_model->findOrFail($id);
        $roles = $this->role_model->get();
        $permission_groups = $this->permission_group_repository->getAll();

        return view('admin.pages.permission.edit', compact('permission', 'roles', 'permission_groups'));
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
        if (!auth()->user()->hasPermissionTo('Update Permission')) {
            abort('401', '401');
        }

        $permission = $this->permission_model->findOrFail($id);
        $this->validate($request, [
            'name' => 'required|max:75|unique:permissions,name,' . $id,
            'permission_group_id' => 'required',
        ]);
        $input = $request->only(['name', 'permission_group_id']);
//        $roles = $request['roles'];
        $permission->fill($input)->save();

//        if (isset($roles)) {
//            $permission->roles()->sync($roles);
//        } else {
//            $permission->roles()->detach();
//        }

        return redirect()->route('admin.permissions.index')
            ->with('flash_message', [
                'title' => '',
                'message' => 'Permission ' . $permission->name . ' successfully updated.',
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
        if (!auth()->user()->hasPermissionTo('Delete Permission')) {
            abort('401', '401');
        }

        $response = array(
            'status' => FALSE,
            'data' => array(),
            'message' => array(),
        );

        $permission = $this->permission_model->findOrFail($id);

//        if ($permission->name == "Read Permission") {
//            $response['message'][] = 'Cannot delete this Permission!';
//            $response['data']['id'] = $id;
//            $response['status'] = FALSE;
//
//            return json_encode($response);
//        }

        $permission->delete();

        $response['message'][] = 'Permission successfully deleted.';
        $response['data']['id'] = $id;
        $response['status'] = TRUE;

        return json_encode($response);
    }
}