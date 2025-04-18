<div class="navigation">
        <a href="{{ route('admin.user.list') }}" class="{{ request()->routeIs('admin.user.list') ? 'active' : '' }}">Ro'yxat</a>
        <a href="{{ route('admin.user.requests') }}" class="{{ request()->routeIs('admin.user.requests') ? 'active' : '' }}">Kirish so'rovlari</a>
        <a href="{{ route('admin.user.locations') }}" class="{{ request()->routeIs('admin.user.locations') ? 'active' : '' }}">Lokatsiyalar</a>
    </div>