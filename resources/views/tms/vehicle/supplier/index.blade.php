@extends('main.main')

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
                            <form method="GET" action="{{ route('get.tms.supplier.search') }}">
                                <div class="row">
                                    <div class="col-3 pt-1">
                                        <input type="text" name="name" class="form-control"
                                            placeholder="Tedarikçi adı giriniz">
                                    </div>
                                    <div class="col-3 pt-1">
                                        <button type="submit" class="btn btn-primary">ARA</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Tedarikçiler</h3>
                        </div>
                        <div class="card-body">
                            <table id="vehiclesTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Yetkili Adı</th>
                                        <th>Şirket Adı</th>
                                        <th>Telefon Numarası</th>
                                        <th>Emaili</th>
                                        <th>Adresi</th>
                                <tbody>
                                    @foreach ($suppliers as $supplier)
                                        <tr>
                                            <td>{{ $supplier->author }} </td>
                                            <td>{{ $supplier->name }} </td>
                                            <td>{{ $supplier->phone }}</td>
                                            <td>{{ $supplier->email }}</td>
                                            <td>{{ $supplier->address }}</td>
                                            <td>
                                                <a style="padding: 0 10px"
                                                    href="{{ route('get.tms.vehicle.supplier.view', ['id' => $supplier->id]) }}">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                    GÖRÜNTÜLE
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
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
@endsection
