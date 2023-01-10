<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-warehouse"></i>
        <p>WMS
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-user-tie"></i>
                <p>Müşteri Tanımları
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('get.wms.customer.index') }}" class="nav-link">
                        <i class="nav-icon"></i>
                        <p>
                            Müşteriler 
                        </p>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-map-marker-alt"></i>
                <p>Operasyon Tanımları
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('get.wms.location.index') }}" class="nav-link">
                        <i class="nav-icon"></i>
                        <p>
                            Lokasyon
                        </p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-cart-arrow-down"></i>
                <p>Sipariş Tanımları
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('get.wms.order.add') }}" class="nav-link">
                        <i class="nav-icon"></i>
                        <p>
                            Yeni Sipariş
                        </p>
                    </a>
                </li>
            </ul>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('get.wms.order.index', ['id' => '1', 'typeld' => '1']) }}" class="nav-link">
                        <i class="nav-icon"></i>
                        <p>
                            <i class="nav-icon fas fa-store"></i>
                            Bayi Siparişi
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('get.wms.order.index', ['id' => '1', 'typeld' => '1']) }}" class="nav-link">
                                <i class="nav-icon"></i>
                                <p>
                                    Yükleme Bekleyen
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('get.wms.order.index', ['id' => '1', 'typeld' => '7']) }}" class="nav-link">
                                <i class="nav-icon"></i>
                                <p>
                                    Tamamlanan
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('get.wms.order.index', ['id' => '1', 'typeld' => '5']) }}" class="nav-link">
                                <i class="nav-icon"></i>
                                <p>
                                    Anket Bekleyen
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('get.wms.order.index', ['id' => '1', 'typeld' => '8']) }}" class="nav-link">
                                <i class="nav-icon"></i>
                                <p>
                                    İade Bekleyen
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('get.wms.order.index', ['id' => '1', 'typeld' => '6']) }}" class="nav-link">
                                <i class="nav-icon"></i>
                                <p>
                                    Hasar Bekleyen
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('get.wms.order.index', ['id' => '2', 'typeld' => '1']) }}" class="nav-link">
                        <i class="nav-icon"></i>
                        <p>
                            <i class="nav-icon fas fa-warehouse"></i>
                            Depo Siparişi
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('get.wms.order.index', ['id' => '2', 'typeld' => '1']) }}" class="nav-link">
                                <i class="nav-icon"></i>
                                <p>
                                    Yükleme Bekleyen
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('get.wms.order.index', ['id' => '2', 'typeld' => '7']) }}" class="nav-link">
                                <i class="nav-icon"></i>
                                <p>
                                    Tamamlanan
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('get.wms.order.index', ['id' => '2', 'typeld' => '5']) }}" class="nav-link">
                                <i class="nav-icon"></i>
                                <p>
                                    Anket Bekleyen
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('get.wms.order.index', ['id' => '2', 'typeld' => '8']) }}" class="nav-link">
                                <i class="nav-icon"></i>
                                <p>
                                    İade Bekleyen
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('get.wms.order.index', ['id' => '2', 'typeld' => '6']) }}" class="nav-link">
                                <i class="nav-icon"></i>
                                <p>
                                    Hasar Bekleyen
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-undo"></i>
                <p>
                    İADE/HASARLI DEPO
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-file-contract"></i>
                <p>
                    SÖZLEŞME YÖNETİMİ
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-receipt"></i>
                <p>
                    FATURA İŞLEMLERİ
                </p>
            </a>
        </li>
    </ul>
</li>