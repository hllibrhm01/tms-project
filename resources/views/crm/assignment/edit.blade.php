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
                                        <h3 class="card-title">Atama Ekle</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form method="POST"
                                        action="{{ route('post.crm.assignment.update', ['id' => $assignment->id]) }}">
                                        @csrf
                                        <div class="card-body">

                                            <div class="form-group">
                                                <label>Şirket Adı</label>
                                                <input type="text" class="form-control" name="company_name"
                                                    style="text-transform: capitalize;" placeholder="Şirket Adı Giriniz"
                                                    value="{{ $assignment->company_name }}">
                                            </div>


                                            <div class="form-group">
                                                <label>Sektör</label>
                                                <input type="text" class="form-control" name="sector"
                                                    style="text-transform: capitalize;" placeholder="Sektör Giriniz"
                                                    value="{{ $assignment->sector }}">
                                            </div>

                                            <div class="form-group">
                                                <label>Yetkili İsmi</label>
                                                <input type="text" class="form-control" name="name"
                                                    style="text-transform: capitalize;" placeholder="Yetkili İsmi Giriniz"
                                                    value="{{ $assignment->name }}">
                                            </div>

                                            <div class="form-group">
                                                <label>Ünvan</label>
                                                <input type="text" class="form-control" name="title"
                                                    style="text-transform: capitalize;" placeholder="Ünvan Giriniz"
                                                    value="{{ $assignment->title }}">
                                            </div>

                                            <div class="form-group">
                                                <label>E-posta</label>
                                                <input type="text" class="form-control" name="email"
                                                    style="text-transform: lowercase;" placeholder="E-Posta Giriniz"
                                                    value="{{ $assignment->email }}">
                                            </div>

                                            <div class="form-group">
                                                <label>Telefon</label>
                                                <input type="text" class="form-control" name="phone"
                                                    style="text-transform: capitalize;" placeholder="Telefon Giriniz"
                                                    value="{{ $assignment->phone }}">
                                            </div>

                                            <div class="form-group">
                                                <label>Not</label>
                                                <textarea name="note" class="form-control" rows="3"
                                                    style="text-transform: capitalize;"
                                                    placeholder="Not Giriniz">{{ $assignment->note }}</textarea>
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
