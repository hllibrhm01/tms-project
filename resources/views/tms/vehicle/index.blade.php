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
                            <form method="GET" action="{{ route('get.tms.vehicle.search') }}">
                                <div class="row">
                                    <div class="col-3 pt-1">
                                        <input type="text" name="licence_plate" class="form-control"
                                            placeholder="Plaka Giriniz.">
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
                            <h3 class="card-title">Araçlar</h3>
                        </div>
                        <div class="card-body">
                            <table id="vehiclesTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sürücü </th>
                                        <th>Plaka</th>
                                        <th>Araç Markası</th>
                                <tbody>
                                    @foreach ($vehicles as $vehicle)
                                        <tr>
                                            <td>{{ $vehicle->driver->name }} </td>
                                            <td>{{ $vehicle->licence_plate }}</td>
                                            <td>{{ config('constants.vehicle_trademarks')[$vehicle->trademark] }}</td>
                                            <td>
                                                <a style="padding: 0 10px"
                                                    href="{{ route('get.tms.vehicle.view', ['id' => $vehicle->id]) }}">
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
