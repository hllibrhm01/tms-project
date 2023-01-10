@extends('main.main')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                @if ($errors->any())
                    {!! implode('', $errors->all('<div>:message</div>')) !!}
                @endif
                <div class="col-lg-6 col-12">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-info alert-dismissible fade in" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <strong>Success!</strong> {{ $message }}
                        </div>
                    @endif
                    {!! Session::forget('success') !!}
                    <br />
                    <h2 class="text-title">Müşteri Excel'i Yükleme Ekranı</h2>
                    <form style="border: 4px solid #a1a1a1;margin-top: 15px;padding: 10px;"
                        action="{{ route('post.crm.excel.import.customer') }}" class="form-horizontal" method="post"
                        enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="file" name="import_customer_file" />
                        <button class="btn btn-primary">Yükle</button>
                    </form>
                </div>
                <!-- /.row -->

            </div><!-- /.container-fluid -->
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    @if ($errors->any())
                        {!! implode('', $errors->all('<div>:message</div>')) !!}
                    @endif
                    <div class="col-lg-6 col-12">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-info alert-dismissible fade in" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <strong>Success!</strong> {{ $message }}
                            </div>
                        @endif
                        {!! Session::forget('success') !!}
                        <br />
                        <h2 class="text-title">Atamalar Excel'i Yükleme Ekranı</h2>
                        <form style="border: 4px solid #a1a1a1;margin-top: 15px;padding: 10px;"
                            action="{{ route('post.crm.excel.import.assignment') }}" class="form-horizontal" method="post"
                            enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="file" name="import_assignment_file" />
                            <button class="btn btn-primary">Yükle</button>
                        </form>
                        <br />
                        <h2 class="text-title">Müşteri Mailleri Excel'i Yükleme Ekranı</h2>
                        <form style="border: 4px solid #a1a1a1;margin-top: 15px;padding: 10px;"
                            action="{{ route('post.crm.excel.import.customer.mail') }}" class="form-horizontal"
                            method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="file" name="import_customer_mail_file" />
                            <button class="btn btn-primary">Yükle</button>
                        </form>
                        <br />
                        <h2 class="text-title">Assignment Mailleri Excel'i Yükleme Ekranı</h2>
                        <form style="border: 4px solid #a1a1a1;margin-top: 15px;padding: 10px;"
                            action="{{ route('post.crm.excel.import.assignment.mail') }}" class="form-horizontal"
                            method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="file" name="import_assignment_mail_file" />
                            <button class="btn btn-primary">Yükle</button>
                        </form>
                        <br />
                        <h2 class="text-title">Müşteri Evrak Excel'i Yükleme Ekranı</h2>
                        <form style="border: 4px solid #a1a1a1;margin-top: 15px;padding: 10px;"
                            action="{{ route('post.crm.excel.import.customer.paper') }}" class="form-horizontal"
                            method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="file" name="import_customer_paper_file" />
                            <button class="btn btn-primary">Yükle</button>
                        </form>
                        <br />
                        <h2 class="text-title">Müşteri Hatırlatma Excel'i Yükleme Ekranı</h2>
                        <form style="border: 4px solid #a1a1a1;margin-top: 15px;padding: 10px;"
                            action="{{ route('post.crm.excel.import.customer.reminder') }}" class="form-horizontal"
                            method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="file" name="import_customer_reminder_file" />
                            <button class="btn btn-primary">Yükle</button>
                        </form>
                        <br />
                        <h2 class="text-title">Müşteri Toplantı Excel'i Yükleme Ekranı</h2>
                        <form style="border: 4px solid #a1a1a1;margin-top: 15px;padding: 10px;"
                            action="{{ route('post.crm.excel.import.meeting') }}" class="form-horizontal" method="post"
                            enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="file" name="import_meeting_file" />
                            <button class="btn btn-primary">Yükle</button>
                        </form>
                        <br />
                        <h2 class="text-title">Müşteri Toplantı Notları Excel'i Yükleme Ekranı</h2>
                        <form style="border: 4px solid #a1a1a1;margin-top: 15px;padding: 10px;"
                            action="{{ route('post.crm.excel.import.meeting.notes') }}" class="form-horizontal" method="post"
                            enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="file" name="import_meeting_notes_file" />
                            <button class="btn btn-primary">Yükle</button>
                        </form>
                        <br />
                        <h2 class="text-title">Email Template Excel'i Yükleme Ekranı</h2>
                        <form style="border: 4px solid #a1a1a1;margin-top: 15px;padding: 10px;"
                            action="{{ route('post.crm.excel.import.email.templates') }}" class="form-horizontal" method="post"
                            enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="file" name="import_email_template_file" />
                            <button class="btn btn-primary">Yükle</button>
                        </form>
                    </div>
                    <!-- /.row -->

                </div><!-- /.container-fluid -->
    </section>
@endsection
