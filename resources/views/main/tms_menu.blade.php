<li class="nav-item @if (str_contains(request()->path(), 'tms/')) menu-is-opening menu-open @endif">
    <a href="#" class="nav-link">
        <i class="nav-icon fa fa-sitemap"></i>
        <p> TMS
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item  @if (str_contains(request()->path(), 'tms/vehicle/supplier')) menu-is-opening menu-open @endif">
            <a href="#" class="nav-link">
                <i class="nav-icon fa fa-phone-square"></i>
                <p>Tedarikçi Tanımları
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('get.tms.vehicle.supplier.add') }}" class="nav-link">
                        Yeni Tedarikçi Tanımla
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('get.tms.vehicle.supplier.index') }}" class="nav-link">
                        Tüm Tedarikçiler
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item  @if (str_contains(request()->path(), 'tms/vehicle/service')) menu-is-opening menu-open @endif">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-map-marker-alt"></i>
                <p>Servis Tanımları
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('get.tms.vehicle.service.add') }}" class="nav-link">
                        Yeni Servis Tanımla
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('get.tms.vehicle.service.index') }}" class="nav-link">
                        Tüm Servisler
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item @if (str_contains(request()->path(), 'tms/customer')) menu-is-opening menu-open @endif">
            <a href="#" class="nav-link">
                <i class="nav-icon fa fa-sign-language"></i>
                <p>Müşteri Tanımları
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('get.tms.customer.add') }}" class="nav-link">
                        <i class="nav-icon"></i>
                        <p>
                            Yeni Müşteri Tanımla
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('get.tms.customer.index') }}" class="nav-link">
                        <i class="nav-icon"></i>
                        <p>
                            Tüm Müşteriler
                        </p>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item @if (str_contains(request()->path(), 'tms/vehicle/add') || request()->path() == 'tms/vehicle') menu-is-opening menu-open @endif">
            <a href="#" class="nav-link">
                <i class="nav-icon fa fa-car"></i>
                <p>Araç Tanımları
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('get.tms.vehicle.add') }}" class="nav-link">
                        Yeni Araç Tanımla
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('get.tms.vehicle.expense.index') }}" class="nav-link">
                        Araç Maliyeti Tanımla
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('get.tms.vehicle.index') }}" class="nav-link">
                        Tüm Araçlar
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item @if (str_contains(request()->path(), 'tms/order')) menu-is-opening menu-open @endif">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-cart-plus"></i>
                <p>Sipariş Tanımları
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('get.tms.order.add') }}" class="nav-link">
                        <i class="nav-icon"></i>
                        <p>
                            Yeni Sipariş
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('get.tms.order.index') }}" class="nav-link">
                        <i class="nav-icon"></i>
                        <p>
                            Tüm Siparişler
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('get.tms.preorder.type' , ['typeld' => 0]) }}" class="nav-link">
                        <i class="nav-icon"></i>
                        <p>
                            Tüm Ön Siparişler
                        </p>
                    </a>
                </li>
            </ul>
        </li>
        <!--
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-route"></i>
                <p>
                    ROUTE PLANLAMA
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
    -->
    </ul>
</li>
