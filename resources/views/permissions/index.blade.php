@push('scripts')
{{-- {{ $moduleDataTable->scripts() }} --}}
@endpush
<x-app-layout :assets="$assets ?? []">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center justify-content-between">
                        <div class="d-flex flex-wrap align-items-center">
                            <div class="d-flex flex-wrap align-items-center mb-3 mb-sm-0">
                                {{-- <h4 class="me-2 h4"> {!! $headerAction ?? '' !!}</h4> --}}
                            </div>
                        </div>
                        <ul class="d-flex nav nav-pills mb-0 text-center profile-tab" data-toggle="slider-tab" id="profile-pills-tab" role="tablist">
                            @can('update-setting-permission')
                            <li class="nav-item">
                                <a class="nav-link active show" data-bs-toggle="tab" href="#module" role="tab" aria-selected="false">Module</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#menu" role="tab" aria-selected="false">Menu</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#location" role="tab" aria-selected="false">Location</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#other" role="tab" aria-selected="false">Other</a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="profile-content tab-content">
                @can('update-setting-permission')
                <div id="module" class="tab-pane fade active show">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="me-2 h4"> {!! $buttonAddModule ?? '' !!}</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-striped" data-toggle="data-table">
                                        <thead>
                                            <tr>
                                                <th>Location</th>
                                                <th>Name</th>
                                                <th>Title</th>
                                                <th>Order</th>
                                                <th>action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($moduleDataTable as $module)
                                            <tr>
                                                <td>
                                                    @foreach($locationDataTable as $location)
                                                    {{ $location->id == $module->parent_id ? $location->title : ''}}
                                                    @endforeach
                                                </td>
                                                <td>{{$module->name}}</td>
                                                <td>{{$module->title}}</td>
                                                <td>{{$module->order}}</td>
                                                <td>
                                                    @php
                                                    echo app('App\Http\Controllers\Security\PermissionController')->getActionModal($module->id);
                                                    @endphp</td>
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
                <div id="menu" class="tab-pane fade">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="me-2 h4"> {!! $buttonAddMenu ?? '' !!}</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-striped" data-toggle="data-table">
                                        <thead>
                                            <tr>
                                                <th>Location</th>
                                                <th>Module</th>
                                                <th>Title</th>
                                                <th>Order</th>
                                                {{-- <th>Description</th> --}}
                                                <th>action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($menuDataTable as $menu)
                                            <tr>
                                                <td>
                                                    @foreach($moduleDataTable as $modul)
                                                    @if($menu->parent_id == $modul->id)
                                                    @foreach($locationDataTable as $location)
                                                    @if($modul->parent_id == $location->id)
                                                    {{ $location->title }}
                                                    @endif
                                                    @endforeach
                                                    @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach($moduleDataTable as $value)
                                                    @if($menu->parent_id == $value->id)
                                                    @php
                                                    $bg = '';
                                                    if($value->aliases == 'BP'){
                                                    $bg = 'success';
                                                    }else if($value->aliases == 'TS'){
                                                    $bg = 'warning';
                                                    }else{
                                                    $bg = 'primary';
                                                    }
                                                    @endphp
                                                    <div class="badge rounded-pill bg-{{ $bg}} item-name">
                                                        {{ $value->aliases}}
                                                    </div>
                                                    @endif
                                                    @endforeach
                                                </td>
                                                <td>{{$menu->title}}</td>
                                                <td>{{$menu->order}}</td>
                                                <td>
                                                    @php
                                                    echo app('App\Http\Controllers\Security\PermissionController')->getActionModal($menu->id);
                                                    @endphp
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
                </div>
                <div id="location" class="tab-pane fade">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="me-2 h4"> {!! $buttonAddLocation ?? '' !!}</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-striped" data-toggle="data-table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Title</th>
                                            <th>Order</th>
                                            <th>action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($locationDataTable as $location)
                                        <tr>
                                            <td>{{$location->name}}</td>
                                            <td>{{$location->title}}</td>
                                            <td>{{$location->order}}</td>
                                            <td>
                                                @php
                                                echo app('App\Http\Controllers\Security\PermissionController')->getActionModal($location->id);
                                                @endphp
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
                <div id="other" class="tab-pane fade">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="me-2 h4"> {!! $buttonAddOther ?? '' !!}</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-striped" data-toggle="data-table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Title</th>
                                            <th>action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($otherDataTable as $other)
                                        <tr>
                                            <td>{{$other->name}}</td>
                                            <td>{{$other->title}}</td>
                                            <td>
                                                @php
                                                echo app('App\Http\Controllers\Security\PermissionController')->getActionModal($other->id);
                                                @endphp
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
            </div>
        </div>
    </div>

    @include('partials.components.share-offcanvas')
</x-app-layout>
