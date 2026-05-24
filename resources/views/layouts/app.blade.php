<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>RFN Application</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.0/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #343a40;
        }
        .navbar a {
            color: white !important;
        }
        .dropdown-menu {
            background-color: white;
            border: 1px solid #dee2e6;
        }
        .dropdown-menu .dropdown-item {
            color: #212529 !important;
        }
        .dropdown-item {
            color: #212529 !important;
            padding: 0.5rem 1rem;
        }
        .dropdown-item:hover,
        .dropdown-item:focus {
            background-color: #f8f9fa;
            color: #007bff !important;
        }
        .dropdown-divider {
            margin: 0.5rem 0;
        }
        .container {
            background-color: white;
            border-radius: 8px;
            padding: 30px;
            margin-top: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #343a40;
            margin-bottom: 30px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">RFN Application</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <!-- Activity Section -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="activityDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-briefcase"></i> Activity
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="activityDropdown">
                            <li><a class="dropdown-item" href="{{ route('degrees.index') }}">Degrees</a></li>
                            <li><a class="dropdown-item" href="{{ route('students.index') }}">Students</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('logs.index') }}">Activity Logs</a></li>
                        </ul>
                    </li>

                    <!-- Dashboard Section -->
                    @auth
                    @if(Auth::user()->user_type === 'student')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('student.dashboard') }}">
                            <i class="bi bi-house"></i> Dashboard
                        </a>
                    </li>
                    @elseif(Auth::user()->user_type === 'teacher')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('teacher.dashboard') }}">
                            <i class="bi bi-house"></i> Dashboard
                        </a>
                    </li>
                    @elseif(Auth::user()->user_type === 'admin')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-house"></i> Dashboard
                        </a>
                    </li>
                    @endif
                    @endauth

                    <!-- Relationships Section -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="relationshipsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-graph"></i> Relationships
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="relationshipsDropdown">
                            <li><a class="dropdown-item" href="{{ route('profiles.index') }}"><i class="bi bi-person"></i> Profiles (1:1)</a></li>
                            <li><a class="dropdown-item" href="{{ route('posts.index') }}"><i class="bi bi-file-text"></i> Posts (1:Many)</a></li>
                            <li><a class="dropdown-item" href="{{ route('courses.index') }}"><i class="bi bi-book"></i> Courses (Many:Many)</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('courses.by-degree') }}"><i class="bi bi-mortarboard"></i> <strong>Courses by Degree</strong></a></li>
                        </ul>
                    </li>

                    <!-- User Menu -->
                    @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i> {{ Auth::user()->name ?? Auth::user()->email }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile') }}">👤 Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="dropdown-item" style="border: none; background: none; cursor: pointer; color: #dc3545;">
                                        🚪 Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">🔐 Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">📝 Register</a>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; 2026 RFN Application. All rights reserved.</p>
    </footer>

    <!-- jQuery (before Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    
    <!-- App JS -->
    @vite(['resources/js/app.js'])
</body>
</html>
