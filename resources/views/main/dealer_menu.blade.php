<li class="nav-item @if (str_contains(request()->path(), 'tms/dealer')) menu-is-opening menu-open @endif">
    <a href="#" class="nav-link">
        <i class="nav-icon fa fa-thumbs-up" aria-hidden="true"></i>
        <p>BAYİ 
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item @if (str_contains(request()->path(), 'tms/dealer/order')) menu-is-opening menu-open @endif">
            <a href="#" class="nav-link">
                <i class="fa fa-shopping-bag"></i>
                <p>Siparişlerim
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('get.tms.dealer.order.type' , ['typeld' => 0]) }}" class="nav-link">
                        <i class="nav-icon"></i>
                        <p>
                            Tüm Siparişler
                        </p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item @if (str_contains(request()->path(), 'tms/preorder')) menu-is-opening menu-open @endif">
            <a href="#" class="nav-link">
                <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                <p>Ön Sipariş Tanımları
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('get.tms.dealer.preorder.add') }}" class="nav-link">
                        <i class="nav-icon"></i>
                        <p>
                            Yeni Ön Sipariş
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('get.tms.dealer.preorder.type' , ['typeld' => 0]) }}" class="nav-link">
                        <i class="nav-icon"></i>
                        <p>
                            Tüm Ön Siparişler
                        </p>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</li>
