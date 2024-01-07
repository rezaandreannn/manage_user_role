<?php

namespace App\Http\Controllers\Security;

use App\DataTables\LocationPermissionsDataTable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\PermissionsDataTable;
use App\Http\Requests\PermissionRequest;
use Spatie\Permission\Models\Permission;
use App\DataTables\ModulePermissionsDataTable;

class PermissionController extends Controller
{
    protected $formMessage;

    public function __construct()
    {
        $this->formMessage = [
            'store'  => trans('global-message.save_form',  ['form' => __('permissions.title')]),
            'update' => trans('global-message.update_form',  ['form' => __('permissions.title')]),
            'delete' => trans('global-message.delete_form',  ['form' => __('permissions.title')])
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = trans('global-message.list_form_title', ['form' => trans('permissions.title')]);

        $assets = ['data-table'];

        $canCreateRole = auth()->user()->hasRole('super admin') && auth()->user()->can('create');

        $buttonAddModule = $canCreateRole ?  view('components.add-form-button', [
            'route' => route('permission.create', ['type' => 'module']),
            'title' => 'New Module'
        ])->render()
            : '';
        $buttonAddLocation = $canCreateRole ?  view('components.add-form-button', [
            'route' => route('permission.create', ['type' => 'location']),
            'title' => 'New Location'
        ])->render()
            : '';
        $buttonAddMenu = $canCreateRole ?  view('components.add-form-button', [
            'route' => route('permission.create', ['type' => 'menu']),
            'title' => 'New Menu'
        ])->render()
            : '';
        $buttonAddOther = $canCreateRole ?  view('components.add-form-button', [
            'route' => route('permission.create', ['type' => 'other']),
            'title' => 'New Other'
        ])->render()
            : '';
        $moduleDataTable = Permission::where('type', 'module')->get();
        $menuDataTable = Permission::where('type', 'menu')
            ->orderBy('parent_id', 'asc')
            ->get();
        $locationDataTable = Permission::where('type', 'location')->get();
        $otherDataTable = Permission::where('type', 'other')->get();

        return view('permissions.index', compact('moduleDataTable', 'locationDataTable', 'menuDataTable', 'otherDataTable', 'pageTitle', 'buttonAddModule', 'buttonAddLocation', 'buttonAddMenu', 'buttonAddOther'));
    }


    public function getActionModal($id)
    {
        $title = 'Edit Permission';
        $id = $id;
        $routeEdit = route('permission.edit', $id);
        $permissionEdit = auth()->user()->hasRole('super admin') && auth()->user()->can('edit');
        $routeDelete = route('permission.destroy', $id);
        $permissionDelete = auth()->user()->hasRole('super admin') && auth()->user()->can('delete');
        $message = 'Are you sure delete permission ?';
        return view('components.action-modal', compact('id', 'title', 'routeEdit', 'routeDelete', 'message', 'permissionEdit', 'permissionDelete'))->render();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $type)
    {
        $module = '';
        if ($type == 'menu') {
            $module = Permission::where('type', 'module')->get();
        }
        $view = view('permissions.form-permission-module', compact('type', 'module'))->render();
        return response()->json(['data' =>  $view, 'status' => true]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionRequest $request)
    {
        $request['guard_name'] = 'web';

        if ($request->type == 'menu') {
            $request['parent_id'] = $request->parent_id;
            $request['url'] = $request->url;
        }
        $request['type'] = $request->type;
        $request['order'] = $request->order;

        Permission::create($request->all());

        return redirect()->route('permission.index')->withSuccess($this->formMessage['store']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //code here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Permission::query()->findOrFail($id);
        $module = '';

        if ($data->type == 'menu') {
            $module = Permission::where('type', 'module')->get();
        }
        $type = $data->type;
        $view = view('permissions.form-permission-module', compact('type', 'module', 'data', 'id'))->render();
        return response()->json(['data' =>  $view, 'status' => true]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $permission = Permission::query()->findOrFail($id);

        $permission->fill($request->all())->update();

        return redirect()->route('permission.index')->withSuccess($this->formMessage['update']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = Permission::query()->findOrFail($id);

        $permission->delete();

        return redirect()->route('permission.index')->withSuccess($this->formMessage['delete']);
    }
}
