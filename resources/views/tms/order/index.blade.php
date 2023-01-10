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
                            <form method="GET" action="{{ route('get.tms.order.search') }}">
                                <div class="row">
                                    <div class="col-sm-2 col-3 pt-1">
                                        <select class="form-control" id="status" name="status">
                                            <option value="0" data-select2-id="0">SEÇİNİZ</option>
                                            @foreach (App\Models\tms\TMSOrder::OrderStatus as $key => $value)
                                                <option value="{{ $key }}" data-select2-id="{{ $key }}">
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
                                        <th>Grup Tipi</th>
                                        <th>Şirket Adı</th>
                                        <th>İl</th>
                                        <th>İlçe</th>
                                        <th>Durumu</th>
                                        <th>Sipariş Tipi</th>
                                <tbody>
                                    @if ($orders != null)
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td>
                                                    {{ config('constants.group_types')[$order->group_type] }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('get.tms.customer.view', ['id' => $order->customer->id]) }}">
                                                        {{ $order->customer->company_name }}
                                                    </a>
                                                </td>
                                                <td>{{ $order->city->name }}</td>
                                                <td>{{ $order->district->name }}</td>
                                                <td>{{ \App\Models\tms\TMSOrder::OrderStatus[$order->status] }}</td>
                                                <td>
                                                    @if ($order->order_type)
                                                    {{ config('constants.order_types')[$order->order_type] }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <a style="padding: 0 10px"
                                                        href="{{ route('get.tms.order.view', ['id' => $order->id]) }}">
                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                        GÖRÜNTÜLE
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>

                                </tr>
                                </thead>
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
