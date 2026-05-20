<?php

namespace App\Http\Controllers;

use App\Http\Traits\SystemSettingTrait;
use App\Repositories\SystemSettingRepository;
use Illuminate\Http\Request;
use App\Models\SystemSetting;

/**
 * Class SystemSettingController
 * @package App\Http\Controllers
 * @author Richard Guevara
 */
class SystemSettingController extends Controller
{
    use SystemSettingTrait;

    /*
    |--------------------------------------------------------------------------
    | SystemSetting Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles system settings.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @param SystemSetting $system_setting_model
     * @param SystemSettingRepository $system_setting_repository
     */
    public function __construct(SystemSetting $system_setting_model,
                                SystemSettingRepository $system_setting_repository
    )
    {
        /*
         * Model namespace
         * using $this->system_setting_model can also access $this->system_setting_model->where('id', 1)->get();
         * */
        $this->system_setting_model = $system_setting_model;

        /*
         * Repository namespace
         * this class may include methods that can be used by other controllers, like getting of system_settings with other data (related tables).
         * */
        $this->system_setting_repository = $system_setting_repository;

//        $this->middleware(['isAdmin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        if (!auth()->user()->hasPermissionTo('Read System Setting')) {
            abort('401', '401');
        }

        $system_settings = $this->system_setting_model->get();

        return view('admin.pages.system_setting.index', compact('system_settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->hasPermissionTo('Create System Setting')) {
            abort('401', '401');
        }

        $max_code = $this->generateSystemCode($this->system_setting_model, 'SS');

        return view('admin.pages.system_setting.create', compact('max_code'));
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
        if (!auth()->user()->hasPermissionTo('Create System Setting')) {
            abort('401', '401');
        }

        $this->validate($request, [
            'code' => 'required|max:25',
            'name' => 'required|max:75',
            'value' => 'required',
        ]);

        $system_setting = $this->system_setting_model->create($request->only('code', 'name', 'value'));

        return redirect()->route('admin.system_settings.index')
            ->with('flash_message', [
                'code' => '',
                'message' => 'System setting ' . $system_setting->name . ' successfully added.',
                'type' => 'success'
            ]);
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
        if (!auth()->user()->hasPermissionTo('Update System Setting')) {
            abort('401', '401');
        }

        $system_setting = $this->system_setting_model->findOrFail($id);

        return view('admin.pages.system_setting.edit', compact('system_setting'));
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
        if (!auth()->user()->hasPermissionTo('Update System Setting')) {
            abort('401', '401');
        }

        $this->validate($request, [
            'code' => 'required|max:25',
            'name' => 'required|max:75',
            'value' => 'required',
        ]);

        $system_setting = $this->system_setting_model->findOrFail($id);
        $input = $request->only(['code', 'name', 'value']);
        if ($system_setting->type == 'file') {
            $file_upload_path = $this->system_setting_repository->uploadFile($request->file('value'), $system_setting);
            $input['value'] = $file_upload_path;
        }
        $system_setting->fill($input)->save();

        return redirect()->route('admin.system_settings.index')
            ->with('flash_message', [
                'code' => '',
                'message' => 'System setting ' . $system_setting->name . ' successfully updated.',
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
        if (!auth()->user()->hasPermissionTo('Delete System Setting')) {
            abort('401', '401');
        }

        $response = array(
            'status' => FALSE,
            'data' => array(),
            'message' => array(),
        );

        $system_setting = $this->system_setting_model->findOrFail($id);
        $system_setting->delete();

        $response['message'][] = 'System Setting successfully deleted.';
        $response['data']['id'] = $id;
        $response['status'] = TRUE;

        return json_encode($response);
    }
}
