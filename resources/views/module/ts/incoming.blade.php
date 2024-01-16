<x-app-layout :assets="$assets ?? []">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Incoming Material</h4>
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
                                        <th>Vendor</th>
                                        <th>Material</th>
                                        <th>Netto</th>
                                        <th>Kadar Air</th>
                                        <th>Date</th>
                                        <th>Operator</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($Ddetail as $val)
                                        <tr>
                                            <td>{{ $val->no_nota }}</td>
                                            <td>{{ $val->vendor_name }}</td>
                                            <td>{{ $val->material_name }}</td>
                                            <td>{{ formatNominal($val->netto) }} {{ $val->type_satuan }}</td>
                                            <td>{{ formatNominal($val->kadar_air_persen) }} %</td>
                                            <td>{{ $val->date_masuk }}</td>
                                            <td>{{ $val->operator_1 }}</td>
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
                    <div class="row pb-3">
                        {{-- <div class="col-lg-4 col-md-12 col-sm-12">
                            <div class="card px-2 py-2 bg-gray">
                                <img src="https://www.escapemotions.com/images/mainpage/images/blog_posts_bg/landing-page_blog_93303113643.jpg"
                                    style="height:100%; width:100%;" alt="">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <div class="card px-2 py-2 bg-gray">
                                <img src="https://www.escapemotions.com/images/mainpage/images/blog_posts_bg/landing-page_blog_93303113643.jpg"
                                    style="height:100%; width:100%;" alt="">
                            </div>
                        </div> --}}
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h4 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Capture Timbang Isi
                                    </button>
                                </h4>
                                <div id="collapseOne" class="accordion-collapse collapse"
                                    aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-12 col-sm-12 py-1">
                                                <div class="card px-2 py-2 bg-gray mb-0">
                                                    <img src="https://www.escapemotions.com/images/mainpage/images/blog_posts_bg/landing-page_blog_93303113643.jpg"
                                                        style="height:100%; width:100%;" alt="">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12 col-sm-12 py-1">
                                                <div class="card px-2 py-2 bg-gray mb-0">
                                                    <img src="https://www.escapemotions.com/images/mainpage/images/blog_posts_bg/landing-page_blog_93303113643.jpg"
                                                        style="height:100%; width:100%;" alt="">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12 col-sm-12 py-1">
                                                <div class="card px-2 py-2 bg-gray mb-0">
                                                    <img src="https://www.escapemotions.com/images/mainpage/images/blog_posts_bg/landing-page_blog_93303113643.jpg"
                                                        style="height:100%; width:100%;" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h4 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo" aria-expanded="true"
                                        aria-controls="collapseTwo">
                                        Capture Timbang Kosong
                                    </button>
                                </h4>
                                <div id="collapseTwo" class="accordion-collapse collapse"
                                    aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-12 col-sm-12 py-1">
                                                <div class="card px-2 py-2 bg-gray mb-0">
                                                    <img src="https://www.escapemotions.com/images/mainpage/images/blog_posts_bg/landing-page_blog_93303113643.jpg"
                                                        style="height:100%; width:100%;" alt="">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12 col-sm-12 py-1">
                                                <div class="card px-2 py-2 bg-gray mb-0">
                                                    <img src="https://www.escapemotions.com/images/mainpage/images/blog_posts_bg/landing-page_blog_93303113643.jpg"
                                                        style="height:100%; width:100%;" alt="">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12 col-sm-12 py-1">
                                                <div class="card px-2 py-2 bg-gray mb-0">
                                                    <img src="https://www.escapemotions.com/images/mainpage/images/blog_posts_bg/landing-page_blog_93303113643.jpg"
                                                        style="height:100%; width:100%;" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <div class="form-group pt-2">
                                <div class="form-floating custom-form-floating custom-form-floating-sm mb-3">
                                    <input type="text" class="form-control" value="CV. CERIA KARYA ABADI"
                                        readonly>
                                    <label>Nama Vendor</label>
                                </div>
                            </div>
                            <div class="form-group pt-2">
                                <div class="form-floating custom-form-floating custom-form-floating-sm mb-3">
                                    <input type="email" class="form-control" value="PASIR SRUMBUNG" readonly>
                                    <label>Nama Material</label>
                                </div>
                            </div>
                            <div class="form-group pt-2">
                                <div class="form-floating custom-form-floating custom-form-floating-sm mb-3">
                                    <input type="email" class="form-control" value="MGY0100092" readonly>
                                    <label>No Surat Jalan</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <div class="form-group pt-2">
                                <div class="form-floating custom-form-floating custom-form-floating-sm mb-3">
                                    <input type="text" class="form-control" value="BUDI" readonly>
                                    <label>Supir</label>
                                </div>
                            </div>
                            <div class="form-group pt-2">
                                <div class="form-floating custom-form-floating custom-form-floating-sm mb-3">
                                    <input type="email" class="form-control" value="AA 1566 MK" readonly>
                                    <label>No Polisi</label>
                                </div>
                            </div>
                            <div class="form-group pt-2">
                                <div class="form-floating custom-form-floating custom-form-floating-sm mb-3">
                                    <input type="email" class="form-control is-valid" value="37.650 Kg" readonly>
                                    <label>Netto</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <div class="form-group pt-2">
                                <div class="form-floating custom-form-floating custom-form-floating-sm mb-3">
                                    <input type="text" class="form-control" value="-" readonly>
                                    <label>PO Number</label>
                                </div>
                            </div>
                            <div class="form-group pt-2">
                                <div class="form-floating custom-form-floating custom-form-floating-sm mb-3">
                                    <input type="email" class="form-control" value="-" readonly>
                                    <label>No RR</label>
                                </div>
                            </div>
                            <div class="form-group pt-2">
                                <div class="form-floating custom-form-floating custom-form-floating-sm mb-3">
                                    <input type="email" class="form-control is-invalid" value="Manual - Not Posted"
                                        readonly>
                                    <label>Status</label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row pt-2">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Gross Real</th>
                                        <th>Gross</th>
                                        <th>Kadar Air</th>
                                        <th>Operator</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Timbang 1</td>
                                        <td>2023-01-31 14:00:10</td>
                                        <td>51.760 KG</td>
                                        <td>49.690 KG</td>
                                        <td>2.070 KG <span class="badge bg-success text-white">4%</span></td>
                                        <td>Angga</td>
                                    </tr>
                                    <tr>
                                        <td>Timbang 2</td>
                                        <td>2023-01-31 14:10:10</td>
                                        <td>-</td>
                                        <td>12.040 KG</td>
                                        <td>-</td>
                                        <td>Angga</td>
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
