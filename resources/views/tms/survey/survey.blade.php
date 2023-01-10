<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>1K2A | NAKLİYE TAKİP </title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-8 ml-auto mr-auto">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">1K2A ALFA MEMNUNİYET ANKETİ</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form method="POST" action="{{ route('post.tms.survey.send') }}">
                                    @csrf
                                    <input type="hidden" name="oid" value="{{ $orderId }}">
                                    <input type="hidden" name="vid" value="{{ $vehicleId }}">

                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>ZAYIF</th>
                                                <th>ORTA</th>
                                                <th>İYİ</th>
                                                <th>ÇOK İYİ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>KURULUM EKİBİNİN GÖRGÜ KURALLARINA UYUMU</td>
                                                <td><input type="radio" name="etiquette_point" value="1"></td>
                                                <td><input type="radio" name="etiquette_point" value="2"></td>
                                                <td><input type="radio" name="etiquette_point" value="3" checked>
                                                </td>
                                                <td><input type="radio" name="etiquette_point" value="4"></td>
                                            </tr>
                                            <tr>
                                                <td>KURULUM EKİBİNİN İŞ GÜVENLİĞİ KURALLARINA UYUMU</td>
                                                <td><input type="radio" name="safefy_rule_point" value="1"></td>
                                                <td><input type="radio" name="safefy_rule_point" value="2"></td>
                                                <td><input type="radio" name="safefy_rule_point" value="3"
                                                        checked></td>
                                                <td><input type="radio" name="safefy_rule_point" value="4"></td>
                                            </tr>
                                            <tr>
                                                <td>KURULUM EKİBİNİN ÇALIŞMA ALANI TEMİZLİK VE DÜZENİNE UYUMU</td>
                                                <td><input type="radio" name="work_area_cleaning_point"
                                                        value="1"></td>
                                                <td><input type="radio" name="work_area_cleaning_point"
                                                        value="2"></td>
                                                <td><input type="radio" name="work_area_cleaning_point" value="3"
                                                        checked></td>
                                                <td><input type="radio" name="work_area_cleaning_point"
                                                        value="4"></td>
                                            </tr>
                                            <tr>
                                                <td>KURULUM EKİBİNİN VERDİĞİ HİZMET KALİTESİ</td>
                                                <td><input type="radio" name="service_quality_point" value="1">
                                                </td>
                                                <td><input type="radio" name="service_quality_point" value="2">
                                                </td>
                                                <td><input type="radio" name="service_quality_point" value="3"
                                                        checked></td>
                                                <td><input type="radio" name="service_quality_point" value="4">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="float-right mt-2">
                                        <button type="submit" class="btn btn-primary">Kaydet</button>
                                    </div>
                                </form>
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
    </div>
</body>

</html>
