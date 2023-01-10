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
                            <form method="GET" action="{{ route('get.tms.service.search') }}">
                                <div class="row">
                                    <div class="col-3 pt-1">
                                        <input type="text" name="name" class="form-control"
                                            placeholder="Servis adı giriniz">
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
                            <h3 class="card-title">Servisler</h3>
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
                                    @foreach ($services as $service)
                                        <tr>
                                            <td>{{ $service->author }} </td>
                                            <td>{{ $service->name }} </td>
                                            <td>{{ $service->phone }}</td>
                                            <td>{{ $service->email }}</td>
                                            <td>{{ $service->address }}</td>
                                            <td>
                                                <a style="padding: 0 10px"
                                                    href="{{ route('get.tms.vehicle.service.view', ['id' => $service->id]) }}">
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
