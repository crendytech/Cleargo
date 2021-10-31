<nav id="sidebar" class="sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="https://uniosun.edu.ng">
            <span class="align-middle">UNIOSUN CMS</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-brand " >
                Pages
            </li>

            <li class="sidebar-item @if(\Illuminate\Support\Facades\Request::route()->getName() == "dashboard" ) active @endif">
            <a class="sidebar-link" href="{{ route('dashboard.index')}}">
                <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
            </a>
            </li>
            @if(\Auth::user()->role == "admin")
            <li class="sidebar-item @if(\Illuminate\Support\Facades\Request::route()->getName() == "faculties" ) active @endif">
            <a class="sidebar-link" href="{{ route('faculties.index')}}">
                <i class="align-middle" data-feather="home"></i> <span class="align-middle">Faculties</span>
            </a>
            </li>

            <li class="sidebar-item @if(\Illuminate\Support\Facades\Request::route()->getName() == "departments" ) active @endif">
            <a class="sidebar-link" href="{{ route("departments.index") }}">
                <i class="align-middle" data-feather="columns"></i> <span class="align-middle">Departments</span>
            </a>
            </li>
            <li class="sidebar-item @if(\Illuminate\Support\Facades\Request::route()->getName() == "students" ) active @endif">
                <a class="sidebar-link" href="{{ route("students.index") }}">
                    <i class="align-middle" data-feather="user"></i> <span class="align-middle">Students</span>
                </a>
            </li>
            <li class="sidebar-item @if(\Illuminate\Support\Facades\Request::route()->getName() == "staffs" ) active @endif">
                <a class="sidebar-link" href="{{ route("staffs.index") }}">
                    <i class="align-middle" data-feather="users"></i> <span class="align-middle">Staffs</span>
                </a>
            </li>

            <li class="sidebar-item @if(\Illuminate\Support\Facades\Request::route()->getName() == "clearance") active @endif">
            <a class="sidebar-link" href="{{ route("clearance.index") }}">
                <i class="align-middle" data-feather="book"></i> <span class="align-middle">Clearance</span>
            </a>
            </li>
            @endif
            @if(\Auth::user()->role == "student")
                <li class="sidebar-item @if(\Illuminate\Support\Facades\Request::route()->getName() == "print" ) active @endif">
                    <a class="sidebar-link" target="_blank" href="{{ route('document.print')}}">
                        <i class="align-middle" data-feather="printer"></i> <span class="align-middle">Print Document</span>
                    </a>
                </li>
            @endif
            <li class="sidebar-item @if(\Illuminate\Support\Facades\Request::route()->getName() == "logout" ) active @endif">
            <a class="sidebar-link" href="{{ route('signout') }}">
                <i class="align-middle" data-feather="log-out"></i> <span class="align-middle">Logout</span>
            </a>
            </li>
        </ul>
    </div>
</nav>
