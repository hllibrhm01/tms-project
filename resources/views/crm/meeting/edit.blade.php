@extends('main.main')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        @endif

                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="col-md-12">
                                <!-- general form elements -->
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Görüşme Düzenle</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form method="POST"
                                        action="{{ route('post.crm.meeting.edit', ['id' => $meeting->id]) }}">
                                        @csrf
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label>Müşteri Ismi </label>
                                                <select class="form-control select2bs4 select2-hidden-accessible"
                                                    id="customer_id" name="customer_id" style="width: 100%;"
                                                    data-select2-id="17" tabindex="-1" aria-hidden="true">
                                                    <option selected="selected" data-select2-id="0">Seçiniz</option>
                                                    @if (!is_null($customers))
                                                        @foreach ($customers as $customer)
                                                            <option value={{ $customer->id }}
                                                                data-select2-id="{{ $customer->id }}">
                                                                {{ $customer->author }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>

                                            </div>

                                            <div class="form-group">
                                                <label>Toplantı Türü</label>
                                                <select class="form-control select2bs4 select2-hidden-accessible"
                                                    id="type" name="type" style="width: 100%;" data-select2-id="17"
                                                    tabindex="-1" aria-hidden="true">
                                                    @foreach (config('constants.meet_types') as $key => $value)
                                                        <option value={{ $key }}
                                                            data-select2-id="{{ $key }}">
                                                            {{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Başlık</label>
                                                <input type="text" class="form-control" name="header"
                                                    placeholder="Başlık Giriniz" value={{ $meeting->header }}>
                                            </div>
                                            <div class="form-group">
                                                <label>Açıklama</label>
                                                <textarea name="description" class="form-control" rows="3" placeholder="Açıklama Giriniz">{{ $meeting->description }}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Date and time:</label>
                                                <div class="input-group date" id="reservationdatetime"
                                                    data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input"
                                                        data-target="#reservationdatetime" name="schedule_date"
                                                        value={{ $meeting->schedule_date }}>
                                                    <div class="input-group-append" data-target="#reservationdatetime"
                                                        data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- /.card-body -->

                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">Güncelle</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Notlar</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="meetingEdit" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Note</th>
                                            <th>Tarih</th>
                                            <th></th>
                                            <th><a
                                                    href="{{ route('get.crm.meeting.note.add', ['meetingId' => $meeting->id]) }}">
                                                    <i class="fas fa-plus"></i></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($notes != null)
                                            @foreach ($notes as $note)
                                                <tr>
                                                    <td>{{ $note->notes }}</td>
                                                    <td>{{ $note->created_at }}</td>
                                                    <td><a
                                                            href="{{ route('get.crm.meeting.note.delete', ['id' => $note->id]) }}">
                                                            <i class="nav-icon fa fa-trash"></i>
                                                    </td>
                                                    <td> <a
                                                            href="{{ route('get.crm.meeting.note.edit', ['id' => $note->id, 'meetingId' => $meeting->id]) }}">
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
            $('#reservationdatetime').datetimepicker({
                icons: {
                    time: 'far fa-clock'
                },
                format: 'YYYY-MM-DD hh:mm:ss'
            });
            $('#meetingEdit').DataTable({
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

            $('#customer_id').val({{ $meeting->customer_id }}).change();
            $('#type').val({{ $meeting->type }}).change();


        });
    </script>
@endsection
