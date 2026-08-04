<div class="sidebar" id="sidebar">
    <div class="d-flex align-items-center justify-content-center py-4 border-bottom">
        <!-- Logo -->
        <h4 class="m-0 fw-bold text-danger d-flex align-items-center gap-2">
            <i class="bi bi-fire fs-3"></i>
            SRI CRACKERS
        </h4>
    </div>
    
    <div class="py-3">
        <ul class="nav flex-column mb-auto">
            
            <!-- Dashboard -->
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.dashboard') ? 'active bg-danger bg-opacity-10 text-danger border-end border-danger border-3 fw-medium' : 'text-dark' }}" 
                   href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-speedometer2 fs-5"></i>
                    Dashboard
                </a>
            </li>
            
            <!-- Orders -->
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.orders.*') ? 'active bg-danger bg-opacity-10 text-danger border-end border-danger border-3 fw-medium' : 'text-dark' }}" 
                   href="{{ route('admin.orders.index') }}">
                    <i class="bi bi-bag-check fs-5"></i>
                    Orders
                </a>
            </li>

            <!-- Categories -->
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.categories.*') ? 'active bg-danger bg-opacity-10 text-danger border-end border-danger border-3 fw-medium' : 'text-dark' }}" 
                   href="{{ route('admin.categories.index') }}">
                    <i class="bi bi-grid fs-5"></i>
                    Categories
                </a>
            </li>

            <!-- Products -->
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.products.*') ? 'active bg-danger bg-opacity-10 text-danger border-end border-danger border-3 fw-medium' : 'text-dark' }}" 
                   href="{{ route('admin.products.index') }}">
                    <i class="bi bi-box-seam fs-5"></i>
                    Products
                </a>
            </li>

            <!-- Offers Header -->
            <li class="nav-item mt-3 mb-2 px-4">
                <small class="text-uppercase text-muted fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Offers</small>
            </li>

            <!-- Banners -->
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-3 px-4 py-2 {{ request()->routeIs('admin.banners.*') ? 'active text-danger fw-medium' : 'text-dark opacity-75' }}" 
                   href="{{ route('admin.banners.index') }}">
                    <i class="bi bi-image fs-6"></i>
                    Banners
                </a>
            </li>

            <!-- Combo Offers -->
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-3 px-4 py-2 {{ request()->routeIs('admin.combo-offers.*') ? 'active text-danger fw-medium' : 'text-dark opacity-75' }}" 
                   href="{{ route('admin.combo-offers.index') }}">
                    <i class="bi bi-box2-heart fs-6"></i>
                    Combo Offers
                </a>
            </li>

            <!-- Users Header -->
            <li class="nav-item mt-3 mb-2 px-4">
                <small class="text-uppercase text-muted fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Users</small>
            </li>

            <!-- Customers -->
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-3 px-4 py-2 {{ request()->routeIs('admin.customers.*') ? 'active text-danger fw-medium' : 'text-dark opacity-75' }}" 
                   href="{{ route('admin.customers.index') }}">
                    <i class="bi bi-people fs-6"></i>
                    Customers
                </a>
            </li>

            <!-- Configuration Header -->
            <li class="nav-item mt-3 mb-2 px-4">
                <small class="text-uppercase text-muted fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Configuration</small>
            </li>
            
            <!-- Reports -->
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-3 px-4 py-2 {{ request()->routeIs('admin.reports.*') ? 'active text-danger fw-medium' : 'text-dark opacity-75' }}" 
                   href="{{ route('admin.reports.index') }}">
                    <i class="bi bi-graph-up-arrow fs-6"></i>
                    Reports
                </a>
            </li>
            
            <!-- Stock Entry (New) -->
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-3 px-4 py-2 {{ request()->routeIs('admin.stock-entries.*') ? 'active text-danger fw-medium' : 'text-dark opacity-75' }}" 
                   href="{{ route('admin.stock-entries.index') }}">
                    <i class="bi bi-boxes fs-6 text-success"></i>
                    Stock Entry
                </a>
            </li>

            <!-- UPI Payment Settings -->
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-3 px-4 py-2 {{ request()->routeIs('admin.upi.*') ? 'active text-danger fw-medium' : 'text-dark opacity-75' }}" 
                   href="{{ route('admin.upi.index') }}">
                    <i class="bi bi-qr-code-scan fs-6 text-primary"></i>
                    UPI Payment Settings
                </a>
            </li>

            <!-- Settings -->
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-3 px-4 py-2 {{ request()->routeIs('admin.settings.*') ? 'active text-danger fw-medium' : 'text-dark opacity-75' }}" 
                   href="{{ route('admin.settings.edit') }}">
                    <i class="bi bi-gear fs-6"></i>
                    Settings
                </a>
            </li>
            
        </ul>
    </div>
</div>
