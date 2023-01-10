@extends('main.main')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $customer->company_name }}</h3>

                            <div class="form-group">
                                <input type="hidden" class="form-control" id="customerId" value={{ $customer->id }}>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form method="POST" action="{{ route('post.crm.customer.update', ['id' => $customer->id]) }}">
                                @csrf
                                <div class="row pt-3">
                                    <div class="col-4 pt-1">
                                        <label for="company_name">ŞİRKET ADI</label>
                                        <input type="text" name="company_name" class="form-control"
                                            style="text-transform: capitalize;" placeholder="Şirket Adı Giriniz."
                                            value="{{ $customer->company_name }}">
                                    </div>
                                    <div class="col-4 pt-1">
                                        <label for="author">YETKİLİ ADI</label>
                                        <input type="text" name="author" class="form-control"
                                            style="text-transform: capitalize;" placeholder="Yetkili Adı Giriniz."
                                            value="{{ $customer->author }}">
                                    </div>
                                    <div class="col-4 pt-1">
                                        <label for="sector">SEKTÖR</label>
                                        <input type="text" name="sector" class="form-control"
                                            style="text-transform: capitalize;" placeholder="Sektör Giriniz."
                                            value="{{ $customer->sector }}">
                                    </div>
                                </div>
                                <div class="row pt-3">
                                    <div class="col-4">
                                        <label for="title">ÜNVAN</label>
                                        <input type="text" name="title" class="form-control"
                                            placeholder="Ünvan Giriniz." style="text-transform: capitalize;"
                                            value="{{ $customer->title }}">
                                    </div>
                                    <div class="col-4">
                                        <label for="email">E-POSTA</label>
                                        <input type="text" name="email" class="form-control"
                                            style="text-transform: lowercase;" placeholder="E-posta Giriniz."
                                            value="{{ $customer->email }}">
                                    </div>
                                    <div class="col-4">
                                        <label for="phone">TELEFON</label>
                                        <input type="text" name="phone" class="form-control"
                                            style="text-transform: capitalize;" placeholder="Telefon Giriniz."
                                            value="{{ $customer->phone }}">
                                    </div>
                                </div>
                                <div class="row pt-3">
                                    <div class="col-4">
                                        <label for="call_content">GÖRÜŞME İÇERİĞİ</label>
                                        <textarea name="call_content" class="form-control" style="text-transform: capitalize;"
                                            placeholder="Görüşme İçeriği Giriniz.">{{ $customer->call_content }}</textarea>
                                    </div>
                                    <div class="col-4">
                                        <label for="call_detail">GÖRÜŞME DETAYI</label>
                                        <textarea name="call_detail" class="form-control" style="text-transform: capitalize;"
                                            placeholder="Görüşme Detayı Giriniz.">{{ $customer->call_detail }}</textarea>
                                    </div>
                                    <div class="col-4">
                                        <label for="note">NOT</label>
                                        <textarea name="note" class="form-control" style="text-transform: capitalize;" placeholder="Not Giriniz.">{{ $customer->note }}</textarea>
                                    </div>
                                </div>

                                <div class="row pt-3">
                                    <div class="col-4">
                                        <button type="submit" class="btn btn-primary">
                                            GÜNCELLE
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-tabs">
                        <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="tab-meetings-tab" data-toggle="pill" href="#tab-meetings"
                                        role="tab" aria-controls="custom-tabs-one-home"
                                        aria-selected="true">TOPLANTILAR</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab-visit-notes-tab" data-toggle="pill"
                                        href="#tab-visit-notes" role="tab" aria-controls="tab-visit-notes"
                                        aria-selected="false">ZİYARET NOTLARI</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab-reminders-tab" data-toggle="pill" href="#tab-reminders"
                                        role="tab" aria-controls="tab-reminders"
                                        aria-selected="false">HATIRLATMALAR</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab-emails-tab" data-toggle="pill" href="#tab-emails"
                                        role="tab" aria-controls="tab-emails" aria-selected="false">E-POSTA
                                        İŞLEMLERİ</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab-paperworks-tab" data-toggle="pill"
                                        href="#tab-paperworks" role="tab" aria-controls="tab-paperworks"
                                        aria-selected="false">EVRAK İŞLEMLERİ</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                <div class="tab-pane fade show active" id="tab-meetings" role="tabpanel"
                                    aria-labelledby="tab-meetings-tab">

                                    <table id="meetingTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>ŞİRKET</th>
                                                <th>YETKİLİ</th>
                                                <th>TÜR</th>
                                                <th>BAŞLIK</th>
                                                <th>AÇIKLAMA</th>
                                                <th>TOPLANTI TARİHİ</th>
                                                <th></th>
                                                <th>
                                                    <a href="#" id="addMeeting" data-toggle="modal"
                                                        data-target="#modal-meeting">
                                                        <i class="fas fa-plus"></i>
                                                </th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!is_null($customer->meetings))
                                                @foreach ($customer->meetings as $meeting)
                                                    <tr>
                                                        <td>{{ $meeting->customer->company_name }}</td>
                                                        <td>{{ $meeting->customer->author }}</td>
                                                        <td>{{ config('constants.meet_types')[$meeting->type] }}
                                                        </td>
                                                        <td>{{ $meeting->header }}</td>
                                                        <td>{{ $meeting->description }}</td>
                                                        <td>{{ $meeting->schedule_date }}</td>
                                                        <td><a class="deleteMeeting" href="#"
                                                                data-id="{{ $meeting->id }}"
                                                                data-customer-id="{{ $customer->id }}">
                                                                <i class="nav-icon fa fa-trash "></i>
                                                        </td>
                                                        <td> <a class="editMeeting" href="#"
                                                                data-id="{{ $meeting->id }}"
                                                                data-customer-id="{{ $customer->id }}">
                                                                <i class="nav-icon fa fa-edit "></i>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>

                                </div>
                                <div class="tab-pane fade" id="tab-visit-notes" role="tabpanel"
                                    aria-labelledby="tab-visit-notes-tab">
                                    <table id="meetingNoteTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>TOPLANTI BAŞLIĞI</th>
                                                <th>TOPLANTI TÜRÜ</th>
                                                <th>TARTIŞILAN KONULAR</th>
                                                <th>NOTLAR</th>
                                                <th>YAPILACAK İŞLER</th>
                                                <th></th>
                                                <th>
                                                    <a href="#" id="addMeetingNote" data-toggle="modal"
                                                        data-target="#modal-meeting-notes">
                                                        <i class="fas fa-plus"></i>
                                                </th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!is_null($customer->meetingNotes))
                                                @foreach ($customer->meetingNotes as $meetingNote)
                                                    <tr>
                                                        <td>{{ $meetingNote->meeting->header }}</td>
                                                        <td>{{ config('constants.meet_types')[$meetingNote->meeting->type] }}
                                                        </td>
                                                        <td>{{ $meetingNote->discussed_topics }}</td>
                                                        <td>{{ $meetingNote->notes }}</td>
                                                        <td>{{ $meetingNote->to_dos }}</td>
                                                        <td> <a href="#" class="deleteMeetingNote"
                                                                data-id="{{ $meetingNote->id }}">
                                                                <i class="nav-icon fa fa-trash"></i>
                                                        </td>
                                                        <td> <a href="#" class="editMeetingNote"
                                                                data-id="{{ $meetingNote->id }}">
                                                                <i class="nav-icon fa fa-edit"></i>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="tab-reminders" role="tabpanel"
                                    aria-labelledby="tab-reminders-tab">
                                    <table id="remindersTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>E-POSTA</th>
                                                <th>KONU</th>
                                                <th>BİTİŞ ZAMANI</th>
                                                <th style="text-align:center;">DURUMU</th>

                                                <th></th>
                                                <th>
                                                    <a href="#" id="addReminder" data-toggle="modal"
                                                        data-target="#modal-reminders">
                                                        <i class="fas fa-plus"></i>
                                                </th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!is_null($customer->reminders))
                                                @foreach ($customer->reminders as $reminder)
                                                    <tr>
                                                        <td>{{ $reminder->email }}</td>
                                                        <td>{{ $reminder->abstract }}</td>
                                                        <td>{{ $reminder->finish_time }}</td>
                                                        <td style="text-align:center;">
                                                            @if ($reminder->is_completed)
                                                                <i class="fas fa-check" style="color:green"></i>
                                                            @else
                                                                @if ($reminder->finish_time < Carbon\Carbon::now())
                                                                    <i class="fas fa-clock" style="color:red"></i>
                                                                @else
                                                                    <i class="fas fa-hourglass-half"
                                                                        style="color:gray"></i>
                                                                @endif
                                                            @endif

                                                        </td>
                                                        <td> <a href="#" class="deleteReminder"
                                                                data-id="{{ $reminder->id }}">
                                                                <i class="nav-icon fa fa-trash"></i>
                                                        </td>
                                                        <td> <a href="#" class="editReminder"
                                                                data-id="{{ $reminder->id }}">
                                                                <i class="nav-icon fa fa-edit"></i>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="tab-emails" role="tabpanel"
                                    aria-labelledby="tab-emails-tab">
                                    <table id="emailsTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>MAİL TÜRÜ</th>
                                                <th>MAİL İÇERİĞİ</th>
                                                <th>GÖNDERİM TARİHİ</th>
                                                <th> <a href="#" id="sentEmail" data-toggle="modal"
                                                        data-target="#modal-emails">
                                                        E-Posta Gönder</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!is_null($customer->mails))
                                                @foreach ($customer->mails as $mail)
                                                    <tr>
                                                        <td>{{ config('constants.mail_types')[$mail->type] }}</td>
                                                        <td>{!! $mail->body !!}</td>
                                                        <td>{{ $mail->sent_time }}</td>
                                                        <td></td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="tab-paperworks" role="tabpanel"
                                    aria-labelledby="tab-paperworks-tab">
                                    <table id="paperworksTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>EVRAK TÜRÜ</th>
                                                <th>AÇIKLAMA</th>
                                                <th>EVRAK</th>
                                                <th></th>
                                                <th>
                                                    <a href="#" id="addPaperwork" data-toggle="modal"
                                                        data-target="#modal-paperworks">
                                                        <i class="fas fa-plus"></i>
                                                </th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!is_null($customer->papers))
                                                @foreach ($customer->papers as $paper)
                                                    <tr>
                                                        <td>{{ config('constants.paper_types')[$paper->type] }}
                                                        </td>
                                                        <td>{{ $paper->description }}</td>
                                                        <td><a
                                                                href="{{ env('DO_SPACE_URL') . '/' . $paper->path }}">İNDİR</a>
                                                        </td>
                                                        <td> <a href="#" class="deletePaperwork"
                                                                data-id="{{ $paper->id }}">
                                                                <i class="nav-icon fa fa-trash"></i>
                                                        </td>
                                                        <td> <a href="#" class="editPaperwork"
                                                                data-id="{{ $paper->id }}">
                                                                <i class="nav-icon fa fa-edit"></i>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>

            <!-- Modals Start -->
            <div class="modal fade" id="modal-meeting">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Toplantılar</h4>
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
                                        <input type="hidden" class="form-control" name="id">
                                    </div>

                                    <div class="form-group">
                                        <input type="hidden" class="form-control" name="customer_id"
                                            value={{ $customer->id }}>
                                    </div>

                                    <div class="form-group">
                                        <label>Toplantı Türü</label>
                                        <select class="form-control select2bs4 select2-hidden-accessible" id="type"
                                            name="type" style="width: 100%;" data-select2-id="17" tabindex="-1"
                                            aria-hidden="true">
                                            @foreach (config('constants.meet_types') as $key => $value)
                                                <option value={{ $key }} data-select2-id="{{ $key }}">
                                                    {{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Başlık</label>
                                        <input type="text" class="form-control" name="header"
                                            placeholder="Başlık Giriniz">
                                    </div>
                                    <div class="form-group">
                                        <label>Açıklama</label>
                                        <textarea name="description" class="form-control" rows="3" placeholder="Açıklama Giriniz"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Date and time:</label>
                                        <div class="input-group date" id="meetingTime" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input"
                                                data-target="#meetingTime" name="schedule_date">
                                            <div class="input-group-append" data-target="#meetingTime"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- /.card-body -->

                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
                                    <button id="btnAddMeetingButton" type="button" class="btn btn-primary">Ekle</button>

                                    <button id="btnEditMeetingButton" type="button"
                                        class="btn btn-primary">Düzenle</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->

            <div class="modal fade" id="modal-meeting-notes">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Toplantılar</h4>
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
                                        <input type="hidden" class="form-control" name="id">
                                    </div>

                                    <div class="form-group">
                                        <input type="hidden" class="form-control" name="customer_id"
                                            value={{ $customer->id }}>
                                    </div>

                                    <div class="form-group">
                                        <div class="form-group">
                                            <label>Toplantı</label>
                                            <select class="form-control select2bs4 select2-hidden-accessible"
                                                id="type" name="meeting_id" style="width: 100%;" tabindex="-1"
                                                aria-hidden="true">
                                                @foreach ($customer->meetings as $meeting)
                                                    <option value={{ $meeting->id }}
                                                        data-select2-id="{{ $meeting->id }}">
                                                        {{ $meeting->header }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>GÖRÜŞÜLEN KONULAR:</label>
                                        <textarea name="discussed_topics" class="form-control" rows="3" placeholder="Not Giriniz"></textarea>
                                    </div>


                                    <div class="form-group">
                                        <label>GÖRÜŞME NOTLARI:</label>
                                        <textarea name="notes" class="form-control" rows="3" placeholder="Not Giriniz"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>YAPILACAK İŞLER veya TAKİP EDİLCEK KONULAR:</label>
                                        <textarea name="to_dos" class="form-control" rows="3" placeholder="Not Giriniz"></textarea>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
                                    <button id="btnAddMeetingNoteButton" type="button"
                                        class="btn btn-primary">Ekle</button>
                                    <button id="btnEditMeetingNoteButton" type="button"
                                        class="btn btn-primary">Düzenle</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->

            <div class="modal fade" id="modal-emails">
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
                                        <input type="hidden" class="form-control" name="customer_id"
                                            value={{ $customer->id }}>
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
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
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
            <div class="modal fade" id="modal-reminders">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Toplantılar</h4>
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
                                        <input type="hidden" class="form-control" name="id">
                                    </div>

                                    <div class="form-group">
                                        <input type="hidden" class="form-control" name="customer_id"
                                            value={{ $customer->id }}>
                                    </div>

                                    <div class="form-group">
                                        <label>E-POSTA:</label>
                                        <input type="text" class="form-control" name="email">
                                    </div>

                                    <div class="form-group">
                                        <label>KONU:</label>
                                        <input type="text" class="form-control" name="abstract">
                                    </div>

                                    <div class="form-group">
                                        <label>İÇERİK:</label>
                                        <textarea name="body" class="form-control" rows="3" placeholder="İçerik Giriniz"></textarea>
                                    </div>


                                    <div class="form-group">
                                        <label>Bitiş Zamanı:</label>
                                        <div class="input-group date" id="reminderFinishTime"
                                            data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input"
                                                data-target="#reminderFinishTime" name="finish_time">
                                            <div class="input-group-append" data-target="#reminderFinishTime"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="form-group">
                                            <label>TAMAMLANDI MI?</label>
                                            <select class="form-control select2bs4 select2-hidden-accessible"
                                                id="is_completed" name="is_completed" style="width: 100%;"
                                                tabindex="-1" aria-hidden="true">
                                                <option value="0" data-select2-id="0">HAYIR</option>
                                                <option value="1" data-select2-id="1">EVET</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <!-- /.card-body -->

                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
                                    <button id="btnAddReminderButton" type="button"
                                        class="btn btn-primary">Ekle</button>
                                    <button id="btnEditReminderButton" type="button"
                                        class="btn btn-primary">Düzenle</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->

            <!-- Modals Start -->
            <div class="modal fade" id="modal-paperworks">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Evrak İşlemleri</h4>
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
                                        <input type="hidden" class="form-control" name="id">
                                    </div>

                                    <div class="form-group">
                                        <input type="hidden" class="form-control" name="customer_id"
                                            value={{ $customer->id }}>
                                    </div>

                                    <div class="form-group">
                                        <label>Evrak Türü</label>
                                        <select class="form-control select2bs4 select2-hidden-accessible" id="paper_type"
                                            name="paper_type" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                            @foreach (config('constants.paper_types') as $key => $value)
                                                <option value={{ $key }} data-select2-id="{{ $key }}">
                                                    {{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Açıklama</label>
                                        <textarea class="form-control" name="description" placeholder="Açıklama Giriniz"> </textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="file">Evrak</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="paperFile">
                                                <label class="custom-file-label" for="file">Evrak Seç</label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- /.card-body -->

                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
                                    <button id="btnAddPaper" type="button" class="btn btn-primary">Ekle</button>
                                    <button id="btnEditPaper" type="button" class="btn btn-primary">Düzenle</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->

            <!-- / .Modals -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection


@section('js')
    <script src="/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/js/meeting.js"></script>
    <script src="/js/meeting_note.js"></script>
    <script src="/js/reminder.js"></script>
    <script src="/js/email-sending.js"></script>
    <script src="/js/paper-work.js"></script>
@endsection
