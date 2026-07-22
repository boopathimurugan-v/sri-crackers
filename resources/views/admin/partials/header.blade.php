<div class="header">
    <div class="d-flex align-items-center">
        <!-- Mobile Sidebar Toggle -->
        <button id="sidebarToggle" class="btn btn-light d-md-none me-3 border-0 shadow-sm">
            <i class="bi bi-list fs-4"></i>
        </button>
        
        <!-- Page Title -->
        <h4 class="mb-0 fw-semibold text-dark">
            @yield('title', 'Dashboard')
        </h4>
    </div>
    
    <div class="d-flex align-items-center gap-4">
        <!-- Notification Icon -->
        <div class="position-relative cursor-pointer">
            <i class="bi bi-bell fs-5 text-secondary"></i>
            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                <span class="visually-hidden">New alerts</span>
            </span>
        </div>
        
        <!-- Profile & Admin Name -->
        <div class="d-flex align-items-center gap-2 border-start ps-4">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Admin') }}&background=0D8ABC&color=fff" alt="Admin" class="rounded-circle" width="38" height="38">
            <span class="fw-medium text-dark d-none d-sm-block">{{ auth()->user()->name ?? 'Admin Name' }}</span>
        </div>
        
        <!-- Logout Button -->
        <form action="{{ route('admin.logout') }}" method="POST" class="m-0">
            @csrf
            <button type="submit" class="btn btn-danger btn-sm px-3 d-flex align-items-center gap-1 shadow-sm">
                <i class="bi bi-box-arrow-right"></i>
                <span class="d-none d-sm-inline">Logout</span>
            </button>
        </form>
    </div>
</div>