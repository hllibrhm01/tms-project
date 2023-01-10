@extends('main.main')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="form-group">
                                <input type="hidden" class="form-control" id="orderId" value="{{ $order->id }}">
                                <input type="hidden" id="current_city" value="{{ $order->city_id }}">
                                <input type="hidden" id="current_district" value="{{ $order->district_id }}">
                            </div>
                            <div class="float-right">
                                <a style="padding: 0 10px"
                                    href="{{ route('get.tms.order.tracking', ['id' => $order->id]) }}">
                                    <i class="nav-icon fa fa-truck"></i>
                                    SİPARİŞİ TAKİBİ
                                </a>
                                <a style="padding: 0 10px" href="{{ route('get.tms.order.delete', ['id' => $order->id]) }}">
                                    <i class="nav-icon fa fa-trash"></i>
                                    SİL
                                </a>
                                <a style="padding: 0 10px" href="{{ route('get.tms.order.edit', ['id' => $order->id]) }}">
                                    <i class="nav-icon fa fa-edit"></i>
                                    GÜNCELLE
                                </a>
                            </div>
                        </div>
                        <div class="card-body" style="pointer-events: none;">
                            <div class="col-md-12">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title" style="pointer-events: all;">
                                            <a href="{{ route('get.tms.customer.view', ['id' => $order->customer->id]) }}">
                                                {{ $order->customer->company_name }}
                                            </a>
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row p-2">
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-6 mt-2">
                                                        <label class="control-label">Sipariş Tipi :</label>
                                                    </div>
                                                    <div class="col-6">
                                                        <select class="form-control" id="group_type" name="group_type">
                                                            @foreach (config('constants.order_types') as $key => $value)
                                                                <option value="{{ $key }}"
                                                                    data-select2-id="{{ $key }}"
                                                                    @if ($key == $order->order_type) selected @endif>
                                                                    {{ $value }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row p-2">
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-6 mt-2">
                                                        <label class="control-label">Tipi :</label>
                                                    </div>
                                                    <div class="col-6">
                                                        <select class="form-control" id="group_type" name="group_type">
                                                            <option value="0" data-select2-id="0">SEÇİNİZ</option>
                                                            @foreach (config('constants.group_types') as $key => $value)
                                                                <option value="{{ $key }}"
                                                                    data-select2-id="{{ $key }}"
                                                                    @if ($key == $order->group_type) selected @endif>
                                                                    {{ $value }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-6 mt-2">
                                                        <label class="control-label" for="owner_id">Şirket Adı :</label>
                                                    </div>
                                                    <div class="col-6">
                                                        <select class="form-control" id="owner_id" name="owner_id">
                                                            <option value="{{ $order->owner_id }}"
                                                                data-select2-id="{{ $order->owner_id }}">
                                                                {{ $order->customer->company_name }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row p-2">
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-6 mt-2">
                                                        <label class="control-label" for="orderer_name">Ad-Soyadı
                                                            :</label>
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="text" class="form-control" id="orderer_name"
                                                            name="orderer_name" placeholder="Sipariş veren adı giriniz"
                                                            value="{{ $order->orderer_name }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-6 mt-2">
                                                        <label class="control-label" for="orderer_phone">Telefon
                                                            :</label>
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="text" class="form-control" id="orderer_phone"
                                                            name="orderer_phone"
                                                            placeholder="Sipariş veren telefon numarası giriniz"
                                                            value="{{ $order->orderer_phone }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row p-2">
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-6 mt-2">
                                                        <label class="control-label" for="orderer_email">Email :</label>
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="email" class="form-control" id="orderer_email"
                                                            name="orderer_email" placeholder="Sipariş veren emaili giriniz"
                                                            value="{{ $order->orderer_email }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-6 mt-2">
                                                        <label class="control-label" for="weight">Ağırlık(kg) :</label>
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="number" class="form-control" id="weight"
                                                            name="weight" placeholder="Ağırlık giriniz"
                                                            value="{{ $order->weight }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row p-2">
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-6 mt-2">
                                                        <label class="control-label" for="city_id">Şehir :</label>
                                                    </div>
                                                    <div class="col-6">
                                                        <select class="form-control" id="city_id" name="city_id">
                                                            <option value="{{ $order->city->id }}"
                                                                data-select2-id="{{ $order->city->id }}">
                                                                {{ $order->city->name }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-6 mt-2">
                                                        <label class="control-label" for="district_id">İlçe :</label>
                                                    </div>
                                                    <div class="col-6">
                                                        <select class="form-control" id="district_id" name="district_id">
                                                            <option value="{{ $order->district->id }}"
                                                                data-select2-id="{{ $order->district->id }}">
                                                                {{ $order->district->name }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row p-2">
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-6 mt-2">
                                                        <label class="control-label" for="weight">Sipariş Email
                                                            Dosyası
                                                            :</label>
                                                    </div>
                                                    <div class="col-6">
                                                        <input style="ml-4" type="file" id="attachment"
                                                            name="attachment" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-6 mt-2">
                                                        <label class="control-label" for="address_description">Durumu
                                                            :</label>
                                                    </div>
                                                    <div class="col-6">
                                                        <select class="form-control" name="status" id="status">
                                                            @foreach (\App\Models\tms\TMSOrder::OrderStatus as $key => $value)
                                                                <option value="{{ $key }}"
                                                                    data-select2-id="{{ $key }}">
                                                                    {{ \App\Models\tms\TMSOrder::OrderStatus[$order->status] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row p-2">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-3 mt-2">
                                                        <label class="control-label" for="address_description">Adres
                                                            Tarifi
                                                            :</label>
                                                    </div>
                                                    <div class="col-9 mb-2">
                                                        <textarea type="text" class="form-control" rows="3" id="address_description" name="address_description"
                                                            placeholder="Adres tarifi giriniz">{{ $order->address_description }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row p-2">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-3">
                                                        <label class="control-label" for="note">Not :</label>
                                                    </div>
                                                    <div class="col-9 mb-2">
                                                        <textarea type="text" class="form-control" rows="3" id="note" name="note"
                                                            placeholder="Not giriniz">{{ $order->note }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row p-2">
                                            <div class="col-12" id="product_list_container">
                                                <div class="row">
                                                    <table id="productsTable" class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Ürün Adı</th>
                                                                <th>Adet</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($order->products as $orderProduct)
                                                                @if (!is_null($orderProduct->product))
                                                                <tr>
                                                                    <td>{{ $orderProduct->product->name }}</td>
                                                                    <td>{{ $orderProduct->count }}</td>
                                                                </tr>
                                                                @endif
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Tabs -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-tabs">
                        <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="tab-movements-tab" data-toggle="pill"
                                        href="#tab-movements" role="tab" aria-controls="custom-tabs-one-home"
                                        aria-selected="true">HAREKETLER</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab-photos-tab" data-toggle="pill" href="#tab-photos"
                                        role="tab" aria-controls="custom-tabs-one-home"
                                        aria-selected="true">FOTOĞRAFLAR</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                <div class="tab-pane fade show active" id="tab-movements" role="tabpanel"
                                    aria-labelledby="tab-movements-tab">
                                    <table id="movementsTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>DURUM</th>
                                                <th>TARİH</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($order->status)
                                            @foreach ($movements as $movement)
                                                <tr>
                                                    <td>{{ \App\Models\tms\TMSOrder::OrderStatus[$movement->status] }}
                                                    </td>
                                                    <td>{{ $movement->created_at }}</td>
                                                </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="tab-photos" role="tabpanel"
                                    aria-labelledby="tab-photos-tab">
                                    <table id="photosTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>DURUM</th>
                                                <th>FOTOĞRAF</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orderImages as $key => $value)
                                                <tr>
                                                    <td>{{ \App\Models\tms\TMSOrder::OrderStatus[$key] }}</td>
                                                    <td>
                                                        <div id="carousel{{ $key }}" class="carousel slide"
                                                            data-ride="carousel" style="height: 300px">
                                                            <div class="carousel-inner" style="height: 300px">
                                                                @for ($i = 0; $i < count($orderImages[$key]['images']); $i++)
                                                                    @if ($i == 0)
                                                                        <div class="carousel-item active">
                                                                            <img height="300" class="d-block w-100"
                                                                                src="{{ do_space_url($orderImages[$key]['images'][$i]->image_path) }}">
                                                                        </div>
                                                                    @else
                                                                        <div class="carousel-item">
                                                                            <img height="300" class="d-block w-100"
                                                                                src="{{ do_space_url($orderImages[$key]['images'][$i]->image_path) }}">
                                                                        </div>
                                                                    @endif
                                                                @endfor
                                                            </div>
                                                            <button class="carousel-control-prev" type="button"
                                                                data-target="#carousel{{ $key }}"
                                                                data-slide="prev">
                                                                <span class="carousel-control-prev-icon"
                                                                    aria-hidden="true"></span>
                                                                <span class="sr-only">Önceki</span>
                                                            </button>
                                                            <button class="carousel-control-next" type="button"
                                                                data-target="#carousel{{ $key }}"
                                                                data-slide="next">
                                                                <span class="carousel-control-next-icon"
                                                                    aria-hidden="true"></span>
                                                                <span class="sr-only">Sonraki</span>
                                                            </button>
                                                        </div>
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
    </section>
@endsection

@section('js')
    <script src="/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/js/tms/order/order.js"></script>
@endsection
