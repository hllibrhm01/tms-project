@extends('main.main')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="error-page">
            <h2 class="headline text-danger">403</h2>

            <div class="error-content">
                <h3><i class="fas fa-exclamation-triangle text-danger"></i> Oops! Bu işlemi yapmaya yetkiniz yok.</h3>

                <p>
                    Eğer bu işlemi yapmanız gerekiyorsa, yöneticiniz ile iletişime geçiniz.
                    Anasayfaya dönmek için <a href="{{ route('get.dashboard') }}">tıklayınız</a>
                </p>

            </div>
        </div>
        <!-- /.error-page -->

    </section>
    <!-- /.content -->
@endsection


@section('js')
@endsection
