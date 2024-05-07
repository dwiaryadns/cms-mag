<li class="menu-item {{ request()->is('operational') ? 'active' : '' }}">
    <a href="{{ route('operational.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Analytics">Dashboard</div>
    </a>
</li>