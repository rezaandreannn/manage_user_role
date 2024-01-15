<x-app-layout :assets="$assets ?? []">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Produksi Percustomer</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="card-body d-flex justify-content-start text-center">
                            <div class="form-group px-2 mb-0">
                                <div
                                    class="form-floating custom-form-floating custom-form-floating-sm" style="max-width : 180px">
                                    <input type="text" class="form-control date_flatpicker" value="2024-01-01">
                                    <label style="color: black">Start Date</label>
                                </div>
                            </div>
                            <div class="form-group px-2 mb-0">
                                <div
                                    class="form-floating custom-form-floating custom-form-floating-sm" style="max-width : 140px">
                                    <input type="text" name="start" class="form-control time_flatpicker" value="08:00:00">
                                    <label style="color: black">Start Time</label>
                                </div>
                            </div>
                            <div class="form-group px-2 mb-0">
                                <div
                                    class="form-floating custom-form-floating custom-form-floating-sm" style="max-width : 180px">
                                    <input type="text" class="form-control date_flatpicker" value="{{ date('Y-m-d') }}">
                                    <label style="color: black">End Date</label>
                                </div>
                            </div>
                            <div class="form-group px-2 mb-0">
                                <div
                                    class="form-floating custom-form-floating custom-form-floating-sm" style="max-width : 140px">
                                    <input type="text" name="start" class="form-control time_flatpicker" value="08:00:00" >
                                    <label style="color: black">End Time</label>
                                </div>
                            </div>
                            <div class="form-group px-2 mb-0" style="min-width:min-content">
                                <select class="form-select">
                                    <option selected="" disabled="" value="">Pilih Customer</option>
                                    @foreach ($Dcustomer as $val)
                                        <option value=""> {{ $val->customer }}</option>
                                    @endforeach
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
                                        <th>Customer</th>
                                        <th>Mutu</th>
                                        <th>Slump</th>
                                        <th>Volume</th>
                                        <th>BP Code</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $Ddetail as $val )
                                    <tr>
                                        <td>{{ $val->customer }}</td>
                                        <td>{{ $val->mutu }}</td>
                                        <td>{{ $val->slump }}</td>
                                        <td>{{ formatNominal($val->akumulasi) }} m3</td>
                                        <td>{{ $val->bpcode }}</td>
                                        <td><a class="btn btn-sm btn-icon btn-info" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal">
                                                <span class="btn-inner">
                                                    <svg width="32" viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M22.4541 11.3918C22.7819 11.7385 22.7819 12.2615 22.4541 12.6082C21.0124 14.1335 16.8768 18 12 18C7.12317 18 2.98759 14.1335 1.54586 12.6082C1.21811 12.2615 1.21811 11.7385 1.54586 11.3918C2.98759 9.86647 7.12317 6 12 6C16.8768 6 21.0124 9.86647 22.4541 11.3918Z"
                                                            stroke="#ffffff"></path>
                                                        <circle cx="12" cy="12" r="5"
                                                            stroke="#ffffff">
                                                        </circle>
                                                        <circle cx="12" cy="12" r="3" fill="#ffffff">
                                                        </circle>
                                                        <mask mask-type="alpha" maskUnits="userSpaceOnUse" x="9"
                                                            y="9" width="6" height="6">
                                                            <circle cx="12" cy="12" r="3"
                                                                fill="#ffffff">
                                                            </circle>
                                                        </mask>
                                                        <circle opacity="0.89" cx="13.5" cy="10.5" r="1.5"
                                                            fill="white"></circle>
                                                    </svg>
                                                </span>
                                            </a>
                                        </td>
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
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="exampleModalLabel" style="color:white">Detail Material Usage</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group pt-2">
                                <div class="form-floating custom-form-floating custom-form-floating-sm mb-3">
                                    <input type="text" class="form-control" value="PT Adhi Karya" readonly>
                                    <label>Customer</label>
                                </div>
                            </div>
                            <div class="form-group pt-2">
                                <div class="form-floating custom-form-floating custom-form-floating-sm mb-3">
                                    <input type="text" class="form-control" value="12+-2" readonly>
                                    <label>Mutu</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group pt-2">
                                <div
                                    class="form-floating custom-form-floating custom-form-floating-sm mb-3">
                                    <input type="email" class="form-control" value="BP1 - Margomulyo" readonly>
                                    <label>BP Name</label>
                                </div>
                            </div>
                            <div class="form-group pt-2">
                                <div class="form-floating custom-form-floating custom-form-floating-sm mb-3">
                                    <input type="text" class="form-control" value="182 m3" readonly>
                                    <label>Total Volume</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group pt-2">
                                <div class="form-floating custom-form-floating custom-form-floating-sm mb-3">
                                    <input type="email" class="form-control" value="2023-11-21 08:00:00" readonly>
                                    <label>Start Date</label>
                                </div>
                            </div>
                             <div class="form-group pt-2">
                                <div class="form-floating custom-form-floating custom-form-floating-sm mb-3">
                                    <input type="text" class="form-control" value="2023-12-20 08:00:00" readonly>
                                    <label>End Date</label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row pt-3">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-sm table-striped" data-toggle="data-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Material Code</th>
                                        <th>Material Name</th>
                                        <th>Akumulasi Target</th>
                                        <th>Akumulasi Aktual </th>
                                        <th>Akumulasi Deviasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($Dmaterial as $key => $val )
                                    <tr>
                                        <td class="py-2">{{ $key +1 }}</td>
                                        <td>{{ $val->material_code }}</td>
                                        <td>{{ $val->material_name }}</td>
                                        <td>{{ formatNominal($val->target) }} <small>{{ $val->satuan }}</small></td>
                                        <td>{{ formatNominal($val->actual) }} <small>{{ $val->satuan }}</small></td>
                                        <td>{{ calcDeviasi($val->actual,$val->target) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    {{-- End Div --}}
    </div>
</x-app-layout>
