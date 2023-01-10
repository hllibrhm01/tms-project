<li class="nav-item @if (str_contains(request()->path(), 'crm/')) menu-is-opening menu-open @endif">
    <a href="#" class="nav-link">
        <i class="nav-icon fa fa-address-card"></i>
        <p>CRM
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
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
                    <a href="{{ route('get.crm.email.templates.index') }}" class="nav-link">
                        <i class="nav-icon  fas fa-envelope"></i>
                        <p>
                            Email Şablonları
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('get.crm.multi.mail.send') }}" class="nav-link">
                        <i class="nav-icon fas fa-reply"></i>
                        <p>
                            Toplu Mail Gönder
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-reply-all"></i>
                        <p>
                            Gönderilen Emailler
                        </p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="{{ route('get.crm.customer.index') }}" class="nav-link">
                <i class="nav-icon fas fa-user-tie"></i>
                <p>
                    Müşteriler
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('get.crm.assignment.index') }}" class="nav-link">
                <i class="nav-icon fas fa-people-arrows"></i>
                <p>
                    Atamalar
                </p>
            </a>
        </li>
    </ul>
</li>
