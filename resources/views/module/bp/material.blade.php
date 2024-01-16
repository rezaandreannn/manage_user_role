<x-app-layout :assets="$assets ?? []">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Material Usage</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="card-body d-flex justify-content-start text-center">
                            <div class="form-group px-2 mb-0">
                                <div class="form-floating custom-form-floating custom-form-floating-sm"
                                    style="max-width : 180px">
                                    <input type="text" class="form-control date_flatpicker" value="2024-01-01">
                                    <label style="color: black">Start Date</label>
                                </div>
                            </div>
                            <div class="form-group px-2 mb-0">
                                <div class="form-floating custom-form-floating custom-form-floating-sm"
                                    style="max-width : 140px">
                                    <input type="text" name="start" class="form-control time_flatpicker"
                                        value="08:00:00">
                                    <label style="color: black">Start Time</label>
                                </div>
                            </div>
                            <div class="form-group px-2 mb-0">
                                <div class="form-floating custom-form-floating custom-form-floating-sm"
                                    style="max-width : 180px">
                                    <input type="text" class="form-control date_flatpicker"
                                        value="{{ date('Y-m-d') }}">
                                    <label style="color: black">End Date</label>
                                </div>
                            </div>
                            <div class="form-group px-2 mb-0">
                                <div class="form-floating custom-form-floating custom-form-floating-sm"
                                    style="max-width : 140px">
                                    <input type="text" name="start" class="form-control time_flatpicker"
                                        value="08:00:00">
                                    <label style="color: black">End Time</label>
                                </div>
                            </div>
                            <div class="form-group px-2 mb-0" style="min-width:min-content">
                                <select class="form-select">
                                    <option selected="" disabled="" value="">Pilih BP ...</option>
                                    <option>All</option>
                                    <option>BP1</option>
                                    <option>BP2</option>    
                                </select>
                            </div>
                            <div class="form-group px-1 mb-0">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped" data-toggle="data-table">
                                <thead>
                                    <tr>
                                        <th class="py-2 px-3">No</th>
                                        <th class="py-2">Material Code</th>
                                        <th class="py-2">Material Name</th>
                                        <th class="py-2">Akumulasi Target</th>
                                        <th class="py-2">Akumulasi Aktual </th>
                                        <th class="py-2">Akumulasi Deviasi</th>
                                        <th class="py-2">BP Code</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($result as $key => $val)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $val->material_name }}</td>
                                            <td>{{ $val->material_code }}</td>
                                            <td>{{ formatNominal($val->target) }} <small>{{ $val->satuan }}</small>
                                            </td>
                                            <td>{{ formatNominal($val->actual) }} <small>{{ $val->satuan }}</small>
                                            </td>
                                            <td>{{ calcDeviasi($val->actual, $val->target) }}</td>
                                            <td>{{ $val->bpcode }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- End Div --}}
    </div>
</x-app-layout>
