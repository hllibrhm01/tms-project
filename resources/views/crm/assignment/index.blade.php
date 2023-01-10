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
                            <form method="GET" action="{{ route('get.crm.assignment.search') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-3 pt-1">
                                        <label for="company_name">ŞİRKET ADI</label>
                                        <input type="text" name="company_name" class="form-control"
                                            placeholder="Şirket Adı Giriniz.">
                                    </div>
                                    <div class="col-3 pt-1">
                                        <label for="company_name">SEKTÖR</label>
                                        <input type="text" name="sector" class="form-control"
                                            placeholder="Sektör Giriniz.">
                                    </div>
                                    <div class="col-3 pt-1">
                                        <label for="sector">YETKİLİ</label>
                                        <input type="text" name="name" class="form-control"
                                            placeholder="Yetkili Giriniz.">
                                    </div>
                                    <div class="col-3">
                                        <label for="title">ÜNVAN</label>
                                        <input type="text" name="title" class="form-control"
                                            placeholder="Ünvan Giriniz.">
                                    </div>
                                </div>

                                <div class="row pt-3">
                                    <div class="col-4">
                                        <button type="submit" class="btn btn-primary">ARA</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Atamalar</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="assignmentTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Şirket</th>
                                        <th>Yetkili</th>
                                        <th>Ünvan</th>
                                        <th>E-Posta</th>
                                        <th>Telefon</th>
                                        <th>Not</th>
                                        <th></th>
                                        <th></th>
                                        <th><a href="{{ route('get.crm.assignment.add') }}">
                                                <i class="fas fa-plus"></i></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($assignments != null)
                                        @foreach ($assignments as $assignment)
                                            <tr>
                                                <td>{{ $assignment->company_name }}</td>
                                                <td>{{ $assignment->name }}</td>
                                                <td>{{ $assignment->title }}</td>
                                                <td>{{ $assignment->email }}</td>
                                                <td>{{ $assignment->phone }}</td>
                                                <td>{{ $assignment->note }}</td>
                                                <td><a
                                                        href="{{ route('get.crm.assignment.delete', ['id' => $assignment->id]) }}">
                                                        <i class="nav-icon fa fa-trash"></i>
                                                </td>
                                                <td> <a
                                                        href="{{ route('get.crm.assignment.edit', ['id' => $assignment->id]) }}">
                                                        <i class="nav-icon fa fa-edit"></i>
                                                </td>
                                                <td> <a href="#" class="btnShowSentEmail"
                                                        data-id="{{ $assignment->id }}">
                                                        <i class="nav-icon fas fa-paper-plane"></i>
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
                    <div class="modal fade" id="modal-sent-email">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">GÖNDERİLECEK MAİL ŞABLONU</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- form start -->
                                    <form method="POST">
                                        @csrf
                                        <div class="card-body">

                                            <div class="form-group">
                                                <input type="hidden" class="form-control" name="assignment_id">
                                            </div>

                                            <div class="form-group">
                                                <select class="form-control select2bs4 select2-hidden-accessible"
                                                    id="email_template_id" name="email_template_id" style="width: 100%;"
                                                    tabindex="-1" aria-hidden="true">
                                                    @foreach ($emailTemplates as $emailTemplate)
                                                        <option value={{ $emailTemplate->id }}
                                                            data-select2-id="{{ $emailTemplate->id }}">
                                                            {{ $emailTemplate->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->

                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default"
                                                data-dismiss="modal">Kapat</button>
                                            <button id="btnSentEmail" type="button" class="btn btn-primary">Gönder</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
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
    <script src="/js/assignment.js"></script>
@endsection
