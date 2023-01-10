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
                                <input type="hidden" class="form-control" id="serviceId" value="{{ $service->id }}">
                            </div>
                            <div class="float-right">
                                <a style="padding: 0 10px"
                                    href="{{ route('get.tms.vehicle.service.delete', ['id' => $service->id]) }}">
                                    <i class="nav-icon fa fa-trash"></i>
                                    SİL
                                </a>
                                <a style="padding: 0 10px"
                                    href="{{ route('get.tms.vehicle.service.edit', ['id' => $service->id]) }}">
                                    <i class="nav-icon fa fa-edit"></i>
                                    GÜNCELLE
                                </a>
                            </div>
                        </div>
                        <div class="card-body" style="pointer-events: none;">
                            <div class="col-md-12">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">{{ $service->name }}</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mt-4">
                                            <div class="col-3">
                                                <label class="control-label">Servis Yetkilisi :</label>
                                            </div>
                                            <div class="col-9">
                                                <input type="text" class="form-control" id="author"
                                                    style="text-transform:uppercase" name="author"
                                                    placeholder="Servis yetkili adı-soyadı giriniz"
                                                    value="{{ $service->author }}">
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-3">
                                                <label class="control-label">Servis Adı :</label>
                                            </div>
                                            <div class="col-9">
                                                <input type="text" class="form-control" id="name"
                                                    style="text-transform:uppercase" name="name"
                                                    value="{{ $service->name }}">
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-3">
                                                <label class="control-label">Servisin Telefon Numarası :</label>
                                            </div>
                                            <div class="col-9">
                                                <input type="text" class="form-control" id="phone" name="phone"
                                                    placeholder="Servisin telefon numarasını giriniz"
                                                    value="{{ $service->phone }}">
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-3">
                                                <label class="control-label">Servisin Emaili :</label>
                                            </div>
                                            <div class="col-9">
                                                <input type="text" class="form-control" id="email" name="email"
                                                    style="text-transform:lowercase" placeholder="Servisin emailini giriniz"
                                                    value="{{ $service->email }}">
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-3">
                                                <label class="control-label">Servisin Adresi :</label>
                                            </div>
                                            <div class="col-9">
                                                <textarea type="text" class="form-control" id="address" name="address" style="text-transform:uppercase"
                                                    rows="3" placeholder="Servisin adresini giriniz">{{ $service->address }}
                                                </textarea>
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
    </section>
@endsection

@section('js')
    <script src="/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/js/tms/order/order.js"></script>
@endsection
