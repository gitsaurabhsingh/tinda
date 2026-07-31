<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Portal') - Tindablog</title>
    <!-- Favicon -->
    @if(isset($settings['site_logo']) && !empty($settings['site_logo']))
        <link rel="icon" href="{{ $settings['site_logo'] }}">
    @endif
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { 
            font-family: 'Outfit', sans-serif; 
            background-color: #f3f4f6; 
            color: #1f2937; 
            overflow-x: hidden;
        }
        
        /* Premium Sidebar */
        .sidebar { 
            background: linear-gradient(180deg, #1e1b4b 0%, #312e81 100%);
            height: 100vh; 
            color: #e5e7eb; 
            padding: 30px 15px;
            box-shadow: 4px 0 15px rgba(0,0,0,0.1);
            position: fixed;
            width: 260px;
            z-index: 1000;
            overflow-y: auto;
            overflow-x: hidden;
        }
        /* Custom Scrollbar for Sidebar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }
        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05); 
        }
        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2); 
            border-radius: 10px;
        }
        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.4); 
        }
        .sidebar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: #ffffff;
            text-align: center;
            margin-bottom: 40px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .sidebar .nav-link { 
            color: #9ca3af; 
            font-weight: 500;
            padding: 12px 20px; 
            border-radius: 12px;
            display: flex;
            align-items: center;
            margin-bottom: 8px;
            transition: all 0.3s ease; 
        }
        .sidebar .nav-link i {
            width: 25px;
            font-size: 1.1rem;
            margin-right: 10px;
        }
        .sidebar .nav-link:hover { 
            background: rgba(255,255,255,0.1); 
            color: #ffffff; 
            transform: translateX(5px);
        }
        .sidebar .nav-link.active { 
            background: linear-gradient(90deg, #4f46e5, #6366f1); 
            color: white; 
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.4);
        }

        /* Main Content */
        .main-content {
            margin-left: 260px;
            padding: 40px;
            width: calc(100% - 260px);
            min-height: 100vh;
        }

        /* Premium Cards */
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        }
        .hover-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 30px -10px rgba(0, 0, 0, 0.1);
        }
        
        /* Modern Tables */
        .table {
            --bs-table-bg: transparent;
            vertical-align: middle;
        }
        .table thead th {
            background-color: #f8fafc;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e2e8f0;
            padding: 15px;
        }
        .table tbody td {
            padding: 15px;
            border-bottom: 1px solid #f1f5f9;
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, #4f46e5, #3b82f6);
            border: none;
            border-radius: 50px;
            padding: 10px 25px;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(59, 130, 246, 0.3);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(59, 130, 246, 0.4);
        }

        /* Responsive Admin Layout */
        .mobile-header {
            display: none;
            background: linear-gradient(90deg, #1e1b4b 0%, #312e81 100%);
            padding: 15px 20px;
            color: white;
            align-items: center;
            justify-content: space-between;
        }
        
        .offcanvas-end {
            background: linear-gradient(180deg, #1e1b4b 0%, #312e81 100%);
            color: #e5e7eb;
            width: 280px;
        }

        @media (max-width: 991.98px) {
            .sidebar.desktop-sidebar {
                display: none;
            }
            .main-content {
                margin-left: 0;
                width: 100%;
                padding: 20px;
            }
            .mobile-header {
                display: flex;
            }
        }
    </style>
</head>
<body>
    <div class="d-flex flex-column flex-lg-row">
        
        <!-- Mobile Top Header -->
        <div class="mobile-header d-lg-none w-100 shadow-sm sticky-top">
            <div class="fw-bold fs-5"><i class="fa-solid fa-bolt text-warning me-2"></i> Tindablog Admin</div>
            <button class="btn btn-outline-light border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
                <i class="fa-solid fa-bars fs-4"></i>
            </button>
        </div>

        <!-- Desktop Sidebar -->
        <div class="sidebar desktop-sidebar">
            <div class="sidebar-brand">
                <i class="fa-solid fa-bolt text-warning me-2"></i> Tindablog
            </div>
            
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-pie"></i> Dashboard
            </a>
            
            <a href="{{ route('admin.blogs.index') }}" class="nav-link {{ request()->routeIs('admin.blogs.index') ? 'active' : '' }}">
                <i class="fa-solid fa-layer-group"></i> All Blogs
            </a>
            
            <a href="{{ route('admin.blogs.create') }}" class="nav-link {{ request()->routeIs('admin.blogs.create') ? 'active' : '' }}">
                <i class="fa-solid fa-pen-nib"></i> Manage Blogs
            </a>
            
            <a href="{{ route('admin.categories') }}" class="nav-link {{ request()->routeIs('admin.categories') ? 'active' : '' }}">
                <i class="fa-solid fa-tags"></i> Categories
            </a>
            
            <a href="{{ route('admin.users') }}" class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                <i class="fa-solid fa-users"></i> Users
            </a>

            <a href="{{ route('admin.subscribers') }}" class="nav-link {{ request()->routeIs('admin.subscribers') ? 'active' : '' }}">
                <i class="fa-solid fa-envelope"></i> Subscribers
            </a>

            <a href="{{ route('admin.settings.header') }}" class="nav-link {{ request()->routeIs('admin.settings.header') ? 'active' : '' }}">
                <i class="fa-solid fa-heading"></i> Header Settings
            </a>
            
            <div class="mt-4 mb-2 ps-3 text-uppercase" style="font-size: 0.75rem; color: #6b7280; font-weight: 700; letter-spacing: 1px;">Content</div>
            
            <a href="{{ route('admin.pages.index') }}" class="nav-link {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-lines"></i> Pages
            </a>
            
            <a href="{{ route('admin.contacts.index') }}" class="nav-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }} d-flex justify-content-between align-items-center">
                <div><i class="fa-solid fa-envelope-open-text"></i> Messages</div>
                <span class="badge bg-danger rounded-pill px-2 py-1 unread-badge" style="display: {{ (isset($unreadMessages) && $unreadMessages > 0) ? 'inline-block' : 'none' }};"><i class="fa-solid fa-bell fa-shake me-1"></i> <span class="unread-count">{{ $unreadMessages ?? 0 }}</span></span>
            </a>
            
            <div class="mt-4 mb-2 ps-3 text-uppercase" style="font-size: 0.75rem; color: #6b7280; font-weight: 700; letter-spacing: 1px;">Configuration</div>
            
            <a href="{{ route('admin.settings.cta') }}" class="nav-link {{ request()->routeIs('admin.settings.cta') ? 'active' : '' }}">
                <i class="fa-solid fa-bullhorn"></i> CTA Settings
            </a>
            <a href="{{ route('admin.settings.hero') }}" class="nav-link {{ request()->routeIs('admin.settings.hero') ? 'active' : '' }}">
                <i class="fa-solid fa-image"></i> Hero Settings
            </a>
            
            <a href="{{ route('admin.settings.footer') }}" class="nav-link {{ request()->routeIs('admin.settings.footer') ? 'active' : '' }}">
                <i class="fa-solid fa-link"></i> Footer Settings
            </a>
            
            <a href="{{ url('/') }}" class="nav-link text-warning mt-5" target="_blank">
                <i class="fa-solid fa-arrow-up-right-from-square"></i> View Live Site
            </a>
            
            <div class="mt-4 pt-3 border-top border-secondary border-opacity-50">
                <a href="{{ route('admin.profile') }}" class="btn btn-outline-light w-100 fw-bold d-flex align-items-center justify-content-center mb-2" style="border-radius: 10px; transition: all 0.3s ease;">
                    <i class="fa-solid fa-user-circle me-2"></i> My Profile
                </a>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger w-100 fw-bold d-flex align-items-center justify-content-center" style="border-radius: 10px; transition: all 0.3s ease;">
                        <i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Log Out
                    </button>
                </form>
            </div>
        </div>

        <!-- Mobile Offcanvas Sidebar (Opens from Right) -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
            <div class="offcanvas-header border-bottom border-secondary">
                <h5 class="offcanvas-title fw-bold text-white" id="mobileSidebarLabel"><i class="fa-solid fa-bolt text-warning me-2"></i> Tindablog Admin</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body sidebar" style="position: relative; width: 100%; min-height: auto; box-shadow: none;">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-pie"></i> Dashboard
                </a>
                <a href="{{ route('admin.blogs.index') }}" class="nav-link {{ request()->routeIs('admin.blogs.index') ? 'active' : '' }}">
                    <i class="fa-solid fa-layer-group"></i> All Blogs
                </a>
                <a href="{{ route('admin.blogs.create') }}" class="nav-link {{ request()->routeIs('admin.blogs.create') ? 'active' : '' }}">
                    <i class="fa-solid fa-pen-nib"></i> Manage Blogs
                </a>
                <a href="{{ route('admin.categories') }}" class="nav-link {{ request()->routeIs('admin.categories') ? 'active' : '' }}">
                    <i class="fa-solid fa-tags"></i> Categories
                </a>
                <a href="{{ route('admin.users') }}" class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                    <i class="fa-solid fa-users"></i> Users
                </a>
                <a href="{{ route('admin.subscribers') }}" class="nav-link {{ request()->routeIs('admin.subscribers') ? 'active' : '' }}">
                    <i class="fa-solid fa-envelope"></i> Subscribers
                </a>
                <a href="{{ route('admin.settings.header') }}" class="nav-link {{ request()->routeIs('admin.settings.header') ? 'active' : '' }}">
                    <i class="fa-solid fa-heading"></i> Header Settings
                </a>

                <div class="mt-4 mb-2 ps-3 text-uppercase" style="font-size: 0.75rem; color: #6b7280; font-weight: 700; letter-spacing: 1px;">Content</div>
                
                <a href="{{ route('admin.pages.index') }}" class="nav-link {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-file-lines"></i> Pages
                </a>
                
                <a href="{{ route('admin.contacts.index') }}" class="nav-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }} d-flex justify-content-between align-items-center">
                    <div><i class="fa-solid fa-envelope-open-text"></i> Messages</div>
                    <span class="badge bg-danger rounded-pill px-2 py-1 unread-badge" style="display: {{ (isset($unreadMessages) && $unreadMessages > 0) ? 'inline-block' : 'none' }};"><i class="fa-solid fa-bell fa-shake me-1"></i> <span class="unread-count">{{ $unreadMessages ?? 0 }}</span></span>
                </a>

                <div class="mt-4 mb-2 ps-3 text-uppercase" style="font-size: 0.75rem; color: #6b7280; font-weight: 700; letter-spacing: 1px;">Configuration</div>
                
                <a href="{{ route('admin.settings.cta') }}" class="nav-link {{ request()->routeIs('admin.settings.cta') ? 'active' : '' }}">
                    <i class="fa-solid fa-bullhorn"></i> CTA Settings
                </a>
                <a href="{{ route('admin.settings.hero') }}" class="nav-link {{ request()->routeIs('admin.settings.hero') ? 'active' : '' }}">
                    <i class="fa-solid fa-image"></i> Hero Settings
                </a>
                <a href="{{ route('admin.settings.footer') }}" class="nav-link {{ request()->routeIs('admin.settings.footer') ? 'active' : '' }}">
                    <i class="fa-solid fa-link"></i> Footer Settings
                </a>
                <a href="{{ url('/') }}" class="nav-link text-warning mt-5" target="_blank">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i> View Live Site
                </a>
                
                <div class="mt-4 pt-3 border-top border-secondary border-opacity-50">
                    <a href="{{ route('admin.profile') }}" class="btn btn-outline-light w-100 fw-bold d-flex align-items-center justify-content-center mb-2" style="border-radius: 10px; transition: all 0.3s ease;">
                        <i class="fa-solid fa-user-circle me-2"></i> My Profile
                    </a>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100 fw-bold d-flex align-items-center justify-content-center" style="border-radius: 10px; transition: all 0.3s ease;">
                            <i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            @yield('content')
        </div>
    </div>
    
    <!-- FIX: Added Bootstrap JS bundle for collapse/dropdowns -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Real-time Notification Sound Logic
        document.addEventListener('DOMContentLoaded', function() {
            let currentUnread = {{ $unreadMessages ?? 0 }};
            let lastNotifiedUnread = localStorage.getItem('notified_unread_count') || currentUnread;
            
            const playSound = function() {
                const context = new (window.AudioContext || window.webkitAudioContext)();
                const osc = context.createOscillator();
                const gain = context.createGain();
                
                osc.connect(gain);
                gain.connect(context.destination);
                
                osc.type = 'sine';
                osc.frequency.setValueAtTime(880, context.currentTime); 
                osc.frequency.exponentialRampToValueAtTime(1760, context.currentTime + 0.1); 
                
                gain.gain.setValueAtTime(0, context.currentTime);
                gain.gain.linearRampToValueAtTime(0.2, context.currentTime + 0.05);
                gain.gain.exponentialRampToValueAtTime(0.01, context.currentTime + 0.5);
                
                osc.start(context.currentTime);
                osc.stop(context.currentTime + 0.5);
            };

            const updateBadges = function(count) {
                const badges = document.querySelectorAll('.unread-badge');
                const counts = document.querySelectorAll('.unread-count');
                if (count > 0) {
                    badges.forEach(b => b.style.display = 'inline-block');
                    counts.forEach(c => c.textContent = count);
                } else {
                    badges.forEach(b => b.style.display = 'none');
                }
            };

            // Initial Check (in case they have unread messages right on load)
            if (currentUnread > 0 && currentUnread > lastNotifiedUnread) {
                try { 
                    playSound(); 
                    localStorage.setItem('notified_unread_count', currentUnread);
                } catch(e) {
                    document.body.addEventListener('click', function playOnInteract() {
                        try { playSound(); } catch(err){}
                        localStorage.setItem('notified_unread_count', currentUnread);
                        document.body.removeEventListener('click', playOnInteract);
                    }, { once: true });
                }
            }

            // AJAX Polling every 5 seconds
            setInterval(function() {
                fetch('{{ route('admin.contacts.unread') }}')
                    .then(response => response.json())
                    .then(data => {
                        const newCount = parseInt(data.count);
                        updateBadges(newCount);
                        
                        if (newCount > currentUnread) {
                            try { playSound(); } catch(e){}
                            localStorage.setItem('notified_unread_count', newCount);
                        }
                        
                        currentUnread = newCount;
                        if(newCount === 0) {
                            localStorage.setItem('notified_unread_count', 0);
                        }
                    })
                    .catch(err => console.error("Error checking notifications:", err));
            }, 5000);
        });
    </script>
    @yield('scripts')
</body>
</html>