<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserLocation;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class UpdateLocationToNavbarController extends Controller
{
    public function update(Request $request)
    {
        $locationId = $request->input('location_id');

        $user = User::find(auth()->user()->id);
        $permission = Permission::find($locationId);

        if (!$user->hasPermissionTo($permission->name)) {
            $user->givePermissionTo($permission);
        }

        // Hapus status primary dari semua izin model
        $user->permissions->each(function ($permission) {
            $permission->pivot->update(['is_primary' => false]);
        });

        $user->permissions()->updateExistingPivot($permission->id, ['is_primary' => true]);

        // Permission::where('id', $locationId)->update(['active_location' => 1]);

        // Permission::where('type', 'location')->where('id', '!=', $locationId)->update(['active_location' => 0]);

        return response()->json(['message' => 'Location updated successfully']);
    }

    public function setPrimaryLocation(Request $request)
    {
        $userId = auth()->user()->id;
        $locationId = $request->input('location_id');

        UserLocation::where('user_id', $userId)->update(['is_primary' => false]);


        UserLocation::where('user_id', $userId)->where('location_id', $locationId)->update(['is_primary' => true]);

        return response()->json(['message' => 'Primary location set successfully']);
    }
}
