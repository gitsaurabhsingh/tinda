<?php
$content = file_get_contents('resources/views/layouts/app.blade.php');

// 1. Add theme init script in head
$headScript = <<<'EOT'
    <!-- Theme Initialization Script -->
    <script>
        const storedTheme = localStorage.getItem('theme');
        const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        const defaultTheme = storedTheme ? storedTheme : (prefersDark ? 'dark' : 'light');
        document.documentElement.setAttribute('data-bs-theme', defaultTheme);
    </script>
EOT;
$content = str_replace('<!-- Favicon -->', $headScript . "\n    <!-- Favicon -->", $content);

// 2. Add Dark Mode styling overrides for custom CSS
$darkCSS = <<<'EOT'
        /* Dark Mode Overrides */
        [data-bs-theme="dark"] body {
            background-color: #0b1120;
            color: #f1f5f9;
        }
        [data-bs-theme="dark"] .navbar {
            background: rgba(15, 23, 42, 0.8) !important;
            border-bottom-color: rgba(255, 255, 255, 0.1) !important;
        }
        [data-bs-theme="dark"] .card, [data-bs-theme="dark"] .dash-sidebar, [data-bs-theme="dark"] .dash-table-card, [data-bs-theme="dark"] .settings-card, [data-bs-theme="dark"] .bg-white {
            background-color: #1e293b !important;
            border: 1px solid rgba(255,255,255,0.05) !important;
            box-shadow: 0 10px 25px rgba(0,0,0,0.5) !important;
            color: #f1f5f9 !important;
        }
        [data-bs-theme="dark"] .text-dark { color: #f8fafc !important; }
        [data-bs-theme="dark"] .text-muted { color: #94a3b8 !important; }
        [data-bs-theme="dark"] .form-control { background-color: #0f172a; border-color: rgba(255,255,255,0.1); color: white; }
        [data-bs-theme="dark"] .form-control:focus { background-color: #0f172a; border-color: var(--secondary); color: white; }
        [data-bs-theme="dark"] .btn-light { background: #334155; border-color: #475569; color: white; }
        [data-bs-theme="dark"] .table-light { background: #334155; color: white; }
        [data-bs-theme="dark"] .table-custom thead th { background: #0f172a; border-bottom: 1px solid #334155; color: #94a3b8; }
        [data-bs-theme="dark"] .table-custom tbody td { border-bottom: 1px solid #334155; color: #f1f5f9; }
        [data-bs-theme="dark"] .table-custom tbody tr:hover { background: #1e293b; }
        [data-bs-theme="dark"] .nav-tabs .nav-link { color: #94a3b8; }
        [data-bs-theme="dark"] .nav-tabs .nav-link.active { color: white; border-bottom-color: var(--secondary); }
        [data-bs-theme="dark"] .news-card-small { border-bottom-color: rgba(255,255,255,0.1); }
        [data-bs-theme="dark"] .news-title-small { color: white; }
        [data-bs-theme="dark"] .dash-nav-link:hover, [data-bs-theme="dark"] .dash-nav-link.active { background: rgba(255,255,255,0.05); color: var(--secondary); border-left-color: var(--secondary); }
        
        /* Theme Toggle Button */
        .theme-toggle-btn {
            background: transparent; border: none; color: inherit;
            width: 40px; height: 40px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem; transition: all 0.3s ease;
        }
        .theme-toggle-btn:hover { background: rgba(0,0,0,0.05); }
        [data-bs-theme="dark"] .theme-toggle-btn { color: #fbbf24; }
        [data-bs-theme="dark"] .theme-toggle-btn:hover { background: rgba(255,255,255,0.1); }
EOT;
$content = str_replace('</style>', $darkCSS . "\n</style>", $content);

// 3. Add Theme Toggle Button to Navbar
$toggleBtn = <<<'EOT'
                    <!-- Theme Toggle -->
                    <button class="theme-toggle-btn me-2" id="themeToggle" title="Toggle Dark Mode">
                        <i class="fa-solid fa-moon dark-icon"></i>
                        <i class="fa-solid fa-sun light-icon d-none"></i>
                    </button>
                    <!-- Global Search -->
EOT;
$content = str_replace('<!-- Global Search -->', $toggleBtn, $content);

// 4. Add JS for Theme Toggle at bottom
$themeJS = <<<'EOT'
    <!-- Theme Toggle Logic -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const themeToggleBtn = document.getElementById('themeToggle');
            if(!themeToggleBtn) return;
            const darkIcon = themeToggleBtn.querySelector('.dark-icon');
            const lightIcon = themeToggleBtn.querySelector('.light-icon');
            
            function updateIcons(theme) {
                if (theme === 'dark') {
                    darkIcon.classList.add('d-none');
                    lightIcon.classList.remove('d-none');
                } else {
                    lightIcon.classList.add('d-none');
                    darkIcon.classList.remove('d-none');
                }
            }
            
            const currentTheme = document.documentElement.getAttribute('data-bs-theme') || 'light';
            updateIcons(currentTheme);
            
            themeToggleBtn.addEventListener('click', () => {
                let theme = document.documentElement.getAttribute('data-bs-theme') || 'light';
                let newTheme = theme === 'dark' ? 'light' : 'dark';
                
                document.documentElement.setAttribute('data-bs-theme', newTheme);
                localStorage.setItem('theme', newTheme);
                updateIcons(newTheme);
            });
        });
    </script>
</body>
EOT;
$content = str_replace('</body>', $themeJS, $content);

file_put_contents('resources/views/layouts/app.blade.php', $content);
echo "Dark mode implemented.\n";
