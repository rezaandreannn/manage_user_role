<x-app-layout :assets="$assets ?? []">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Produksi Perdocket</h4>
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
                            <div class="form-group px-2 mb-0" style="min-width:fit-content">
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
                                        <th>Docket</th>
                                        <th>Customer</th>
                                        <th>Mutu</th>
                                        <th>Qty</th>
                                        <th>Accumulate</th>
                                        <th>Date</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($produksi as $pd)
                                        <tr>
                                            <td>{{ $pd->docket }}</td>
                                            <td>{{ $pd->customer }}</td>
                                            <td>{{ $pd->mutu }}</td>
                                            <td>{{ formatNominal($pd->qty) }} m3</td>
                                            <td>{{ formatNominal($pd->delivered_qty) }} of
                                                {{ formatNominal($pd->ordered_qty) }} m3</td>
                                            <td>{{ $pd->created_at }}</td>
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
                    <h5 class="modal-title" id="exampleModalLabel" style="color:white">Detail Produksi Perdocket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group ">
                                <label class="form-label mb-0" style="color: black">Docket Number</label>
                                <input type="text" class="form-control is-valid" value="17788" readonly>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="form-group pt-2">
                                <div class="form-floating custom-form-floating custom-form-floating-sm mb-3">
                                    <input type="text" class="form-control" value="PT Adhi Karya" readonly>
                                    <label>Customer</label>
                                </div>
                            </div>
                            <div class="form-group pt-2">
                                <div class="form-floating custom-form-floating custom-form-floating-sm mb-3">
                                    <input type="email" class="form-control" value="FC 1" readonly>
                                    <label>Mutu</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group">
                                <label class="form-label mb-0" style="color: black">SKLP Number</label>
                                <input type="text" class="form-control is-valid" value="TASK-011" readonly>
                                <div class="valid-feedback">
                                    Posted
                                </div>
                            </div>

                            <div class="form-group pt-2">
                                <div class="form-floating custom-form-floating custom-form-floating-sm mb-3">
                                    <input type="text" class="form-control" value="Tono" readonly>
                                    <label>Operator</label>
                                </div>
                            </div>
                            <div class="form-group pt-2">
                                <div
                                    class="form-floating custom-form-floating custom-form-floating-sm mb-3">
                                    <input type="email" class="form-control" value="BP1 - Margomulyo" readonly>
                                    <label>BP Name</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group ">
                                <label class="form-label mb-0" style="color: black">JO ERP Number</label>
                                <input type="text" class="form-control is-valid" value="MGY01-202401012000"
                                    readonly>
                                <div class="valid-feedback">
                                    Posted
                                </div>
                            </div>
                            <div class="form-group pt-2">
                                <div
                                    class="form-floating custom-form-floating custom-form-floating-sm mb-3">
                                    <input type="text" class="form-control" value="Toni" readonly>
                                    <label>Supir</label>
                                </div>
                            </div>
                            <div class="form-group pt-2">
                                <div
                                    class="form-floating custom-form-floating custom-form-floating-sm mb-3">
                                    <input type="email" class="form-control" value="TM 102" readonly>
                                    <label>Truck</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-3">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped" data-toggle="data-table">
                                <thead>
                                    <tr>
                                        <th>Material</th>
                                        <th>Target</th>
                                        <th>Actual</th>
                                        <th>Deviasi</th>
                                        <th>Volume</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>FATANJUNGJT <br> SMNGRKOPC <br>WATER <br>_PLASTOCRE</td>
                                        <td>367,00 kg <br> 543,00 kg <br> 258,18 kg <br> 3.670,00 g </td>
                                        <td>364,00 kg <br> 556,00 kg <br> 254,00 kg <br> 3.700,00 g</td>
                                        <td>-0,82% <br> +2,39% <br> -1,62% <br> +0,82%</td>
                                        <td>load : 6,5 <small>m3</small><br> akumulasi : 6,5 <small>m3</small><br> order
                                            : 60 <small>m3</small> <br> total batch : 3</td>
                                        <td>start : 2023-01-03 10:20:10 <br> finish : 2023-01-03 10:22:10 <br> record :
                                            2024-01-01 01:00:00 </td>
                                    </tr>
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
