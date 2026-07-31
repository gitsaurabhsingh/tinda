<?php
$content = file_get_contents('resources/views/layouts/app.blade.php');

// 1. Inject Dark Mode CSS
if (strpos($content, '/* Dark Mode Overrides */') === false) {
    $css = <<<'EOT'
        /* Dark Mode Overrides */
        [data-bs-theme="dark"] body {
            background: #0f172a;
            color: #e2e8f0;
        }
        [data-bs-theme="dark"] .navbar {
            background: rgba(15, 23, 42, 0.85);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.3);
        }
        [data-bs-theme="dark"] .navbar.scrolled {
            background: rgba(15, 23, 42, 0.95);
        }
        [data-bs-theme="dark"] .card, [data-bs-theme="dark"] .blog-card, [data-bs-theme="dark"] .bg-white {
            background-color: #1e293b !important;
            border-color: rgba(255,255,255,0.05) !important;
        }
        [data-bs-theme="dark"] .card-body {
            background-color: transparent !important;
        }
        [data-bs-theme="dark"] .text-dark, [data-bs-theme="dark"] .nav-link, [data-bs-theme="dark"] h1, [data-bs-theme="dark"] h2, [data-bs-theme="dark"] h3, [data-bs-theme="dark"] h4, [data-bs-theme="dark"] h5, [data-bs-theme="dark"] h6 {
            color: #e2e8f0 !important;
        }
        [data-bs-theme="dark"] .text-muted, [data-bs-theme="dark"] .text-secondary {
            color: #94a3b8 !important;
        }
        [data-bs-theme="dark"] .btn-outline-dark {
            border-color: #475569;
            color: #e2e8f0;
        }
        [data-bs-theme="dark"] .btn-outline-dark:hover {
            background: #475569;
            color: #fff;
        }
        [data-bs-theme="dark"] .form-control {
            background-color: #334155;
            border-color: #475569;
            color: #e2e8f0;
        }
        [data-bs-theme="dark"] .form-control:focus {
            background-color: #475569;
            color: #fff;
            border-color: var(--primary);
        }
        [data-bs-theme="dark"] .dropdown-menu, [data-bs-theme="dark"] .offcanvas {
            background-color: #1e293b !important;
            border-color: #334155 !important;
        }
        [data-bs-theme="dark"] .dropdown-item {
            color: #e2e8f0;
        }
        [data-bs-theme="dark"] .dropdown-item:hover {
            background-color: #334155;
            color: #fff;
        }
        [data-bs-theme="dark"] .theme-toggle-btn {
            background: #334155;
            color: #f59e0b;
        }
EOT;
    $content = str_replace('</style>', $css . "\n    </style>", $content);
}

// 2. Inject Javascript for Theme Toggle
if (strpos($content, 'const themeToggle = document.getElementById(\'themeToggle\');') === false) {
    $js = <<<'EOT'
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggle = document.getElementById('themeToggle');
            const themeToggleMobile = document.getElementById('themeToggleMobile');
            
            function setupToggle(toggleBtn) {
                if(!toggleBtn) return;
                const darkIcon = toggleBtn.querySelector('.dark-icon');
                const lightIcon = toggleBtn.querySelector('.light-icon');
                
                function updateIcon(theme) {
                    if(!darkIcon || !lightIcon) return;
                    if (theme === 'dark') {
                        darkIcon.classList.add('d-none');
                        lightIcon.classList.remove('d-none');
                    } else {
                        lightIcon.classList.add('d-none');
                        darkIcon.classList.remove('d-none');
                    }
                }
                
                // Init
                const currentTheme = document.documentElement.getAttribute('data-bs-theme');
                updateIcon(currentTheme);
                
                toggleBtn.addEventListener('click', () => {
                    const currentTheme = document.documentElement.getAttribute('data-bs-theme');
                    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                    
                    document.documentElement.setAttribute('data-bs-theme', newTheme);
                    localStorage.setItem('theme', newTheme);
                    updateIcon(newTheme);
                    
                    // Synchronize the other button if it exists
                    if(toggleBtn.id === 'themeToggle' && themeToggleMobile) {
                        const mDark = themeToggleMobile.querySelector('.dark-icon');
                        const mLight = themeToggleMobile.querySelector('.light-icon');
                        if (newTheme === 'dark') {
                            if(mDark) mDark.classList.add('d-none');
                            if(mLight) mLight.classList.remove('d-none');
                        } else {
                            if(mLight) mLight.classList.add('d-none');
                            if(mDark) mDark.classList.remove('d-none');
                        }
                    }
                });
            }
            
            setupToggle(themeToggle);
            setupToggle(themeToggleMobile);
        });
    </script>
EOT;
    $content = str_replace('</body>', $js . "\n</body>", $content);
}

// Ensure theme button styling in head
if(strpos($content, '.theme-toggle-btn') === false) {
    $btnStyle = <<<'EOT'
        .theme-toggle-btn {
            background: #f1f5f9;
            border: none;
            border-radius: 50%;
            width: 45px; height: 45px;
            display: flex; align-items: center; justify-content: center;
            color: #475569;
            transition: all 0.3s ease;
        }
        .theme-toggle-btn:hover { background: #e2e8f0; transform: scale(1.1); }
EOT;
    $content = str_replace('</style>', $btnStyle . "\n    </style>", $content);
}

file_put_contents('resources/views/layouts/app.blade.php', $content);
echo "Dark Mode implemented successfully.";
