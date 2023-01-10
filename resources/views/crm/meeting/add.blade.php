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
                                        <h3 class="card-title">Görüşme Ekle</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form method="POST" action="{{ route('post.crm.meeting.add') }}">
                                        @csrf
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label>Müşteri Ismi </label>
                                                <select class="form-control select2bs4 select2-hidden-accessible"
                                                   id="customer_id" name="customer_id" style="width: 100%;" data-select2-id="17"
                                                    tabindex="-1" aria-hidden="true">
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
                                                <select class="form-control select2bs4 select2-hidden-accessible" id="type"
                                                    name="type" style="width: 100%;" data-select2-id="17" tabindex="-1"
                                                    aria-hidden="true">
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
                                                    placeholder="Başlık Giriniz">
                                            </div>
                                            <div class="form-group">
                                                <label>Açıklama</label>
                                                <textarea name="description" class="form-control" rows="3"
                                                    placeholder="Açıklama Giriniz"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Date and time:</label>
                                                <div class="input-group date" id="reservationdatetime"
                                                    data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input"
                                                        data-target="#reservationdatetime" name="schedule_date">
                                                    <div class="input-group-append" data-target="#reservationdatetime"
                                                        data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- /.card-body -->

                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">Kaydet</button>
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


@section('js')
    <script>
        $('#reservationdatetime').datetimepicker({
            icons: {
                time: 'far fa-clock'
            },
            format: 'YYYY-MM-DD hh:mm:ss'
        });

        
        $('#customer_id').val({{ $customerId }}).change();
    </script>
@endsection
