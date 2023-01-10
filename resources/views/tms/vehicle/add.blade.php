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
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">YENİ ARAÇ EKLE</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('post.tms.vehicle.add') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-3 p-3" style="border: 1px solid rgb(102, 99, 99); border-radius:2px">
                                        <div class="row">
                                            <div class="col-9">
                                                <label class="control-label">Dedike Edilecek Müşteri :</label>
                                            </div>
                                            <div class="col-9">
                                                <select class="form-control" id="dedicated_customer_id" name="dedicated_customer_id">
                                                    <option value="0" data-select2-id="0">SEÇİNİZ</option>
                                                    @foreach ($customers as $customer)
                                                        <option value="{{ $customer->id }}"
                                                            data-select2-id="{{ $customer->id }}">
                                                            {{ $customer->company_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-9">
                                                <label class="control-label">Sürücü :</label>
                                            </div>
                                            <div class="col-9">
                                                <select class="form-control" id="driver_id" name="driver_id">
                                                    @foreach ($drivers as $driver)
                                                        <option value="{{ $driver->id }}"
                                                            data-select2-id="{{ $driver->id }}">
                                                            {{ $driver->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-9">
                                                <label class="control-label">Marka :</label>
                                            </div>
                                            <div class="col-9">
                                                <select class="form-control mb-4" id="trademark" name="trademark">
                                                    @foreach (config('constants.vehicle_trademarks') as $key => $value)
                                                        <option value="{{ $key }}"
                                                            data-select2-id="{{ $key }}">
                                                            {{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-9">
                                                <label class="control-label">Model :</label>
                                            </div>
                                            <div class="col-9">
                                                <input type="text" style="text-transform: uppercase;" class="form-control" id="model" name="model"
                                                    placeholder="Araç modeli giriniz">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-9">
                                                <label class="control-label">Plaka :</label>
                                            </div>
                                            <div class="col-9">
                                                <input type="text" style="text-transform:uppercase" minlength="7"
                                                    maxlength="8" class="form-control" id="licence_plate"
                                                    name="licence_plate" placeholder="Plaka giriniz">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-9">
                                                <label class="control-label">Yıl :</label>
                                            </div>
                                            <div class="col-9">
                                                <select class="form-control" id="model_date" name="model_date">
                                                    @for ($i = config('constants.vehicle_start_years'); $i <= date('Y'); $i++)
                                                        <option value="{{ $i }}"
                                                            data-select2-id="{{ $i }}">
                                                            {{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-9">
                                                <label class="control-label">Aracın Sabit Adresi :</label>
                                            </div>
                                            <div class="col-9">
                                                <input type="text" class="form-control" id="fixed_address" name="fixed_address"
                                                    placeholder="Aracın sabit adresini giriniz">
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-3 p-3" style="border: 1px solid rgb(102, 99, 99); border-radius:2px">

                                        <div class="row">
                                            <div class="col-9">
                                                <label class="control-label">Taşıma Kapasitesi (TONAJ) :</label>
                                            </div>
                                            <div class="col-9">
                                                <input type="number" class="form-control input-sm" id="capacity"
                                                    name="capacity" placeholder="Taşıma kapasitesini giriniz">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-9">
                                                <label class="control-label">Araç Genişliği :</label>
                                            </div>
                                            <div class="col-9">
                                                <input type="number" class="form-control input-sm" id="width"
                                                    name="width" placeholder="En giriniz">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-9">
                                                <label class="control-label">Araç Uzunluğu :</label>
                                            </div>
                                            <div class="col-9">
                                                <input type="number" class="form-control input-sm" id="size"
                                                    name="size" placeholder="Boy giriniz">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-9">
                                                <label class="control-label">Araç Yüksekliği :</label>
                                            </div>
                                            <div class="col-9">
                                                <input type="number" class="form-control input-sm" id="height"
                                                    name="height" placeholder="Yükseklik giriniz">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-9">
                                                <label class="control-label">Kime Ait :</label>
                                            </div>
                                            <div class="col-9">
                                                <select class="form-control mb-4" id="ownership" name="ownership">
                                                    @foreach (config('constants.vehicle_belong_type') as $key => $value)
                                                        <option value="{{ $key }}"
                                                            data-select2-id="{{ $key }}">
                                                            {{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row" id="supplier_div" name="supplier_div">
                                            <div class="col-9">
                                                <label class="control-label">Tedarikçi Adı :</label>
                                            </div>
                                            <div class="col-10">
                                                <select class="form-control" id="supplier_id" name="supplier_id">
                                                    @foreach ($suppliers as $supplier)
                                                        <option value="{{ $supplier->id }}"
                                                            data-select2-id="{{ $supplier->id }}">
                                                            {{ $supplier->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-3 p-3" style="border: 1px solid rgb(102, 99, 99); border-radius:2px">
                                        <div class="row mt-2">
                                            <div class="col-9">
                                                <label class="control-label">Araç Kilometresi :</label>
                                            </div>
                                            <div class="col-9">
                                                <input type="number" class="form-control" id="kilometer"
                                                    name="kilometer" placeholder="Araç kilometresi giriniz">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-9">
                                                <label class="control-label">Bakım Kilometresi :</label>
                                            </div>
                                            <div class="col-9">
                                                <input type="number" class="form-control" id="care_kilometer"
                                                    name="care_kilometer" placeholder="Araç bakım kilometresi giriniz">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-9">
                                                <label class="control-label">Muayene Tarihi :</label>
                                            </div>
                                            <div class="col-9">
                                                <input type="date" class="form-control input-sm" id="inspection_date"
                                                    name="inspection_date" placeholder="Araç muayene tarihi giriniz">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-9">
                                                <label class="control-label">Yakıt Tük. (100km) :</label>
                                            </div>
                                            <div class="col-9">
                                                <input type="number" step="any" class="form-control input-sm"
                                                    id="average_fuel_consumption" name="average_fuel_consumption"
                                                    placeholder="Aracın ortalama yakıt tüketimini giriniz">
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <label>ACİL DURUMDA ARANACAK</label>
                                            <div class="col-9">
                                                <label class="control-label">Yakınının Adı-Soyadı :</label>
                                            </div>
                                            <div class="col-9">
                                                <input type="text" class="form-control" id="relations_name_surname"
                                                    name="relations_name_surname"
                                                    placeholder="Yakının adını ve soyadını giriniz">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-9">
                                                <label class="control-label">Yakının Telefon Numarası :</label>
                                            </div>
                                            <div class="col-9">
                                                <input type="text" class="form-control" id="relations_phone"
                                                    name="relations_phone"
                                                    placeholder="Yakının telefon numarasını giriniz">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-9">
                                                <label class="control-label">Yakınlık Derecesi :</label>
                                            </div>
                                            <div class="col-9">
                                                <input type="text" class="form-control" id="degree_of_proximity"
                                                    name="degree_of_proximity" placeholder="Yakınlık derecesini giriniz">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-3 p-3" style="border: 1px solid rgb(102, 99, 99); border-radius:2px">
                                        <div class="row mt-3">
                                            <div class="col-9">
                                                <label class="control-label">Araç Takip Sistemi Var Mı ?</label>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="vehicle_tracking_system" name="vehicle_tracking_system">
                                                    <label class="form-check-label" for="vehicle_tracking_system"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-9">
                                                <label class="control-label">Taşıt Tanıma Var Mı ?</label>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="vehicle_recognition" name="vehicle_recognition">
                                                    <label class="form-check-label" for="vehicle_recognition"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-9">
                                                <label class="control-label">Bakım Anlaşması İmzalandı Mı ?</label>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="maintenance_agreement_signature"
                                                        name="maintenance_agreement_signature">
                                                    <label class="form-check-label"
                                                        for="maintenance_agreement_signature"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-9">
                                                <label class="control-label">Zimmet Formu Düzenlendi mi ?</label>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="embezzlement_form" name="embezzlement_form">
                                                    <label class="form-check-label" for="embezzlement_form"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-9">
                                                <label class="control-label">Servisi Tanımlı Mı ?</label>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="service_description" name="service_description">
                                                    <label class="form-check-label" for="service_description"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3" id="service_div" name="service_div">
                                            <div class="col-9">
                                                <label class="control-label">Servis Adları :</label>
                                            </div>
                                            <div class="col-10">
                                                <select class="form-control" id="service_id" name="service_id">
                                                    @foreach ($services as $service)
                                                        <option value="{{ $service->id }}"
                                                            data-select2-id="{{ $service->id }}">
                                                            {{ $service->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
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
    </section>
@endsection

@section('js')
    <script src="/js/tms/vehicle/service.js"></script>
@endsection
