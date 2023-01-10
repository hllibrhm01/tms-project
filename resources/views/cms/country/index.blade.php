@extends('main.main')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Ülkeler</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="countriesTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Iso Code</th>
                                        <th></th>
                                        <th></th>
                                        <th><a href="{{ route('get.cms.country.add') }}">
                                                <i class="fas fa-plus"></i></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($countries as $country)
                                        <tr>
                                            <td>{{ $country->name }}</td>
                                            <td>{{ $country->iso_code }}</td>
                                            <td><a href="{{ route('get.cms.city.index', ['countryId' => $country->id]) }}">
                                                    <i class="fas fa-city"></i>
                                            </td>
                                            <td><a href="{{ route('get.cms.country.delete', ['id' => $country->id]) }}">
                                                    <i class="nav-icon fa fa-trash"></i>
                                            </td>
                                            <td> <a href="{{ route('get.cms.country.edit', ['id' => $country->id]) }}">
                                                    <i class="nav-icon fa fa-edit"></i>
                                            </td>
                                        </tr>
                                    @endforeach
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

    <script>
        $(function() {
            $('#countriesTable').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
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
