@extends('main.main')

@section('css')
    <link href="{{ asset('/css/main/main.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Arama Yap</h3>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ route('get.tms.customer.search') }}">
                                <div class="row">
                                    <div class="col-3 pt-1">
                                        <input type="text" name="company_name" class="form-control"
                                            placeholder="Şirket Adı Giriniz.">
                                    </div>
                                    <div class="col-2 pt-1">
                                        <button type="submit" class="btn btn-primary">ARA</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Müşteriler</h3>
                        </div>
                        <div class="card-body">
                            <table id="vehiclesTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Grup</th>
                                        <th>Çalışma Şekli</th>
                                        <th>Şirket Adı</th>
                                        <th>Not</th>
                                <tbody>
                                    @if ($customers != null)
                                        @foreach ($customers as $customer)
                                            <tr>
                                                <td>{{ config('constants.group_types')[$customer->group_type] }}</td>
                                                <td>{{ config('constants.work_types')[$customer->work_type] }}</td>
                                                <td>{{ $customer->company_name }}</td>
                                                <td>{{ $customer->note }}</td>
                                                <td>
                                                    <a style="padding: 0 10px"
                                                        href="{{ route('get.tms.customer.view', ['id' => $customer->id]) }}">
                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                        GÖRÜNTÜLE
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script src="/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/js/tms/customer/customer.js"></script>
@endsection
