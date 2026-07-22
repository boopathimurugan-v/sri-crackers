<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Sri Crackers</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f8f9fa;
            margin: 0;
            overflow-x: hidden;
        }
        .wrapper {
            display: flex;
            width: 100%;
            height: 100vh;
        }
        .sidebar {
            width: 260px;
            min-width: 260px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1040;
            background-color: #fff;
            box-shadow: 2px 0 5px rgba(0,0,0,0.05);
            overflow-y: auto;
            transition: all 0.3s ease;
        }
        .main-content {
            width: 100%;
            margin-left: 260px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            transition: all 0.3s ease;
        }
        .header {
            height: 70px;
            position: sticky;
            top: 0;
            z-index: 1030;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
        }
        .page-content {
            flex-grow: 1;
            padding: 2rem;
        }
        .footer {
            padding: 1rem 1.5rem;
            background-color: #fff;
            border-top: 1px solid #dee2e6;
            margin-top: auto;
        }
        
        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .sidebar {
                margin-left: -260px;
            }
            .sidebar.active {
                margin-left: 0;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

    @auth
        <div class="wrapper">
            <!-- Sidebar (Fixed Left) -->
            @include('admin.partials.sidebar')
            
            <!-- Main Content -->
            <div class="main-content" id="mainContent">
                <!-- Header (Fixed Top) -->
                @include('admin.partials.header')
                
                <!-- Page Content -->
                <div class="page-content">
                    @yield('content')
                </div>
                
                <!-- Footer -->
                @include('admin.partials.footer')
            </div>
        </div>
    @else
        <!-- For Guest Pages (Login) -->
        <main>
            @yield('content')
        </main>
    @endauth

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar toggle logic for mobile
        document.addEventListener('DOMContentLoaded', function() {
            var toggleBtn = document.getElementById('sidebarToggle');
            var sidebar = document.getElementById('sidebar');
            
            if(toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                });
            }
        });
    </script>
</body>
</html>
