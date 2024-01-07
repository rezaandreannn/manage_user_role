<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\UsersDataTable;
use App\Models\User;
use App\Helpers\AuthHelper;
use Spatie\Permission\Models\Role;
use App\Http\Requests\UserRequest;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UsersDataTable $dataTable)
    {

        // dd(User::with('roles')->get());

        $pageTitle = trans('global-message.list_form_title', ['form' => trans('users.title')]);
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a href="' . route('users.create') . '" class="btn btn-sm btn-primary" role="button">Add User</a>';
        return $dataTable->render('global.datatable', compact('pageTitle', 'auth_user', 'assets', 'headerAction'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where('status', 1)->get()->pluck('title', 'id');

        return view('users.form', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $findRole = Role::query()->find($request->user_role);

        $request['password'] = bcrypt($request->password);

        $request['username'] = $request->username ?? stristr($request->email, "@", true) . rand(100, 1000);

        $user = User::create($request->all());

        // storeMediaFile($user, $request->profile_image, 'profile_image');

        // Save user Profile data...
        // $user->userProfile()->create($request->userProfile);

        $user->assignRole($findRole->name ?? 'user');

        return redirect()->route('users.index')->withSuccess(__('message.msg_added', ['name' => __('users.store')]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {

        $data = User::with('roles')->where('uuid', $uuid)->firstOrFail();
        $id = $data->id;

        $role = $data->roles[0]['name'];

        $permissionMenu = Permission::where('type', 'menu')
            ->orWhere('type', 'Menu')
            ->get();

        $permissionModule = Permission::where('type', 'module')
            ->orWhere('type', 'Module')
            ->get();

        $permissionLocation = Permission::where('type', 'location')
            ->orWhere('type', 'Location')
            ->get();

        $permissionOther = Permission::where('type', 'other')
            ->orWhere('type', 'Other')
            ->get();

        return view('users.profile', compact('data', 'role', 'permissionMenu', 'permissionModule', 'permissionLocation', 'permissionOther', 'id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        $data = User::with('userProfile', 'roles')->where('uuid', $uuid)->firstOrFail();

        $id = $data->id;

        $data['user_type'] = $data->roles->pluck('id')[0] ?? null;

        $roles = Role::where('status', 1)->get()->pluck('title', 'id');

        $profileImage = getSingleMedia($data, 'profile_image');

        return view('users.form', compact('data', 'id', 'roles', 'profileImage', 'uuid'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $uuid)
    {

        $user = User::with('userProfile')->where('uuid', $uuid)->firstOrFail();

        $role = Role::find($request->user_role);

        if (env('IS_DEMO')) {
            if ($role->name === 'admin' && $user->user_type === 'admin') {
                return redirect()->back()->with('error', 'Permission denied');
            }
        }
        $user->assignRole($role->name);

        $request['password'] = $request->password != '' ? bcrypt($request->password) : $user->password;

        // User user data...
        $user->fill($request->all())->update();

        // Save user image...
        // if (isset($request->profile_image) && $request->profile_image != null) {
        //     $user->clearMediaCollection('profile_image');
        //     $user->addMediaFromRequest('profile_image')->toMediaCollection('profile_image');
        // }

        // user profile data....
        // if ($user->userProfile === null) {
        //     $user->userProfile()->create($request->userProfile);
        // } else {
        //     $user->userProfile->fill($request->userProfile)->update();
        // }

        if (auth()->check()) {
            return redirect()->route('users.index')->withSuccess(__('message.msg_updated', ['name' => __('message.user')]));
        }
        return redirect()->back()->withSuccess(__('message.msg_updated', ['name' => 'users.update']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::where('uuid', $id)->firstOrFail();
        $status = 'errors';
        $message = __('global-message.delete_form', ['form' => __('users.title')]);

        if ($user != '') {
            $user->delete();
            $status = 'success';
            $message = __('global-message.delete_form', ['form' => __('users.title')]);
        }

        if (request()->ajax()) {
            return response()->json(['status' => true, 'message' => $message, 'datatable_reload' => 'dataTable_wrapper']);
        }

        return redirect()->back()->with($status, $message);
    }

    public function userPermission(Request $request)
    {
        $userId = $request->input('user_id');
        $permissionName = $request->input('permission_name');
        $checked = $request->input('action');

        $user = User::with('roles')->findOrFail($userId);

        $permission = Permission::where('name', $permissionName)->first();

        if ($user && $permission) {
            if ($checked == 'insert') {
                $user->givePermissionTo($permission);
                $message = 'Permissions updated successfully';
            } else {
                $user->revokePermissionTo($permission);
                $message = 'Permissions delete successfully';
            }


            return response()->json(['message' => $message]);
        }

        return response()->json(['error' => 'Role or permission not found'], 404);
    }
}
