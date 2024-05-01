@php
    $routeActive = Route::currentRouteName();
@endphp

<li class="nav-item">
    <a class="nav-link {{ $routeActive == 'home' ? 'active' : '' }}" href="{{ route('home') }}">
        <i class="ni ni-tv-2 text-primary"></i>
        <span class="nav-link-text">Dashboard</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ $routeActive == 'users.index' ? 'active' : '' }}" href="{{ route('users.index') }}">
        <i class="fas fa-users text-warning"></i>
        <span class="nav-link-text">Users</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ $routeActive == 'categories.index' ? 'active' : '' }}" href="{{ route('categories.index') }}">
        <i class="fas fa-book text-danger"></i>
        <span class="nav-link-text">Data Kategori</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ $routeActive == 'drink-recipes.index' ? 'active' : '' }}" href="{{ route('drink-recipes.index') }}">
        <i class="fas fa-building text-dark"></i>
        <span class="nav-link-text">Resep Minuman</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ $routeActive == 'profile' ? 'active' : '' }}" href="{{ route('profile') }}">
        <i class="fas fa-user-tie text-success"></i>
        <span class="nav-link-text">Profile</span>
    </a>
</li>
