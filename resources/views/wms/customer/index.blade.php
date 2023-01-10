@extends('main.main')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Arama Yap</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form method="GET" action="">
                                <div class="row">
                                    <div class="col-3 pt-1">
                                        <input type="text" name="driver" class="form-control"
                                            placeholder="Sürücü Adı Giriniz.">
                                    </div>
                                    <div class="col-3 pt-1">
                                        <input type="text" name="license_plate" class="form-control"
                                            placeholder="Plaka Giriniz.">
                                    </div>
                                    <div class="col-2 pt-1">
                                        <input type="number" name="capacity" class="form-control"
                                            placeholder="Kapasite (Desi) Giriniz.">
                                    </div>
                                    <div class="col-sm-2 col-3 pt-1">
                                        <select class="form-control" id="type" name="status">
                                            <option value="1" data-select2-id="1">Bayi</option>
                                            <option value="2" data-select2-id="2">Spot</option>
                                            <option value="3" data-select2-id="3">Mağaza</option>
                                        </select>
                                    </div>
                                    <div class="col-2 pt-1">
                                        <button type="submit" class="btn btn-primary">ARA</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Müşteriler</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="vehiclesTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Tipi</th>
                                        <th>Şirket Adı</th>
                                        <th>Vergi Numarası</th>
                                        <th>Yetkili Adı Soyadı</th>
                                        <th>Telefon</th>
                                        <th>Email</th>
                                        <th>Adresi</th>
                                        <th>Not</th>
                                        <th><a href="{{ route('get.wms.customer.add') }}"><i
                                                    class="nav-icon fa fa-plus"></i></a></th>
                                <tbody>
                                    @if ($customers != null)
                                        @foreach ($customers as $customer)
                                            <tr>
                                                <td>{{ $customer->type }}</td>
                                                <td>{{ $customer->company_name }}</td>
                                                <td>{{ $customer->tax_number }}</td>
                                                <td>{{ $customer->authorized_person }}</td>
                                                <td>{{ $customer->phone }}</td>
                                                <td>{{ $customer->email }}</td>
                                                <td>{{ $customer->address }}</td>
                                                <td>{{ $customer->note }}</td>
                                                <td>
                                                    <a href="{{ route('get.wms.customer.edit', ['id' => $customer->id]) }}"><i
                                                            class="fa fa-pen"></i></a>
                                                    <a
                                                        href="{{ route('get.wms.customer.delete', ['id' => $customer->id]) }}"><i
                                                            class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>

                                </tr>
                                </thead>
                            </table>
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
    <script src="/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(function() {
            $('#vehiclesTable').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "language": {
                    "sProcessing": "İşleniyor..",
                    "sZeroRecords": "Henüz kayıt yok",
                    "sEmptyTable": "Henüz kayıt yok",
                    "sInfo": "Toplam _TOTAL_ kayıttan _START_ ile _END_ arası gösteriliyor",
                    "sInfoEmpty": "Heüz kayıt yok",
                    "sSearch": "Ara:",
                    "sLoadingRecords": "Yükleniyor...",
                    "oPaginate": {
                        "sFirst": "Ilk Sayfa",
                        "sLast": "Son Sayfa",
                        "sNext": "Sıradaki",
                        "sPrevious": "Önceki"
                    },
                    "oAria": {
                        "sSortAscending": ": Artana göre sırala",
                        "sSortDescending": ": Azalana göre sırala"
                    }
                },
            });
        });
    </script>
@endsection
