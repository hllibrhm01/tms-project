@extends('main.main')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-tabs">
                        <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-customer-mail-tab" data-toggle="pill"
                                        href="#custom-tabs-customer-mail" role="tab"
                                        aria-controls="custom-tabs-customer-mail" aria-selected="true">Toplu Müşteri
                                        Maili</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-assignment-mail-tab" data-toggle="pill"
                                        href="#custom-tabs-assignment-mail" role="tab"
                                        aria-controls="custom-tabs-assignment-mail" aria-selected="false">Toplu Atama
                                        Maili</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                <div class="tab-pane fade show active" id="custom-tabs-customer-mail" role="tabpanel"
                                    aria-labelledby="custom-tabs-customer-mail-tab">
                                    <form method="POST" action="{{ route('post.crm.multi.mail.send') }}">
                                        @csrf
                                        <div class="card-body">
                                            <div class="form-group">
                                                <input type="hidden" name="type" value="1" />
                                            </div>
                                            <div class="form-group">
                                                <label>E-Posta Türü</label>
                                                <select class="form-control select2bs4 select2-hidden-accessible"
                                                    id="template" name="template" style="width: 100%;" tabindex="-1"
                                                    aria-hidden="true">
                                                    @foreach ($emailTemplates as $emailTemplate)
                                                        <option value={{ $emailTemplate->id }}
                                                            data-select2-id="{{ $emailTemplate->id }}">
                                                            {{ $emailTemplate->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Sektör</label>
                                                <select class="form-control select2bs4 select2-hidden-accessible"
                                                    id="group" name="sector" style="width: 100%;" tabindex="-1"
                                                    aria-hidden="true">
                                                    <option value="ALL">TÜMÜ</option>
                                                    @foreach ($customerSectorGroups as $key => $value)
                                                        <option value={{ $key }}>{{ $key }}</option>
                                                    @endforeach
                                                </select>
                                            </div>


                                            <div class="form-group">
                                                <label>Ünvan</label>
                                                <select class="form-control select2bs4 select2-hidden-accessible"
                                                    id="group" name="title" style="width: 100%;" tabindex="-1"
                                                    aria-hidden="true">
                                                    <option value="ALL">TÜMÜ</option>
                                                    @foreach ($customerTitleGroups as $key => $value)
                                                        <option value={{ $key }}>{{ $key }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>
                                        <!-- /.card-body -->

                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">Gönder</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-assignment-mail" role="tabpanel"
                                    aria-labelledby="custom-tabs-assignment-mail-tab">
                                    <form method="POST" action="{{ route('post.crm.multi.mail.send') }}">
                                        @csrf
                                        <div class="card-body">
                                            <div class="form-group">
                                                <input type="hidden" name="type" value="2" />
                                            </div>
                                            <div class="form-group">
                                                <label>E-Posta Türü</label>
                                                <select class="form-control select2bs4 select2-hidden-accessible"
                                                    id="template" name="template" style="width: 100%;" tabindex="-1"
                                                    aria-hidden="true">
                                                    @foreach ($emailTemplates as $emailTemplate)
                                                        <option value={{ $emailTemplate->id }}
                                                            data-select2-id="{{ $emailTemplate->id }}">
                                                            {{ $emailTemplate->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Sektör</label>
                                                <select class="form-control select2bs4 select2-hidden-accessible"
                                                    id="group" name="sector" style="width: 100%;" tabindex="-1"
                                                    aria-hidden="true">
                                                    <option value="ALL">TÜMÜ</option>
                                                    @foreach ($assignmentsSectorGroups as $key => $value)
                                                        <option value={{ $key }}>{{ $key }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>
                                        <!-- /.card-body -->

                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">Gönder</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
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
@endsection
