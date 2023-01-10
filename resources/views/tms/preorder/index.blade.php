@extends('main.main')

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
                            <form method="GET" action="{{ route('get.tms.preorder.search') }}">
                                <div class="row">
                                    <div class="col-sm-4 col-6 pt-1">
                                        <select class="form-control" id="status" name="status">
                                            <option value="0" data-select2-id="0"
                                                @if ($type == 0) selected @endif>SEÇİNİZ</option>
                                            <option value="1" data-select2-id="1"
                                                @if ($type == 1) selected @endif>SİPARİŞ ALINDI</option>
                                            <option value="2" data-select2-id="2"
                                                @if ($type == 2) selected @endif>SİPARİŞ OLUŞTURULDU
                                            </option>
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
                                        <th>Müşteri</th>
                                        <th>Ürün Bilgisi</th>
                                        <th>Durumu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($preorders as $order)
                                        <tr>
                                            <td>
                                                <a
                                                    href="{{ route('get.tms.customer.view', ['id' => $order->customer->id]) }}">
                                                    {{ $order->customer->company_name }}
                                                </a>
                                            </td>
                                            <td>
                                                {!! $order->getProductInfo() !!}
                                            </td>
                                            <td>
                                                @switch($order->status)
                                                    @case(1)
                                                        SİPARİŞ ALINDI
                                                    @break

                                                    @case(2)
                                                        SİPARİŞ OLUŞTURULDU
                                                    @break

                                                    @default
                                                        {{ $order->status }}
                                                    @break
                                                @endswitch
                                            </td>
                                            <td>
                                                <a style="padding: 0 10px"
                                                    href="{{ route('get.tms.preorder.view', ['id' => $order->id]) }}">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                    GÖRÜNTÜLE
                                                </a>
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
