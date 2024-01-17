<x-app-layout :assets="$assets ?? []">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Kedatangan Material</h4>
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
                                    <option selected="" disabled="" value="">Pilih Material</option>
                                    {{-- @foreach ($Dmaterial as $val)
                                        <option value=""> {{ $val->material_name }}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <div class="form-group px-1 mb-0">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-sm" data-toggle="data-table">
                                <thead>
                                    <tr>
                                        <th class="py-2">Vendor Name</th>
                                        <th class="py-2">Material Name</th>
                                        <th class="py-2">Akumulasi Netto Real</th>
                                        <th class="py-2">Akumulasi Netto</th>
                                        <th class="py-2">Potongan Kadar Air</th>
                                        <th class="py-2">#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($Ddetail as $val)
                                        <tr>
                                            <td class="py-3">{{ $val->vendor_name }}</td>
                                            <td>{{ $val->material_name }}</td>
                                            <td>{{ formatNominal($val->akumulasi + $val->kadar_air_kg) }}
                                                {{ $val->type_satuan }}</td>
                                            <td>{{ formatNominal($val->akumulasi) }} {{ $val->type_satuan }}</td>
                                            <td>{{ formatNominal($val->kadar_air_kg) }} {{ $val->type_satuan }} <span
                                                    class="badge bg-success text-white">{{ calcPesentase($val->kadar_air_kg, $val->akumulasi) }}</span>
                                            </td>
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
                    <h5 class="modal-title" id="exampleModalLabel" style="color:white">Detail Penerimaan - RMC
                        Margomulyo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group pt-2">
                                <div class="form-floating custom-form-floating custom-form-floating-sm mb-3">
                                    <input type="text" class="form-control" value="CV. AGUNG SEMBADA" readonly>
                                    <label>Nama Vendor</label>
                                </div>
                            </div>
                            <div class="form-group pt-2">
                                <div class="form-floating custom-form-floating custom-form-floating-sm mb-3">
                                    <input type="text" class="form-control" value="PASIR SRUMBUNG" readonly>
                                    <label>Nama Material</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group pt-2">
                                <div class="form-floating custom-form-floating custom-form-floating-sm mb-3">
                                    <input type="email" class="form-control" value="200.360 Kg (+8,59%)" readonly>
                                    <label>Akumulasi Netto Real</label>
                                </div>
                            </div>
                            <div class="form-group pt-2">
                                <div class="form-floating custom-form-floating custom-form-floating-sm mb-3">
                                    <input type="text" class="form-control" value="184.511 Kg" readonly>
                                    <label>Akumulasi Netto</label>
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
                                        <th>Docket</th>
                                        <th>Surat Jalan</th>
                                        <th>Date</th>
                                        <th>Gross Real</th>
                                        <th>Gross</th>
                                        <th>Tare</th>
                                        <th>Kadar Air</th>
                                        <th>Netto</th>
                                        <th>Netto Real</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($Dtransaction as $key => $val)
                                        <tr>
                                            <td class="py-2" style="font-size:12px">{{ $val->docket }}</td>
                                            <td style="font-size:13px">{{ $val->surat_jalan }}</td>
                                            <td style="font-size:13px">{{ date('Y-m-d H:i', strtotime($val->date_masuk)) }}</td>
                                            <td style="font-size:13px">{{ formatNominal($val->gross_real) }}
                                                <small>{{ $val->satuan }}</small></td>
                                            <td style="font-size:13px">{{ formatNominal($val->gross) }} <small>{{ $val->satuan }}</small>
                                            </td>
                                            <td style="font-size:13px">{{ formatNominal($val->tare) }} <small>{{ $val->satuan }}</small>
                                            </td>
                                            <td style="font-size:13px">{{ formatNominal($val->kadar_air_kg) }}
                                                <small>{{ $val->satuan }}</small> <span
                                                    class="badge bg-success text-white">{{ $val->kadar_air_persen }}%</span>
                                            </td>
                                            <td style="font-size:13px">{{ formatNominal($val->netto) }} <small>{{ $val->satuan }}</small>
                                            </td>
                                            <td style="font-size:13px">{{ formatNominal($val->netto + $val->kadar_air_kg) }}
                                                <small>{{ $val->satuan }}</small></td>
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
