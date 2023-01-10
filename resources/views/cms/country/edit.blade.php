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
                                        <h3 class="card-title">Ülke Ekle</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form method="POST"
                                        action="{{ route('post.cms.country.update', ['id' => $country->id]) }}">
                                        @csrf
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label>Ülke Adı : </label>
                                                <input type="text" class="form-control" name="name"
                                                    placeholder="Ülke adı giriniz" value="{{ $country->name }}">
                                            </div>

                                            <div class="form-group">
                                                <label>Iso Code : </label>
                                                <input type="text" class="form-control" name="iso_code"
                                                    placeholder="Iso Code giriniz" value="{{ $country->iso_code }}">
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
