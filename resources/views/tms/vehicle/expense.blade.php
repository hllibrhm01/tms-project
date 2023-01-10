@extends('main.main')

@section('css')
    <style>
        table td input {
            width: 100px;
            overflow: hidden;
        }

        .collapsible {
            background-color: white;
            color: black;
            cursor: pointer;
            padding: 18px;
            width: 100%;
            border: none;
            text-align: left;
            outline: none;
            font-size: 15px;
            border: 1px solid black;
        }

        .collapsible a {
            color: #007bff;
        }

        .active,
        .collapsible:hover {
            background-color: #aaaaaa;
        }

        .collapsible:after {
            content: '\002B';
            color: black;
            font-weight: bold;
            float: right;
            margin-left: 5px;
        }

        .active:after {
            collapsible-content: "\2212";
        }

        .collapsible-content {
            padding: 0 18px;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.2s ease-out;
        }
    </style>
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="card-header">
                    <h3>ARAÇ MALİYETLERİ</h3>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <input type="hidden" id="daily_mail_price" name="daily_mail_price" value="{{ $dailyMailPrice }}">
                            <form method="GET" action="{{ route('get.tms.vehicle.expense.index') }}">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="input-group date" id="plan_date" data-target-input="nearest">
                                            <input id="plan_date_input" type="text" name="date"
                                                class="form-control datetimepicker-input" data-target="#plan_date"
                                                value="{{ $date }}" />
                                            <div class="input-group-append" data-target="#plan_date"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <button type="submit" class="btn btn-primary">Getir</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <div class="col-12">
                                @foreach ($expenses as $expense)
                                    <button class="collapsible">
                                        <a href="{{ route('get.tms.vehicle.view', ['id' => $expense->vehicle->id]) }}"
                                            target="_blank">
                                            <strong> {{ $expense->vehicle->licence_plate }} </strong>
                                        </a>

                                        <span class="ml-3">
                                            <strong>TOPLAM MALİYET : {{ $expense->total_cost }}</strong>
                                        </span>

                                        <span class="ml-5">
                                            <strong>TOPLAM GELİR : {{ $expense->total_revenue }}</strong>
                                        </span>
                                    </button>
                                    <div class="collapsible-content">
                                        <input type="hidden" id="vehicle_id" name="vehicle_id"
                                            value="{{ $expense->vehicle->id }}">
                                        <div class="row p-2">
                                            <div class="col-4">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="control-label">ÇALIŞAN PERSONEL</label>
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="number" class="employee_count" id="employee_count"
                                                            name="employee_count" value="{{ $expense->employee_count }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="control-label">EKSİK PERS.
                                                            NEDENİ</label>
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="number" class="missing_employee_count"
                                                            id="missing_employee_count" name="missing_employee_count"
                                                            value="{{ $expense->missing_employee_count }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="control-label">FAZLA ÇALIŞAN KİŞİ
                                                            SAYISI</label>
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="number" class="overtimer_employee_count"
                                                            id="overtimer_employee_count" name="overtimer_employee_count"
                                                            value="{{ $expense->overtimer_employee_count }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row p-2">
                                            <div class="col-4">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="control-label">MESAİ BİTİŞ SAATİ</label>
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="time" class="work_finish_time" id="work_finish_time"
                                                            name="work_finish_time"
                                                            value="{{ $expense->work_finish_time }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="control-label">YAPILAN KM</label>
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="number" step="any" class="driven_km"
                                                            id="driven_km" name="driven_km"
                                                            value="{{ $expense->driven_km }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="control-label">ALINAN YAKIT LİTRE</label>
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="number" step="any" class="fuel_taken_per_litre"
                                                            id="fuel_taken_per_litre" name="fuel_taken_per_litre"
                                                            value="{{ $expense->fuel_taken_per_litre }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row p-2">
                                            <div class="col-4">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="control-label">ALINAN YAKIT TL</label>
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="number" step="any" class="fuel_taken_with_tl"
                                                            id="fuel_taken_with_tl" name="fuel_taken_with_tl"
                                                            value="{{ $expense->fuel_taken_with_tl }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="control-label">KM DE HARCANAN
                                                            YAKIT</label>
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="number" step="any"
                                                            class="fuel_consumption_per_km" id="fuel_consumption_per_km"
                                                            name="fuel_consumption_per_km"
                                                            value="{{ $expense->fuel_consumption_per_km }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="control-label">YAKIT YÜZDE ORANI</label>
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="number" step="any"
                                                            class="fuel_consumption_percentage_per_km"
                                                            id="fuel_consumption_percentage_per_km"
                                                            name="fuel_consumption_percentage_per_km"
                                                            value="{{ $expense->fuel_consumption_percentage_per_km }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row p-2">
                                            <div class="col-4">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="control-label">KİRA MALİYETİ</label>
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="number" step="any" class="rental_cost"
                                                            id="rental_cost" name="rental_cost"
                                                            value="{{ $expense->rental_cost }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="control-label">PERSONEL
                                                            MALİYETİ</label>
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="number" step="any" class="employee_cost"
                                                            id="employee_cost" name="employee_cost"
                                                            value="{{ $expense->employee_cost }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="control-label">SODEXO GÜNLÜK HAKEDİŞ</label>
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="number" step="any" class="daily_meal_cost"
                                                            id="daily_meal_cost" name="daily_meal_cost"
                                                            value="{{ $expense->daily_meal_cost }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row p-2">
                                            <div class="col-4">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="control-label">SODEXO MESAİ GÜNLÜK</label>
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="number" step="any"
                                                            class="daily_overtime_meal_cost" id="daily_overtime_meal_cost"
                                                            name="daily_overtime_meal_cost"
                                                            value="{{ $expense->daily_overtime_meal_cost }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="control-label">OTOYOL
                                                            GİDERLERİ</label>
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="number" step="any" class="highway_expenses"
                                                            id="highway_expenses" name="highway_expenses"
                                                            value="{{ $expense->highway_expenses }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="control-label">YEVMİYECİ</label>
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="number" step="any" class="day_laborer"
                                                            id="day_laborer" name="day_laborer"
                                                            value="{{ $expense->day_laborer }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row p-2">
                                            <div class="col-4">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="control-label">SARF MALZEME</label>
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="number" step="any" class="supplies_cost"
                                                            id="supplies_cost" name="supplies_cost"
                                                            value="{{ $expense->supplies_cost }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="control-label">TOPLAM MALİYET</label>
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="number" class="total_cost" id="total_cost"
                                                            name="total_cost" value="{{ $expense->total_cost }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="control-label">TOPLAM GELİR</label>
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="number" class="total_revenue" id="total_revenue"
                                                            name="total_revenue" value="{{ $expense->total_revenue }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row p-2">
                                            <div class="col-4">
                                                <button type="button" class="btn btn-primary save">KAYDET</button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
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
    <script src="/js/tms/vehicle/expense.js"></script>
@endsection
