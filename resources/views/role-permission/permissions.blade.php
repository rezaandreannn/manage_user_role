@push('scripts')
<script>
    $(document).ready(function() {
        $('input[type="checkbox"]').change(function() {
            var checkbox = $(this);
            var roleId = checkbox.val();
            var permissionName = checkbox.attr('name').replace('permission[', '').replace('][]', '');
            var status = $(this).is(':checked');
            var action = ""

            if (status) {
                action = "insert"
            } else {
                action = "delete"
            }

            $.ajax({
                url: '{{ route("role.permission.store") }}'
                , method: 'GET'
                , data: {
                    role_id: roleId
                    , permission_name: permissionName
                    , action: action
                }
                , success: function(response) {
                    console.log(response);
                }
                , error: function(error) {
                    console.error(error);
                }
            });
        });
    });

</script>
@endpush
<x-app-layout :assets="$assets ?? []">
    <div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title mb-0">Role & Permission</h4>
                        </div>
                        <ul class="d-flex nav nav-pills mb-0 text-center profile-tab" data-toggle="slider-tab" id="profile-pills-tab" role="tablist">
                            @can('update-setting-permission')
                            <li class="nav-item">
                                <a class="nav-link active show" data-bs-toggle="tab" href="#module" role="tab" aria-selected="false">Module</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#location" role="tab" aria-selected="false">Location</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#menu" role="tab" aria-selected="false">Menu</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#other" role="tab" aria-selected="false">Other</a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="profile-content tab-content">
                            <div id="module" class="tab-pane fade active show">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                @foreach ($roles as $role)
                                                <th class="text-center">{{ $role->title }}
                                                </th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($modulePermissions as $module)
                                            <tr class="{{ !isset($module->parent_id) ? 'bg-body' : '' }}">
                                                <td>{{ $module->title }}
                                                </td>
                                                @foreach ($roles as $role)
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" id="role-{{$role->id}}-permission-{{$module->id}}" name="permission[{{$module->name}}][]" value='{{$role->name}}' {{ (AuthHelper::checkRolePermission($role,$module->name)) ? 'checked' : '' }}>
                                                </td>
                                                @endforeach
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="text-center">
                                    </div>
                                </div>
                            </div>
                            <div id="location" class="tab-pane fade">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                @foreach ($roles as $role)
                                                <th class="text-center">{{ $role->title }}
                                                </th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($locationPermissions as $location)
                                            <tr class="{{ !isset($location->parent_id) ? 'bg-body' : '' }}">
                                                <td>{{ $location->title }}
                                                </td>
                                                @foreach ($roles as $role)
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" id="role-{{$role->id}}-permission-{{$location->id}}" name="permission[{{$location->name}}][]" value='{{$role->name}}' {{ (AuthHelper::checkRolePermission($role,$location->name)) ? 'checked' : '' }}>
                                                </td>
                                                @endforeach
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="text-center">
                                    </div>
                                </div>
                            </div>
                            <div id="menu" class="tab-pane fade">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                @foreach ($roles as $role)
                                                <th class="text-center">{{ $role->title }}
                                                </th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($menuPermissions as $menu)
                                            <tr class="{{ !isset($menu->parent_id) ? 'bg-body' : '' }}">
                                                <td style="position: relative;">
                                                    <span> {{ $menu->title }} </span>
                                                    @foreach($modulePermissions as $value)
                                                    @if($menu->parent_id == $value->id)
                                                    @php
                                                    $brightness = hexdec(substr(md5($value->id), 0, 2));
                                                    $textColor = $brightness > 128 ? 'dark' : 'light';
                                                    @endphp
                                                    <div class="badge rounded-pill" style="background-color: {{ '#' . substr(md5($value->id), 0, 6) }}; color: {{ $textColor }};">
                                                        {{ $value->title }}
                                                    </div>
                                                    @endif
                                                    @endforeach
                                                </td>
                                                @foreach ($roles as $role)
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" id="role-{{$role->id}}-permission-{{$menu->id}}" name="permission[{{$menu->name}}][]" value='{{$role->name}}' {{ (AuthHelper::checkRolePermission($role,$menu->name)) ? 'checked' : '' }}>
                                                </td>
                                                @endforeach
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="text-center">
                                    </div>
                                </div>
                            </div>
                            <div id="other" class="tab-pane fade">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                @foreach ($roles as $role)
                                                <th class="text-center">{{ $role->title }}
                                                </th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($otherPermissions as $other)
                                            <tr class="{{ !isset($other->parent_id) ? 'bg-body' : '' }}">
                                                <td>{{ $other->title }}
                                                </td>
                                                @foreach ($roles as $role)
                                                <td class="text-center">
                                                    <input class="form-check-input" type="checkbox" id="role-{{$role->id}}-permission-{{$other->id}}" name="permission[{{$other->name}}][]" value='{{$role->name}}' {{ (AuthHelper::checkRolePermission($role,$other->name)) ? 'checked' : '' }}>
                                                </td>
                                                @endforeach
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="text-center">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
