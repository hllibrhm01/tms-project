@extends('main.main')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="form-group">
                                <input type="hidden" class="form-control" id="supplierId" value="{{ $supplier->id }}">
                            </div>
                            <div class="float-right">
                                <a style="padding: 0 10px"
                                    href="{{ route('get.tms.vehicle.supplier.delete', ['id' => $supplier->id]) }}">
                                    <i class="nav-icon fa fa-trash"></i>
                                    SİL
                                </a>
                                <a style="padding: 0 10px"
                                    href="{{ route('get.tms.vehicle.supplier.edit', ['id' => $supplier->id]) }}">
                                    <i class="nav-icon fa fa-edit"></i>
                                    GÜNCELLE
                                </a>
                            </div>
                        </div>
                        <div class="card-body" style="pointer-events: none;">
                            <div class="col-md-12">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">{{ $supplier->name }}</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mt-4">
                                            <div class="col-3">
                                                <label class="control-label">Tedarikçi Yetkilisi :</label>
                                            </div>
                                            <div class="col-9">
                                                <input type="text" class="form-control" id="author"
                                                    style="text-transform:uppercase" name="author"
                                                    placeholder="Tedarikçi yetkili adı-soyadı giriniz"
                                                    value="{{ $supplier->author }}">
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-3">
                                                <label class="control-label">Tedarikçi Adı :</label>
                                            </div>
                                            <div class="col-9">
                                                <input type="text" class="form-control" id="name"
                                                    style="text-transform:uppercase" name="name"
                                                    value="{{ $supplier->name }}">
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-3">
                                                <label class="control-label">Tedarikçi Telefon Numarası :</label>
                                            </div>
                                            <div class="col-9">
                                                <input type="text" class="form-control" id="phone" name="phone"
                                                    placeholder="Tedarikçiin telefon numarasını giriniz"
                                                    value="{{ $supplier->phone }}">
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-3">
                                                <label class="control-label">Tedarikçi Emaili :</label>
                                            </div>
                                            <div class="col-9">
                                                <input type="text" class="form-control" id="email" name="email"
                                                    style="text-transform:lowercase"
                                                    placeholder="Tedarikçiin emailini giriniz"
                                                    value="{{ $supplier->email }}">
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-3">
                                                <label class="control-label">Tedarikçi Adresi :</label>
                                            </div>
                                            <div class="col-9">
                                                <textarea type="text" class="form-control" id="address" name="address" style="text-transform:uppercase"
                                                    rows="3" placeholder="Tedarikçiin adresini giriniz">{{ $supplier->address }}
                                                </textarea>
                                            </div>
                                        </div>
                                        <div class="float-right mt-4">
                                            <button type="submit" class="btn btn-primary">Kaydet</button>
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
