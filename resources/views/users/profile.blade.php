@push('scripts')
<script>
    $(document).ready(function() {
        $('input[type="checkbox"]').change(function() {
            var checkbox = $(this);
            var userId = checkbox.val();
            var permissionName = checkbox.attr('name').replace('permission[', '').replace('][]', '');
            var status = $(this).is(':checked');
            var action = ""


            if (status) {
                action = "insert"
            } else {
                action = "delete"
            }

            $.ajax({
                url: '{{ route("user.permission.update") }}'
                , method: 'GET'
                , data: {
                    user_id: userId
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
    @php
    $user = App\Models\User::find($data->id);
    $canUpdateSettings = AuthHelper::checkUserPermission($user, 'update-setting-permission');
    $showUser = $user->hasPermissionTo('show-user') || $data->roles[0]->hasPermissionTo('show-user');
    if(auth()->user()->hasRole('super admin')) {
    $isActiveShow = $showUser;
    } else {
    $isActiveShow = $showUser;
    }
    @endphp
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center justify-content-between">
                        <div class="d-flex flex-wrap align-items-center">
                            <div class="profile-img position-relative me-3 mb-3 mb-lg-0">
                                <img src="{{ $profileImage ?? asset('images/avatars/01.png')}}" alt="User-Profile" class="theme-color-default-img img-fluid rounded-pill avatar-100">
                                <img src="{{asset('images/avatars/avtar_1.png')}}" alt="User-Profile" class="theme-color-purple-img img-fluid rounded-pill avatar-100">
                                <img src="{{asset('images/avatars/avtar_2.png')}}" alt="User-Profile" class="theme-color-blue-img img-fluid rounded-pill avatar-100">
                                <img src="{{asset('images/avatars/avtar_4.png')}}" alt="User-Profile" class="theme-color-green-img img-fluid rounded-pill avatar-100">
                                <img src="{{asset('images/avatars/avtar_5.png')}}" alt="User-Profile" class="theme-color-yellow-img img-fluid rounded-pill avatar-100">
                                <img src="{{asset('images/avatars/avtar_3.png')}}" alt="User-Profile" class="theme-color-pink-img img-fluid rounded-pill avatar-100">
                            </div>
                            <div class="d-flex flex-wrap align-items-center mb-3 mb-sm-0">
                                <h4 class="me-2 h4">{{ $data->full_name ?? 'your name'  }}</h4>
                                <span class="text-capitalize"> - {{ str_replace('_',' ',$role ?? '') ?? 'Role' }}</span>
                            </div>
                        </div>
                        <ul class="d-flex nav nav-pills mb-0 text-center profile-tab" data-toggle="slider-tab" id="profile-pills-tab" role="tablist">
                            @can('update-setting-permission')
                            @if(auth()->user()->hasRole('super admin') && auth()->id() !== $id)
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
                            @endif
                            @endcan
                            <li class="nav-item">
                                <a class="nav-link {{ $isActiveShow ? 'active show' : '' }}" data-bs-toggle="tab" href="#profile-profile" role="tab" aria-selected="false">Profile</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            {{-- <div class="card">
                <div class="card-header">
                    <div class="header-title">
                        <h4 class="card-title">News</h4>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="list-inline m-0 p-0">
                        <li class="d-flex mb-2">
                            <div class="news-icon me-3">
                                <svg width="20" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M20,2H4A2,2 0 0,0 2,4V22L6,18H20A2,2 0 0,0 22,16V4C22,2.89 21.1,2 20,2Z" />
                                </svg>
                            </div>
                            <p class="news-detail mb-0">there is a meetup in your city on fryday at 19:00. <a href="#">see details</a></p>
                        </li>
                        <li class="d-flex">
                            <div class="news-icon me-3">
                                <svg width="20" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M20,2H4A2,2 0 0,0 2,4V22L6,18H20A2,2 0 0,0 22,16V4C22,2.89 21.1,2 20,2Z" />
                                </svg>
                            </div>
                            <p class="news-detail mb-0">20% off coupon on selected items at pharmaprix </p>
                        </li>
                    </ul>
                </div>
            </div> --}}
        </div>
        <div class="col-lg-8">
            <div class="profile-content tab-content">
                @can('update-setting-permission')
                @if(auth()->user()->hasRole('super admin') && auth()->id() !== $id)
                <div id="module" class="tab-pane fade active show">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title mb-0">Module Access</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        @foreach($permissionModule as $permission)
                                        <tr class="{{ !isset($permission->parent_id) ? 'bg-body' : '' }}">
                                            <td>
                                                {{ $permission->title}}
                                            </td>
                                            <td class="text-center">
                                                @php

                                                $hasUserPermission = AuthHelper::checkUserPermission($user, $permission->id);

                                                $isChecked = $hasUserPermission;
                                                @endphp
                                                <input class="form-check-input" type="checkbox" id="permission-{{ $permission->id }}" name="permission[{{$permission->name}}][]" value='{{ $data->id }}' {{ $isChecked ? 'checked' : '' }}>
                                            </td>
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
                <div id="location" class="tab-pane fade">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title mb-0">Pabrik Location</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        @foreach($permissionLocation as $permission)
                                        <tr class="{{ !isset($permission->parent_id) ? 'bg-body' : '' }}">
                                            <td>
                                                {{ $permission->title}}
                                            </td>
                                            <td class="text-center">
                                                @php

                                                $hasUserPermission = AuthHelper::checkUserPermission($user, $permission->id);

                                                $isChecked = $hasUserPermission;
                                                @endphp
                                                <input class="form-check-input" type="checkbox" id="permission-{{ $permission->id }}" name="permission[{{$permission->name}}][]" value='{{ $data->id }}' {{ $isChecked ? 'checked' : '' }}>
                                            </td>
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
                <div id="menu" class="tab-pane fade">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title mb-0">Menu</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        @foreach($permissionMenu as $permission)
                                        <tr class="{{ !isset($permission->parent_id) ? 'bg-body' : '' }}">
                                            <td>
                                                {{ $permission->title}}
                                            </td>
                                            <td class="text-center">
                                                @php
                                                $hasUserPermission = AuthHelper::checkUserPermission($user, $permission->id);

                                                $isChecked = $hasUserPermission;
                                                @endphp
                                                <input class="form-check-input" type="checkbox" id="permission-{{ $permission->id }}" name="permission[{{$permission->name}}][]" value='{{ $data->id }}' {{ $isChecked ? 'checked' : '' }}>
                                            </td>
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
                @endif
                <div id="other" class="tab-pane fade">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title mb-0">Other</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        @foreach($permissionOther as $permission)
                                        <tr class="{{ !isset($permission->parent_id) ? 'bg-body' : '' }}">
                                            <td>
                                                {{ $permission->title}}
                                            </td>
                                            <td class="text-center">
                                                @php
                                                $hasUserPermission = AuthHelper::checkUserPermission($user, $permission->id);

                                                $isChecked = $hasUserPermission;
                                                @endphp
                                                <input class="form-check-input" type="checkbox" id="permission-{{ $permission->id }}" name="permission[{{$permission->name}}][]" value='{{ $data->id }}' {{ $isChecked ? 'checked' : '' }}>
                                            </td>
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
                @endcan
                <div id="profile-profile" class="tab-pane fade {{ $isActiveShow ? 'active show' : '' }}">
                    <div class="card">
                        <div class="card-header">
                            <div class="header-title">
                                <h4 class="card-title">Profile</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <div class="user-profile">
                                    <img src="{{asset('images/avatars/01.png')}}" alt="profile-img" class="rounded-pill avatar-130 img-fluid">
                                </div>
                                <div class="mt-3">
                                    <h3 class="d-inline-block">{{ $data->full_name ?? 'your name'  }}</h3>
                                    <p class="d-inline-block pl-3"> - {{ $role ?? ''}}</p>
                                    <p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <div class="header-title">
                                <h4 class="card-title">About User</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="user-bio">
                                <p>Tart I love sugar plum I love oat cake. Sweet roll caramels I love jujubes. Topping cake wafer.</p>
                            </div>
                            <div class="mt-2">
                                <h6 class="mb-1">Joined:</h6>
                                <p>{{ date('d M, Y',strtotime($data->created_at)) }}</p>
                            </div>
                            <div class="mt-2">
                                <h6 class="mb-1">Lives:</h6>
                                <p>United States of America</p>
                            </div>
                            <div class="mt-2">
                                <h6 class="mb-1">Email:</h6>
                                <p><a href="#" class="text-body"> {{$data->email}}</a></p>
                            </div>
                            <div class="mt-2">
                                <h6 class="mb-1">Contact:</h6>
                                <p><a href="#" class="text-body">{{$data->phone_number}}</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            {{-- <div class="card">
                <div class="card-header">
                    <div class="header-title">
                        <h4 class="card-title">About</h4>
                    </div>
                </div>
                <div class="card-body">
                    <p>Lorem ipsum dolor sit amet, contur adipiscing elit.</p>
                    <div class="mb-1">Email: <a href="#" class="ms-3">nikjone@demoo.com</a></div>
                    <div class="mb-1">Phone: <a href="#" class="ms-3">001 2351 256 12</a></div>
                    <div>Location: <span class="ms-3">USA</span></div>
                </div>
            </div> --}}
        </div>
    </div>

    @include('partials.components.share-offcanvas')
</x-app-layout>
