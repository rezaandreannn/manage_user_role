<?php

namespace App\Http\Controllers\Security;

use App\DataTables\RolesDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    protected $formMessage;

    public function __construct()
    {
        $this->formMessage = [
            'store'  => trans('global-message.save_form',  ['form' => __('roles.title')]),
            'update' => trans('global-message.update_form',  ['form' => __('roles.title')]),
            'delete' => trans('global-message.delete_form',  ['form' => __('roles.title')])
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RolesDataTable $dataTable)
    {
        $pageTitle = trans('global-message.list_form_title', ['form' => trans('roles.title')]);

        $assets = ['data-table'];

        $canCreateRole = auth()->user()->hasRole('super admin') && auth()->user()->can('create');

        $headerAction = $canCreateRole ?  view('components.add-form-button', [
            'route' => route('role.create'),
            'title' => 'New Role'
        ])->render()
            : '';

        return $dataTable->render('global.datatable', compact('pageTitle', 'assets', 'headerAction'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $view = view('role-permission.form-role')->render();

        return response()->json(['data' =>  $view, 'status' => true]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $request['guard_name'] = 'web';

        Role::create($request->all());

        return redirect()->route('role.index')->withSuccess($this->formMessage['store']);
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
        $data = Role::findOrFail($id);

        $view = view('role-permission.form-role', compact('data', 'id'))->render();

        return response()->json(['data' =>  $view, 'status' => true]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, $id)
    {
        $role = Role::query()->findOrFail($id);

        $role->fill($request->all())->update();

        return redirect()->route('role.index')->withSuccess($this->formMessage['update']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::query()->findOrFail($id);

        $role->delete();

        return redirect()->route('role.index')->withSuccess($this->formMessage['delete']);
    }
}
