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
                            <h3 class="card-title">{{ $vehicle->licence_plate }} <br>
                                GÖRGÜ KURALLARINA UYUMU : <strong>{{ $vehiclePoints['etiquette_point'] }}</strong> <br>
                                İŞ GÜVENLİĞİ KURALLARINA UYUMU : <strong>{{ $vehiclePoints['safefy_rule_point'] }}</strong>
                                <br>
                                ÇALIŞMA ALANI TEMİZLİK VE DÜZENİNE UYUMU
                                :<strong>{{ $vehiclePoints['work_area_cleaning_point'] }}</strong>
                                <br>
                                VERDİĞİ HİZMET KALİTESİ : <strong>{{ $vehiclePoints['service_quality_point'] }}</strong>
                            </h3>
                            <div class="form-group">
                                <input type="hidden" class="form-control" id="spaceUrl" value="{{ $spaceUrl }}">
                                <input type="hidden" class="form-control" id="vehicleId" value="{{ $vehicle->id }}">
                                <input type="hidden" id="current_service_id" value="{{ $vehicle->service_id }}">
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('post.tms.vehicle.edit', ['id' => $vehicle->id]) }}">
                                @csrf
                                <div class="row">
                                    <div class="col-3 p-3" style="border: 1px solid rgb(102, 99, 99); border-radius:2px">
                                        <div class="row">
                                            <div class="col-9">
                                                <label class="control-label">Dedike Edilecek Müşteri :</label>
                                            </div>
                                            <div class="col-9">
                                                <select class="form-control" id="dedicated_customer_id"
                                                    name="dedicated_customer_id">
                                                    <option value="0" data-select2-id="0">SEÇİNİZ</option>
                                                    @foreach ($customers as $customer)
                                                        <option value="{{ $customer->id }}"
                                                            data-select2-id="{{ $customer->id }}"
                                                            @if ($vehicle->dedicated_customer_id == $customer->id) selected @endif>
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
                                                            data-select2-id="{{ $driver->id }}"
                                                            @if ($vehicle->driver_id == $driver->id) selected @endif>
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
                                                            data-select2-id="{{ $key }}"
                                                            @if ($key == $vehicle->trademark) selected @endif>
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
                                                <input type="text" class="form-control" id="model" name="model"
                                                    placeholder="Araç modeli giriniz" value="{{ $vehicle->model }}">
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
                                                    name="licence_plate" placeholder="Plaka giriniz"
                                                    value="{{ $vehicle->licence_plate }}">
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
                                                            data-select2-id="{{ $i }}"
                                                            @if ($i == $vehicle->model_date) selected @endif>
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
                                                <input type="text" class="form-control" id="fixed_address"
                                                    name="fixed_address" placeholder="Aracın sabit addresini giriniz"
                                                    value="{{ $vehicle->fixed_address }}">
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
                                                    name="capacity" placeholder="Taşıma kapasitesini giriniz"
                                                    value="{{ $vehicle->capacity }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-9">
                                                <label class="control-label">Araç Genişliği :</label>
                                            </div>
                                            <div class="col-9">
                                                <input type="number" class="form-control input-sm" id="width"
                                                    name="width" placeholder="En giriniz"
                                                    value="{{ $vehicle->width }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-9">
                                                <label class="control-label">Araç Uzunluğu :</label>
                                            </div>
                                            <div class="col-9">
                                                <input type="number" class="form-control input-sm" id="size"
                                                    name="size" placeholder="Boy giriniz"
                                                    value="{{ $vehicle->size }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-9">
                                                <label class="control-label">Araç Yüksekliği :</label>
                                            </div>
                                            <div class="col-9">
                                                <input type="number" class="form-control input-sm" id="height"
                                                    name="height" placeholder="Yükseklik giriniz"
                                                    value="{{ $vehicle->height }}">
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
                                                            data-select2-id="{{ $key }}"
                                                            @if ($key == $vehicle->ownership) selected @endif>
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
                                                            data-select2-id="{{ $supplier->id }}"
                                                            @if ($key == $vehicle->supplier_id) selected @endif>
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
                                                    name="kilometer" placeholder="Araç kilometresi giriniz"
                                                    value="{{ $vehicle->kilometer }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-9">
                                                <label class="control-label">Bakım Kilometresi :</label>
                                            </div>
                                            <div class="col-9">
                                                <input type="number" class="form-control" id="care_kilometer"
                                                    name="care_kilometer" placeholder="Araç bakım kilometresi giriniz"
                                                    value="{{ $vehicle->care_kilometer }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-9">
                                                <label class="control-label">Muayene Tarihi :</label>
                                            </div>
                                            <div class="col-9">
                                                <input type="date" class="form-control input-sm" id="inspection_date"
                                                    name="inspection_date" placeholder="Araç muayene tarihi giriniz"
                                                    value="{{ $vehicle->inspection_date }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-9">
                                                <label class="control-label">Yakıt Tük. (100km) :</label>
                                            </div>
                                            <div class="col-9">
                                                <input type="number" step="any" class="form-control input-sm"
                                                    id="average_fuel_consumption" name="average_fuel_consumption"
                                                    placeholder="Aracın ortalama yakıt tüketimini giriniz"
                                                    value="{{ $vehicle->average_fuel_consumption }}">
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
                                                    placeholder="Yakının adını ve soyadını giriniz"
                                                    value="{{ $vehicle->relations_name_surname }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-9">
                                                <label class="control-label">Yakının Telefon Numarası :</label>
                                            </div>
                                            <div class="col-9">
                                                <input type="text" class="form-control" id="relations_phone"
                                                    name="relations_phone"
                                                    placeholder="Yakının telefon numarasını giriniz"
                                                    value="{{ $vehicle->relations_phone }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-9">
                                                <label class="control-label">Yakınlık Derecesi :</label>
                                            </div>
                                            <div class="col-9">
                                                <input type="text" class="form-control" id="degree_of_proximity"
                                                    name="degree_of_proximity" placeholder="Yakınlık derecesini giriniz"
                                                    value="{{ $vehicle->degree_of_proximity }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3 p-3" style="border: 1px solid rgb(102, 99, 99); border-radius:2px">

                                        <div class="row">
                                            <div class="col-9">
                                                <label class="control-label">Araç Takip Sistemi Var Mı ?</label>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="vehicle_tracking_system" name="vehicle_tracking_system"
                                                        @if ($vehicle->vehicle_tracking_system) checked @endif>
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
                                                        id="vehicle_recognition" name="vehicle_recognition"
                                                        @if ($vehicle->vehicle_recognition) checked @endif>
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
                                                        name="maintenance_agreement_signature"
                                                        @if ($vehicle->maintenance_agreement_signature) checked @endif>
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
                                                        id="embezzlement_form" name="embezzlement_form"
                                                        @if ($vehicle->embezzlement_form) checked @endif>
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
                                                        id="service_description" name="service_description"
                                                        @if ($vehicle->service_description) checked @endif>
                                                    <label class="form-check-label" for="service_description"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3" id="service_div_edit" name="service_div_edit">
                                            <div class="col-9">
                                                <label class="control-label">Servis Adları :</label>
                                            </div>
                                            <div class="col-10">
                                                <select class="form-control" id="service_id" name="service_id">
                                                    @foreach ($services as $service)
                                                        <option value="{{ $service->id }}"
                                                            data-select2-id="{{ $service->id }}"
                                                            @if ($service->id == $vehicle->service_id) selected @endif>
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
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-tabs">
                        <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="tab-equipments-tab" data-toggle="pill"
                                        href="#tab-equipments" role="tab" aria-controls="custom-tabs-one-home"
                                        aria-selected="true">EKİPMANLAR</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab-inspections-tab" data-toggle="pill"
                                        href="#tab-inspections" role="tab" aria-controls="custom-tabs-one-home"
                                        aria-selected="true">MUAYENELER</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab-maintains-tab" data-toggle="pill" href="#tab-maintains"
                                        role="tab" aria-controls="custom-tabs-one-home"
                                        aria-selected="true">BAKIMLAR</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab-incomes-tab" data-toggle="pill" href="#tab-incomes"
                                        role="tab" aria-controls="custom-tabs-one-home"
                                        aria-selected="true">HAKEDİŞLER</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab-paperworks-tab" data-toggle="pill"
                                        href="#tab-paperworks" role="tab" aria-controls="tab-paperworks"
                                        aria-selected="true">EVRAKLAR</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab-hgs-tab" data-toggle="pill" href="#tab-hgs"
                                        role="tab" aria-controls="tab-hgs" aria-selected="true">HGS</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                <div class="tab-pane fade show active" id="tab-equipments" role="tabpanel"
                                    aria-labelledby="tab-equipments-tab">
                                    <table id="equipmentsTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>MALZEME</th>
                                                <th>ADET</th>
                                                <th style="width: 200px">
                                                    <a href="#" id="addEquipment" data-toggle="modal"
                                                        data-target="#modal-equipments">
                                                        <i class="nav-icon fa fa-plus"></i>YENİ EKLE</a>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($vehicle->equipments as $vehicleEquipment)
                                                <tr>
                                                    <td>{{ $vehicleEquipment->equipment->equipment_name }}</td>
                                                    <td>{{ $vehicleEquipment->count }}</td>
                                                    <td>
                                                        <a class="deleteEquipment" href=""
                                                            data-id={{ $vehicleEquipment->id }}><i
                                                                class="fa fa-trash"></i>SİL</a>
                                                        <a class="editEquipment" style="margin-left: 20px" href=""
                                                            data-id={{ $vehicleEquipment->id }}>
                                                            <i class="fa fa-pen"></i>GÜNCELLE</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="tab-hgs" role="tabpanel" aria-labelledby="tab-hgs-tab">
                                    <table id="hgsTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>TARİH</th>
                                                <th>FİYAT(₺)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($vehicle->expenses as $expense)
                                                <tr>
                                                    <td>{{ $expense->date }}</td>
                                                    <td>{{ $expense->highway_expenses }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="tab-inspections" role="tabpanel"
                                    aria-labelledby="tab-inspections-tab">
                                    <table id="inspectionsTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>TARİH</th>
                                                <th>FİYAT(₺)</th>
                                                <th style="width: 200px">
                                                    <a href="#" id="addInspection" data-toggle="modal"
                                                        data-target="#modal-inspections">
                                                        <i class="nav-icon fa fa-plus"></i>YENİ EKLE</a>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($vehicle->inspections as $vehicleInspection)
                                                <tr>
                                                    <td>{{ $vehicleInspection->date }}</td>
                                                    <td>{{ $vehicleInspection->cost }}</td>
                                                    <td>
                                                        <a class="deleteInspection" href=""
                                                            data-id={{ $vehicleInspection->id }}><i
                                                                class="fa fa-trash"></i>SİL</a>
                                                        <a class="editInspection" style="margin-left: 20px"
                                                            href="" data-id={{ $vehicleInspection->id }}>
                                                            <i class="fa fa-pen"></i>GÜNCELLE</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="tab-maintains" role="tabpanel"
                                    aria-labelledby="tab-maintains-tab">
                                    <table id="maintainsTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>TARİH</th>
                                                <th>TİP</th>
                                                <th>KM</th>
                                                <th>FİYAT(₺)</th>
                                                <th style="width: 200px">
                                                    <a href="#" id="addMaintain" data-toggle="modal"
                                                        data-target="#modal-maintains">
                                                        <i class="nav-icon fa fa-plus"></i>YENİ EKLE</a>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($vehicle->maintains as $vehicleMaintain)
                                                <tr>
                                                    <td>{{ $vehicleMaintain->date }}</td>
                                                    <td>{{ config('constants.maintain_types')[$vehicleMaintain->type] }}
                                                    </td>
                                                    <td>{{ $vehicleMaintain->kilometer }}</td>
                                                    <td>{{ $vehicleMaintain->cost }}</td>
                                                    <td>
                                                        <a class="deleteMaintain" href=""
                                                            data-id={{ $vehicleMaintain->id }}><i
                                                                class="fa fa-trash"></i>SİL</a>
                                                        <a class="editMaintain" style="margin-left: 20px" href=""
                                                            data-id={{ $vehicleMaintain->id }}>
                                                            <i class="fa fa-pen"></i>GÜNCELLE</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="tab-incomes" role="tabpanel"
                                    aria-labelledby="tab-incomes-tab">
                                    <table id="incomesTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>TARİH</th>
                                                <th>TOPLAM GİDER</th>
                                                <th>TOPLAM GELİR</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($vehicle->expenses as $expense)
                                                <tr>
                                                    <td>{{ $expense->date }}</td>
                                                    <td>{{ $expense->total_cost }}</td>
                                                    <td>{{ $expense->total_revenue }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="tab-paperworks" role="tabpanel"
                                    aria-labelledby="tab-paperworks-tab">
                                    <table id="paperworksTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>EVRAK TÜRÜ</th>
                                                <th>AÇIKLAMA</th>
                                                <th>EVRAK</th>
                                                <th style="width: 200px">
                                                    <a href="#" id="addPaperwork" data-toggle="modal"
                                                        data-target="#modal-paperworks">
                                                        <i class="nav-icon fa fa-plus"></i>YENİ EKLE</a>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($vehicle->papers as $paper)
                                                <tr>
                                                    <td>{{ config('constants.vehicle_paper_types')[$paper->type] }}</td>
                                                    <td>{{ $paper->description }}</td>
                                                    <td><a href="{{ do_space_url($paper->path) }}"
                                                            target="_blank">İNDİR</a> </td>
                                                    <td>
                                                        <a class="deletePaperwork" href=""
                                                            data-id={{ $paper->id }}><i class="fa fa-trash"></i>SİL</a>
                                                        <a class="editPaperwork" style="margin-left: 20px" href=""
                                                            data-id={{ $paper->id }}>
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
            <!-- Equipments Modals Start -->
            <div class="modal fade" id="modal-equipments">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Ekipman Ekle/Güncelle</h4>
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
                                    <input type="hidden" class="form-control" name="vehicle_id"
                                        value="{{ $vehicle->id }}">
                                </div>

                                <div class="form-group">
                                    <label>Ekipman</label>
                                    <select class="form-control" id="equipment_id" name="equipment_id">
                                        @foreach ($equipments as $equipment)
                                            <option value="{{ $equipment->id }}" data-select2-id="{{ $equipment->id }}">
                                                {{ $equipment->equipment_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Adet</label>
                                    <input type="number" id="count" name="count" class="form-control"
                                        placeholder="Ekipman Sayısı Giriniz">
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
                                <button id="btnAddEquipmentButton" type="button" class="btn btn-primary">Ekle</button>
                                <button id="btnEditEquipmentButton" type="button"
                                    class="btn btn-primary">Düzenle</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Inspections Modals Start -->
            <div class="modal fade" id="modal-hgs">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">HGS Ekle/Güncelle</h4>
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
                                    <input type="hidden" class="form-control" id="vehicle_id" name="vehicle_id"
                                        value="{{ $vehicle->id }}">
                                </div>

                                <div class="form-group">
                                    <label>HGS Yüklenme Tarihi :</label>
                                    <input type="date" class="form-control input-sm" id="date" name="date"
                                        placeholder="Araç muayene tarihi giriniz">
                                </div>
                                <div class="form-group">
                                    <label>Fiyat(₺)</label>
                                    <input type="number" id="cost" name="cost" class="form-control"
                                        placeholder="Fiyat giriniz">
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
                                <button id="btnAddHGSButton" type="button" class="btn btn-primary">Ekle</button>
                                <button id="btnEditHGSButton" type="button" class="btn btn-primary">Düzenle</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Inspections Modals Start -->
            <div class="modal fade" id="modal-inspections">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Muayene Ekle/Güncelle</h4>
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
                                    <input type="hidden" class="form-control" id="vehicle_id" name="vehicle_id"
                                        value="{{ $vehicle->id }}">
                                </div>

                                <div class="form-group">
                                    <label>Muayene Tarihi :</label>
                                    <input type="date" class="form-control input-sm" id="date" name="date"
                                        placeholder="Araç muayene tarihi giriniz">
                                </div>
                                <div class="form-group">
                                    <label>Fiyat(₺)</label>
                                    <input type="number" id="cost" name="cost" class="form-control"
                                        placeholder="Fiyat giriniz">
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
                                <button id="btnAddInspectionButton" type="button" class="btn btn-primary">Ekle</button>
                                <button id="btnEditInspectionButton" type="button"
                                    class="btn btn-primary">Düzenle</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Maintains Modals Start -->
            <div class="modal fade" id="modal-maintains">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Bakım Ekle/Güncelle</h4>
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
                                    <input type="hidden" class="form-control" id="vehicle_id" name="vehicle_id"
                                        value="{{ $vehicle->id }}">
                                </div>

                                <div class="form-group">
                                    <label>Bakım Tarihi :</label>
                                    <input type="date" class="form-control input-sm" id="date" name="date"
                                        placeholder="Araç bakım tarihi giriniz">
                                </div>
                                <div class="form-group">
                                    <label>Tip :</label>
                                    <select class="form-control" id="type" name="type">
                                        @foreach (config('constants.maintain_types') as $type => $value)
                                            <option value="{{ $type }}" data-select2-id="{{ $type }}">
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>KM :</label>
                                    <input type="number" id="kilometer" name="kilometer" class="form-control"
                                        placeholder="KM giriniz">
                                </div>
                                <div class="form-group">
                                    <label>Fiyat(₺) :</label>
                                    <input type="number" id="cost" name="cost" class="form-control"
                                        placeholder="Fiyat giriniz">
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
                                <button id="btnAddMaintainButton" type="button" class="btn btn-primary">Ekle</button>
                                <button id="btnEditMaintainButton" type="button"
                                    class="btn btn-primary">Düzenle</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Incomes Modals Start -->
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
                                    <input type="hidden" class="form-control" id="vehicle_id" name="vehicle_id"
                                        value="{{ $vehicle->id }}">
                                </div>

                                <div class="form-group">
                                    <label>Hakediş Tarihi :</label>
                                    <input type="date" class="form-control input-sm" id="date" name="date"
                                        placeholder="Hakediş tarihi giriniz">
                                </div>
                                <div class="form-group">
                                    <label>Fiyat(₺)</label>
                                    <input type="number" id="income" name="income" class="form-control"
                                        placeholder="Fiyat giriniz">
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
                                <button id="btnAddIncomeButton" type="button" class="btn btn-primary">Ekle</button>
                                <button id="btnEditIncomeButton" type="button" class="btn btn-primary">Düzenle</button>
                            </div>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->

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
                                        <input type="hidden" class="form-control" name="vehicle_id"
                                            value="{{ $vehicle->id }}">
                                    </div>

                                    <div class="form-group">
                                        <label>Evrak Türü</label>
                                        <select class="form-control select2bs4 select2-hidden-accessible" id="paper_type"
                                            name="paper_type" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                            @foreach (config('constants.vehicle_paper_types') as $key => $value)
                                                <option value={{ $key }} data-select2-id="{{ $key }}">
                                                    {{ $value }}</option>
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
        </div>
    </section>
@endsection

@section('js')
    <script src="/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/js/tms/vehicle/equipment.js"></script>
    <script src="/js/tms/vehicle/inspection.js"></script>
    <script src="/js/tms/vehicle/maintain.js"></script>
    <script src="/js/tms/vehicle/paper-work.js"></script>
    <script src="/js/tms/vehicle/service.js"></script>
    <script src="/js/tms/vehicle/hgs.js"></script>
@endsection
