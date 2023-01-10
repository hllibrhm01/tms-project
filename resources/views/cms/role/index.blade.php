@extends('main.main')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Roller</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="usersTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Rol Adı</th>
                                        <th>Guard Name</th>
                                        <th></th>
                                        <th></th>
                                        <th><a href="{{ route('get.cms.role.add') }}">
                                                <i class="fas fa-plus"></i></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($roles != null)
                                        @foreach ($roles as $role)
                                            <tr>
                                                <td>{{ $role->name }}</td>
                                                <td>{{ $role->guard_name }}</td>
                                                <td></td>
                                                <td><a href="{{ route('get.cms.role.delete', ['id' => $role->id]) }}">
                                                        <i class="nav-icon fa fa-trash"></i>
                                                </td>
                                                <td> <a href="{{ route('get.cms.role.edit', ['id' => $role->id]) }}">
                                                        <i class="nav-icon fa fa-edit"></i>
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

    <script>
        $(function() {
            $('#usersTable').DataTable({
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
