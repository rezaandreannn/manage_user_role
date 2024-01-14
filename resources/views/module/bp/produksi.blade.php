<x-app-layout :assets="$assets ?? []">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Bootstrap Datatables</h4>
                    </div>
                </div>
                <div class="card-body">
                    <p>Images in Bootstrap are made responsive with <code>.img-fluid</code>. <code>max-width: 100%;</code> and <code>height: auto;</code> are applied to the image so that it scales with the parent element.</p>
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped" data-toggle="data-table">
                            <thead>
                                <tr>
                                    <th>Docket</th>
                                    <th>Customer</th>
                                    <th>Mutu</th>
                                    <th>Qty</th>
                                    {{-- <th>Accumulate</th> --}}
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($produksi as $pd)
                                <tr>
                                    <td>{{ $pd->docket }}</td>
                                    <td>{{ $pd->customer}}</td>
                                    <td>{{$pd->mutu}}</td>
                                    <td>{{ $pd->qty}}</td>
                                    {{-- <td></td> --}}
                                    <td>{{ $pd->created_at}}</td>
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
</x-app-layout>
