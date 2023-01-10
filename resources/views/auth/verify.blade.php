@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">E-mail adresinizi doğrulayın</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            Mail adresinize yeni bir doğrulama maili gönderdik.
                        </div>
                    @endif

                    Doğrulama linki için mail adresinizi kontrol ediniz.
                    Eğer mail size ulaşmadıysa,
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">Tekrar Gönder</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
