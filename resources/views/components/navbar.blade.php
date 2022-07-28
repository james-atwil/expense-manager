<?php $user = auth()->user(); ?>
<nav id="navbar" class="navbar navbar-expand fixed-top navbar-dark bg-primary" aria-label="Navigation Bar">
    <div class="container-fluid px-3">
        <button type="button" class="btn btn-sm btn-outline-light me-3"
                aria-controls="navbars" aria-expanded="false" aria-label="Toggle navigation"
                data-bs-toggle="offcanvas" data-bs-target="#sidebar">
            <i class="fas fa-bars"></i>
        </button>

        <a class="navbar-brand" href="{{ route('home') }}">{{ settings('admin.meta.title') }}</a>

        <div class="collapse navbar-collapse" id="navbars">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('profile') }}">Hello, {{ $user->name_display }}!</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
