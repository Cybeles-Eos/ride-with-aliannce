<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Repositories\PermissionGroupRepository;

/**
 * Class RoleController
 * @package App\Http\Controllers
 * @author Richard Guevara
 */
class RoleController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Role Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles roles.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @param Role $role_model
     * @param Permission $permission_model
     * @param PermissionGroupRepository $permission_group_repository
     */
    public function __construct(Role $role_model,
                                Permission $permission_model,
                                PermissionGroupRepository $permission_group_repository
    )
    {
        /*
         * Model namespace
         * using $this->role_model can also access $this->role_model->where('id', 1)->get();
         * */
        $this->role_model = $role_model;
        $this->permission_model = $permission_model;

        /*
         * Repository namespace
         * this class may include methods that can be used by other controllers, like getting of posts with other data (related tables).
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
        if (!auth()->user()->hasPermissionTo('Read Role')) {
            abort('401', '401');
        }

        $roles = $this->role_model->get();

        return view('admin.pages.role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->hasPermissionTo('Create Role')) {
            abort('401', '401');
        }

        $permission_groups = $this->permission_group_repository->getAllWithPermissions();

        return view('admin.pages.role.create', compact('permission_groups'));
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
        if (!auth()->user()->hasPermissionTo('Create Role')) {
            abort('401', '401');
        }

        $this->validate($request, [
            'name' => 'required|unique:roles|max:75',
            'permissions' => 'required',
        ]);

        $role = $this->role_model->create($request->only('name'));
        $permissions = $request['permissions'];

        foreach ($permissions as $permission) {
            $p = $this->permission_model->where('id', '=', $permission)->firstOrFail();
            $role->givePermissionTo($p);
        }

        return redirect()->route('admin.roles.index')
            ->with('flash_message', [
                'title' => '',
                'message' => 'Role ' . $role->name . ' successfully added.',
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
        if (!auth()->user()->hasPermissionTo('Read Role')) {
            abort('401', '401');
        }

        return redirect('admin/roles');
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
        if (!auth()->user()->hasPermissionTo('Update Role')) {
            abort('401', '401');
        }

        $role = $this->role_model->findOrFail($id);
        $permission_groups = $this->permission_group_repository->getAllWithPermissions();

        return view('admin.pages.role.edit', compact('role', 'permission_groups'));
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
        if (!auth()->user()->hasPermissionTo('Update Role')) {
            abort('401', '401');
        }

        $role = $this->role_model->findOrFail($id);
        $this->validate($request, [
            'name' => 'required|max:75|unique:roles,name,' . $id,
            'permissions' => 'required',
        ]);

        $input = $request->only(['name']);
        $permissions = $request['permissions'];
        $role->fill($input)->save();

        $p_all = $this->permission_model->get();

        foreach ($p_all as $p) {
            $role->revokePermissionTo($p);
        }

        foreach ($permissions as $permission) {
            $p = $this->permission_model->where('id', '=', $permission)->firstOrFail();
            $role->givePermissionTo($p);
        }

        return redirect()->route('admin.roles.index')
            ->with('flash_message', [
                'title' => '',
                'message' => 'Role ' . $role->name . ' successfully updated.',
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
        if (!auth()->user()->hasPermissionTo('Delete Role')) {
            abort('401', '401');
        }

        $response = array(
            'status' => false,
            'data' => array(),
            'message' => array(),
        );

        $role = $this->role_model->findOrFail($id);


        if ($role->name == "Super Admin" || $role->name == "Admin" || $role->name == "Customer") {
            $response['message'][] = 'Cannot delete this Role!';
            $response['data']['id'] = $id;
            $response['status'] = FALSE;

            return json_encode($response);
        }

        $role->delete();

        $response['message'][] = 'Role successfully deleted';
        $response['data']['id'] = $id;
        $response['status'] = true;
        return json_encode($response);
    }
}