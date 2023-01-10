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
                                        <h3 class="card-title">Rol Düzenle</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form method="POST" action="{{ route('post.cms.role.update', ['id' => $role->id]) }}">
                                        @csrf
                                        <div class="card-body">

                                            <div class="form-group">
                                                <label>Rol Adı : </label>
                                                <input type="text" class="form-control" name="name"
                                                    placeholder="Rol adı giriniz" value="{{ $role->name }}"">
                                            </div>


                                            <div class="form-group">
                                                <label>Guard Name : </label>
                                                <input type="text" class="form-control" name="guard_name"
                                                    placeholder="Guard Name giriniz" value="{{ $role->guard_name }}">
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


@section('js')
@endsection
