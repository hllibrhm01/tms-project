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
                        </div>
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="card card-primary">
                                    <div class="card-body">
                                        <form method="POST"
                                            action="{{ route('post.tms.dealer.preorder.edit', ['id' => $order->id]) }}">
                                            @csrf
                                            <input type="hidden" id="customer_id" name="customer_id" value="{{ $order->tms_customer_id }}">
                                            <div class="row p-2">
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-6 mt-2">
                                                        <label class="control-label">Sipariş Tipi :</label>
                                                    </div>
                                                    <div class="col-6">
                                                        <select class="form-control" id="order_type" name="order_type">
                                                            @foreach (config('constants.order_types') as $key => $value)
                                                                <option value="{{ $key }}"
                                                                    data-select2-id="{{ $key }}"
                                                                    @if ($order->order_type == $key) selected @endif>
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
                                                                name="orderer_email"
                                                                placeholder="Sipariş veren emaili giriniz"
                                                                value="{{ $order->orderer_email }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div class="col-6 mt-2">
                                                            <label class="control-label" for="weight">Ağırlık :</label>
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
                                                            <select class="form-control" id="district_id"
                                                                name="district_id">
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
                                                            <textarea type="text" style="text-transform: uppercase;" class="form-control" rows="3" id="note" name="note"
                                                                placeholder="Not giriniz">{{ $order->note }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row p-2">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-3">
                                                            <label class="control-label" for="address_description">Ürün
                                                                Listesi :</label>
                                                        </div>
                                                        <div class="col-6">
                                                            <select class="form-control" id="product_list"
                                                                name="product_list">
                                                                <option value="0" data-select2-id="0">SEÇİNİZ
                                                                </option>
                                                                @foreach ($products as $product)
                                                                    <option value="{{ $product->id }}"
                                                                        data-select2-id="{{ $product->id }}">
                                                                        {{ $product->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-3">
                                                            <button id="btnAddProduct" type="button"
                                                                class="btn btn-primary">Ekle</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row p-2">
                                                <div class="col-12" id="product_list_container">
                                                    <div class="row">
                                                        <table id="productsTable"
                                                            class="table table-bordered table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>Ürün Adı</th>
                                                                    <th>Adet</th>
                                                                    <th>İşlemler</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($order->products as $orderProduct)
                                                                    <tr>
                                                                        <td class="d-none">
                                                                            <input name="productId[]" type="hidden"
                                                                                value="{{ $orderProduct->id }}">
                                                                        </td>
                                                                        <td>{{ $orderProduct->product->name }}</td>
                                                                        <td>
                                                                            <input name="productCount[]" type="number"
                                                                                value="{{ $orderProduct->count }}">
                                                                        </td>
                                                                        <td>
                                                                            <a class="deleteProduct" href="#"
                                                                                data-id="{{ $orderProduct->id }}">
                                                                                <i class="fa fa-trash"></i>SİL
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="float-right mr-2 mb-2">
                                                <button type="submit" class="btn btn-primary">Kaydet</button>
                                            </div>
                                        </form>
                                    </div>
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
    <script src="/js/tms/order/edit.js"></script>
@endsection
