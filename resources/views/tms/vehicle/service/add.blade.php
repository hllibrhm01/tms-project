@extends('main.main')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">YENİ SERVİS EKLE</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('post.tms.vehicle.service.add') }}">
                                @csrf
                                <div class="row mt-4">
                                    <div class="col-3">
                                        <label class="control-label">Servis Yetkilisi :</label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" class="form-control" id="author"
                                            style="text-transform:uppercase" name="author"
                                            placeholder="Servis yetkili adı-soyadı giriniz">
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-3">
                                        <label class="control-label">Servis Adı :</label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" class="form-control" id="name"
                                            style="text-transform:uppercase" name="name"
                                            placeholder="Servis adı giriniz">
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-3">
                                        <label class="control-label">Servisin Telefon Numarası :</label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" class="form-control" id="phone" name="phone"
                                            placeholder="Servisin telefon numarasını giriniz">
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-3">
                                        <label class="control-label">Servisin Emaili :</label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" class="form-control" id="email" name="email"
                                            style="text-transform:lowercase" placeholder="Servisin emailini giriniz">
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-3">
                                        <label class="control-label">Servisin Adresi :</label>
                                    </div>
                                    <div class="col-9">
                                        <textarea type="text" class="form-control" id="address" name="address" style="text-transform:uppercase"
                                            rows="3" placeholder="Servisin adresini giriniz">
                                            </textarea>
                                    </div>
                                </div>
                                <div class="float-right mt-4">
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
@endsection

@section('css')
    <link href="{{ asset('/css/main/main.css') }}" rel="stylesheet" type="text/css">
@endsection
