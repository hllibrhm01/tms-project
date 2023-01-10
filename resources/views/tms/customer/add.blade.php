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
                                        <h3 class="card-title">Müşteri Ekle</h3>
                                    </div>
                                    <div class="card-body">
                                        <form method="POST" action="{{ route('post.tms.customer.add') }}">
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
                                                            <label class="control-label">Çalışma Şekli :</label>
                                                        </div>
                                                        <div class="col-6">
                                                            <select class="form-control" id="work_type" name="work_type">
                                                                @foreach (config('constants.work_types') as $key => $value)
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
                                                            <label class="control-label" for="company_name">Şirket Adı
                                                                :</label>
                                                        </div>
                                                        <div class="col-6">
                                                            <input type="text" class="form-control" name="company_name"
                                                                style="text-transform:uppercase"
                                                                placeholder="Şirket adı giriniz">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div class="col-6 mt-2">
                                                            <label class="control-label" for="tax_department_id">Vergi
                                                                Dairesi İli:</label>
                                                        </div>
                                                        <div class="col-6">
                                                            <select class="form-control" id="tax_department_city_id"
                                                                name="tax_department_city_id">
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
                                            </div>
                                            <div class="row p-2">
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div class="col-6 mt-2">
                                                            <label class="control-label" for="payment_type">Ödeme Şekli
                                                                :</label>
                                                        </div>
                                                        <div class="col-6">
                                                            <select class="form-control" id="payment_type"
                                                                name="payment_type">
                                                                @foreach (config('constants.payment_types') as $key => $value)
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
                                                            <label class="control-label"
                                                                for="tax_department_district_id">Vergi Dairesi İlçesi
                                                                :</label>
                                                        </div>
                                                        <div class="col-6">
                                                            <select class="form-control" id="tax_department_district_id"
                                                                name="tax_department_district_id">
                                                                @foreach ($districts as $district)
                                                                    <option value="{{ $district->id }}"
                                                                        data-select2-id="{{ $district->id }}">
                                                                        {{ $district->name }}</option>
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
                                                            <select class="form-control" id="billing_period"
                                                                name="billing_period">
                                                                @foreach (config('constants.billing_periods') as $key => $value)
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
                                                            <label class="control-label" for="tax_department_id">Vergi
                                                                Dairesi :</label>
                                                        </div>
                                                        <div class="col-6">
                                                            <select class="form-control" id="tax_department_id"
                                                                name="tax_department_id">
                                                                @foreach ($tax_departments as $tax_department)
                                                                    <option value="{{ $tax_department->id }}"
                                                                        data-select2-id="{{ $tax_department->id }}">
                                                                        {{ $tax_department->name }}</option>
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
                                                            <label class="control-label"
                                                                for="progress_payment_type">Hakediş Hesaplama
                                                                :</label>
                                                        </div>
                                                        <div class="col-6">
                                                            <select class="form-control" id="progress_payment_type"
                                                                name="progress_payment_type">
                                                                @foreach (config('constants.progress_payment_types') as $key => $value)
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
                                                            <label class="control-label" for="tax_number">Vergi Numarası
                                                                :</label>
                                                        </div>
                                                        <div class="col-6">
                                                            <input type="number" class="form-control" name="tax_number"
                                                                placeholder="Vergi numarası giriniz">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row p-2">
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div class="col-6 mt-2">
                                                            <label class="control-label"
                                                                for="progress_payment_rate">Hakediş
                                                                Değeri :</label>
                                                        </div>
                                                        <div class="col-6">
                                                            <input type="text" class="form-control" step="any"
                                                                id="progress_payment_rate" name="progress_payment_rate"
                                                                placeholder="Hakediş değeri giriniz">
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
                                                            <input type="text" class="form-control" id="iban"
                                                                name="iban" placeholder="IBAN giriniz">
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
                                                            <textarea type="text" style="text-transform: uppercase;" class="form-control" id="note" name="note" rows="3"
                                                                placeholder="Not giriniz"></textarea>
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
    </section>
@endsection

@section('js')
    <script src="/js/tms/customer/customer.js"></script>
@endsection
