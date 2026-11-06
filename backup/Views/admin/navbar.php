<?php $current_page = basename($_SERVER['PHP_SELF']); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Admin'); ?> - SIA Syiar Gemilang</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        display: ['Plus Jakarta Sans', 'Inter', 'sans-serif']
                    },
                    colors: {
                        brand: {
                            DEFAULT: '#0066CC',
                            dark: '#0052A3',
                            deep: '#073B66',
                            active: '#003E7E',
                            light: '#E8F3FC',
                            border: '#B9DCF7'
                        }
                    }
                }
            }
        };
    </script>
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts: Inter + Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sg-display { font-family: 'Plus Jakarta Sans', 'Inter', sans-serif; }
        .sg-card { background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 12px; box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04); }
        .sg-banner { background: linear-gradient(100deg, rgba(0, 102, 204, 0.05) 0%, #FFFFFF 70%); border: 1px solid rgba(0, 102, 204, 0.15); border-radius: 12px; }
        .text-2xs { font-size: 0.70rem; line-height: 0.95rem; }
        .text-3xs { font-size: 0.625rem; line-height: 0.85rem; }

        /* Sidebar Collapsible Styles (Desktop) */
        @media (min-width: 1024px) {
            #appSidebar {
                transition: width 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            }
            #appSidebar.is-collapsed {
                width: 5rem !important; /* 80px */
            }
            #appSidebar.is-collapsed .sidebar-label {
                display: none !important;
            }
            #appSidebar.is-collapsed .sidebar-nav-link {
                justify-content: center !important;
                padding-left: 0.5rem !important;
                padding-right: 0.5rem !important;
            }
            #appSidebar.is-collapsed .sidebar-header {
                justify-content: center !important;
                padding-left: 0.5rem !important;
                padding-right: 0.5rem !important;
            }
            #appSidebar.is-collapsed .sidebar-header-brand {
                display: none !important;
            }
            #appSidebar.is-collapsed .sidebar-profile-box {
                flex-direction: column !important;
                gap: 0.6rem !important;
                align-items: center !important;
                justify-content: center !important;
                padding: 0.75rem 0.25rem !important;
            }
            #appSidebar.is-collapsed .sidebar-profile-info {
                display: none !important;
            }
        }

        /* Mobile Drawer State */
        @media (max-width: 1023px) {
            #appSidebar {
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            #appSidebar.mobile-open {
                transform: translateX(0) !important;
            }
        }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-800 flex h-screen overflow-hidden antialiased">

    <!-- Mobile Drawer Backdrop -->
    <div id="mobileSidebarBackdrop" onclick="toggleMobileSidebar()" class="hidden fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-xs lg:hidden transition-opacity"></div>

    <!-- Sidebar Navigation -->
    <aside id="appSidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-[#073B66] text-slate-200 flex flex-col shrink-0 shadow-2xl select-none -translate-x-full lg:translate-x-0 lg:static transition-all duration-300">
        
        <!-- Sidebar Brand & Toggle Header -->
        <div class="sidebar-header h-16 px-4 flex items-center justify-between border-b border-white/10 shrink-0">
            <div class="sidebar-header-brand flex items-center gap-3 overflow-hidden">
                <div class="w-9 h-9 rounded-xl bg-[#0066CC] text-white flex items-center justify-center text-lg shrink-0 shadow-md shadow-[#0066CC]/30">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <div class="leading-tight truncate">
                    <span class="font-extrabold text-white text-base tracking-tight block sg-display">Syiar Gemilang</span>
                    <span class="text-3xs text-sky-200/80 block">Rumah Gemilang Indonesia</span>
                </div>
            </div>

            <div class="flex items-center gap-1">
                <!-- Mobile Close Button (Shown only on Mobile) -->
                <button type="button" onclick="toggleMobileSidebar()" class="lg:hidden w-8 h-8 rounded-lg bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition cursor-pointer" aria-label="Tutup Menu">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>

                <!-- Desktop Collapse Button -->
                <button type="button" id="sidebarToggleBtn" onclick="toggleSidebar()" 
                        title="Perkecil / Perbesar Menu Sidebar"
                        class="hidden lg:flex w-8 h-8 rounded-lg bg-white/10 hover:bg-[#0066CC] text-white items-center justify-center transition shrink-0 cursor-pointer">
                    <i id="sidebarToggleIcon" class="fa-solid fa-chevron-left text-xs transition-transform duration-300"></i>
                </button>
            </div>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 p-3 space-y-1.5 text-sm font-medium overflow-y-auto">
            <a href="<?= base_url('/'); ?>" title="Dashboard"
               class="sidebar-nav-link nav-link <?= (url_is('') || url_is('/')) ? 'bg-[#0066CC] text-white shadow-md shadow-[#0066CC]/30 font-semibold' : 'text-slate-300 hover:bg-white/10 hover:text-white' ?> flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition duration-150">
                <i class="fa-solid fa-house w-5 text-center text-base shrink-0"></i>
                <span class="sidebar-label truncate">Dashboard</span>
            </a>

            <a href="<?= base_url('admin/data'); ?>" title="Data Santri"
               class="sidebar-nav-link nav-link <?= (url_is('admin/data*') || url_is('/admin/data*')) ? 'bg-[#0066CC] text-white shadow-md shadow-[#0066CC]/30 font-semibold' : 'text-slate-300 hover:bg-white/10 hover:text-white' ?> flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition duration-150">
                <i class="fa-solid fa-user-graduate w-5 text-center text-base shrink-0"></i>
                <span class="sidebar-label truncate">Data Santri</span>
            </a>

            <a href="<?= base_url('admin/add'); ?>" title="Input Data Santri"
               class="sidebar-nav-link nav-link <?= (url_is('admin/add*') || url_is('/admin/add*')) ? 'bg-[#0066CC] text-white shadow-md shadow-[#0066CC]/30 font-semibold' : 'text-slate-300 hover:bg-white/10 hover:text-white' ?> flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition duration-150">
                <i class="fa-solid fa-pen-to-square w-5 text-center text-base shrink-0"></i>
                <span class="sidebar-label truncate">Input Data Santri</span>
            </a>

            <a href="<?= base_url('admin/pemeringkatan'); ?>" title="Pemeringkatan Santri"
               class="sidebar-nav-link nav-link <?= (url_is('admin/pemeringkatan*') || url_is('/admin/pemeringkatan*')) ? 'bg-[#0066CC] text-white shadow-md shadow-[#0066CC]/30 font-semibold' : 'text-slate-300 hover:bg-white/10 hover:text-white' ?> flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition duration-150">
                <i class="fa-solid fa-trophy w-5 text-center text-base shrink-0"></i>
                <span class="sidebar-label truncate">Pemeringkatan Santri</span>
            </a>

            <a href="<?= base_url('admin/kehadiran'); ?>" title="Sesi Kehadiran"
               class="sidebar-nav-link nav-link <?= (url_is('admin/kehadiran*') || url_is('/admin/kehadiran*')) ? 'bg-[#0066CC] text-white shadow-md shadow-[#0066CC]/30 font-semibold' : 'text-slate-300 hover:bg-white/10 hover:text-white' ?> flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition duration-150">
                <i class="fa-solid fa-clipboard-user w-5 text-center text-base shrink-0"></i>
                <span class="sidebar-label truncate">Sesi Kehadiran</span>
            </a>
        </nav>

        <!-- User Profile & Logout -->
        <div class="p-3 border-t border-white/10 bg-black/20 shrink-0">
            <div class="sidebar-profile-box flex items-center justify-between gap-2.5">
                <div class="flex items-center gap-3 overflow-hidden">
                    <div class="w-9 h-9 rounded-xl bg-[#0066CC] text-white flex items-center justify-center shrink-0 font-bold text-sm shadow-sm" title="<?= esc(session()->get('nama') ?? 'Administrator'); ?>">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>
                    <div class="sidebar-profile-info overflow-hidden leading-tight">
                        <h4 class="text-xs font-bold text-white truncate"><?= esc(session()->get('nama') ?? 'Administrator'); ?></h4>
                        <div class="mt-0.5">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-3xs font-extrabold bg-sky-400/20 text-sky-200 border border-sky-400/30 uppercase tracking-wider">
                                <?= esc(session()->get('role') ?? 'ADMIN'); ?>
                            </span>
                        </div>
                    </div>
                </div>
                <button type="button" onclick="openLogoutModal()" title="Keluar / Logout" 
                   class="w-8 h-8 rounded-lg bg-white/10 hover:bg-rose-600 hover:text-white text-slate-300 flex items-center justify-center transition shrink-0 cursor-pointer">
                    <i class="fa-solid fa-arrow-right-from-bracket text-xs"></i>
                </button>
            </div>
        </div>
    </aside>

    <!-- ===================== MODAL KONFIRMASI LOGOUT ===================== -->
    <div id="logoutConfirmationModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
        <!-- Backdrop Blur -->
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" onclick="closeLogoutModal()"></div>

        <!-- Modal Card Content -->
        <div class="relative bg-white w-full max-w-sm sm:max-w-md rounded-2xl sm:rounded-3xl shadow-2xl border border-slate-100 overflow-hidden transform transition-all z-10 animate-in fade-in zoom-in-95 duration-150">
            <!-- Top decorative gradient line -->
            <div class="h-2 bg-gradient-to-r from-rose-500 via-[#0066CC] to-[#073B66]"></div>

            <div class="p-6 sm:p-7 text-center">
                <!-- Icon Badge -->
                <div class="w-14 h-14 mx-auto mb-3.5 rounded-2xl bg-rose-50 border border-rose-100 text-rose-600 flex items-center justify-center text-xl shadow-xs">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                </div>

                <!-- Title & Description -->
                <h3 class="text-base sm:text-lg font-bold text-slate-800 sg-display mb-1.5">
                    Konfirmasi Keluar Sistem
                </h3>
                <p class="text-xs sm:text-sm text-slate-500 leading-relaxed max-w-xs mx-auto">
                    Apakah Anda yakin ingin keluar dari sistem <strong class="text-slate-700">Syiar Gemilang</strong>? Anda harus masuk kembali untuk mengakses portal admin.
                </p>

                <!-- User Info Pill -->
                <div class="mt-4 p-2.5 bg-slate-50 rounded-xl border border-slate-200 inline-flex items-center gap-2 text-xs text-slate-600 max-w-full truncate">
                    <span class="w-6 h-6 rounded-full bg-[#0066CC] text-white flex items-center justify-center text-3xs font-bold shrink-0">
                        <i class="fa-solid fa-user-shield"></i>
                    </span>
                    <span class="font-semibold text-slate-800 truncate"><?= esc(session()->get('nama') ?? 'Administrator'); ?></span>
                    <span class="text-3xs text-slate-400">•</span>
                    <span class="text-3xs font-bold text-sky-700 bg-sky-100/70 px-2 py-0.5 rounded-md uppercase tracking-wider"><?= esc(session()->get('role') ?? 'ADMIN'); ?></span>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 flex items-center justify-center gap-2.5">
                    <button type="button" onclick="closeLogoutModal()" 
                            class="flex-1 py-2.5 px-4 rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-100 font-semibold text-xs sm:text-sm transition cursor-pointer">
                        Batal
                    </button>
                    <a href="<?= base_url('logout'); ?>" 
                       class="flex-1 py-2.5 px-4 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs sm:text-sm shadow-md shadow-rose-600/25 transition flex items-center justify-center gap-2 cursor-pointer">
                        <i class="fa-solid fa-arrow-right-from-bracket text-xs"></i>
                        <span>Ya, Keluar</span>
                    </a>
                </div>
            </div>

            <!-- Close 'X' Button in Corner -->
            <button type="button" onclick="closeLogoutModal()" class="absolute top-3.5 right-3.5 text-slate-400 hover:text-slate-600 p-1.5 rounded-lg hover:bg-slate-100 transition cursor-pointer" aria-label="Tutup">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>
    </div>

    <!-- Sidebar State Persistence & Responsive Drawer Script -->
    <script>
        (function() {
            const savedState = localStorage.getItem('sidebar_collapsed');
            const sidebar = document.getElementById('appSidebar');
            const icon = document.getElementById('sidebarToggleIcon');
            if (savedState === 'true' && sidebar && window.innerWidth >= 1024) {
                sidebar.classList.add('is-collapsed');
                if (icon) {
                    icon.className = 'fa-solid fa-chevron-right text-xs transition-transform duration-300';
                }
            }
        })();

        function toggleSidebar() {
            const sidebar = document.getElementById('appSidebar');
            const icon = document.getElementById('sidebarToggleIcon');
            const isCollapsed = sidebar.classList.toggle('is-collapsed');
            localStorage.setItem('sidebar_collapsed', isCollapsed ? 'true' : 'false');
            if (icon) {
                icon.className = isCollapsed 
                    ? 'fa-solid fa-chevron-right text-xs transition-transform duration-300' 
                    : 'fa-solid fa-chevron-left text-xs transition-transform duration-300';
            }
        }

        function toggleMobileSidebar() {
            const sidebar = document.getElementById('appSidebar');
            const backdrop = document.getElementById('mobileSidebarBackdrop');
            if (!sidebar || !backdrop) return;
            const isOpen = sidebar.classList.toggle('mobile-open');
            if (isOpen) {
                backdrop.classList.remove('hidden');
                document.body.classList.add('overflow-hidden', 'lg:overflow-auto');
            } else {
                backdrop.classList.add('hidden');
                document.body.classList.remove('overflow-hidden', 'lg:overflow-auto');
            }
        }

        function openLogoutModal() {
            const modal = document.getElementById('logoutConfirmationModal');
            if (modal) {
                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }
        }

        function closeLogoutModal() {
            const modal = document.getElementById('logoutConfirmationModal');
            if (modal) {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeLogoutModal();
            }
        });
    </script>
