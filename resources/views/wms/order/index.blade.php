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
                                            <option value="2" data-select2-id="2">Depo</option>
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
                            @if (!is_null($order))
                                <h3 class="card-title">{{ $order->id == 1 ? 'Bayi' : 'Depo' }} Siparişleri</h3>
                            @endif
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="vehiclesTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Tipi</th>
                                        <th>Şirket Adı</th>
                                        <th>Telefon</th>
                                        <th>Şehir</th>
                                        <th>İlçe</th>
                                        <th>Not</th>
                                        <th>Durumu</th>
                                        <th></th>
                                <tbody>
                                    @if ($orders != null)
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td>
                                                    @if ($order->type == 1)
                                                        Bayi
                                                    @elseif ($order->type == 2)
                                                        Depo
                                                    @endif
                                                </td>
                                                <td>{{ $order->customer->company_name }}</td>
                                                <td>{{ $order->phone }}</td>
                                                <td>{{ $order->city->name }}</td>
                                                <td>{{ $order->district->name }}</td>
                                                <td>{{ $order->note }}</td>
                                                <td>
                                                    @if ($order->status == 1)
                                                        {{ 'Sipariş Alındı' }}
                                                    @elseif ($order->status == 2)
                                                        {{ 'Taşımada' }}
                                                    @elseif ($order->status == 3)
                                                        {{ 'Kurulumda' }}
                                                    @elseif ($order->status == 4)
                                                        {{ 'Kuruldu' }}
                                                    @elseif ($order->status == 5)
                                                        {{ 'Anket Bekleniyor' }}
                                                    @elseif ($order->status == 6)
                                                        {{ 'Hasarlı Ürün' }}
                                                    @elseif ($order->status == 7)
                                                        {{ 'Tamamlandı' }}
                                                    @elseif ($order->status == 8)
                                                        {{ 'İade Bekleniyor' }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('get.wms.order.edit', ['id' => $order->id]) }}"><i
                                                            class="fa fa-pen"></i></a>
                                                    <a href="{{ route('get.wms.order.delete', ['id' => $order->id]) }}"><i
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
