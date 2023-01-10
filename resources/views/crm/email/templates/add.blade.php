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
                                        <h3 class="card-title">Şablon Ekle</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form method="POST" action="{{ route('post.crm.email.templates.add') }}">
                                        @csrf
                                        <div class="card-body">

                                            <div class="form-group">
                                                <label>E-Posta Türü</label>
                                                <select class="form-control select2bs4 select2-hidden-accessible" id="type"
                                                    name="type" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                                    @foreach (config('constants.mail_types') as $key => $value)
                                                        <option value={{ $key }}
                                                            data-select2-id="{{ $key }}">
                                                            {{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>


                                            <div class="form-group">
                                                <label>Şablon Adı</label>
                                                <input type="text" class="form-control" name="name"
                                                    placeholder="Şablon Adı Giriniz">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>Konu</label>
                                                <input type="text" class="form-control" name="subject"
                                                    placeholder="Mail Konusu Giriniz">
                                            </div>

                                            <div class="form-group">
                                                <label>Mail Şablonu</label>
                                                <textarea name="body" class="form-control" rows="3"
                                                    placeholder="Mail Şablonu Giriniz"></textarea>
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
@endsection
