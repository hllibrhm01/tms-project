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
                                        <h3 class="card-title">Ziyaret Tutanağı Güncelle</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form method="POST"
                                        action="{{ route('post.crm.meeting.note.update', ['id' => $meetingNote->id, 'meetingId' => $meetingNote->meeting_id]) }}">
                                        @csrf
                                        <div class="card-body">
                                            <div class="form-group">

                                                <input type="hidden" class="form-control" name="meeting_id"
                                                    value="{{ $meetingNote->meeting_id }}">

                                            </div>


                                            <div class="form-group">
                                                <label>GÖRÜŞÜLEN KONULAR:</label>
                                                <textarea name="discussed_topics" class="form-control" rows="3"
                                                    placeholder="Not Giriniz">{{ $meetingNote->discussed_topics }}</textarea>
                                            </div>


                                            <div class="form-group">
                                                <label>GÖRÜŞME NOTLARI:</label>
                                                <textarea name="notes" class="form-control" rows="3"
                                                    placeholder="Not Giriniz">{{ $meetingNote->notes }}</textarea>
                                            </div>


                                            <div class="form-group">
                                                <label>YAPILACAK İŞLER veya TAKİP EDİLCEK KONULAR:</label>
                                                <textarea name="to_dos" class="form-control" rows="3"
                                                    placeholder="Not Giriniz">{{ $meetingNote->to_dos }}</textarea>
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
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection


@section('js'),
    <script>
        $('#reservationdatetime').datetimepicker({
            icons: {
                time: 'far fa-clock'
            },
            format: 'YYYY-MM-DD hh:mm:ss'
        });
    </script>
@endsection
