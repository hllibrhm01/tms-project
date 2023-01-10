@extends('main.main')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <button onclick="ExportToExcel('xlsx')">Export table to excel</button>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Müşteriler</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="customerTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>İlgili Kişi</th>
                                        <th>Firma Adı</th>
                                        <th>Yetkili</th>
                                        <th>Sektör</th>
                                        <th>Ünvan</th>
                                        <th>E-mail</th>
                                        <th>Telefon</th>
                                        <th>Not</th>
                                        <th><a href="{{ route('get.crm.customer.add') }}">
                                                <i class="nav-icon fa fa-plus"></i></th>
                                        <th><a href="{{ route('get.crm.import.excel') }}"> Excel Yükle </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($customers != null)
                                        @foreach ($customers as $customer)
                                            <tr>
                                                <td>{{ $customer->user->name }}</td>
                                                <td>
                                                    <a href="{{ route('get.crm.customer.show', ['id' => $customer->id]) }}">
                                                        {{ $customer->company_name }}
                                                    </a>
                                                </td>
                                                <td>{{ $customer->author }}</td>
                                                <td>{{ $customer->sector }}</td>
                                                <td>{{ $customer->title }}</td>
                                                <td>{{ $customer->email }}</td>
                                                <td>{{ $customer->phone }}</td>
                                                <td>{{ $customer->note }}</td>
                                                <td></td>
                                                <td> <a
                                                        href="{{ route('get.crm.customer.delete', ['id' => $customer->id]) }}">
                                                        <i class="nav-icon fa fa-trash"></i>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
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
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>

    <script>
        $(function() {
            $('#customerTable').DataTable({
                "paging": false,
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

        function ExportToExcel(type, fn, dl) {

            var elt = document.getElementById('customerTable');
            var wb = XLSX.utils.table_to_book(elt, {
                sheet: "sheet1"
            });
            return dl ?
                XLSX.write(wb, {
                    bookType: type,
                    bookSST: true,
                    type: 'base64'
                }) :
                XLSX.writeFile(wb, fn || ('customer.' + (type || 'xlsx')));
        }
    </script>
@endsection
