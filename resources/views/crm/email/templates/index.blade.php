@extends('main.main')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Email Şablonları</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="emailTemplatesTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>E-Posta Türü</th>
                                        <th>Şablon Adı</th>
                                        <th>Konu</th>
                                        <th>Mail Şablonu</th>
                                        <th></th>
                                        <th><a href="{{ route('get.crm.email.templates.add') }}">
                                                <i class="nav-icon fa fa-plus"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($emailTemplates != null)
                                        @foreach ($emailTemplates as $emailTemplate)
                                            <tr>
                                                <td>{{ config('constants.mail_types')[$emailTemplate->type] }}</td>
                                                <td>{{ $emailTemplate->name }}</td>
                                                <td>{{ $emailTemplate->subject }}</td>
                                                <td>{!! $emailTemplate->body !!}</td>
                                                <td> <a
                                                        href="{{ route('get.crm.email.templates.delete', ['id' => $emailTemplate->id]) }}">
                                                        <i class="nav-icon fa fa-trash"></i>
                                                </td>
                                                <td> <a
                                                        href="{{ route('get.crm.email.templates.edit', ['id' => $emailTemplate->id]) }}">
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
        $(document).ready(function() {
            $('#emailTemplatesTable').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
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
