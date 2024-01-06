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

        $headerAction = $canCreateRole ?  view('components.add-form-button', [
            'route' => route('permission.create'),
            'title' => 'New Permission'
        ])->render()
            : '';
        $moduleDataTable = Permission::where('type', 'module')->get();
        $locationDataTable = Permission::where('type', 'location')->get();
        $otherDataTable = Permission::where('type', 'other')->get();
        // dd($locationDataTable);

        return view('permissions.index', compact('moduleDataTable', 'locationDataTable', 'otherDataTable', 'pageTitle', 'headerAction'));
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
    public function create(Request $request)
    {
        $data = $request->all();
        $typeOptions = [
            'module' => 'Module',
            'location' => 'Location',
            'other' => 'Other'
        ];
        $view = view('role-permission.form-permission', compact('typeOptions'))->render();
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

        $request['type'] = $request->type;

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
        $typeOptions = [
            'module' => 'Module',
            'location' => 'Location',
            'other' => 'Other'
        ];
        $view = view('role-permission.form-permission', compact('typeOptions', 'data', 'id'))->render();
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
