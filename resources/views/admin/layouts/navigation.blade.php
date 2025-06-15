<div class="navigation">
        <a href="{{ route('admin.user.list') }}" class="{{ request()->routeIs('admin.user.list') ? 'active' : '' }}">Ro'yxat</a>
        <a href="{{ route('admin.user.requests') }}" class="{{ request()->routeIs('admin.user.requests') ? 'active' : '' }}">Kirish so'rovlari</a>
        <a href="{{ route('admin.user.locations') }}" class="{{ request()->routeIs('admin.user.locations') ? 'active' : '' }}">Lokatsiyalar</a>
        <a href="{{ route('admin.user.baza.district') }}" class="{{ request()->routeIs('admin.user.baza.district') ? 'active' : '' }}">Tumanlar</a>
        <a href="{{ route('admin.user.baza.object') }}" class="{{ request()->routeIs('admin.user.baza.object') ? 'active' : '' }}">Obyektlar</a>
        <a href="{{ route('admin.user.baza.doctor') }}" class="{{ request()->routeIs('admin.user.baza.doctor') ? 'active' : '' }}">Shifokorlar</a>
        <a href="{{ route('admin.user.baza.pharmacy') }}" class="{{ request()->routeIs('admin.user.baza.pharmacy') ? 'active' : '' }}">Dorixonalar</a>
    </div>