@extends('main.main')

@section('css')
    <link href="{{ asset('/css/tms/vehicle/plan.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <a href="{{ route('get.tms.vehicle.view', ['id' => $vehicle->id]) }}">
                                    {{ $vehicle->licence_plate }} Planlaması
                                </a>
                            </h3>
                        </div>
                    </div>
                    <div class="progress progress-xs progress-striped active">
                        <input type="hidden" id="max_capacity" value="{{ $vehicle->capacity }}">
                        <input type="hidden" id="current_capacity" value="{{ $ordersWeight }}">
                        <div id="capacity_progress" class="progress-bar" style="width: {{ $avg }}%"></div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('get.tms.vehicle.plan.vehicle.make') }}"
                        enctype="multipart/form-data">
                        <div class="row">
                            <input type="hidden" id="vehicle_id" name="vehicle_id" value="{{ $vehicle->id }}">
                            <div class="col-3">
                                <div class="input-group date" id="plan_date" data-target-input="nearest">
                                    <input id="plan_date_input" type="text" name="plan_date"
                                        class="form-control datetimepicker-input" data-target="#plan_date"
                                        value="{{ $date }}" />
                                    <div class="input-group-append" data-target="#plan_date" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <button type="submit" class="btn btn-primary">Getir</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Araç Siparişleri</S></h3>
                                    </div>
                                    <div class="card-body">
                                        <table id="vehicleOrdersTable" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10px">#</th>
                                                    <th>Ürün</th>
                                                    <th>Adres</th>
                                                    <th>Telefon</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($vehicleOrders as $vehicleOrder)
                                                    <tr orderId="{{ $vehicleOrder->order->id }}">
                                                        <td></td>
                                                        <td>
                                                            <a
                                                                href="{{ route('get.tms.order.view', ['id' => $vehicleOrder->order->id]) }}">
                                                                {!! $vehicleOrder->order->getProductInfo() !!}
                                                            </a>
                                                        </td>
                                                        <td>{{ $vehicleOrder->order->address_description }}</td>
                                                        <td>{!! $vehicleOrder->order->getOrdererInfo() !!}</td>
                                                        <td>
                                                            <a
                                                                href="{{ route('get.tms.vehicle.plan.delete', ['planId' => $vehicleOrder->id]) }}">
                                                                <i class="nav-icon fa fa-trash">
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Açık Siparişler</h3>
                                    </div>
                                    <div class="card-body">
                                        <table id="ordersTable" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10px">#</th>
                                                    <th>Ürün</th>
                                                    <th>Adres</th>
                                                    <th>Telefon</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($getOrdersOnStatusOpen as $getOrderOnStatusOpen)
                                                    <tr orderId="{{ $getOrderOnStatusOpen->id }}">
                                                        <td><a href="#" class='move-row'>{{ '<' }}</a></td>
                                                        <td>
                                                            <a
                                                                href="{{ route('get.tms.order.view', ['id' => $getOrderOnStatusOpen->id]) }}">
                                                                {!! $getOrderOnStatusOpen->getProductInfo() !!}
                                                            </a>
                                                        </td>
                                                        <td>{{ $getOrderOnStatusOpen->address_description }}</td>
                                                        <td>{!! $getOrderOnStatusOpen->getOrdererInfo() !!}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row float-right pr-1">
                            <button id="save" type="button" class="btn btn-primary">Kaydet</button>
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
    <script src="/js/tms/vehicle/plan.js"></script>
@endsection
