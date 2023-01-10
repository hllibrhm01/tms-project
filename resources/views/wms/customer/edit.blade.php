@extends('main.main')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="col-md-12">
                                <!-- general form elements -->
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Müşteri Düzenle</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form method="POST" action="">
                                        @csrf
                                        <div class="container">
                                            <div class="input-group mt-4 row">
                                                <div class="col-sm-2">
                                                    <label class="control-label" for="type">Tipi :</label>
                                                </div>
                                                <div class="col-sm-10">
                                                    <select class="form-control" name="type">
                                                            <option value="1"
                                                            @if(($customer->type == 1)) selected @endif>
                                                                Bayi 
                                                            </option>
                                                            <option value="2"
                                                            @if(($customer->type == 2)) selected @endif>
                                                                Depo
                                                            </option>
                                                    </select>
                                                </div>
                                            </div>
                                                <div class="input-group mt-4 row">
                                                    <div class="col-sm-2">
                                                        <label class="control-label" for="company_name">Şirket Adı :</label>
                                                    </div>
                                                    <div class="col">
                                                        <input 
                                                            value="{{ $customer->company_name }}"
                                                            type="text" 
                                                            class="form-control" 
                                                            name="company_name"
                                                            placeholder="Şirket adı giriniz">
                                                    </div>
                                                </div>
                                                <div class="input-group mt-4 row">
                                                    <div class="col-sm-2">
                                                        <label class="control-label" for="tax_number">Vergi Numarası :</label>
                                                    </div>
                                                    <div class="col">
                                                        <input 
                                                            value="{{ $customer->tax_number }}"
                                                            type="text" 
                                                            class="form-control" 
                                                            name="tax_number"
                                                            placeholder="Vergi numarası giriniz">
                                                    </div>
                                                </div>
                                                <div class="input-group mt-4 row">
                                                    <div class="col-sm-2">
                                                        <label class="control-label" for="authorized_person">Yetkili Adı-Soyadı :</label>
                                                    </div>
                                                    <div class="col">
                                                        <input 
                                                            value="{{ $customer->authorized_person }}"
                                                            type="text" 
                                                            class="form-control" 
                                                            name="authorized_person"
                                                            placeholder="Yetkili adı giriniz">
                                                    </div>
                                                </div>
                                                <div class="input-group mt-4 row">
                                                    <div class="col-sm-2">
                                                        <label class="control-label" for="phone">Telefon :</label>
                                                    </div>
                                                    <div class="col">
                                                        <input  
                                                            value="{{ $customer->phone }}"
                                                            type="text" 
                                                            class="form-control" 
                                                            name="phone"
                                                            placeholder="Telefon numarası giriniz">
                                                    </div>
                                                </div>
                                                <div class="input-group mt-4 row">
                                                    <div class="col-sm-2">
                                                        <label class="control-label" for="email">Email :</label>
                                                    </div>
                                                    <div class="col">
                                                        <input 
                                                            value="{{ $customer->email }}"
                                                            type="text" 
                                                            class="form-control" 
                                                            name="email"
                                                            placeholder="Email adresi giriniz">
                                                    </div>
                                                </div>
                                                <div class="input-group mt-4 row">
                                                    <div class="col-sm-2">
                                                        <label class="control-label" for="address">Adresi :</label>
                                                    </div>
                                                    <div class="col">
                                                        <input 
                                                            value="{{ $customer->address }}"
                                                            type="text" 
                                                            class="form-control" 
                                                            name="address"
                                                            placeholder="Adres giriniz">
                                                    </div>
                                                </div>
                                                <div class="input-group mt-4 row mb-3">
                                                    <div class="col-sm-2">
                                                        <label class="control-label" for="note">Not :</label>
                                                    </div>
                                                    <div class="col">
                                                        <input 
                                                            value="{{ $customer->note }}"
                                                            type="text" 
                                                            class="form-control" 
                                                            name="note"
                                                            placeholder="Not giriniz">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer ml-auto">
                                            <div class="float-right">
                                                <button type="submit" class="btn btn-primary">Düzenle</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection


@section('js')
@endsection

