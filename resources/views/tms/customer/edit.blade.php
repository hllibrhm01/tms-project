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
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="spaceUrl" value="{{ $spaceUrl }}">
                            <input type="hidden" class="form-control" id="customerId" value="{{ $customer->id }}">
                            <input type="hidden" id="current_city" value="{{ $customer->tax_department_city_id }}">
                            <input type="hidden" id="current_district" value="{{ $customer->tax_department_district_id }}">
                            <input type="hidden" id="current_tax_department" value="{{ $customer->tax_department_id }}">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">{{ $customer->company_name }}</h3>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('post.tms.customer.edit', ['id' => $customer->id]) }}">
                                        @csrf
                                        <div class="row p-2">
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-6 mt-2">
                                                        <label class="control-label">Grup Tipi :</label>
                                                    </div>
                                                    <div class="col-6">
                                                        <select class="form-control" id="group_type" name="group_type">
                                                            @foreach (config('constants.group_types') as $key => $value)
                                                            <option value="{{ $key }}" data-select2-id="{{ $key }}" @if ($key==$customer->group_type) selected @endif>
                                                                {{ $value }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-6 mt-2">
                                                        <label class="control-label">Çalışma Şekli :</label>
                                                    </div>
                                                    <div class="col-6">
                                                        <select class="form-control" id="work_type" name="work_type">
                                                            @foreach (config('constants.work_types') as $key => $value)
                                                            <option value="{{ $key }}" data-select2-id="{{ $key }}" @if ($key==$customer->work_type) selected @endif>
                                                                {{ $value }}
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
                                                        <label class="control-label" for="company_name">Şirket Adı
                                                            :</label>
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="text" class="form-control" name="company_name" style="text-transform:uppercase" placeholder="Şirket adı giriniz" value="{{ $customer->company_name }}"">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class=" col-6">
                                                        <div class="row">
                                                            <div class="col-6 mt-2">
                                                                <label class="control-label" for="tax_department_id">Vergi
                                                                    Dairesi İli :</label>
                                                            </div>
                                                            <div class="col-6">
                                                                <select class="form-control" id="tax_department_city_id" name="tax_department_city_id">
                                                                    @foreach ($cities as $city)
                                                                    <option value="{{ $city->id }}" data-select2-id="{{ $city->id }}" @if ($key==$customer->tax_department_city_id) selected @endif>
                                                                        {{ $city->name }}
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
                                                                <label class="control-label" for="payment_type">Ödeme Şekli
                                                                    :</label>
                                                            </div>
                                                            <div class="col-6">
                                                                <select class="form-control" id="payment_type" name="payment_type">
                                                                    @foreach (config('constants.payment_types') as $key => $value)
                                                                    <option value="{{ $key }}" data-select2-id="{{ $key }}" @if ($key==$customer->payment_type) selected @endif>
                                                                        {{ $value }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-6 mt-2">
                                                                <label class="control-label" for="tax_department_district_id">Vergi Dairesi İlçesi
                                                                    :</label>
                                                            </div>
                                                            <div class="col-6">
                                                                <select class="form-control" id="tax_department_district_id" name="tax_department_district_id">
                                                                    @foreach ($districts as $district)
                                                                    <option value="{{ $district->id }}" data-select2-id="{{ $district->id }}" @if ($key==$customer->tax_department_district_id) selected @endif>
                                                                        {{ $district->name }}
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
                                                                <label class="control-label" for="billing_period">Fatura
                                                                    Periyodu :</label>
                                                            </div>
                                                            <div class="col-6">
                                                                <select class="form-control" id="billing_period" name="billing_period">
                                                                    @foreach (config('constants.billing_periods') as $key => $value)
                                                                    <option value="{{ $key }}" data-select2-id="{{ $key }}" @if ($key==$customer->billing_period) selected @endif>
                                                                        {{ $value }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-6 mt-2">
                                                                <label class="control-label" for="tax_department_id">Vergi
                                                                    Dairesi :</label>
                                                            </div>
                                                            <div class="col-6">
                                                                <select class="form-control" id="tax_department_id" name="tax_department_id">
                                                                    @foreach ($tax_departments as $tax_department)
                                                                    <option value="{{ $tax_department->id }}" data-select2-id="{{ $tax_department->id }}" @if ($key==$customer->tax_department_id) selected @endif>
                                                                        {{ $tax_department->name }}
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
                                                                <label class="control-label" for="progress_payment_type">Hakediş Hesaplama
                                                                    :</label>
                                                            </div>
                                                            <div class="col-6">
                                                                <select class="form-control" id="progress_payment_type" name="progress_payment_type">
                                                                    @foreach (config('constants.progress_payment_types') as $key => $value)
                                                                    <option value="{{ $key }}" data-select2-id="{{ $key }}" @if ($key==$customer->progress_payment_type) selected @endif>
                                                                        {{ $value }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-6 mt-2">
                                                                <label class="control-label" for="tax_number">Vergi Numarası
                                                                    :</label>
                                                            </div>
                                                            <div class="col-6">
                                                                <input type="number" class="form-control" name="tax_number" placeholder="Vergi numarası giriniz" value="{{ $customer->tax_number }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row p-2">
                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-6 mt-2">
                                                                <label class="control-label" for="progress_payment_rate">Hakediş
                                                                    Değeri :</label>
                                                            </div>
                                                            <div class="col-6">
                                                                <input type="text" class="form-control" step="any" id="progress_payment_rate" name="progress_payment_rate" placeholder="Hakediş değeri giriniz" value="{{ $customer->progress_payment_rate }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                    </div>
                                                </div>
                                                <div class="row p-2">
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-3 mt-2">
                                                                <label class="control-label" for="iban">IBAN :</label>
                                                            </div>
                                                            <div class="col-9">
                                                                <input type="text" class="form-control" id="iban" name="iban" placeholder="IBAN giriniz" value="{{ $customer->iban }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row p-2">
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-3 mt-2">
                                                                <label class="control-label" for="note">Not :</label>
                                                            </div>
                                                            <div class="col-9">
                                                                <textarea type="text" style="text-transform: uppercase;" class="form-control" id="note" name="note" rows="3" placeholder="Not giriniz">{{ $customer->note }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="float-right mt-2">
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
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-tabs">
                <div class="card-header p-0 pt-1">
                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="tab-authors-tab" data-toggle="pill" href="#tab-authors" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">YETKİLİLER</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-products-tab" data-toggle="pill" href="#tab-products" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">ÜRÜNLER</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-adresses-tab" data-toggle="pill" href="#tab-adresses" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">ADRESLER</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-incomes-tab" data-toggle="pill" href="#tab-incomes" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">HAKEDİŞLER</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-order-history-tab" data-toggle="pill" href="#tab-order-history" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">SİPARİŞ GEÇMİŞİ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-paperworks-tab" data-toggle="pill" href="#tab-paperworks" role="tab" aria-controls="tab-paperworks" aria-selected="false">EVRAKLAR</a>
                        </li>
                    </ul>
                </div>

                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-one-tabContent">
                        <div class="tab-pane fade show active" id="tab-authors" role="tabpanel" aria-labelledby="tab-authors-tab">
                            <table id="authorsTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>AD-SOYADI</th>
                                        <th>ÜNVAN</th>
                                        <th>TELEFON</th>
                                        <th>EMAİL</th>
                                        <th>
                                            <a href="#" id="addAuthors" data-toggle="modal" data-target="#modal-authors">
                                                <i class="nav-icon fa fa-plus"></i>YENİ EKLE</a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customer->authors as $author)
                                    <tr>
                                        <td>{{ $author->name }}</td>
                                        <td>{{ $author->title }}</td>
                                        <td>{{ $author->phone }}</td>
                                        <td>{{ $author->email }}</td>
                                        <td>
                                            <a class="deleteAuthor" href="" data-id={{ $author->id }}><i class="fa fa-trash"></i>SİL</a>
                                            <a class="editAuthor" style="margin-left: 20px" href="" data-id={{ $author->id }}>
                                                <i class="fa fa-pen"></i>GÜNCELLE</a>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="tab-adresses" role="tabpanel" aria-labelledby="tab-adresses-tab">
                            <table id="addressesTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>İL</th>
                                        <th>İLÇE</th>
                                        <th>ADRES</th>
                                        <th>FATURA ADRESİ Mİ?</th>
                                        <th>
                                            <a href="#" id="addAddress" data-toggle="modal" data-target="#modal-addresses">
                                                <i class="nav-icon fa fa-plus"></i>YENİ EKLE</a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customer->addresses as $address)
                                    <tr>
                                        <td>{{ $address->city->name }}</td>
                                        <td>{{ $address->district->name }}</td>
                                        <td>{{ $address->address }}</td>
                                        <td>
                                            @if ($address->is_invoice_address === 0)
                                            HAYIR
                                            @else
                                            EVET
                                            @endif
                                        </td>
                                        <td>
                                            <a class="deleteAddress" href="" data-id={{ $address->id }}><i class="fa fa-trash"></i>SİL</a>
                                            <a class="editAddress" style="margin-left: 20px" href="" data-id={{ $address->id }}>
                                                <i class="fa fa-pen"></i>GÜNCELLE</a>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane fade" id="tab-incomes" role="tabpanel" aria-labelledby="tab-incomes-tab">
                            <table id="incomesTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>TARİH</th>
                                        <th>FİYAT(₺)</th>
                                        <th style="width: 200px">
                                            <a href="#" id="addIncome" data-toggle="modal" data-target="#modal-incomes">
                                                <i class="nav-icon fa fa-plus"></i>YENİ EKLE</a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customer->incomes as $customerIncome)
                                    <tr>
                                        <td>{{ $customerIncome->date }}</td>
                                        <td>{{ $customerIncome->income }}</td>
                                        <td>
                                            <a class="deleteIncome" href="" data-id={{ $customerIncome->id }}><i class="fa fa-trash"></i>SİL</a>
                                            <a class="editIncome" style="margin-left: 20px" href="" data-id={{ $customerIncome->id }}>
                                                <i class="fa fa-pen"></i>GÜNCELLE</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="tab-order-history" role="tabpanel" aria-labelledby="tab-order-history-tab">
                            <table id="earningsTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>SİPARİŞ VEREN BİLGİSİ</th>
                                        <th>ÜRÜN BİLGİSİ</th>
                                        <th>TARİH BİLGİSİ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order as $ord)
                                    <tr>
                                        <td>{!! $ord->getOrdererInfo() !!}</td>
                                        <td>
                                            <a href="{{ route('get.tms.order.view', ['id' => $ord->id]) }}">
                                                {!! $ord->getProductInfo() !!}
                                            </a>
                                        </td>
                                        <td>{{ $ord->created_at }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="tab-paperworks" role="tabpanel" aria-labelledby="tab-paperworks-tab">
                            <table id="paperworksTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>EVRAK TÜRÜ</th>
                                        <th>AÇIKLAMA</th>
                                        <th>EVRAK</th>
                                        <th style="width: 200px">
                                            <a href="#" id="addPaperwork" data-toggle="modal" data-target="#modal-paperworks">
                                                <i class="nav-icon fa fa-plus"></i>YENİ EKLE</a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customer->papers as $paper)
                                    <tr>
                                        <td>{{ config('constants.paper_types')[$paper->type] }}</td>
                                        <td>{{ $paper->description }}</td>
                                        <td><a href="{{ do_space_url($paper->path) }}" target="_blank">İNDİR</a>
                                        </td>
                                        <td>
                                            <a class="deletePaperwork" href="" data-id={{ $paper->id }}><i class="fa fa-trash"></i>SİL</a>
                                            <a class="editPaperwork" style="margin-left: 20px" href="" data-id={{ $paper->id }}>
                                                <i class="fa fa-pen"></i>GÜNCELLE</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="tab-products" role="tabpanel" aria-labelledby="tab-products-tab">
                            <table id="productsTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ÜRÜN BİLGİSİ</th>
                                        <th>FİYAT</th>
                                        <th style="width: 200px">
                                            <a href="#" id="addProduct" data-toggle="modal" data-target="#modal-products">
                                                <i class="nav-icon fa fa-plus"></i>YENİ EKLE</a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customer->products as $product)
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td>
                                            <a class="deleteProduct" href="" data-id={{ $product->id }}><i class="fa fa-trash"></i>SİL</a>
                                            <a class="editProduct" style="margin-left: 20px" href="" data-id={{ $product->id }}>
                                                <i class="fa fa-pen"></i>GÜNCELLE</a>
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
    <!-- Address Modals Start -->
    <div class="modal fade" id="modal-authors">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Yetkili Ekle/Güncelle</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="id">
                        </div>

                        <div class="form-group">
                            <input type="hidden" class="form-control" id="customer_id" name="customer_id" value="{{ $customer->id }}">
                        </div>

                        <div class="input-group mt-4 row">
                            <div class="col-sm-2">
                                <label class="control-label" for="name">Ad-Soyadı:</label>
                            </div>
                            <div class="col">
                                <input type="text" style="text-transform:uppercase;" class="form-control input-sm" id="name" name="name" placeholder="Ad-Soyadı giriniz">
                            </div>
                        </div>

                        <div class="input-group mt-4 row">
                            <div class="col-sm-2">
                                <label class="control-label" for="title">Ünvan:</label>
                            </div>
                            <div class="col">
                                <input type="text" style="text-transform:uppercase;" class="form-control input-sm" id="title" name="title" placeholder="Ünvan giriniz">
                            </div>
                        </div>

                        <div class="input-group mt-4 row">
                            <div class="col-sm-2">
                                <label class="control-label" for="title">Telefon:</label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control input-sm" id="phone" name="phone" placeholder="Telefon giriniz">
                            </div>
                        </div>

                        <div class="input-group mt-4 row">
                            <div class="col-sm-2">
                                <label class="control-label" for="title">Email:</label>
                            </div>
                            <div class="col">
                                <input type="email" style="text-transform:lowercase;" class="form-control input-sm" id="email" name="email" placeholder="E-posta giriniz">
                            </div>
                        </div>

                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
                            <button id="btnAddAuthorButton" type="button" class="btn btn-primary">Ekle</button>
                            <button id="btnEditAuthorButton" type="button" class="btn btn-primary">Düzenle</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Address Modals Start -->
    <div class="modal fade" id="modal-products">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Ürün Ekle/Güncelle</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="id">
                        </div>

                        <div class="form-group">
                            <input type="hidden" class="form-control" id="customer_id" name="customer_id" value="{{ $customer->id }}">
                        </div>

                        <div class="input-group mt-4 mb-4 row">
                            <div class="col-sm-2">
                                <label>İsim :</label>
                            </div>
                            <div class="col">
                                <input type="text" style="text-transform:uppercase;" class="form-control input-sm" id="name" name="name" placeholder="Ürün ismi giriniz">
                            </div>
                        </div>

                        <div class="input-group mt-4 mb-4 row">
                            <div class="col-sm-2">
                                <label>Fiyat :</label>
                            </div>
                            <div class="col">
                                <input type="number" step="any" class="form-control input-sm" id="price" name="price" placeholder="Ürün fiyatı giriniz">
                            </div>
                        </div>

                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
                            <button id="btnAddProductButton" type="button" class="btn btn-primary">Ekle</button>
                            <button id="btnEditProductButton" type="button" class="btn btn-primary">Düzenle</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Address Modals Start -->
    <div class="modal fade" id="modal-addresses">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Adres Ekle/Güncelle</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="id">
                        </div>

                        <div class="form-group">
                            <input type="hidden" class="form-control" id="customer_id" name="customer_id" value="{{ $customer->id }}">
                        </div>

                        <div class="input-group mt-4 row">
                            <div class="col-sm-2">
                                <label class="control-label" for="city_id">İl :</label>
                            </div>
                            <div class="col">
                                <select class="form-control" id="city_id" name="city_id">
                                    @foreach ($cities as $city)
                                    <option value="{{ $city->id }}" data-select2-id="{{ $city->id }}">
                                        {{ $city->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="input-group mt-4 row">
                            <div class="col-sm-2">
                                <label class="control-label" for="district_id">İlçe :</label>
                            </div>
                            <div class="col">
                                <select class="form-control" id="district_id" name="district_id">
                                    @foreach ($districts as $district)
                                    <option value="{{ $district->id }}" data-select2-id="{{ $district->id }}">
                                        {{ $district->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="input-group mt-4 row">
                            <div class="col-sm-2">
                                <label>Adres :</label>
                            </div>
                            <div class="col">
                                <input type="text" style="text-transform:uppercase;" class="form-control input-sm" id="address" name="address" placeholder="Adres giriniz">
                            </div>
                        </div>
                        <div class="input-group mt-4 row">
                            <div class="col-sm-2">
                                <label>Fatura Adresi :</label>
                            </div>
                            <div class="col">
                                <select class="form-control select2bs4 select2-hidden-accessible" id="is_invoice_address" name="is_invoice_address" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                    <option value="0" data-select2-id="0">HAYIR</option>
                                    <option value="1" data-select2-id="1">EVET</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
                            <button id="btnAddAddressButton" type="button" class="btn btn-primary">Ekle</button>
                            <button id="btnEditAddressButton" type="button" class="btn btn-primary">Düzenle</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-incomes">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Hakediş Ekle/Güncelle</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="id">
                        </div>

                        <div class="form-group">
                            <input type="hidden" class="form-control" id="customer_id" name="customer_id" value="{{ $customer->id }}">
                        </div>

                        <div class="form-group">
                            <label>Hakediş Tarihi :</label>
                            <input type="date" class="form-control input-sm" id="date" name="date" placeholder="Hakediş tarihi giriniz">
                        </div>
                        <div class="form-group">
                            <label>Fiyat(₺)</label>
                            <input type="number" id="income" name="income" class="form-control" placeholder="Fiyat giriniz">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
                        <button id="btnAddIncomeButton" type="button" class="btn btn-primary">Ekle</button>
                        <button id="btnEditIncomeButton" type="button" class="btn btn-primary">Düzenle</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modals Start -->
    <div class="modal fade" id="modal-paperworks">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Evrak İşlemleri</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- form start -->
                    <form method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <input type="hidden" class="form-control" name="id">
                            </div>

                            <div class="form-group">
                                <input type="hidden" class="form-control" name="customer_id" value="{{ $customer->id }}">
                            </div>

                            <div class="form-group">
                                <label>Evrak Türü</label>
                                <select class="form-control select2bs4 select2-hidden-accessible" id="paper_type" name="paper_type" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                    @foreach (config('constants.paper_types') as $key => $value)
                                    <option value={{ $key }} data-select2-id="{{ $key }}">
                                        {{ $value }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Açıklama</label>
                                <textarea class="form-control" name="description" placeholder="Açıklama Giriniz"> </textarea>
                            </div>

                            <div class="form-group">
                                <label for="file">Evrak</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="paperFile">
                                        <label class="custom-file-label" for="file">Evrak Seç</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
                            <button id="btnAddPaper" type="button" class="btn btn-primary">Ekle</button>
                            <button id="btnEditPaper" type="button" class="btn btn-primary">Düzenle</button>
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
<script src="/js/tms/customer/address.js"></script>
<script src="/js/tms/customer/author.js"></script>
<script src="/js/tms/customer/income.js"></script>
<script src="/js/tms/customer/paper-work.js"></script>
<script src="/js/tms/customer/product.js"></script>
@endsection