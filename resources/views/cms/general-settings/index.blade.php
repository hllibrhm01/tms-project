@extends('main.main')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            GENEL AYARLAR
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <form method="POST" action="{{ route('post.cms.general.settings.update') }}">
                                            @csrf
                                            <div class="row p-2">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-6 mt-2">
                                                            <label class="control-label" for="copyright">Telif Metni
                                                                :</label>
                                                        </div>
                                                        <div class="col-6">
                                                            <input type="text" class="form-control" id="copyright"
                                                                name="copyright" placeholder="Telif metni giriniz"
                                                                value="{{ $setting->copyright }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row p-2">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-6 mt-2">
                                                            <label class="control-label" for="daily_meal_price">
                                                                Günlük Yemek Fiyatı :</label>
                                                        </div>
                                                        <div class="col-6">
                                                            <input type="text" class="form-control" id="daily_meal_price"
                                                                name="daily_meal_price"
                                                                placeholder="Günlük yemek fiyatı giriniz"
                                                                value="{{ $setting->daily_meal_price }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row p-2">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-6 mt-2">
                                                            <label class="control-label" for="code_mandatory_status">
                                                                SMS KODU ZORUNLU DURUMLAR :</label>
                                                        </div>
                                                        <div class="col-6">
                                                            <input type="text" class="form-control"
                                                                id="code_mandatory_status" name="code_mandatory_status"
                                                                placeholder="SMS kodu zorunlu durumları giriniz"
                                                                value="{{ $setting->code_mandatory_status }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row p-2">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-6 mt-2">
                                                            <label class="control-label" for="note_mandatory_status">
                                                                NOT ZORUNLU DURUMLAR :</label>
                                                        </div>
                                                        <div class="col-6">
                                                            <input type="text" class="form-control"
                                                                id="note_mandatory_status" name="note_mandatory_status"
                                                                placeholder="Not zorunlu durumları giriniz"
                                                                value="{{ $setting->note_mandatory_status }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row p-2">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-6 mt-2">
                                                            <label class="control-label" for="image_mandatory_status">
                                                                RESİM YÜKLEMESİ ZORUNLU DURUMLAR :</label>
                                                        </div>
                                                        <div class="col-6">
                                                            <input type="text" class="form-control"
                                                                id="image_mandatory_status" name="image_mandatory_status"
                                                                placeholder="Resim yüklemesi zorunlu durumları giriniz"
                                                                value="{{ $setting->image_mandatory_status }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row p-2">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-6 mt-2">
                                                            <label class="control-label"
                                                                for="dealer_notify_mandatory_status">
                                                                BAYİNİN MÜŞTERİSİNE BİLDİRİM GÖNDERİLECEK DURUMLAR :</label>
                                                        </div>
                                                        <div class="col-6">
                                                            <input type="text" class="form-control"
                                                                id="dealer_notify_mandatory_status"
                                                                name="dealer_notify_mandatory_status"
                                                                placeholder="Bayinin müşterisine bildirim gönderilecek durumları giriniz"
                                                                value="{{ $setting->dealer_notify_mandatory_status }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row p-2">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-6 mt-2">
                                                            <label class="control-label"
                                                                for="planner_notify_mandatory_status">
                                                                PLANLAMACIYA BİLDİRİM GÖNDERİLECEK DURUMLAR :</label>
                                                        </div>
                                                        <div class="col-6">
                                                            <input type="text" class="form-control"
                                                                id="planner_notify_mandatory_status"
                                                                name="planner_notify_mandatory_status"
                                                                placeholder="Planlamacıya bildirim gönderilecek durumları giriniz"
                                                                value="{{ $setting->planner_notify_mandatory_status }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row p-2">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-6 mt-2">
                                                            <label class="control-label"
                                                                for="orderer_notify_mandatory_status">
                                                                BAYİYE BİLDİRİM GÖNDERİLECEK DURUMLAR :</label>
                                                        </div>
                                                        <div class="col-6">
                                                            <input type="text" class="form-control"
                                                                id="orderer_notify_mandatory_status"
                                                                name="orderer_notify_mandatory_status"
                                                                placeholder="Bayiye bildirim gönderilecek durumları giriniz"
                                                                value="{{ $setting->orderer_notify_mandatory_status }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="float-right mt-3">
                                                <button type="submit" class="btn btn-primary">Güncelle</button>
                                            </div>
                                        </form>
                                    </div>
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
@endsection
