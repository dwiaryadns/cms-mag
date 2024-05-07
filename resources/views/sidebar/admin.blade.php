<li class="menu-item {{ request()->is('admin') ? 'active' : '' }}">
    <a href="{{ route('admin.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Analytics">Dashboard</div>
    </a>
</li>
<li class="menu-item {{ request()->is('admin/user*') ? 'active' : '' }}">
    <a href="{{ route('admin.user.index') }}" class="menu-link">
        <i class="menu-icon fas fa-user" style="opacity: 0.8"></i>
        <div data-i18n="Analytics">User</div>
    </a>
</li>
<li class="menu-item {{ request()->is('admin/faq*') ? 'active' : '' }}">
    <a href="{{ route('admin.faq.index') }}" class="menu-link">
        <i class="menu-icon tf-icons fa fa-question-circle" style="opacity: 0.8"></i>
        <div data-i18n="Analytics">FAQ</div>
    </a>
</li>
<li class="menu-item {{ request()->is('admin/promotion*') ? 'active' : '' }}">
    <a href="{{ route('admin.promotion.index') }}" class="menu-link">
        <i class="menu-icon tf-icons fa fa-bullhorn" style="opacity: 0.8"></i>
        <div data-i18n="Analytics">Promotion</div>
    </a>
</li>
<li class="menu-item {{ request()->is('admin/news*') ? 'active' : '' }}">
    <a href="{{ route('admin.news.index') }}" class="menu-link">
        <i class="menu-icon tf-icons fa fa-newspaper" style="opacity: 0.8"></i>
        <div data-i18n="Analytics">News</div>
    </a>
</li>
<li class="menu-item {{ request()->is('admin/terms*') ? 'active' : '' }}">
    <a href="{{ route('admin.terms.index') }}" class="menu-link">
        <i class="menu-icon tf-icons fa fa-gavel" style="opacity: 0.8"></i>
        <div data-i18n="Analytics">Terms</div>
    </a>
</li>
<li class="menu-item {{ request()->is('admin/list-branches*') ? 'active' : '' }}">
    <a href="{{ route('admin.list-branches.index') }}" class="menu-link">
        <i class="menu-icon tf-icons fa fa-gavel" style="opacity: 0.8"></i>
        <div data-i18n="Analytics">List Branches</div>
    </a>
</li>