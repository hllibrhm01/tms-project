@extends('main.main')

@section('css')
    <link href="{{ asset('/css/main/main.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Arama Yap</h3>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ route('get.tms.dealer.order.search') }}">
                                <div class="row">
                                    <div class="col-sm-4 col-6 pt-1">
                                        <select class="form-control" id="status" name="status">
                                            <option value="0" data-select2-id="0">Seçiniz</option>
                                            @foreach (App\Models\tms\TMSOrder::OrderStatus as $key => $value)
                                                <option value="{{ $key }}" data-select2-id="{{ $key }}"
                                                    @if ($key == $type) selected @endif>
                                                    {{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-2 pt-1">
                                        <button type="submit" class="btn btn-primary">ARA</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Siparişler</h3>
                        </div>
                        <div class="card-body">
                            <table id="vehiclesTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sipariş Veren</th>
                                        <th>Ürün Bilgisi</th>
                                        <th>Durumu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>
                                                {!! $order->getOrdererInfo() !!}
                                            </td>
                                            <td>
                                                {!! $order->getProductInfo() !!}
                                            </td>
                                            <td>
                                                {{ \App\Models\tms\TMSOrder::OrderStatus[$order->status] }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script src="/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/js/tms/order/order.js"></script>
@endsection
