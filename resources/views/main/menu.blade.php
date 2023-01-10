<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
            <a href="{{ route('get.dashboard') }}" class="d-block">@auth
                    {{ Auth::user()->name }}
                @endauth
        </div>


        <div class="info">
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            @hasanyrole('Super Admin|Admin')
                @include('main.cms_menu')
            @endhasanyrole
            @hasanyrole('Super Admin|Admin')
                @include('main.crm_menu')
            @endhasanyrole
            @hasanyrole('Super Admin|Admin|Planner')
                @include('main.tms_menu')
            @endhasanyrole
            @hasanyrole('Super Admin|Admin|Dealer')
                @include('main.dealer_menu')
            @endhasanyrole
        </ul>

    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->

<style>
    .sidebar {}
</style>
