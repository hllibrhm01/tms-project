@extends('main.main')

@section('css')
    <link href="{{ asset('/css/main/main.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Kullanıcılar</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="usersTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Kullanıcı Adı</th>
                                    <th>Email</th>
                                    <th>Rol</th>
                                    <th>
                                        <a href="{{ route('get.cms.user.add') }}">
                                            <i class="fas fa-plus"></i>
                                        </a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($users != null)
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role->name }}</td>
                                    <td>
                                        <a href="{{ route('get.cms.user.view', ['id' => $user->id]) }}">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                            GÖRÜNTÜLE
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
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