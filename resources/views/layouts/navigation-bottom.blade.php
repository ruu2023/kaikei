<nav class="bottom-nav">
    <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i>
        <span>ホーム</span>
    </a>
    <a href="{{ route('transaction') }}" class="nav-item {{ request()->routeIs('transaction') ? 'active' : '' }}">
        <i class="fas fa-exchange-alt"></i>
        <span>取引</span>
    </a>
    <a href="{{ route('analytics') }}" class="nav-item {{ request()->routeIs('analytics') ? 'active' : '' }}">
        <i class="fas fa-chart-line"></i>
        <span>分析</span>
    </a>
    <a href="{{ route('settings') }}" class="nav-item {{ request()->routeIs('settings') ? 'active' : '' }}">
        <i class="fas fa-cog"></i>
        <span>設定</span>
    </a>
</nav>