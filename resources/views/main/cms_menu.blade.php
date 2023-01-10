<li class="nav-item @if (str_contains(request()->path(), 'cms/')) menu-is-opening menu-open @endif">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-user-friends"></i>
        <p>CMS
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item @if (str_contains(request()->path(), 'cms/user')) menu-is-opening menu-open @endif">
            <a href="#" class="nav-link">
                <i class="nav-icon fa fa-wrench"></i>
                <p>Sistem Tanımları
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('get.cms.general.settings') }}" class="nav-link">
                        <i class="nav-icon"></i>
                        <p>
                            Genel Ayarlar
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('get.cms.user.index') }}" class="nav-link">
                        <i class="nav-icon"></i>
                        <p>
                            Kullanıcılar
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon"></i>
                        <p>
                            Roller
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon"></i>
                        <p>
                            İzinler
                        </p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-mail-bulk"></i>
                <p>
                    Email İşlemleri
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon"></i>
                        <p>
                            Email Şablonları
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon"></i>
                        <p>
                            Toplu Mail Gönder
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon"></i>
                        <p>
                            Gönderilen Emailler
                        </p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-mail-bulk"></i>
                <p>
                    Mail Gönderim İşlemleri
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>
                            Müşteri Mailleri
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-people-arrows"></i>
                        <p>
                            Atama Mailleri
                        </p>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</li>
