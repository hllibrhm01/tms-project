@extends('main.main')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Yeni Müşteri Ekle</h3>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form method="POST">
                                @csrf
                                <div class="row pt-3">
                                    <div class="col-4 pt-1">
                                        <label for="company_name">ŞİRKET ADI</label>
                                        <input type="text" name="company_name" class="form-control"
                                            style="text-transform: capitalize;" placeholder="Şirket Adı Giriniz.">
                                    </div>
                                    <div class="col-4 pt-1">
                                        <label for="author">YETKİLİ ADI</label>
                                        <input type="text" name="author" class="form-control"
                                            style="text-transform: capitalize;" placeholder="Yetkili Adı Giriniz.">
                                    </div>
                                    <div class="col-4 pt-1">
                                        <label for="sector">SEKTÖR</label>
                                        <input type="text" name="sector" class="form-control"
                                            style="text-transform: capitalize;" placeholder="Sektör Giriniz.">
                                    </div>
                                </div>
                                <div class="row pt-3">
                                    <div class="col-4">
                                        <label for="title">ÜNVAN</label>
                                        <input type="text" name="title" class="form-control"
                                            style="text-transform: capitalize;" placeholder="Ünvan Giriniz.">
                                    </div>
                                    <div class="col-4">
                                        <label for="email">E-POSTA</label>
                                        <input type="text" name="email" class="form-control"
                                            style="text-transform: lowercase;" placeholder="E-posta Giriniz.">
                                    </div>
                                    <div class="col-4">
                                        <label for="phone">TELEFON</label>
                                        <input type="text" name="phone" class="form-control"
                                            style="text-transform: capitalize;" placeholder="Telefon Giriniz.">
                                    </div>
                                </div>
                                <div class="row pt-3">
                                    <div class="col-4">
                                        <label for="call_content">GÖRÜŞME İÇERİĞİ</label>
                                        <textarea name="call_content" class="form-control" style="text-transform: capitalize;"
                                            placeholder="Görüşme İçeriği Giriniz."></textarea>
                                    </div>
                                    <div class="col-4">
                                        <label for="call_detail">GÖRÜŞME DETAYI</label>
                                        <textarea name="call_detail" class="form-control" style="text-transform: capitalize;"
                                            placeholder="Görüşme Detayı Giriniz."></textarea>
                                    </div>
                                    <div class="col-4">
                                        <label for="note">NOT</label>
                                        <textarea name="note" class="form-control" style="text-transform: capitalize;" placeholder="Not Giriniz."></textarea>
                                    </div>
                                </div>

                                <div class="row pt-3">
                                    <div class="col-4">
                                        <button type="submit" class="btn btn-primary">KAYDET</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection


@section('js')
    <script src="/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
@endsection
