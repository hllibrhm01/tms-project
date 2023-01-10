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
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Sipariş Ekle</h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('post.tms.order.add') }}"
                                        enctype="multipart/form-data">
                                        @csrf
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
                                                                    data-select2-id="{{ $key }}">
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
                                                                    data-select2-id="{{ $key }}">
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
                                                            @foreach ($customers as $customer)
                                                                <option value="{{ $customer->id }}" data-select2-id="1">
                                                                    {{ $customer->name }}
                                                                </option>
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
                                                        <label class="control-label" for="orderer_name">Ad-Soyadı :</label>
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="text" style="text-transform: uppercase;" class="form-control" id="orderer_name"
                                                            name="orderer_name" placeholder="Sipariş veren adı giriniz">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-6 mt-2">
                                                        <label class="control-label" for="orderer_phone">Telefon :</label>
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="text" class="form-control" id="orderer_phone"
                                                            name="orderer_phone"
                                                            placeholder="Sipariş veren telefon numarası giriniz">
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
                                                        <input type="email" style="text-transform: lowercase;" class="form-control" id="orderer_email"
                                                            name="orderer_email" placeholder="Sipariş veren emaili giriniz">
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
                                                            name="weight" placeholder="Ağırlık giriniz">
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
                                                            @foreach ($cities as $city)
                                                                <option value="{{ $city->id }}"
                                                                    data-select2-id="{{ $city->id }}">
                                                                    {{ $city->name }}
                                                                </option>
                                                            @endforeach
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
                                                            @foreach ($districts as $district)
                                                                <option value="{{ $district->id }}"
                                                                    data-select2-id="{{ $district->id }}">
                                                                    {{ $district->name }}
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
                                                        <textarea type="text" style="text-transform: uppercase;" class="form-control" rows="3" id="address_description" name="address_description"
                                                            placeholder="Adres tarifi giriniz"></textarea>
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
                                                            placeholder="Not giriniz"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row p-2">
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-6 mt-2">
                                                        <label class="control-label" for="weight">Sipariş Email Dosyası
                                                            :</label>
                                                    </div>
                                                    <div class="col-6">
                                                        <input style="ml-4" type="file" id="attachment"
                                                            name="attachment" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
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
                                                            <option value="0" data-select2-id="0">SEÇİNİZ</option>
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
                                                    <table id="productsTable" class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th class="d-none"></th>
                                                                <th>Ürün Adı</th>
                                                                <th>Adet</th>
                                                                <th>İşlemler</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="float-right mt-3">
                                            <button type="submit" class="btn btn-primary">Kaydet</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
@endsection

@section('js')
    <script src="/js/tms/order/add.js"></script>
@endsection