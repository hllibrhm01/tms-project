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
                                        <h3 class="card-title">Müşteri Ekle</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form method="POST" action="{{ route('post.wms.customer.add') }}">
                                        @csrf
                                        <div class="container">
                                            <div class="input-group mt-4 row">
                                                <div class="col-sm-2">
                                                    <label class="control-label">Tipi :</label>
                                                </div>
                                                <div class="col-sm-10">
                                                    <select class="form-control" name="type">
                                                        <option value="1" data-select2-id="1">Bayi</option>
                                                        <option value="2" data-select2-id="2">Depo</option>
                                                    </select>
                                                </div>
                                            </div>
                                                <div class="input-group mt-4 row">
                                                    <div class="col-sm-2">
                                                        <label class="control-label" for="company_name">Şirket Adı :</label>
                                                    </div>
                                                    <div class="col">
                                                        <input
                                                          type="text"
                                                          style="text-transform:uppercase"
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
                                                        <input type="text" class="form-control" name="tax_number"
                                                            placeholder="Vergi numarası giriniz">
                                                    </div>
                                                </div>
                                                <div class="input-group mt-4 row">
                                                    <div class="col-sm-2">
                                                        <label class="control-label" for="authorized_person">Yetkili Adı-Soyadı :</label>
                                                    </div>
                                                    <div class="col">
                                                        <input
                                                          type="text"
                                                          class="form-control"
                                                          name="authorized_person"
                                                          style="text-transform:uppercase"
                                                          placeholder="Yetkili adı giriniz">
                                                    </div>
                                                </div>
                                                <div class="input-group mt-4 row">
                                                    <div class="col-sm-2">
                                                        <label class="control-label" for="phone">Telefon :</label>
                                                    </div>
                                                    <div class="col">
                                                        <input type="text" class="form-control" name="phone"
                                                            placeholder="Telefon numarası giriniz">
                                                    </div>
                                                </div>
                                                <div class="input-group mt-4 row">
                                                    <div class="col-sm-2">
                                                        <label class="control-label" for="email">Email :</label>
                                                    </div>
                                                    <div class="col">
                                                        <input
                                                          type="text"
                                                          class="form-control"
                                                          name="email"
                                                          style="text-transform:lowercase"
                                                          placeholder="Email adresi giriniz">
                                                    </div>
                                                </div>
                                                <div class="input-group mt-4 row">
                                                    <div class="col-sm-2">
                                                        <label class="control-label" for="address">Adresi :</label>
                                                    </div>
                                                    <div class="col">
                                                        <input
                                                          type="text"
                                                          class="form-control"
                                                          name="address"
                                                          style="text-transform:uppercase"
                                                          placeholder="Adres giriniz">
                                                    </div>
                                                </div>
                                                <div class="input-group mt-4 row mb-3">
                                                    <div class="col-sm-2">
                                                        <label class="control-label" for="note">Not :</label>
                                                    </div>
                                                    <div class="col">
                                                        <input type="text" class="form-control" name="note"
                                                            placeholder="Not giriniz">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer ml-auto">
                                            <div class="float-right">
                                                <button type="submit" class="btn btn-primary">Kaydet</button>
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

<style>
  ::-webkit-input-placeholder { /* WebKit browsers */
      text-transform: none;
  }
  :-moz-placeholder { /* Mozilla Firefox 4 to 18 */
      text-transform: none;
  }
  ::-moz-placeholder { /* Mozilla Firefox 19+ */
      text-transform: none;
  }
  :-ms-input-placeholder { /* Internet Explorer 10+ */
      text-transform: none;
  }
  ::placeholder { /* Recent browsers */
      text-transform: none;
  }
</style>
