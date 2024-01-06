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
                                <h4 class="me-2 h4"> {!! $headerAction ?? '' !!}</h4>
                            </div>
                        </div>
                        <ul class="d-flex nav nav-pills mb-0 text-center profile-tab" data-toggle="slider-tab" id="profile-pills-tab" role="tablist">
                            @can('update-setting-permission')
                            <li class="nav-item">
                                <a class="nav-link active show" data-bs-toggle="tab" href="#profile-feed" role="tab" aria-selected="false">Module</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#profile-activity" role="tab" aria-selected="false">Location</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#profile-friends" role="tab" aria-selected="false">Other</a>
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
                <div id="profile-feed" class="tab-pane fade active show">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title mb-0">Module</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
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
                                            @foreach($moduleDataTable as $module)
                                            <tr>
                                                <td>{{$module->name}}</td>
                                                <td>{{$module->title}}</td>
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
                <div id="profile-activity" class="tab-pane fade">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title mb-0">Location</h4>
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
                                        @foreach($locationDataTable as $location)
                                        <tr>
                                            <td>{{$location->name}}</td>
                                            <td>{{$location->title}}</td>
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
                <div id="profile-friends" class="tab-pane fade">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title mb-0">Other</h4>
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
