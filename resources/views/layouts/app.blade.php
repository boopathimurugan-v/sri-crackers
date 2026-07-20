<!DOCTYPE html>
<html lang="en">
<head>
    @include('components.head')
</head>

<body class="bg-amber-50/30 text-slate-800 font-sans">

@include('components.topbar')

@include('components.navbar')

@yield('content')

@include('components.footer')

@include('components.scripts')
    
</body>
</html>