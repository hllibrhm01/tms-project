@extends('main.main')

@section('css')
    <link href="{{ asset('/css/main/main.css') }}" rel="stylesheet" type="text/css">
@endsection

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
                                    <h3 class="card-title">Kullanıcı Düzenle</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form method="POST" action="{{ route('post.cms.user.update', ['id' => $user->id]) }}">
                                    @csrf
                                    <div class="card-body">
                                        <div class="row p-2">
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-6 mt-2">
                                                        <label class="control-label" for="name">İsim & Soyisim : </label>
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="text" style="text-transform: uppercase;" class="form-control" name="name" placeholder="İsim Soyisim giriniz" value="{{ $user->name }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-6 mt-2">
                                                        <label class="control-label" for="email">E-mail : </label>
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="email" style="text-transform: lowercase;" class="form-control" name="email" placeholder="E-mail giriniz" value="{{ $user->email }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row p-2">
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-6 mt-2">
                                                        <label class="control-label" for="name">Rol : </label>
                                                    </div>
                                                    <div class="col-6">
                                                        <select class="form-control" id="role_id" name="role_id">
                                                            <option data-select2-id="0" value="0">Seçiniz</option>
                                                            @if (!is_null($roles))
                                                            @foreach ($roles as $role)
                                                            <option value={{ $role->id }} data-select2-id="{{ $role->id }}" @if ($user->hasRole($role->name)) selected="selected" @endif>
                                                                {{ $role->name }}
                                                            </option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-6 mt-2">
                                                        <label class="control-label" for="vehicle_id">Araç Tanımlama: </label>
                                                    </div>
                                                    <div class="col-6">
                                                        <select class="form-control" id="vehicle_id" name="vehicle_id">
                                                            <option data-select2-id="0" value="0">Seçiniz</option>
                                                            @if (!is_null($tms_vehicles))
                                                            @foreach ($tms_vehicles as $tms_vehicle)
                                                            <option value={{ $tms_vehicle->id }} data-select2-id="{{ $tms_vehicle->id }}" @if ($user->vehicle_id == $tms_vehicle->id) selected="selected" @endif>
                                                                {{ $tms_vehicle->licence_plate }}
                                                            </option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>




                                        <div class="row p-2">
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-6 mt-2">
                                                        <label class="control-label" for="tms_id">Müşteri Tanımlama : </label>
                                                    </div>
                                                    <div class="col-6">
                                                        <select class="form-control" id="tms_id" name="tms_id">
                                                            <option data-select2-id="0" value="0">Seçiniz</option>
                                                            @if (!is_null($tms_customers))
                                                            @foreach ($tms_customers as $tms_customer)
                                                            <option value={{ $tms_customer->id }} data-select2-id="{{ $tms_customer->id }}" @if ($user->tms_id == $tms_customer->id) selected="selected" @endif>
                                                                {{ $tms_customer->company_name }}
                                                            </option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                            </div>
                                        </div>




                                        <div class="col-12">
                                            @if (!is_null($permissions))
                                            <label>İzinler </label>
                                            <div class="form-group">
                                                <div class="row" id="permissionRows">
                                                    @foreach ($permissions as $permission)
                                                    <div class="form-check col-4">
                                                        <input class="form-check-input" type="checkbox" id="permission{{ $permission->id }}" name="permissions[]" value="{{ $permission->id }}" @if ($user->can($permission->name)) checked @endif>
                                                        <label class="form-check-label">{{ $permission->name }}</label>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="float-right mt-2 mb-2 mr-2">
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
    var cols = $('#permissionRows .col-4');
    cols.click(function() {
        var el = $(this);
        var index = el.index();
        var group = Math.ceil(index / 4);
        $(cols.get((group * 4) - 1)).after('<div class="form-group col-12"></div>');
    });
</script>
@endsection