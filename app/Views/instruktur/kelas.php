<?php require_once 'navbar.php'; ?>

<style>
    /* Smooth scrolling */
    html {
        scroll-behavior: smooth;
    }
    
    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }
    ::-webkit-scrollbar-track {
        background: #f1f5f9;
    }
    ::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 9999px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    /* Card Hover Effect */
    .student-card {
        transition: all 0.22s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .student-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 24px -6px rgba(0, 102, 204, 0.12);
    }

    /* Modal Animation */
    .modal-backdrop {
        transition: opacity 0.2s ease-out;
    }
    .modal-box {
        transition: transform 0.2s ease-out, opacity 0.2s ease-out;
    }

    /* Hide scrollbar for category pills on mobile */
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<div class="flex-1 min-w-0 flex flex-col overflow-hidden bg-[#F8FAFC]">
        
    <!-- Top Header Bar -->
    <?php 
    $page_title = $title ?? 'Data & Capaian Kelas';
    ob_start();
    ?>
    <div class="flex items-center gap-2">
        <a href="<?= base_url('instruktur/download-nilai-csv'); ?>" class="inline-flex px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold shadow-xs transition items-center gap-1.5">
            <i class="fa-solid fa-file-csv"></i> <span class="hidden sm:inline">Export CSV</span>
        </a>
        <a href="<?= base_url('instruktur/nilai'); ?>" class="inline-flex px-3 py-1.5 bg-[#0066CC] hover:bg-[#0052A3] text-white rounded-xl text-xs font-semibold shadow-xs transition items-center gap-1.5">
            <i class="fa-solid fa-pen-to-square"></i> <span class="hidden sm:inline">Input / Update Nilai</span><span class="sm:hidden">Nilai</span>
        </a>
    </div>
    <?php
    $topbar_extra_right = ob_get_clean();
    require_once __DIR__ . '/components/topbar.php'; 
    ?>

    <!-- Main Scrollable Area -->
    <main class="flex-1 overflow-y-auto pb-16">

        <!-- ================= HERO HEADER ================= -->
        <?php
        ob_start();
        ?>
        <div class="flex items-center gap-2">
            <a href="<?= base_url('instruktur/download-nilai-csv'); ?>" class="px-3.5 py-2 bg-white text-emerald-800 hover:bg-emerald-50 rounded-xl font-bold text-xs shadow-md transition flex items-center gap-1.5 shrink-0">
                <i class="fa-solid fa-file-csv text-emerald-600"></i> Rekap Nilai (CSV)
            </a>
            <a href="<?= base_url('instruktur/nilai'); ?>" class="px-3.5 py-2 bg-sky-500/20 hover:bg-sky-500/30 text-white border border-white/20 rounded-xl font-bold text-xs transition flex items-center gap-1.5 shrink-0">
                <i class="fa-solid fa-pen-to-square"></i> Kelola Nilai
            </a>
        </div>
        <?php
        $hero_actions = ob_get_clean();

        $hero = [
            'breadcrumb' => [
                ['label' => 'Portal Instruktur', 'url' => base_url('instruktur')],
                ['label' => 'Direktori & Capaian Kelas']
            ],
            'badge' => 'Lembaga Pendidikan E-RGI Syiar Gemilang',
            'title' => 'Direktori & Capaian Nilai Kelas',
            'subtitle' => 'Pemantauan komprehensif performa 4 mata pelajaran akademik, evaluasi adab & akhlaq (bobot 20%), serta rekapitulasi presensi santri pada 6 kejuruan.',
            'extra_action' => $hero_actions,
            'stats' => [
                ['icon' => 'fa-solid fa-users', 'bg' => 'bg-sky-400/20 text-sky-200', 'value' => $total_siswa, 'label' => 'Santri Terdaftar'],
                ['icon' => 'fa-solid fa-layer-group', 'bg' => 'bg-emerald-400/20 text-emerald-200', 'value' => '6 Jurusan', 'label' => 'Kelas Kejuruan'],
                ['icon' => 'fa-solid fa-chart-line', 'bg' => 'bg-amber-400/20 text-amber-200', 'value' => $rata_rata, 'label' => 'Rata-rata Nilai'],
                ['icon' => 'fa-solid fa-clipboard-check', 'bg' => 'bg-teal-400/20 text-teal-200', 'value' => $rata_kehadiran . '%', 'label' => 'Rata-rata Hadir'],
            ]
        ];
        require_once __DIR__ . '/components/hero_header.php';
        ?>

        <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 mt-6 space-y-6">

            <!-- ================= RINGKASAN CAPAIAN 4 MAPEL & KARAKTER (KOMPAK & BERSIH) ================= -->
            <div class="bg-white rounded-2xl border border-slate-200 p-4 sm:p-5 shadow-xs">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-4 pb-3 border-b border-slate-100">
                    <div>
                        <h2 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                            <span class="w-2 h-4 rounded-full bg-[#0066CC]"></span>
                            Standar Capaian 4 Mapel Pokok & Karakter
                        </h2>
                        <p class="text-xs text-slate-500 mt-0.5">
                            Formula Nilai Akhir: <span class="font-semibold text-slate-700">(Rata-rata 4 Mapel × 80%) + (Adab & Akhlaq × 20%)</span> • Standar KKM: 75 (Adab: 80)
                        </p>
                    </div>
                    <span class="text-3xs font-semibold px-2.5 py-1 bg-slate-100 text-slate-600 rounded-lg self-start sm:self-auto">
                        Evaluasi Terpadu Diklat
                    </span>
                </div>

                <!-- Grid 5 Pilar Akademik & Karakter -->
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
                    
                    <!-- Tauhid -->
                    <?php $t = $mapel_stats['tauhid']; ?>
                    <div class="p-3 rounded-xl border border-emerald-100 bg-emerald-50/40 flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-3xs font-bold uppercase tracking-wider text-emerald-700 flex items-center gap-1">
                                <i class="fa-solid fa-book-quran"></i> Tauhid
                            </span>
                            <span class="text-3xs font-bold px-1.5 py-0.5 bg-white text-emerald-700 rounded border border-emerald-200">
                                KKM 75
                            </span>
                        </div>
                        <div class="my-1">
                            <div class="text-xl font-extrabold text-emerald-800"><?= esc($t['rata_rata']); ?></div>
                            <div class="text-3xs text-emerald-700/80 truncate font-medium">Ust. Kamal Malawi</div>
                        </div>
                        <div class="pt-2 border-t border-emerald-100 flex items-center justify-between text-3xs text-slate-500">
                            <span>Lulus: <strong class="text-emerald-700"><?= esc($t['kelulusan']); ?>%</strong></span>
                            <span>Maks: <?= esc($t['tertinggi']); ?></span>
                        </div>
                    </div>

                    <!-- Fiqih -->
                    <?php $f = $mapel_stats['fiqih']; ?>
                    <div class="p-3 rounded-xl border border-blue-100 bg-blue-50/40 flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-3xs font-bold uppercase tracking-wider text-blue-700 flex items-center gap-1">
                                <i class="fa-solid fa-hands-praying"></i> Fiqih
                            </span>
                            <span class="text-3xs font-bold px-1.5 py-0.5 bg-white text-blue-700 rounded border border-blue-200">
                                KKM 75
                            </span>
                        </div>
                        <div class="my-1">
                            <div class="text-xl font-extrabold text-blue-800"><?= esc($f['rata_rata']); ?></div>
                            <div class="text-3xs text-blue-700/80 truncate font-medium">Usth. Yanni Susanti</div>
                        </div>
                        <div class="pt-2 border-t border-blue-100 flex items-center justify-between text-3xs text-slate-500">
                            <span>Lulus: <strong class="text-blue-700"><?= esc($f['kelulusan']); ?>%</strong></span>
                            <span>Maks: <?= esc($f['tertinggi']); ?></span>
                        </div>
                    </div>

                    <!-- Bahasa Inggris -->
                    <?php $b = $mapel_stats['b_ing']; ?>
                    <div class="p-3 rounded-xl border border-indigo-100 bg-indigo-50/40 flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-3xs font-bold uppercase tracking-wider text-indigo-700 flex items-center gap-1">
                                <i class="fa-solid fa-language"></i> B. Inggris
                            </span>
                            <span class="text-3xs font-bold px-1.5 py-0.5 bg-white text-indigo-700 rounded border border-indigo-200">
                                KKM 75
                            </span>
                        </div>
                        <div class="my-1">
                            <div class="text-xl font-extrabold text-indigo-800"><?= esc($b['rata_rata']); ?></div>
                            <div class="text-3xs text-indigo-700/80 truncate font-medium">Ms. Nadia</div>
                        </div>
                        <div class="pt-2 border-t border-indigo-100 flex items-center justify-between text-3xs text-slate-500">
                            <span>Lulus: <strong class="text-indigo-700"><?= esc($b['kelulusan']); ?>%</strong></span>
                            <span>Maks: <?= esc($b['tertinggi']); ?></span>
                        </div>
                    </div>

                    <!-- Menulis Kreatif -->
                    <?php $m = $mapel_stats['menulis_kreatif']; ?>
                    <div class="p-3 rounded-xl border border-amber-100 bg-amber-50/40 flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-3xs font-bold uppercase tracking-wider text-amber-700 flex items-center gap-1">
                                <i class="fa-solid fa-pen-fancy"></i> Menulis
                            </span>
                            <span class="text-3xs font-bold px-1.5 py-0.5 bg-white text-amber-700 rounded border border-amber-200">
                                KKM 75
                            </span>
                        </div>
                        <div class="my-1">
                            <div class="text-xl font-extrabold text-amber-800"><?= esc($m['rata_rata']); ?></div>
                            <div class="text-3xs text-amber-700/80 truncate font-medium">Ust. Oleh Solihin</div>
                        </div>
                        <div class="pt-2 border-t border-amber-100 flex items-center justify-between text-3xs text-slate-500">
                            <span>Lulus: <strong class="text-amber-700"><?= esc($m['kelulusan']); ?>%</strong></span>
                            <span>Maks: <?= esc($m['tertinggi']); ?></span>
                        </div>
                    </div>

                    <!-- Adab & Akhlaq (20%) -->
                    <?php $a = $mapel_stats['adab_akhlaq']; ?>
                    <div class="p-3 rounded-xl border border-rose-100 bg-rose-50/40 flex flex-col justify-between col-span-2 sm:col-span-1">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-3xs font-bold uppercase tracking-wider text-rose-700 flex items-center gap-1">
                                <i class="fa-solid fa-heart-pulse"></i> Adab & Akhlaq
                            </span>
                            <span class="text-3xs font-bold px-1.5 py-0.5 bg-rose-600 text-white rounded">
                                Bobot 20%
                            </span>
                        </div>
                        <div class="my-1">
                            <div class="text-xl font-extrabold text-rose-800"><?= esc($a['rata_rata']); ?></div>
                            <div class="text-3xs text-rose-700/80 truncate font-medium">Karakter & Kedisiplinan</div>
                        </div>
                        <div class="pt-2 border-t border-rose-100 flex items-center justify-between text-3xs text-slate-500">
                            <span>Standar: <strong>80.0</strong></span>
                            <span>Maks: <?= esc($a['tertinggi']); ?></span>
                        </div>
                    </div>

                </div>
            </div>

            <!-- ================= TAB KELAS KEJURUAN & TOOLBAR ================= -->
            <div class="bg-white rounded-2xl border border-slate-200 p-4 sm:p-5 shadow-xs space-y-4">
                
                <!-- Filter Pills: 6 Kejuruan + Semua -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-3xs font-bold text-slate-400 uppercase tracking-wider flex items-center gap-1.5">
                            <i class="fa-solid fa-layer-group text-[#0066CC]"></i> Pilih Jurusan / Kelas:
                        </span>
                        <span class="text-3xs text-slate-500 font-medium" id="filterStatusLabel">Menampilkan Semua Kelas (<?= esc($total_siswa); ?> Santri)</span>
                    </div>

                    <div class="flex items-center gap-2 overflow-x-auto pb-1.5 no-scrollbar text-xs font-semibold" id="classFilterContainer">
                        <button onclick="filterClass('ALL')" class="class-pill active-pill px-3 py-2 rounded-xl transition whitespace-nowrap bg-[#0066CC] text-white shadow-xs" data-class="ALL">
                            <i class="fa-solid fa-border-all mr-1.5"></i>Semua Kelas (<?= esc($total_siswa); ?>)
                        </button>
                        <button onclick="filterClass('Teknik Komputer dan Jaringan')" class="class-pill px-3 py-2 rounded-xl transition whitespace-nowrap bg-slate-100 text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 border border-transparent hover:border-emerald-200" data-class="Teknik Komputer dan Jaringan">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block mr-1.5"></span>TKJ
                        </button>
                        <button onclick="filterClass('Tata Busana')" class="class-pill px-3 py-2 rounded-xl transition whitespace-nowrap bg-slate-100 text-slate-600 hover:bg-yellow-50 hover:text-yellow-800 border border-transparent hover:border-yellow-200" data-class="Tata Busana">
                            <span class="w-2 h-2 rounded-full bg-yellow-500 inline-block mr-1.5"></span>Tata Busana
                        </button>
                        <button onclick="filterClass('Fotografi dan Videografi')" class="class-pill px-3 py-2 rounded-xl transition whitespace-nowrap bg-slate-100 text-slate-600 hover:bg-blue-50 hover:text-blue-700 border border-transparent hover:border-blue-200" data-class="Fotografi dan Videografi">
                            <span class="w-2 h-2 rounded-full bg-blue-500 inline-block mr-1.5"></span>Fotografi & Video
                        </button>
                        <button onclick="filterClass('Desain Grafis')" class="class-pill px-3 py-2 rounded-xl transition whitespace-nowrap bg-slate-100 text-slate-600 hover:bg-red-50 hover:text-red-700 border border-transparent hover:border-red-200" data-class="Desain Grafis">
                            <span class="w-2 h-2 rounded-full bg-red-500 inline-block mr-1.5"></span>Desain Grafis
                        </button>
                        <button onclick="filterClass('Otomotif')" class="class-pill px-3 py-2 rounded-xl transition whitespace-nowrap bg-slate-100 text-slate-600 hover:bg-slate-200 hover:text-slate-900 border border-transparent hover:border-slate-300" data-class="Otomotif">
                            <span class="w-2 h-2 rounded-full bg-slate-800 inline-block mr-1.5"></span>Otomotif
                        </button>
                        <button onclick="filterClass('Aplikasi Perkantoran')" class="class-pill px-3 py-2 rounded-xl transition whitespace-nowrap bg-slate-100 text-slate-600 hover:bg-orange-50 hover:text-orange-700 border border-transparent hover:border-orange-200" data-class="Aplikasi Perkantoran">
                            <span class="w-2 h-2 rounded-full bg-orange-500 inline-block mr-1.5"></span>Aplikasi Perkantoran
                        </button>
                    </div>
                </div>

                <!-- Search & View Toolbar -->
                <div class="pt-3 border-t border-slate-100 flex flex-col md:flex-row gap-3 md:items-center justify-between">
                    
                    <!-- Search Input -->
                    <div class="relative flex-1">
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <input 
                            type="text" 
                            id="studentSearchInput" 
                            placeholder="Cari santri berdasarkan nama, NIS, atau jurusan..." 
                            class="w-full pl-9 pr-9 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0066CC] focus:border-[#0066CC] transition placeholder:text-slate-400 text-slate-800"
                        >
                        <button id="clearSearchBtn" class="hidden absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 p-1">
                            <i class="fa-solid fa-xmark text-xs"></i>
                        </button>
                    </div>

                    <!-- Sort & Mode Switcher -->
                    <div class="flex items-center gap-2 shrink-0">
                        <div class="flex items-center gap-1.5 text-xs text-slate-500">
                            <i class="fa-solid fa-arrow-down-wide-short text-slate-400"></i>
                            <span class="hidden sm:inline">Urutkan:</span>
                        </div>
                        <select id="sortBySelect" class="bg-slate-50 border border-slate-200 rounded-xl px-2.5 py-2 text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#0066CC] font-medium">
                            <option value="highest">Nilai Tertinggi</option>
                            <option value="lowest">Nilai Terendah</option>
                            <option value="name-asc">Nama (A - Z)</option>
                            <option value="attendance">Kehadiran Tertinggi</option>
                        </select>

                        <!-- Toggle View Mode: Grid vs Table -->
                        <div class="flex items-center bg-slate-100 p-1 rounded-xl border border-slate-200">
                            <button id="viewGridBtn" onclick="setViewMode('grid')" title="Tampilan Kartu Santri" class="px-2.5 py-1.5 rounded-lg text-xs font-semibold bg-white text-[#0066CC] shadow-xs transition">
                                <i class="fa-solid fa-table-cells-large"></i>
                            </button>
                            <button id="viewTableBtn" onclick="setViewMode('table')" title="Tampilan Tabel Rekap" class="px-2.5 py-1.5 rounded-lg text-xs font-semibold text-slate-500 hover:text-slate-800 transition">
                                <i class="fa-solid fa-list-ul"></i>
                            </button>
                        </div>

                        <!-- Reset Filter -->
                        <button 
                            onclick="resetAllFilters()"
                            class="px-2.5 py-2 text-xs text-slate-600 hover:text-[#0066CC] hover:bg-slate-100 rounded-xl transition flex items-center gap-1 font-medium border border-slate-200"
                            title="Reset Pencarian & Filter"
                        >
                            <i class="fa-solid fa-rotate-left text-3xs"></i>
                            <span class="hidden sm:inline">Reset</span>
                        </button>
                    </div>

                </div>

            </div>

            <!-- ================= DAFTAR SANTRI (GRID / TABLE) ================= -->
            <div>
                <!-- Header Counter -->
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-4 rounded-full bg-[#0066CC]"></span>
                        <h3 class="text-sm font-bold text-slate-900">
                            Daftar Santri & Rekap Raport
                        </h3>
                        <span class="text-2xs font-bold bg-brand-light text-brand px-2 py-0.5 rounded-full border border-brand-border">
                            <span id="displayedStudentsCount">0</span> Santri Ditemukan
                        </span>
                    </div>
                    <div class="text-2xs text-slate-500">
                        Filter Aktif: <strong class="text-slate-800" id="currentClassFilterName">Semua Kelas</strong>
                    </div>
                </div>

                <!-- 1. GRID CARDS VIEW -->
                <div id="studentsGridContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <!-- Populated by JavaScript -->
                </div>

                <!-- 2. TABLE VIEW -->
                <div id="studentsTableContainer" class="hidden bg-white rounded-2xl shadow-xs border border-slate-200 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs min-w-[760px]">
                            <thead class="bg-slate-50 text-slate-500 border-b border-slate-200 uppercase tracking-wider text-3xs font-bold">
                                <tr>
                                    <th class="py-3 px-3.5 text-center w-10">No</th>
                                    <th class="py-3 px-4">Santri</th>
                                    <th class="py-3 px-4">Jurusan</th>
                                    <th class="py-3 px-2.5 text-center">Tauhid</th>
                                    <th class="py-3 px-2.5 text-center">Fiqih</th>
                                    <th class="py-3 px-2.5 text-center">B.Ing</th>
                                    <th class="py-3 px-2.5 text-center">Menulis</th>
                                    <th class="py-3 px-3 text-center bg-rose-50/60 text-rose-700">Adab (20%)</th>
                                    <th class="py-3 px-3 text-center bg-brand-light/60 text-brand">Nilai Akhir</th>
                                    <th class="py-3 px-3 text-center">Kehadiran</th>
                                    <th class="py-3 px-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="studentsTableBody" class="divide-y divide-slate-100">
                                <!-- Populated by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Empty State -->
                <div id="emptyStudentState" class="hidden flex flex-col items-center justify-center py-12 px-4 text-center bg-white rounded-2xl border border-dashed border-slate-300">
                    <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center text-xl mb-3">
                        <i class="fa-solid fa-user-slash"></i>
                    </div>
                    <h4 class="text-sm font-bold text-slate-800">Santri Tidak Ditemukan</h4>
                    <p class="text-xs text-slate-500 max-w-sm mt-0.5 mb-4">
                        Tidak ada data santri yang sesuai dengan pencarian atau filter kelas yang Anda pilih.
                    </p>
                    <button onclick="resetAllFilters()" class="px-3.5 py-1.5 bg-[#0066CC] hover:bg-[#0052A3] text-white rounded-xl text-xs font-semibold transition shadow-xs">
                        Tampilkan Semua Santri
                    </button>
                </div>
            </div>

        </div>

    </main>
</div>

<!-- ================= MODAL DETAIL SANTRI & RAPORT ELEGAN ================= -->
<div id="studentDetailModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-3 sm:p-6 overflow-y-auto">
    <!-- Backdrop Blur -->
    <div id="studentModalBackdrop" onclick="closeStudentModal()" class="modal-backdrop fixed inset-0 bg-slate-900/60 backdrop-blur-xs"></div>

    <!-- Modal Box Content -->
    <div class="modal-box relative bg-white w-full max-w-2xl rounded-2xl shadow-2xl overflow-hidden z-10 border border-slate-200 my-8">
        
        <!-- Modal Top Accent Bar -->
        <div class="h-2 w-full bg-gradient-to-r from-[#073B66] via-[#0066CC] to-sky-400"></div>

        <!-- Modal Header & Profile Bar -->
        <div class="p-5 sm:p-6 pb-4 border-b border-slate-100 flex items-start justify-between gap-4">
            <div class="flex items-center gap-4">
                
                <!-- Foto Santri dengan Fallback Inisial -->
                <div class="relative shrink-0">
                    <img 
                        id="modalStudentPhoto" 
                        src="" 
                        alt="Foto Santri" 
                        class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl object-cover border-2 border-slate-200 shadow-sm bg-slate-100"
                        onerror="handleModalPhotoError(this)"
                    >
                    <div 
                        id="modalStudentAvatarFallback" 
                        class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl border-2 border-slate-200 shadow-sm bg-brand-light text-brand flex items-center justify-center text-2xl font-bold hidden"
                    >
                        AF
                    </div>
                    <span id="modalAttendanceDot" class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full border-2 border-white bg-emerald-500 shadow-xs" title="Status Santri Aktif"></span>
                </div>

                <!-- Info Identitas -->
                <div>
                    <div class="flex flex-wrap items-center gap-2 mb-1">
                        <span id="modalStudentClassBadge" class="px-2.5 py-0.5 text-3xs font-bold rounded-lg uppercase tracking-wider text-white bg-emerald-600">
                            TKJ
                        </span>
                        <span id="modalPredikatBadge" class="text-3xs bg-slate-100 text-slate-700 px-2 py-0.5 rounded-lg font-bold border border-slate-200">
                            Predikat A
                        </span>
                    </div>
                    <h2 id="modalStudentName" class="text-base sm:text-xl font-bold text-slate-900 leading-tight">Nama Santri</h2>
                    <p id="modalStudentNis" class="text-xs text-slate-500 font-medium mt-0.5">NIS: SG-2026-001 • Cabang RGI Depok</p>
                    <p id="modalStudentClassLong" class="text-xs font-semibold text-[#0066CC] mt-0.5">Teknik Komputer dan Jaringan</p>
                </div>

            </div>

            <!-- Close Button -->
            <button onclick="closeStudentModal()" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 flex items-center justify-center transition shrink-0 cursor-pointer" title="Tutup Modal">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        <!-- Modal Body Content -->
        <div class="p-5 sm:p-6 space-y-5">
            
            <!-- Warning Box: Jika Santri Absen > 3x -->
            <div id="modalAbsenWarningBox" class="hidden p-3.5 bg-amber-50 border border-amber-200 rounded-xl text-amber-900 flex items-start gap-3">
                <div class="w-6 h-6 rounded-lg bg-amber-200 text-amber-800 flex items-center justify-center shrink-0 mt-0.5">
                    <i class="fa-solid fa-triangle-exclamation text-xs"></i>
                </div>
                <div class="text-xs">
                    <span class="font-bold block">Peringatan Presensi Ketidakhadiran</span>
                    <span id="modalAbsenWarningText" class="text-amber-800">Santri ini tercatat memiliki absensi lebih dari 3 kali. Diperlukan perhatian khusus & tindak lanjut kedisiplinan instruktur.</span>
                </div>
            </div>

            <!-- 3 Kartu Ringkasan Metrik Nilai (Raport Summary) -->
            <div class="grid grid-cols-3 gap-2.5 sm:gap-3 text-center">
                <div class="p-3 bg-brand-light/40 border border-brand-border/60 rounded-xl">
                    <span class="text-3xs text-slate-500 font-semibold block uppercase">Nilai Akhir Terbobot</span>
                    <span class="text-xl sm:text-2xl font-extrabold text-[#0066CC] block mt-0.5" id="modalNilaiAkhir">88.50</span>
                    <span class="text-3xs text-slate-400">80% Mapel + 20% Adab</span>
                </div>
                <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl">
                    <span class="text-3xs text-slate-500 font-semibold block uppercase">Akademik (80%)</span>
                    <span class="text-xl sm:text-2xl font-extrabold text-slate-800 block mt-0.5" id="modalRataAkademik">87.50</span>
                    <span class="text-3xs text-slate-400">Rata-rata 4 Mapel</span>
                </div>
                <div class="p-3 bg-rose-50/50 border border-rose-200/60 rounded-xl">
                    <span class="text-3xs text-rose-700 font-semibold block uppercase">Adab & Akhlaq (20%)</span>
                    <span class="text-xl sm:text-2xl font-extrabold text-rose-700 block mt-0.5" id="modalNilaiAdab">92.00</span>
                    <span class="text-3xs text-rose-600/80">Evaluasi Karakter</span>
                </div>
            </div>

            <!-- Rincian 4 Mapel Pokok (Tabel Raport Bersih) -->
            <div>
                <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 flex items-center justify-between">
                    <span class="flex items-center gap-1.5">
                        <i class="fa-solid fa-graduation-cap text-[#0066CC]"></i> Capaian 4 Mata Pelajaran Pokok
                    </span>
                    <span class="text-3xs text-slate-400 font-normal">Standar KKM: 75 / 100</span>
                </h4>

                <div class="border border-slate-200 rounded-xl overflow-hidden">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 border-b border-slate-200 text-3xs uppercase font-bold">
                            <tr>
                                <th class="py-2.5 px-3">Mata Pelajaran</th>
                                <th class="py-2.5 px-2.5 text-center w-20">KKM</th>
                                <th class="py-2.5 px-3 text-center w-24">Nilai Santri</th>
                                <th class="py-2.5 px-3 text-center w-24">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <!-- Tauhid -->
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="py-2.5 px-3 font-semibold text-slate-800">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xs shrink-0">
                                            <i class="fa-solid fa-book-quran"></i>
                                        </div>
                                        <div>
                                            <span>Tauhid & Aqidah</span>
                                            <span class="block text-3xs text-slate-400 font-normal">Ust. Kamal Malawi</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-2.5 px-2.5 text-center text-slate-500 font-medium">75</td>
                                <td class="py-2.5 px-3 text-center font-bold text-emerald-700" id="modalScoreTauhid">89</td>
                                <td class="py-2.5 px-3 text-center">
                                    <span id="modalStatusTauhid" class="px-2 py-0.5 rounded-full text-3xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        Tuntas
                                    </span>
                                </td>
                            </tr>

                            <!-- Fiqih -->
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="py-2.5 px-3 font-semibold text-slate-800">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-lg bg-blue-50 text-[#0066CC] flex items-center justify-center text-2xs shrink-0">
                                            <i class="fa-solid fa-hands-praying"></i>
                                        </div>
                                        <div>
                                            <span>Fiqih Ibadah</span>
                                            <span class="block text-3xs text-slate-400 font-normal">Usth. Yanni Susanti</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-2.5 px-2.5 text-center text-slate-500 font-medium">75</td>
                                <td class="py-2.5 px-3 text-center font-bold text-[#0066CC]" id="modalScoreFiqih">90</td>
                                <td class="py-2.5 px-3 text-center">
                                    <span id="modalStatusFiqih" class="px-2 py-0.5 rounded-full text-3xs font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                        Tuntas
                                    </span>
                                </td>
                            </tr>

                            <!-- B. Inggris -->
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="py-2.5 px-3 font-semibold text-slate-800">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-2xs shrink-0">
                                            <i class="fa-solid fa-language"></i>
                                        </div>
                                        <div>
                                            <span>Bahasa Inggris</span>
                                            <span class="block text-3xs text-slate-400 font-normal">Ms. Nadia</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-2.5 px-2.5 text-center text-slate-500 font-medium">75</td>
                                <td class="py-2.5 px-3 text-center font-bold text-indigo-700" id="modalScoreBing">85</td>
                                <td class="py-2.5 px-3 text-center">
                                    <span id="modalStatusBing" class="px-2 py-0.5 rounded-full text-3xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
                                        Tuntas
                                    </span>
                                </td>
                            </tr>

                            <!-- Menulis Kreatif -->
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="py-2.5 px-3 font-semibold text-slate-800">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-2xs shrink-0">
                                            <i class="fa-solid fa-pen-fancy"></i>
                                        </div>
                                        <div>
                                            <span>Menulis Kreatif</span>
                                            <span class="block text-3xs text-slate-400 font-normal">Ust. Oleh Solihin</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-2.5 px-2.5 text-center text-slate-500 font-medium">75</td>
                                <td class="py-2.5 px-3 text-center font-bold text-amber-700" id="modalScoreMenulis">87</td>
                                <td class="py-2.5 px-3 text-center">
                                    <span id="modalStatusMenulis" class="px-2 py-0.5 rounded-full text-3xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                        Tuntas
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Karakter & Presensi Kehadiran -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div class="p-3 bg-rose-50/40 rounded-xl border border-rose-200/70 flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-rose-100 text-rose-700 flex items-center justify-center text-sm shrink-0">
                            <i class="fa-solid fa-heart-pulse"></i>
                        </div>
                        <div>
                            <span class="text-3xs text-slate-500 block font-medium">Karakter: Adab & Akhlaq (20%)</span>
                            <span class="text-xs font-bold text-rose-800" id="modalTextAdab">92 (Sangat Baik)</span>
                        </div>
                    </div>
                    <span class="text-3xs font-bold text-rose-700 px-2 py-0.5 rounded bg-white border border-rose-200">
                        Bobot 20%
                    </span>
                </div>

                <div class="p-3 bg-emerald-50/40 rounded-xl border border-emerald-200/70 flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm shrink-0">
                            <i class="fa-solid fa-clipboard-check"></i>
                        </div>
                        <div>
                            <span class="text-3xs text-slate-500 block font-medium">Rekap Presensi Santri</span>
                            <span class="text-xs font-bold text-emerald-800" id="modalTextKehadiran">96% Kehadiran</span>
                        </div>
                    </div>
                    <span id="modalAbsenBadge" class="text-3xs font-bold text-emerald-700 px-2 py-0.5 rounded bg-white border border-emerald-200">
                        Disiplin
                    </span>
                </div>
            </div>

        </div>

        <!-- Modal Footer Actions -->
        <div class="p-4 sm:p-5 bg-slate-50 border-t border-slate-200 flex flex-wrap items-center justify-between gap-2.5">
            <div class="flex items-center gap-2">
                <button onclick="copyStudentReport()" class="px-3.5 py-2 rounded-xl bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 text-xs font-semibold flex items-center gap-1.5 transition cursor-pointer shadow-2xs">
                    <i class="fa-regular fa-copy"></i> Salin Rincian Nilai
                </button>
                <a id="btnModalEditGrade" href="<?= base_url('instruktur/nilai'); ?>" class="px-3.5 py-2 rounded-xl bg-[#0066CC] hover:bg-[#0052A3] text-white text-xs font-semibold flex items-center gap-1.5 transition shadow-xs">
                    <i class="fa-solid fa-pen-to-square"></i> Update Nilai
                </a>
            </div>
            <button onclick="closeStudentModal()" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:text-slate-900 transition cursor-pointer">
                Tutup
            </button>
        </div>

    </div>
</div>

<!-- ================= TOAST NOTIFICATION ================= -->
<div id="toastNotification" class="fixed bottom-6 right-6 z-50 hidden bg-slate-900 text-white text-xs sm:text-sm px-4 py-3 rounded-xl shadow-xl flex items-center gap-3 border border-slate-700 transition transform duration-200">
    <i class="fa-solid fa-circle-check text-emerald-400 text-base"></i>
    <span id="toastMessage">Pemberitahuan berhasil</span>
</div>

<!-- ================= JAVASCRIPT ================= -->
<script>
    // Data Santri dari PHP
    const studentsData = <?= json_encode($data_siswa); ?>;
    const baseUrlSantriUpload = '<?= base_url('uploads/santri'); ?>/';

    // State Aplikasi
    let currentClass = 'ALL';
    let searchQuery = '';
    let currentSort = 'highest';
    let currentViewMode = 'grid'; // 'grid' atau 'table'
    let currentSelectedStudent = null;

    // Helper Warna Jurusan Resmi
    function getDepartmentTheme(deptName) {
        if (!deptName) return { code: 'RGI', bgClass: 'bg-[#0066CC] text-white', badge: 'bg-blue-50 text-blue-700 border-blue-200', text: 'text-[#0066CC]' };

        if (deptName.includes('Desain')) {
            return { code: 'DG', bgClass: 'bg-red-600 text-white', badge: 'bg-red-50 text-red-700 border-red-200', text: 'text-red-600', dot: 'bg-red-500' };
        } else if (deptName.includes('Komputer') || deptName.includes('TKJ')) {
            return { code: 'TKJ', bgClass: 'bg-emerald-600 text-white', badge: 'bg-emerald-50 text-emerald-700 border-emerald-200', text: 'text-emerald-700', dot: 'bg-emerald-500' };
        } else if (deptName.includes('Perkantoran') || deptName.includes('AP')) {
            return { code: 'AP', bgClass: 'bg-orange-500 text-white', badge: 'bg-orange-50 text-orange-700 border-orange-200', text: 'text-orange-600', dot: 'bg-orange-500' };
        } else if (deptName.includes('Tata Busana')) {
            return { code: 'TB', bgClass: 'bg-yellow-500 text-slate-900 font-bold', badge: 'bg-yellow-50 text-yellow-800 border-yellow-300', text: 'text-yellow-800', dot: 'bg-yellow-500' };
        } else if (deptName.includes('Otomotif')) {
            return { code: 'OTO', bgClass: 'bg-slate-900 text-white', badge: 'bg-slate-100 text-slate-900 border-slate-300', text: 'text-slate-900', dot: 'bg-slate-900' };
        } else if (deptName.includes('Fotografi')) {
            return { code: 'FV', bgClass: 'bg-blue-600 text-white', badge: 'bg-blue-50 text-blue-700 border-blue-200', text: 'text-blue-700', dot: 'bg-blue-600' };
        }
        return { code: 'RGI', bgClass: 'bg-[#0066CC] text-white', badge: 'bg-blue-50 text-[#0066CC] border-blue-200', text: 'text-[#0066CC]', dot: 'bg-[#0066CC]' };
    }

    // Helper Predikat
    function getPredikat(score) {
        if (score >= 90) return { grade: 'A', text: 'Sangat Memuaskan', color: 'bg-emerald-50 text-emerald-700 border-emerald-200' };
        if (score >= 80) return { grade: 'B+', text: 'Memuaskan', color: 'bg-sky-50 text-sky-700 border-sky-200' };
        if (score >= 75) return { grade: 'B', text: 'Cukup Baik', color: 'bg-indigo-50 text-indigo-700 border-indigo-200' };
        return { grade: 'C', text: 'Perlu Bimbingan', color: 'bg-amber-50 text-amber-700 border-amber-200' };
    }

    // Inisialisasi Saat Load
    document.addEventListener('DOMContentLoaded', () => {
        renderStudents();
        initEventListeners();
    });

    // Event Listener Toolbar
    function initEventListeners() {
        const searchInput = document.getElementById('studentSearchInput');
        const clearBtn = document.getElementById('clearSearchBtn');

        searchInput.addEventListener('input', (e) => {
            searchQuery = e.target.value.trim().toLowerCase();
            if (searchQuery.length > 0) {
                clearBtn.classList.remove('hidden');
            } else {
                clearBtn.classList.add('hidden');
            }
            renderStudents();
        });

        clearBtn.addEventListener('click', () => {
            searchInput.value = '';
            searchQuery = '';
            clearBtn.classList.add('hidden');
            searchInput.focus();
            renderStudents();
        });

        const sortSelect = document.getElementById('sortBySelect');
        sortSelect.addEventListener('change', (e) => {
            currentSort = e.target.value;
            renderStudents();
        });

        // Close modal on Escape
        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeStudentModal();
            }
        });
    }

    // Fallback handler foto modal jika error load
    function handleModalPhotoError(imgEl) {
        imgEl.classList.add('hidden');
        const fallback = document.getElementById('modalStudentAvatarFallback');
        if (fallback) fallback.classList.remove('hidden');
    }

    // Toggle View Mode: Grid vs Table
    function setViewMode(mode) {
        currentViewMode = mode;
        const gridContainer = document.getElementById('studentsGridContainer');
        const tableContainer = document.getElementById('studentsTableContainer');
        const viewGridBtn = document.getElementById('viewGridBtn');
        const viewTableBtn = document.getElementById('viewTableBtn');

        if (mode === 'grid') {
            gridContainer.classList.remove('hidden');
            tableContainer.classList.add('hidden');
            viewGridBtn.className = "px-2.5 py-1.5 rounded-lg text-xs font-semibold bg-white text-[#0066CC] shadow-xs transition";
            viewTableBtn.className = "px-2.5 py-1.5 rounded-lg text-xs font-semibold text-slate-500 hover:text-slate-800 transition";
        } else {
            gridContainer.classList.add('hidden');
            tableContainer.classList.remove('hidden');
            viewTableBtn.className = "px-2.5 py-1.5 rounded-lg text-xs font-semibold bg-white text-[#0066CC] shadow-xs transition";
            viewGridBtn.className = "px-2.5 py-1.5 rounded-lg text-xs font-semibold text-slate-500 hover:text-slate-800 transition";
        }
    }

    // Filter Kelas
    function filterClass(className) {
        currentClass = className;

        // Update pills
        const pills = document.querySelectorAll('.class-pill');
        pills.forEach(pill => {
            if (pill.getAttribute('data-class') === className) {
                pill.className = "class-pill active-pill px-3 py-2 rounded-xl transition whitespace-nowrap bg-[#0066CC] text-white shadow-xs";
            } else {
                pill.className = "class-pill px-3 py-2 rounded-xl transition whitespace-nowrap bg-slate-100 text-slate-600 hover:bg-slate-200 border border-transparent";
            }
        });

        // Update status label
        const statusLabel = document.getElementById('filterStatusLabel');
        const curClassLabel = document.getElementById('currentClassFilterName');
        if (className === 'ALL') {
            statusLabel.textContent = `Menampilkan Semua Kelas (${studentsData.length} Santri)`;
            curClassLabel.textContent = "Semua Kelas";
        } else {
            statusLabel.textContent = `Filter Aktif: ${className}`;
            curClassLabel.textContent = className;
        }

        renderStudents();
    }

    // Reset Semua Filter
    function resetAllFilters() {
        currentClass = 'ALL';
        searchQuery = '';
        currentSort = 'highest';

        const searchInput = document.getElementById('studentSearchInput');
        if (searchInput) searchInput.value = '';
        const clearBtn = document.getElementById('clearSearchBtn');
        if (clearBtn) clearBtn.classList.add('hidden');
        const sortSelect = document.getElementById('sortBySelect');
        if (sortSelect) sortSelect.value = 'highest';

        filterClass('ALL');
    }

    // Render Data Santri
    function renderStudents() {
        const grid = document.getElementById('studentsGridContainer');
        const tableBody = document.getElementById('studentsTableBody');
        const emptyState = document.getElementById('emptyStudentState');
        const countBadge = document.getElementById('displayedStudentsCount');

        // 1. Filter
        let filtered = studentsData.filter(s => {
            const matchClass = (currentClass === 'ALL') || (s.kelas === currentClass);
            const matchSearch = !searchQuery ||
                s.nama.toLowerCase().includes(searchQuery) ||
                s.kelas.toLowerCase().includes(searchQuery) ||
                (s.nis && s.nis.toLowerCase().includes(searchQuery)) ||
                (s.id && s.id.toString().includes(searchQuery));
            return matchClass && matchSearch;
        });

        // 2. Sort
        if (currentSort === 'highest') {
            filtered.sort((a, b) => parseFloat(b.rata_rata) - parseFloat(a.rata_rata));
        } else if (currentSort === 'lowest') {
            filtered.sort((a, b) => parseFloat(a.rata_rata) - parseFloat(b.rata_rata));
        } else if (currentSort === 'name-asc') {
            filtered.sort((a, b) => a.nama.localeCompare(b.nama));
        } else if (currentSort === 'attendance') {
            filtered.sort((a, b) => parseInt(b.kehadiran) - parseInt(a.kehadiran));
        }

        countBadge.textContent = filtered.length;

        if (filtered.length === 0) {
            grid.innerHTML = '';
            tableBody.innerHTML = '';
            emptyState.classList.remove('hidden');
            return;
        } else {
            emptyState.classList.add('hidden');
        }

        // 3. Render Grid Cards
        grid.innerHTML = filtered.map(s => {
            const pred = getPredikat(parseFloat(s.rata_rata));
            const initials = s.nama.split(' ').map(n => n[0]).slice(0, 2).join('').toUpperCase();
            const theme = getDepartmentTheme(s.kelas);
            const nis = s.nis || `SG-2026-${String(s.id).padStart(3, '0')}`;
            const totalAbsen = parseInt(s.total_absen || 0);

            // Thumbnail Foto
            let photoHtml = '';
            if (s.foto) {
                photoHtml = `
                    <img 
                        src="${baseUrlSantriUpload}${s.foto}" 
                        alt="${s.nama}" 
                        class="w-12 h-12 rounded-xl object-cover border border-slate-200 shrink-0 bg-slate-100"
                        onerror="this.outerHTML='<div class=\\'w-12 h-12 rounded-xl bg-slate-100 text-[#0066CC] font-bold text-sm flex items-center justify-center border border-slate-200 shrink-0\\'>${initials}</div>'"
                    >
                `;
            } else {
                photoHtml = `
                    <div class="w-12 h-12 rounded-xl bg-slate-100 text-[#0066CC] font-bold text-sm flex items-center justify-center border border-slate-200 shrink-0">
                        ${initials}
                    </div>
                `;
            }

            // Peringatan Absen jika > 3
            let absenWarningPill = '';
            if (totalAbsen > 3) {
                absenWarningPill = `
                    <div class="mt-2.5 px-2.5 py-1 rounded-lg bg-amber-50 border border-amber-200 flex items-center justify-between text-3xs text-amber-800">
                        <span class="font-bold flex items-center gap-1">
                            <i class="fa-solid fa-triangle-exclamation text-amber-600"></i> Absen ${totalAbsen}x
                        </span>
                        <span class="font-semibold text-amber-700">Perlu Tindak Lanjut</span>
                    </div>
                `;
            }

            return `
                <div class="student-card bg-white rounded-2xl border border-slate-200 p-4 flex flex-col justify-between shadow-xs">
                    <div>
                        <!-- Header Kartu: Foto, Nama, Badge Jurusan -->
                        <div class="flex items-start justify-between gap-2 mb-3">
                            <div class="flex items-center gap-3">
                                ${photoHtml}
                                <div>
                                    <h4 class="font-bold text-slate-900 text-sm leading-snug hover:text-[#0066CC] transition line-clamp-1 cursor-pointer" onclick="openStudentModal(${s.id})">
                                        ${s.nama}
                                    </h4>
                                    <span class="text-3xs text-slate-400 font-medium block">NIS: ${nis}</span>
                                </div>
                            </div>
                            <span class="px-2 py-0.5 rounded-md text-3xs font-bold uppercase tracking-wider shrink-0 ${theme.bgClass}">
                                ${theme.code}
                            </span>
                        </div>

                        <!-- Mini 4 Mapel Scores -->
                        <div class="grid grid-cols-4 gap-1.5 text-center my-2.5">
                            <div class="bg-slate-50 p-1.5 rounded-lg border border-slate-100">
                                <span class="text-3xs text-slate-400 block font-medium">Tauhid</span>
                                <span class="text-xs font-bold text-slate-700">${s.tauhid}</span>
                            </div>
                            <div class="bg-slate-50 p-1.5 rounded-lg border border-slate-100">
                                <span class="text-3xs text-slate-400 block font-medium">Fiqih</span>
                                <span class="text-xs font-bold text-slate-700">${s.fiqih}</span>
                            </div>
                            <div class="bg-slate-50 p-1.5 rounded-lg border border-slate-100">
                                <span class="text-3xs text-slate-400 block font-medium">B.Ing</span>
                                <span class="text-xs font-bold text-slate-700">${s.b_ing}</span>
                            </div>
                            <div class="bg-slate-50 p-1.5 rounded-lg border border-slate-100">
                                <span class="text-3xs text-slate-400 block font-medium">Menulis</span>
                                <span class="text-xs font-bold text-slate-700">${s.menulis_kreatif}</span>
                            </div>
                        </div>

                        <!-- Adab & Kehadiran Strip -->
                        <div class="flex items-center justify-between text-2xs px-2.5 py-1.5 rounded-lg bg-slate-50 border border-slate-100">
                            <span class="text-rose-700 font-semibold flex items-center gap-1">
                                <i class="fa-solid fa-heart-pulse text-rose-500"></i> Adab: <strong>${s.adab_akhlaq}</strong>
                            </span>
                            <span class="text-emerald-700 font-semibold flex items-center gap-1">
                                <i class="fa-solid fa-clipboard-check text-emerald-500"></i> Hadir: <strong>${s.kehadiran}%</strong>
                            </span>
                        </div>

                        ${absenWarningPill}
                    </div>

                    <!-- Footer: Nilai Akhir & Tombol Raport -->
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                        <div>
                            <span class="text-3xs text-slate-400 block font-medium">Nilai Akhir Terbobot</span>
                            <div class="flex items-baseline gap-1.5">
                                <span class="text-base font-extrabold text-[#0066CC]">${parseFloat(s.rata_rata).toFixed(2)}</span>
                                <span class="text-3xs font-bold px-1.5 py-0.2 rounded border ${pred.color}">Predikat ${pred.grade}</span>
                            </div>
                        </div>
                        <button onclick="openStudentModal(${s.id})" class="px-3 py-1.5 bg-slate-50 hover:bg-[#0066CC] text-[#0066CC] hover:text-white border border-slate-200 hover:border-transparent text-xs font-semibold rounded-xl transition duration-150 flex items-center gap-1.5 cursor-pointer shadow-2xs">
                            <i class="fa-solid fa-address-card text-2xs"></i>
                            <span>Raport</span>
                        </button>
                    </div>
                </div>
            `;
        }).join('');

        // 4. Render Table Rows
        tableBody.innerHTML = filtered.map((s, idx) => {
            const pred = getPredikat(parseFloat(s.rata_rata));
            const theme = getDepartmentTheme(s.kelas);
            const initials = s.nama.split(' ').map(n => n[0]).slice(0, 2).join('').toUpperCase();
            const nis = s.nis || `SG-2026-${String(s.id).padStart(3, '0')}`;
            const totalAbsen = parseInt(s.total_absen || 0);

            // Thumbnail Foto Tabel
            let tablePhoto = '';
            if (s.foto) {
                tablePhoto = `
                    <img 
                        src="${baseUrlSantriUpload}${s.foto}" 
                        alt="${s.nama}" 
                        class="w-8 h-8 rounded-lg object-cover border border-slate-200 shrink-0 bg-slate-100"
                        onerror="this.outerHTML='<div class=\\'w-8 h-8 rounded-lg bg-slate-100 text-[#0066CC] font-bold text-3xs flex items-center justify-center border border-slate-200 shrink-0\\'>${initials}</div>'"
                    >
                `;
            } else {
                tablePhoto = `
                    <div class="w-8 h-8 rounded-lg bg-slate-100 text-[#0066CC] font-bold text-3xs flex items-center justify-center border border-slate-200 shrink-0">
                        ${initials}
                    </div>
                `;
            }

            return `
                <tr class="hover:bg-slate-50/80 transition">
                    <td class="py-3 px-3.5 text-center font-semibold text-slate-400">${idx + 1}</td>
                    <td class="py-3 px-4">
                        <div class="flex items-center gap-2.5">
                            ${tablePhoto}
                            <div>
                                <span class="font-bold text-slate-900 block hover:text-[#0066CC] cursor-pointer" onclick="openStudentModal(${s.id})">${s.nama}</span>
                                <span class="text-3xs text-slate-400 font-medium">NIS: ${nis}</span>
                            </div>
                        </div>
                    </td>
                    <td class="py-3 px-4">
                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-3xs font-semibold border ${theme.badge}">
                            <span class="w-1.5 h-1.5 rounded-full ${theme.dot || 'bg-slate-400'}"></span>
                            ${s.kelas}
                        </span>
                    </td>
                    <td class="py-3 px-2.5 text-center font-semibold text-slate-700">${s.tauhid}</td>
                    <td class="py-3 px-2.5 text-center font-semibold text-slate-700">${s.fiqih}</td>
                    <td class="py-3 px-2.5 text-center font-semibold text-slate-700">${s.b_ing}</td>
                    <td class="py-3 px-2.5 text-center font-semibold text-slate-700">${s.menulis_kreatif}</td>
                    <td class="py-3 px-3 text-center font-bold text-rose-700 bg-rose-50/30">${s.adab_akhlaq}</td>
                    <td class="py-3 px-3 text-center font-extrabold text-[#0066CC] bg-brand-light/30">
                        ${parseFloat(s.rata_rata).toFixed(2)}
                        <span class="text-3xs font-bold block ${pred.text.includes('Sangat') ? 'text-emerald-600' : 'text-slate-500'}">(${pred.grade})</span>
                    </td>
                    <td class="py-3 px-3 text-center">
                        <span class="font-semibold text-emerald-600 block">${s.kehadiran}%</span>
                        ${totalAbsen > 3 ? `<span class="text-3xs text-amber-700 font-bold block">(Absen: ${totalAbsen}x)</span>` : ''}
                    </td>
                    <td class="py-3 px-4 text-center">
                        <button onclick="openStudentModal(${s.id})" class="px-2.5 py-1 bg-white hover:bg-[#0066CC] text-[#0066CC] hover:text-white border border-slate-200 hover:border-transparent rounded-lg text-3xs font-bold transition cursor-pointer shadow-2xs">
                            Detail
                        </button>
                    </td>
                </tr>
            `;
        }).join('');
    }

    // Buka Modal Raport Santri
    function openStudentModal(id) {
        const student = studentsData.find(item => item.id == id);
        if (!student) return;

        currentSelectedStudent = student;
        const pred = getPredikat(parseFloat(student.rata_rata));
        const initials = student.nama.split(' ').map(n => n[0]).slice(0, 2).join('').toUpperCase();
        const theme = getDepartmentTheme(student.kelas);
        const nis = student.nis || `SG-2026-${String(student.id).padStart(3, '0')}`;
        const totalAbsen = parseInt(student.total_absen || 0);

        // Foto Santri
        const photoEl = document.getElementById('modalStudentPhoto');
        const fallbackEl = document.getElementById('modalStudentAvatarFallback');

        if (student.foto && student.foto.trim() !== '') {
            photoEl.src = baseUrlSantriUpload + student.foto;
            photoEl.classList.remove('hidden');
            fallbackEl.classList.add('hidden');
        } else {
            photoEl.classList.add('hidden');
            fallbackEl.textContent = initials;
            fallbackEl.classList.remove('hidden');
        }

        // Identitas Santri
        document.getElementById('modalStudentName').textContent = student.nama;
        document.getElementById('modalStudentNis').textContent = `NIS: ${nis} • Cabang ${student.cabang || 'RGI Depok'} • Angkatan ${student.angkatan || '35'}`;
        document.getElementById('modalStudentClassLong').textContent = student.kelas;

        // Badge Jurusan & Predikat
        const classBadge = document.getElementById('modalStudentClassBadge');
        classBadge.textContent = student.kelas;
        classBadge.className = `px-2.5 py-0.5 text-3xs font-bold rounded-lg uppercase tracking-wider text-white ${theme.bgClass}`;

        const predikatBadge = document.getElementById('modalPredikatBadge');
        predikatBadge.textContent = `Predikat ${pred.grade} • ${pred.text}`;

        // Nilai Ringkasan 3 Kolom
        document.getElementById('modalNilaiAkhir').textContent = parseFloat(student.rata_rata).toFixed(2);
        const academicAvg = student.rata_akademik || ((parseFloat(student.tauhid) + parseFloat(student.fiqih) + parseFloat(student.b_ing) + parseFloat(student.menulis_kreatif)) / 4);
        document.getElementById('modalRataAkademik').textContent = parseFloat(academicAvg).toFixed(2);
        document.getElementById('modalNilaiAdab').textContent = parseFloat(student.adab_akhlaq).toFixed(2);

        // Nilai 4 Mapel
        document.getElementById('modalScoreTauhid').textContent = student.tauhid;
        updateStatusBadge('modalStatusTauhid', student.tauhid, 75);

        document.getElementById('modalScoreFiqih').textContent = student.fiqih;
        updateStatusBadge('modalStatusFiqih', student.fiqih, 75);

        document.getElementById('modalScoreBing').textContent = student.b_ing;
        updateStatusBadge('modalStatusBing', student.b_ing, 75);

        document.getElementById('modalScoreMenulis').textContent = student.menulis_kreatif;
        updateStatusBadge('modalStatusMenulis', student.menulis_kreatif, 75);

        // Adab & Kehadiran Text
        const adabDesc = student.adab_akhlaq >= 85 ? 'Sangat Terpuji' : (student.adab_akhlaq >= 80 ? 'Baik' : 'Cukup');
        document.getElementById('modalTextAdab').textContent = `${student.adab_akhlaq} (${adabDesc})`;
        document.getElementById('modalTextKehadiran').textContent = `${student.kehadiran}% Kehadiran`;

        // Warning Box Absen > 3x
        const warningBox = document.getElementById('modalAbsenWarningBox');
        const warningText = document.getElementById('modalAbsenWarningText');
        const absenBadge = document.getElementById('modalAbsenBadge');

        if (totalAbsen > 3) {
            warningBox.classList.remove('hidden');
            warningText.textContent = `Perhatian: Santri ini tercatat telah tidak hadir/absen sebanyak ${totalAbsen} kali (> 3x batas evaluasi). Diperlukan pembinaan instruktur dan komunikasi dengan wali santri.`;
            absenBadge.textContent = `Peringatan: Absen ${totalAbsen}x`;
            absenBadge.className = 'text-3xs font-bold text-amber-700 px-2 py-0.5 rounded bg-amber-100 border border-amber-300';
        } else {
            warningBox.classList.add('hidden');
            absenBadge.textContent = student.kehadiran >= 90 ? 'Disiplin Baik' : 'Cukup';
            absenBadge.className = 'text-3xs font-bold text-emerald-700 px-2 py-0.5 rounded bg-white border border-emerald-200';
        }

        // Link Edit Nilai
        document.getElementById('btnModalEditGrade').href = `<?= base_url('instruktur/nilai'); ?>?search=${encodeURIComponent(student.nama)}`;

        // Tampilkan Modal
        const modal = document.getElementById('studentDetailModal');
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    // Helper update status badge KKM
    function updateStatusBadge(elementId, score, kkm) {
        const el = document.getElementById(elementId);
        if (!el) return;
        if (parseFloat(score) >= kkm) {
            el.textContent = 'Tuntas';
            el.className = 'px-2 py-0.5 rounded-full text-3xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200';
        } else {
            el.textContent = 'Remedial';
            el.className = 'px-2 py-0.5 rounded-full text-3xs font-bold bg-amber-50 text-amber-700 border border-amber-200';
        }
    }

    // Tutup Modal
    function closeStudentModal() {
        const modal = document.getElementById('studentDetailModal');
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    // Salin Ringkasan Nilai
    function copyStudentReport() {
        if (!currentSelectedStudent) return;
        const s = currentSelectedStudent;
        const pred = getPredikat(parseFloat(s.rata_rata));
        const nis = s.nis || `SG-2026-${String(s.id).padStart(3, '0')}`;

        const report = `====================================
RAPORT SINGKAT SANTRI SYIAR GEMILANG
Lembaga Pendidikan E-RGI
====================================
Nama Santri : ${s.nama}
NIS         : ${nis}
Jurusan     : ${s.kelas}

Rincian Nilai 4 Mapel Pokok (Bobot 80%):
- Tauhid & Aqidah   : ${s.tauhid} (KKM 75)
- Fiqih Ibadah      : ${s.fiqih} (KKM 75)
- Bahasa Inggris    : ${s.b_ing} (KKM 75)
- Menulis Kreatif   : ${s.menulis_kreatif} (KKM 75)

Karakter & Presensi:
- Adab & Akhlaq     : ${s.adab_akhlaq} (Bobot 20%)
- Tingkat Kehadiran : ${s.kehadiran}%
------------------------------------
NILAI AKHIR TERBOBOT: ${parseFloat(s.rata_rata).toFixed(2)}
PREDIKAT            : Predikat ${pred.grade} (${pred.text})
====================================`;

        const textarea = document.createElement('textarea');
        textarea.value = report;
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand('copy');
        document.body.removeChild(textarea);

        showToast(`Rincian raport santri ${s.nama} berhasil disalin!`);
    }

    // Toast Notification
    function showToast(message) {
        const toast = document.getElementById('toastNotification');
        const toastMsg = document.getElementById('toastMessage');

        toastMsg.textContent = message;
        toast.classList.remove('hidden');

        setTimeout(() => {
            toast.classList.add('hidden');
        }, 3000);
    }
</script>

</body>
</html>
