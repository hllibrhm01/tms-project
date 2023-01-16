@extends('main.main')

@section('css')
    <style>
        input {
            display: none;
        }

        label {
            cursor: pointer;
        }
    </style>
    <link href="{{ asset('/css/main/main.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
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

                                        <input type="hidden" id="noteMandatoryStatus"
                                            value="{{ $setting->note_mandatory_status }}">
                                        <input type="hidden" id="codeMandatoryStatus"
                                            value="{{ $setting->code_mandatory_status }}">
                                        <input type="hidden" id="imageMandatoryStatus"
                                            value="{{ $setting->image_mandatory_status }}">
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" id="vehicle_id" value="{{ $vehicle->id }}">
                                        <input type="hidden" class="form-control" id="plan_date_input" value="{{ $planDate }}">
                                    </div>
                                    <div class="card-body">
                                        <table id="vehicleOrdersTable" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Ürün</th>
                                                    <th>Adres</th>
                                                    <th>Telefon</th>
                                                    <th>Email</th>
                                                    <th>Durumu</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($vehicleOrders as $vehicleOrder)
                                                    <tr orderId="{{ $vehicleOrder->order->id }}">
                                                        <td>
                                                            <a
                                                                href="{{ route('get.tms.order.view', ['id' => $vehicleOrder->order->id]) }}">
                                                                {!! $vehicleOrder->order->getProductInfo() !!}
                                                            </a>
                                                        </td> 
                                                        <td>{{ $vehicleOrder->order->address_description }}</td>
                                                        <td>{{ $vehicleOrder->order->orderer_phone }}</td>
                                                        <td>{{ $vehicleOrder->order->orderer_email }}</td>
                                                        @if ($vehicleOrder->order->status >= \App\Models\tms\TMSOrder::STATUS_PENDING_REVIEW)
                                                            <td>
                                                                {{ \App\Models\tms\TMSOrder::OrderStatus[$vehicleOrder->order->status] }}
                                                                ({{ $vehicleOrder->order->getCompleteTime() }})
                                                            </td>
                                                        @else
                                                            <td class="updateStatus"
                                                                orderId="{{ $vehicleOrder->order->id }}">
                                                                <a href="#">
                                                                    {{ \App\Models\tms\TMSOrder::OrderStatus[$vehicleOrder->order->status] }}
                                                                </a>
                                                            </td>
                                                        @endif
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
        <!-- Modals Start -->
        <div class="modal fade" id="modal-status">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Sipariş</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <input type="hidden" class="form-control" name="order_id" id="order_id">
                                </div>

                                <div class="row">
                                    <div class="form-group col-4">
                                        <label for="images1source">
                                            <img src="/img/tms/vehicle/camera.png" style="border: 1px solid gray;"
                                                id="img1" width="100" height="100" />
                                            <input type="file" id="images1source"
                                                onchange="document.getElementById('img1').src = window.URL.createObjectURL(this.files[0])" />
                                            <br />
                                            <span id="imageName"></span>
                                        </label>
                                    </div>
                                    <div class="form-group col-4">
                                        <label for="images2source">
                                            <img src="/img/tms/vehicle/camera.png" style="border: 1px solid gray;"
                                                id="img2" width="100" height="100" />
                                            <input type="file" id="images2source"
                                                onchange="document.getElementById('img2').src = window.URL.createObjectURL(this.files[0])" />
                                            <br />
                                            <span id="imageName"></span>
                                        </label>
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="images3source">
                                            <img src="/img/tms/vehicle/camera.png" style="border: 1px solid gray;"
                                                id="img3" width="100" height="100" />
                                            <input type="file" id="images3source"
                                                onchange="document.getElementById('img3').src = window.URL.createObjectURL(this.files[0])" />
                                            <br />
                                            <span id="imageName"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-4">
                                        <label for="images4source">
                                            <img src="/img/tms/vehicle/camera.png" style="border: 1px solid gray;"
                                                id="img4" width="100" height="100" />
                                            <input type="file" id="images4source"
                                                onchange="document.getElementById('img4').src = window.URL.createObjectURL(this.files[0])" />
                                            <br />
                                            <span id="imageName"></span>
                                        </label>
                                    </div>
                                    <div class="form-group col-4">
                                        <label for="images5source">
                                            <img src="/img/tms/vehicle/camera.png" style="border: 1px solid gray;"
                                                id="img5" width="100" height="100" />
                                            <input type="file" id="images5source"
                                                onchange="document.getElementById('img5').src = window.URL.createObjectURL(this.files[0])" />
                                            <br />
                                            <span id="imageName"></span>
                                        </label>
                                    </div>
                                    <div class="form-group col-4">
                                        <label for="images6source">
                                            <img src="/img/tms/vehicle/camera.png" style="border: 1px solid gray;"
                                                id="img6" width="100" height="100" />
                                            <input type="file" id="images6source"
                                                onchange="document.getElementById('img6').src = window.URL.createObjectURL(this.files[0])" />
                                            <br />
                                            <span id="imageName"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Not :</label>
                                    <textarea type="text" style="text-transform: uppercase;" class="form-control" rows="3" id="note" name="note"
                                        placeholder="Not giriniz"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Durum :</label>
                                    <select class="form-control select2bs4 select2-hidden-accessible" id="status_list"
                                        name="status_list" style="width: 100%;" data-select2-id="17" tabindex="-1"
                                        aria-hidden="true">
                                        @if ($vehicleOrders->count() > 0)
                                        <option value="{{ $vehicleOrder->order->status }}"
                                            data-select2-id="{{ $vehicleOrder->order->status }}" selected>
                                            {{ \App\Models\tms\TMSOrder::OrderStatus[$vehicleOrder->order->status] }}
                                        </option>
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group d-none" id="code_div">
                                    <label>Doğrulama Kodu :</label>
                                    <input type="text" class="form-control" id="code" name="code"
                                        placeholder="Kodu Giriniz">
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
                                <button id="btnUpdateStatusButton" type="button"
                                    class="btn btn-primary">Güncelle</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script src="/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/js/tms/vehicle/vehicle_operations.js"></script>
@endsection
