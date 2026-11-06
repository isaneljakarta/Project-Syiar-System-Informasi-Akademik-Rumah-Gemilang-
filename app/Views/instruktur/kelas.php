<?php require_once 'navbar.php'; ?>

<style>
    /* Halus dan nyaman saat scrolling */
    html {
        scroll-behavior: smooth;
    }
    
    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 7px;
        height: 7px;
    }
    ::-webkit-scrollbar-track {
        background: #f1f5f9;
    }
    ::-webkit-scrollbar-thumb {
        background: #94a3b8;
        border-radius: 9999px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: #64748b;
    }

    /* Wave Background Generator Adopsi Konsep E-RGI */
    .hero-wave-pattern {
        background-color: #073B66;
        background-image: 
            radial-gradient(at 15% 20%, rgba(255, 255, 255, 0.18) 0px, transparent 50%),
            radial-gradient(at 85% 75%, rgba(0, 102, 204, 0.45) 0px, transparent 60%),
            linear-gradient(135deg, #073B66 0%, #0066CC 50%, #003E7E 100%);
    }

    /* Card Hover Lift Effect */
    .instructor-card {
        transition: all 0.28s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .instructor-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 30px -8px rgba(0, 102, 204, 0.18);
    }

    /* Modal Animation */
    .modal-backdrop {
        transition: opacity 0.25s ease-out;
    }
    .modal-box {
        transition: transform 0.25s ease-out, opacity 0.25s ease-out;
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
    $page_title = $title ?? 'Data Nilai per Kelas';
    ob_start();
    ?>
    <a href="<?= base_url('instruktur/nilai'); ?>" class="inline-flex px-3 py-1.5 bg-[#0066CC] hover:bg-[#0052A3] text-white rounded-xl text-xs font-bold shadow-xs transition items-center gap-1.5">
        <i class="fa-solid fa-pen-to-square"></i> <span class="hidden sm:inline">Input / Update Nilai</span><span class="sm:hidden">Nilai</span>
    </a>
    <?php
    $topbar_extra_right = ob_get_clean();
    require_once __DIR__ . '/components/topbar.php'; 
    ?>

    <!-- Main Scrollable Area -->
    <main class="flex-1 overflow-y-auto pb-16">

        <!-- ================= HERO WAVE BANNER (E-RGI STYLE) ================= -->
        <?php
        $hero = [
            'breadcrumb' => [
                ['label' => 'Portal Instruktur', 'url' => base_url('instruktur')],
                ['label' => 'Pemisah Nilai per Kelas']
            ],
            'badge' => 'Lembaga Pendidikan E-RGI Syiar Gemilang',
            'title' => 'Pemisah & Analisis Nilai per Kelas',
            'subtitle' => 'Pemisah informasi capaian nilai santri berdasarkan 6 kelas kejuruan terdaftar. Analisis komprehensif performa 4 mata pelajaran utama serta integrasi bobot 20% adab & akhlaq karimah.',
            'stats' => [
                ['icon' => 'fa-solid fa-users', 'bg' => 'bg-sky-400/20 text-sky-200', 'value' => $total_siswa, 'label' => 'Santri Terdaftar'],
                ['icon' => 'fa-solid fa-layer-group', 'bg' => 'bg-emerald-400/20 text-emerald-200', 'value' => $total_kelas, 'label' => 'Kelas Kejuruan'],
                ['icon' => 'fa-solid fa-chart-line', 'bg' => 'bg-amber-400/20 text-amber-200', 'value' => $rata_rata, 'label' => 'Rata-rata Nilai'],
            ]
        ];
        require_once __DIR__ . '/components/hero_header.php';
        ?>

        <!-- ================= CARD UNTUK 4 MAPEL YANG ADA (+ ADAB 20%) ================= -->
        <section class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 mt-6 sm:mt-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-2 mb-4">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-6 rounded-full bg-[#0066CC] inline-block"></span>
                        <h2 class="text-lg sm:text-xl font-bold text-[#1E293B] tracking-tight sg-display">
                            4 Mata Pelajaran Utama & Penilaian Karakter
                        </h2>
                    </div>
                    <p class="text-xs text-slate-500 mt-0.5 ml-4">
                        Pilar keilmuan wajib seluruh santri: 4 Mapel Akademik (Bobot 80%) dan Adab & Akhlaq (Bobot 20%).
                    </p>
                </div>
                <span class="text-2xs font-bold text-slate-600 bg-white border border-[#E2E8F0] px-3 py-1 rounded-full self-start sm:self-auto shadow-2xs">
                    Standar KKM: 75 / 100 (Adab: 80)
                </span>
            </div>

            <!-- Grid 4 Mapel Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
                
                <!-- Mapel 1: Tauhid -->
                <?php $tauhid = $mapel_stats['tauhid']; ?>
                <div class="instructor-card bg-white rounded-xl sm:rounded-2xl border border-[#E2E8F0] overflow-hidden flex flex-col justify-between group shadow-xs">
                    <div>
                        <div class="relative h-32 sm:h-36 w-full bg-slate-100 overflow-hidden">
                            <img src="<?= esc($tauhid['cover']); ?>" alt="<?= esc($tauhid['nama']); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-black/30 to-black/20"></div>
                            <div class="absolute top-3 left-3 right-3 flex items-center justify-between">
                                <span class="px-2.5 py-1 rounded-lg text-2xs font-bold bg-emerald-600 text-white shadow-sm uppercase tracking-wider">
                                    <i class="fa-solid fa-book-quran mr-1"></i> <?= esc($tauhid['short']); ?>
                                </span>
                                <span class="px-2 py-0.5 rounded-md text-3xs font-bold bg-white/90 text-slate-800 backdrop-blur-xs">
                                    KKM <?= esc($tauhid['kkm']); ?>
                                </span>
                            </div>
                            <div class="absolute bottom-2.5 left-3 right-3 text-white flex items-center justify-between text-2xs">
                                <span class="font-semibold truncate drop-shadow-sm"><i class="fa-regular fa-clock mr-1"></i> <?= esc($tauhid['jadwal']); ?></span>
                            </div>
                        </div>

                        <div class="p-4">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm font-bold shrink-0 border border-emerald-200">
                                    <i class="fa-solid fa-chalkboard-user"></i>
                                </div>
                                <div class="overflow-hidden">
                                    <h4 class="text-xs font-bold text-slate-800 truncate"><?= esc($tauhid['pengampu']); ?></h4>
                                    <span class="text-3xs text-emerald-600 font-semibold block truncate">Pengampu Tauhid</span>
                                </div>
                            </div>
                            <h3 class="font-bold text-slate-900 text-sm leading-snug group-hover:text-emerald-700 transition">
                                <?= esc($tauhid['nama']); ?>
                            </h3>
                            <p class="text-2xs text-slate-500 mt-1 line-clamp-2 leading-relaxed">
                                <?= esc($tauhid['deskripsi']); ?>
                            </p>
                        </div>
                    </div>

                    <div class="p-4 pt-0 border-t border-slate-100 bg-slate-50/50">
                        <div class="grid grid-cols-3 gap-2 text-center py-2.5 my-1">
                            <div>
                                <span class="text-3xs text-slate-400 block font-medium">Rata-Rata</span>
                                <span class="text-sm font-bold text-emerald-600"><?= esc($tauhid['rata_rata']); ?></span>
                            </div>
                            <div class="border-x border-slate-200">
                                <span class="text-3xs text-slate-400 block font-medium">Tertinggi</span>
                                <span class="text-sm font-bold text-slate-700"><?= esc($tauhid['tertinggi']); ?></span>
                            </div>
                            <div>
                                <span class="text-3xs text-slate-400 block font-medium">Lulus</span>
                                <span class="text-sm font-bold text-emerald-600"><?= esc($tauhid['kelulusan']); ?>%</span>
                            </div>
                        </div>
                        <button onclick="openMapelModal('tauhid')" class="w-full py-2 bg-white hover:bg-emerald-600 text-emerald-700 hover:text-white border border-emerald-200 hover:border-transparent text-xs font-semibold rounded-xl transition flex items-center justify-center gap-1.5 shadow-2xs">
                            <i class="fa-solid fa-circle-info"></i> Detail Mapel Tauhid
                        </button>
                    </div>
                </div>

                <!-- Mapel 2: Fiqih -->
                <?php $fiqih = $mapel_stats['fiqih']; ?>
                <div class="instructor-card bg-white rounded-xl sm:rounded-2xl border border-[#E2E8F0] overflow-hidden flex flex-col justify-between group shadow-xs">
                    <div>
                        <div class="relative h-32 sm:h-36 w-full bg-slate-100 overflow-hidden">
                            <img src="<?= esc($fiqih['cover']); ?>" alt="<?= esc($fiqih['nama']); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-black/30 to-black/20"></div>
                            <div class="absolute top-3 left-3 right-3 flex items-center justify-between">
                                <span class="px-2.5 py-1 rounded-lg text-2xs font-bold bg-[#0066CC] text-white shadow-sm uppercase tracking-wider">
                                    <i class="fa-solid fa-hands-praying mr-1"></i> <?= esc($fiqih['short']); ?>
                                </span>
                                <span class="px-2 py-0.5 rounded-md text-3xs font-bold bg-white/90 text-slate-800 backdrop-blur-xs">
                                    KKM <?= esc($fiqih['kkm']); ?>
                                </span>
                            </div>
                            <div class="absolute bottom-2.5 left-3 right-3 text-white flex items-center justify-between text-2xs">
                                <span class="font-semibold truncate drop-shadow-sm"><i class="fa-regular fa-clock mr-1"></i> <?= esc($fiqih['jadwal']); ?></span>
                            </div>
                        </div>

                        <div class="p-4">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="w-8 h-8 rounded-full bg-blue-100 text-[#0066CC] flex items-center justify-center text-sm font-bold shrink-0 border border-blue-200">
                                    <i class="fa-solid fa-chalkboard-user"></i>
                                </div>
                                <div class="overflow-hidden">
                                    <h4 class="text-xs font-bold text-slate-800 truncate"><?= esc($fiqih['pengampu']); ?></h4>
                                    <span class="text-3xs text-[#0066CC] font-semibold block truncate">Pengampu Fiqih</span>
                                </div>
                            </div>
                            <h3 class="font-bold text-slate-900 text-sm leading-snug group-hover:text-[#0066CC] transition">
                                <?= esc($fiqih['nama']); ?>
                            </h3>
                            <p class="text-2xs text-slate-500 mt-1 line-clamp-2 leading-relaxed">
                                <?= esc($fiqih['deskripsi']); ?>
                            </p>
                        </div>
                    </div>

                    <div class="p-4 pt-0 border-t border-slate-100 bg-slate-50/50">
                        <div class="grid grid-cols-3 gap-2 text-center py-2.5 my-1">
                            <div>
                                <span class="text-3xs text-slate-400 block font-medium">Rata-Rata</span>
                                <span class="text-sm font-bold text-[#0066CC]"><?= esc($fiqih['rata_rata']); ?></span>
                            </div>
                            <div class="border-x border-slate-200">
                                <span class="text-3xs text-slate-400 block font-medium">Tertinggi</span>
                                <span class="text-sm font-bold text-slate-700"><?= esc($fiqih['tertinggi']); ?></span>
                            </div>
                            <div>
                                <span class="text-3xs text-slate-400 block font-medium">Lulus</span>
                                <span class="text-sm font-bold text-[#0066CC]"><?= esc($fiqih['kelulusan']); ?>%</span>
                            </div>
                        </div>
                        <button onclick="openMapelModal('fiqih')" class="w-full py-2 bg-white hover:bg-[#0066CC] text-[#0066CC] hover:text-white border border-[#0066CC]/30 hover:border-transparent text-xs font-semibold rounded-xl transition flex items-center justify-center gap-1.5 shadow-2xs">
                            <i class="fa-solid fa-circle-info"></i> Detail Mapel Fiqih
                        </button>
                    </div>
                </div>

                <!-- Mapel 3: Bahasa Inggris -->
                <?php $bing = $mapel_stats['b_ing']; ?>
                <div class="instructor-card bg-white rounded-xl sm:rounded-2xl border border-[#E2E8F0] overflow-hidden flex flex-col justify-between group shadow-xs">
                    <div>
                        <div class="relative h-32 sm:h-36 w-full bg-slate-100 overflow-hidden">
                            <img src="<?= esc($bing['cover']); ?>" alt="<?= esc($bing['nama']); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-black/30 to-black/20"></div>
                            <div class="absolute top-3 left-3 right-3 flex items-center justify-between">
                                <span class="px-2.5 py-1 rounded-lg text-2xs font-bold bg-indigo-600 text-white shadow-sm uppercase tracking-wider">
                                    <i class="fa-solid fa-language mr-1"></i> <?= esc($bing['short']); ?>
                                </span>
                                <span class="px-2 py-0.5 rounded-md text-3xs font-bold bg-white/90 text-slate-800 backdrop-blur-xs">
                                    KKM <?= esc($bing['kkm']); ?>
                                </span>
                            </div>
                            <div class="absolute bottom-2.5 left-3 right-3 text-white flex items-center justify-between text-2xs">
                                <span class="font-semibold truncate drop-shadow-sm"><i class="fa-regular fa-clock mr-1"></i> <?= esc($bing['jadwal']); ?></span>
                            </div>
                        </div>

                        <div class="p-4">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center text-sm font-bold shrink-0 border border-indigo-200">
                                    <i class="fa-solid fa-chalkboard-user"></i>
                                </div>
                                <div class="overflow-hidden">
                                    <h4 class="text-xs font-bold text-slate-800 truncate"><?= esc($bing['pengampu']); ?></h4>
                                    <span class="text-3xs text-indigo-600 font-semibold block truncate">Pengampu B. Inggris</span>
                                </div>
                            </div>
                            <h3 class="font-bold text-slate-900 text-sm leading-snug group-hover:text-indigo-700 transition">
                                <?= esc($bing['nama']); ?>
                            </h3>
                            <p class="text-2xs text-slate-500 mt-1 line-clamp-2 leading-relaxed">
                                <?= esc($bing['deskripsi']); ?>
                            </p>
                        </div>
                    </div>

                    <div class="p-4 pt-0 border-t border-slate-100 bg-slate-50/50">
                        <div class="grid grid-cols-3 gap-2 text-center py-2.5 my-1">
                            <div>
                                <span class="text-3xs text-slate-400 block font-medium">Rata-Rata</span>
                                <span class="text-sm font-bold text-indigo-600"><?= esc($bing['rata_rata']); ?></span>
                            </div>
                            <div class="border-x border-slate-200">
                                <span class="text-3xs text-slate-400 block font-medium">Tertinggi</span>
                                <span class="text-sm font-bold text-slate-700"><?= esc($bing['tertinggi']); ?></span>
                            </div>
                            <div>
                                <span class="text-3xs text-slate-400 block font-medium">Lulus</span>
                                <span class="text-sm font-bold text-indigo-600"><?= esc($bing['kelulusan']); ?>%</span>
                            </div>
                        </div>
                        <button onclick="openMapelModal('b_ing')" class="w-full py-2 bg-white hover:bg-indigo-600 text-indigo-700 hover:text-white border border-indigo-200 hover:border-transparent text-xs font-semibold rounded-xl transition flex items-center justify-center gap-1.5 shadow-2xs">
                            <i class="fa-solid fa-circle-info"></i> Detail B. Inggris
                        </button>
                    </div>
                </div>

                <!-- Mapel 4: Menulis Kreatif -->
                <?php $menulis = $mapel_stats['menulis_kreatif']; ?>
                <div class="instructor-card bg-white rounded-xl sm:rounded-2xl border border-[#E2E8F0] overflow-hidden flex flex-col justify-between group shadow-xs">
                    <div>
                        <div class="relative h-32 sm:h-36 w-full bg-slate-100 overflow-hidden">
                            <img src="<?= esc($menulis['cover']); ?>" alt="<?= esc($menulis['nama']); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-black/30 to-black/20"></div>
                            <div class="absolute top-3 left-3 right-3 flex items-center justify-between">
                                <span class="px-2.5 py-1 rounded-lg text-2xs font-bold bg-amber-600 text-white shadow-sm uppercase tracking-wider">
                                    <i class="fa-solid fa-pen-fancy mr-1"></i> <?= esc($menulis['short']); ?>
                                </span>
                                <span class="px-2 py-0.5 rounded-md text-3xs font-bold bg-white/90 text-slate-800 backdrop-blur-xs">
                                    KKM <?= esc($menulis['kkm']); ?>
                                </span>
                            </div>
                            <div class="absolute bottom-2.5 left-3 right-3 text-white flex items-center justify-between text-2xs">
                                <span class="font-semibold truncate drop-shadow-sm"><i class="fa-regular fa-clock mr-1"></i> <?= esc($menulis['jadwal']); ?></span>
                            </div>
                        </div>

                        <div class="p-4">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="w-8 h-8 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center text-sm font-bold shrink-0 border border-amber-200">
                                    <i class="fa-solid fa-chalkboard-user"></i>
                                </div>
                                <div class="overflow-hidden">
                                    <h4 class="text-xs font-bold text-slate-800 truncate"><?= esc($menulis['pengampu']); ?></h4>
                                    <span class="text-3xs text-amber-600 font-semibold block truncate">Pengampu Menulis</span>
                                </div>
                            </div>
                            <h3 class="font-bold text-slate-900 text-sm leading-snug group-hover:text-amber-700 transition">
                                <?= esc($menulis['nama']); ?>
                            </h3>
                            <p class="text-2xs text-slate-500 mt-1 line-clamp-2 leading-relaxed">
                                <?= esc($menulis['deskripsi']); ?>
                            </p>
                        </div>
                    </div>

                    <div class="p-4 pt-0 border-t border-slate-100 bg-slate-50/50">
                        <div class="grid grid-cols-3 gap-2 text-center py-2.5 my-1">
                            <div>
                                <span class="text-3xs text-slate-400 block font-medium">Rata-Rata</span>
                                <span class="text-sm font-bold text-amber-600"><?= esc($menulis['rata_rata']); ?></span>
                            </div>
                            <div class="border-x border-slate-200">
                                <span class="text-3xs text-slate-400 block font-medium">Tertinggi</span>
                                <span class="text-sm font-bold text-slate-700"><?= esc($menulis['tertinggi']); ?></span>
                            </div>
                            <div>
                                <span class="text-3xs text-slate-400 block font-medium">Lulus</span>
                                <span class="text-sm font-bold text-amber-600"><?= esc($menulis['kelulusan']); ?>%</span>
                            </div>
                        </div>
                        <button onclick="openMapelModal('menulis_kreatif')" class="w-full py-2 bg-white hover:bg-amber-600 text-amber-700 hover:text-white border border-amber-200 hover:border-transparent text-xs font-semibold rounded-xl transition flex items-center justify-center gap-1.5 shadow-2xs">
                            <i class="fa-solid fa-circle-info"></i> Detail Menulis
                        </button>
                    </div>
                </div>

            </div>

            <!-- Adab & Akhlaq 20% Formula Strip -->
            <div class="mt-4 p-3.5 bg-gradient-to-r from-rose-50 via-white to-sky-50 rounded-xl sm:rounded-2xl border border-rose-200/80 shadow-2xs flex flex-col md:flex-row md:items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-rose-600 text-white flex items-center justify-center text-base shrink-0 shadow-sm">
                        <i class="fa-solid fa-heart-pulse"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h4 class="text-xs font-bold text-slate-800">Komponen Karakter: Adab & Akhlaq Santri</h4>
                            <span class="px-2 py-0.5 rounded-full text-3xs font-extrabold bg-rose-100 text-rose-700 border border-rose-300">
                                Bobot 20% Nilai Akhir
                            </span>
                        </div>
                        <p class="text-2xs text-slate-500 mt-0.5">
                            Rata-rata kumulatif adab santri saat ini: <strong class="text-rose-600"><?= esc($mapel_stats['adab_akhlaq']['rata_rata']); ?></strong>. Formula: <code class="text-3xs bg-white px-1.5 py-0.5 rounded border border-slate-200 text-slate-700">Nilai Akhir = (4 Mapel / 4 * 0.8) + (Adab * 0.2)</code>
                        </p>
                    </div>
                </div>
                <button onclick="openMapelModal('adab_akhlaq')" class="px-3.5 py-1.5 bg-rose-50 hover:bg-rose-600 text-rose-700 hover:text-white border border-rose-200 rounded-xl text-2xs font-bold transition shrink-0 self-start md:self-auto flex items-center gap-1">
                    <i class="fa-solid fa-chart-pie"></i> Detail Evaluasi Adab
                </button>
            </div>
        </section>

        <!-- ================= SEARCH & FILTER CONTROL BAR (E-RGI PILLS STYLE) ================= -->
        <section class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 mt-6 sm:mt-8">
            <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm border border-[#E2E8F0] p-4 sm:p-5">
                <div class="flex flex-col lg:flex-row gap-3 sm:gap-4 lg:items-center justify-between">
                    
                    <!-- Pencarian Input Cepat -->
                    <div class="relative flex-1">
                        <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input 
                            type="text" 
                            id="studentSearchInput" 
                            placeholder="Cari nama santri, kelas, nilai mapel..." 
                            class="w-full pl-11 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0066CC] focus:border-[#0066CC] transition placeholder:text-slate-400 text-slate-800"
                        >
                        <button id="clearSearchBtn" class="hidden absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 p-1">
                            <i class="fa-solid fa-xmark text-sm"></i>
                        </button>
                    </div>

                    <!-- Sorting & View Info -->
                    <div class="flex flex-wrap items-center gap-2 sm:gap-3 shrink-0">
                        <div class="flex items-center gap-1.5 text-xs text-slate-500">
                            <i class="fa-solid fa-arrow-down-wide-short text-slate-400"></i>
                            <span class="hidden sm:inline">Urutkan:</span>
                        </div>
                        <select id="sortBySelect" class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs sm:text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#0066CC] font-medium">
                            <option value="highest">Nilai Akhir Tertinggi</option>
                            <option value="lowest">Nilai Akhir Terendah</option>
                            <option value="name-asc">Nama Santri (A - Z)</option>
                            <option value="attendance">Kehadiran Tertinggi</option>
                        </select>

                        <!-- Toggle View Mode: Grid Kartu vs Tabel -->
                        <div class="flex items-center bg-slate-100 p-1 rounded-xl border border-slate-200">
                            <button id="viewGridBtn" onclick="setViewMode('grid')" title="Tampilan Kartu Grid" class="px-2.5 py-1.5 rounded-lg text-xs font-semibold bg-white text-[#0066CC] shadow-xs transition">
                                <i class="fa-solid fa-table-cells-large"></i>
                            </button>
                            <button id="viewTableBtn" onclick="setViewMode('table')" title="Tampilan Tabel Rekap" class="px-2.5 py-1.5 rounded-lg text-xs font-semibold text-slate-500 hover:text-slate-800 transition">
                                <i class="fa-solid fa-list-ul"></i>
                            </button>
                        </div>

                        <!-- Tombol Reset Filter -->
                        <button 
                            id="resetFilterBtn" 
                            onclick="resetAllFilters()"
                            class="px-3 py-2 text-xs sm:text-sm text-slate-600 hover:text-[#0066CC] hover:bg-slate-100 rounded-xl transition flex items-center gap-1.5 font-medium border border-transparent hover:border-slate-200"
                            title="Reset Semua Filter"
                        >
                            <i class="fa-solid fa-rotate-left text-xs"></i>
                            <span class="hidden sm:inline">Reset</span>
                        </button>
                    </div>

                </div>

                <!-- Kategori Kelas Filter Pills (Pemisah Informasi Nilai Per Kelas) -->
                <!-- WARNA JURUSAN: Desain G=Merah, TKJ=Hijau, AP=Oren, Tata Busana=Kuning, Otomotif=Hitam, FV=Biru -->
                <div class="mt-4 pt-3.5 border-t border-slate-100">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-2xs font-bold text-slate-400 uppercase tracking-wider flex items-center gap-1">
                            <i class="fa-solid fa-filter text-[#0066CC]"></i> Pemisah Berdasarkan Kelas Kejuruan:
                        </span>
                        <span class="text-3xs text-slate-400" id="filterStatusLabel">Menampilkan Semua Kelas</span>
                    </div>

                    <div class="flex items-center gap-2 overflow-x-auto pb-1.5 no-scrollbar text-xs font-semibold" id="classFilterContainer">
                        <button onclick="filterClass('ALL')" class="class-pill active-pill px-3.5 py-2 rounded-xl transition whitespace-nowrap bg-[#0066CC] text-white shadow-sm shadow-[#0066CC]/20" data-class="ALL">
                            <i class="fa-solid fa-border-all mr-1.5"></i>Semua Kelas (<?= esc($total_siswa); ?>)
                        </button>
                        <button onclick="filterClass('Teknik Komputer dan Jaringan')" class="class-pill px-3.5 py-2 rounded-xl transition whitespace-nowrap bg-slate-100 text-slate-600 hover:bg-emerald-50 hover:text-emerald-700" data-class="Teknik Komputer dan Jaringan">
                            <i class="fa-solid fa-network-wired mr-1.5 text-emerald-600"></i>TKJ (Hijau)
                        </button>
                        <button onclick="filterClass('Tata Busana')" class="class-pill px-3.5 py-2 rounded-xl transition whitespace-nowrap bg-slate-100 text-slate-600 hover:bg-yellow-50 hover:text-yellow-800" data-class="Tata Busana">
                            <i class="fa-solid fa-scissors mr-1.5 text-yellow-600"></i>Tata Busana (Kuning)
                        </button>
                        <button onclick="filterClass('Fotografi dan Videografi')" class="class-pill px-3.5 py-2 rounded-xl transition whitespace-nowrap bg-slate-100 text-slate-600 hover:bg-blue-50 hover:text-blue-700" data-class="Fotografi dan Videografi">
                            <i class="fa-solid fa-camera mr-1.5 text-blue-600"></i>Fotografi & Video (Biru)
                        </button>
                        <button onclick="filterClass('Desain Grafis')" class="class-pill px-3.5 py-2 rounded-xl transition whitespace-nowrap bg-slate-100 text-slate-600 hover:bg-red-50 hover:text-red-700" data-class="Desain Grafis">
                            <i class="fa-solid fa-palette mr-1.5 text-red-600"></i>Desain Grafis (Merah)
                        </button>
                        <button onclick="filterClass('Otomotif')" class="class-pill px-3.5 py-2 rounded-xl transition whitespace-nowrap bg-slate-100 text-slate-600 hover:bg-slate-200 hover:text-slate-900" data-class="Otomotif">
                            <i class="fa-solid fa-wrench mr-1.5 text-slate-900"></i>Otomotif (Hitam)
                        </button>
                        <button onclick="filterClass('Aplikasi Perkantoran')" class="class-pill px-3.5 py-2 rounded-xl transition whitespace-nowrap bg-slate-100 text-slate-600 hover:bg-orange-50 hover:text-orange-700" data-class="Aplikasi Perkantoran">
                            <i class="fa-solid fa-file-excel mr-1.5 text-orange-600"></i>Aplikasi Perkantoran (Oren)
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- ================= PEMISAH DIREKTORI KELAS (6 KELAS CARDS E-RGI STYLE) ================= -->
        <section class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 mt-6 sm:mt-8">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-6 rounded-full bg-[#073B66] inline-block"></span>
                    <h2 class="text-lg sm:text-xl font-bold text-[#1E293B] tracking-tight sg-display">
                        Direktori Nilai 6 Kelas Kejuruan
                    </h2>
                </div>
                <span class="text-2xs text-slate-400">Klik salah satu kartu kelas untuk filter langsung</span>
            </div>

            <!-- 6 Directory Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5">
                <?php foreach ($kelas_stats as $k): ?>
                <div onclick="filterClass('<?= esc($k['kelas']); ?>')" 
                     class="instructor-card cursor-pointer bg-white rounded-xl sm:rounded-2xl border border-[#E2E8F0] overflow-hidden flex flex-col justify-between group shadow-xs hover:border-[#0066CC] transition">
                    <div>
                        <!-- Header Cover -->
                        <div class="relative h-28 w-full bg-slate-100 overflow-hidden">
                            <img src="<?= esc($k['cover']); ?>" alt="<?= esc($k['kelas']); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-black/30 to-black/20"></div>
                            <div class="absolute top-2.5 left-3 right-3 flex items-center justify-between">
                                <span class="px-2.5 py-0.5 rounded-lg text-2xs font-bold <?= esc($k['badge_bg']); ?> text-white shadow-xs uppercase tracking-wider">
                                    <i class="fa-solid <?= esc($k['icon']); ?> mr-1"></i> <?= esc($k['code']); ?>
                                </span>
                                <span class="px-2 py-0.5 rounded-md text-3xs font-bold bg-white/90 text-slate-800">
                                    <?= esc($k['total_santri']); ?> Santri
                                </span>
                            </div>
                            <div class="absolute bottom-2 left-3 text-white text-xs font-bold drop-shadow-sm truncate">
                                <?= esc($k['short_name']); ?>
                            </div>
                        </div>

                        <!-- Body Info -->
                        <div class="p-4 pb-2">
                            <h3 class="text-sm font-bold text-[#1E293B] group-hover:text-[#0066CC] transition truncate">
                                <?= esc($k['kelas']); ?>
                            </h3>
                            <p class="text-2xs text-slate-500 mt-0.5 line-clamp-2 leading-relaxed">
                                <?= esc($k['desc']); ?>
                            </p>

                            <!-- Mini 4 Mapel Scores Preview -->
                            <div class="mt-3 grid grid-cols-4 gap-1 text-center bg-slate-50 p-2 rounded-xl border border-slate-100">
                                <div>
                                    <span class="text-3xs text-slate-400 block">Tauhid</span>
                                    <span class="text-xs font-bold text-slate-700"><?= esc($k['avg_tauhid']); ?></span>
                                </div>
                                <div>
                                    <span class="text-3xs text-slate-400 block">Fiqih</span>
                                    <span class="text-xs font-bold text-slate-700"><?= esc($k['avg_fiqih']); ?></span>
                                </div>
                                <div>
                                    <span class="text-3xs text-slate-400 block">B.Ing</span>
                                    <span class="text-xs font-bold text-slate-700"><?= esc($k['avg_bing']); ?></span>
                                </div>
                                <div>
                                    <span class="text-3xs text-slate-400 block">Menulis</span>
                                    <span class="text-xs font-bold text-slate-700"><?= esc($k['avg_menulis']); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Stats & Select Button -->
                    <div class="p-4 pt-2 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between">
                        <div>
                            <span class="text-3xs text-slate-400 block font-medium">Rata-Rata Kelas</span>
                            <span class="text-base font-extrabold text-[#0066CC]"><?= esc($k['avg_akhir']); ?></span>
                            <span class="text-3xs text-emerald-600 ml-1 font-semibold">(Hadir: <?= esc($k['avg_kehadiran']); ?>%)</span>
                        </div>
                        <button class="px-3 py-1.5 rounded-xl bg-white group-hover:bg-[#0066CC] text-[#0066CC] group-hover:text-white border border-[#0066CC]/30 text-2xs font-bold transition flex items-center gap-1.5 shadow-2xs">
                            <span>Buka Kelas</span>
                            <i class="fa-solid fa-arrow-right text-3xs"></i>
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- ================= DAFTAR RINCIAN NILAI SANTRI (CARDS / TABLE VIEW) ================= -->
        <section class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 mt-6 sm:mt-8">
            
            <!-- Filter Status & Counter -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-5">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-6 rounded-full bg-[#0066CC] inline-block"></span>
                    <h2 class="text-lg sm:text-xl font-bold text-[#1E293B] tracking-tight sg-display">
                        Daftar Capaian Nilai Santri
                    </h2>
                    <span class="text-xs font-bold bg-brand-light text-brand px-2.5 py-0.5 rounded-full border border-brand-border">
                        <span id="displayedStudentsCount">0</span> Santri
                    </span>
                </div>
                <div class="text-xs text-slate-500 flex items-center gap-2">
                    <span class="inline-block w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>Status: <strong class="text-[#1E293B]" id="currentClassFilterName">Semua Kelas</strong></span>
                </div>
            </div>

            <!-- 1. GRID CARDS VIEW (Meniru Layout E-RGI Screenshot) -->
            <div id="studentsGridContainer" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                <!-- Populated by JavaScript -->
            </div>

            <!-- 2. TABLE VIEW (Alternatif Tabular) -->
            <div id="studentsTableContainer" class="hidden bg-white rounded-xl sm:rounded-2xl shadow-sm border border-[#E2E8F0] overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs min-w-[760px]">
                        <thead class="bg-slate-50 text-slate-500 border-b border-slate-200 uppercase tracking-wider text-3xs font-bold">
                            <tr>
                                <th class="py-3 px-4">No</th>
                                <th class="py-3 px-4">Santri</th>
                                <th class="py-3 px-4">Kelas Kejuruan</th>
                                <th class="py-3 px-3 text-center">Tauhid</th>
                                <th class="py-3 px-3 text-center">Fiqih</th>
                                <th class="py-3 px-3 text-center">B. Inggris</th>
                                <th class="py-3 px-3 text-center">Menulis</th>
                                <th class="py-3 px-3 text-center bg-rose-50/50 text-rose-700">Adab (20%)</th>
                                <th class="py-3 px-3 text-center bg-brand-light/50 text-brand">Nilai Akhir</th>
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
            <div id="emptyStudentState" class="hidden flex-col items-center justify-center py-16 px-4 text-center bg-white rounded-xl sm:rounded-2xl border border-dashed border-slate-300 my-4">
                <div class="w-16 h-16 rounded-2xl bg-sky-50 text-brand flex items-center justify-center text-2xl mb-4">
                    <i class="fa-solid fa-user-slash"></i>
                </div>
                <h3 class="text-base sm:text-lg font-bold text-slate-800">Santri Tidak Ditemukan</h3>
                <p class="text-xs sm:text-sm text-slate-500 max-w-sm mt-1 mb-5">
                    Tidak ada santri yang cocok dengan kata kunci pencarian atau filter kelas yang Anda pilih.
                </p>
                <button onclick="resetAllFilters()" class="px-4 py-2 bg-[#0066CC] hover:bg-[#0052A3] text-white rounded-xl text-xs font-semibold transition shadow-sm">
                    Kembalikan Semua Santri
                </button>
            </div>

        </section>

    </main>
</div>

<!-- ================= MODAL DETAIL SANTRI & RAPORT (E-RGI STYLE) ================= -->
<div id="studentDetailModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-3 sm:p-6 overflow-y-auto">
    <!-- Backdrop Blur -->
    <div id="studentModalBackdrop" class="modal-backdrop fixed inset-0 bg-slate-900/60 backdrop-blur-xs"></div>

    <!-- Modal Box Content -->
    <div class="modal-box relative bg-white w-full max-w-2xl rounded-2xl shadow-2xl overflow-hidden z-10 border border-slate-100 my-8">
        
        <!-- Modal Header Cover & Close Button -->
        <div id="modalCoverBg" class="h-32 sm:h-40 w-full bg-cover bg-center relative bg-[#073B66]">
            <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/40 to-black/20"></div>
            <button id="closeStudentModalBtn" onclick="closeStudentModal()" class="absolute top-4 right-4 w-9 h-9 rounded-full bg-black/40 hover:bg-black/70 text-white flex items-center justify-center backdrop-blur-xs transition cursor-pointer">
                <i class="fa-solid fa-xmark text-base"></i>
            </button>
            <div class="absolute bottom-4 left-6 right-6 flex items-end justify-between">
                <span id="modalStudentClassBadge" class="px-3 py-1 text-xs font-bold rounded-lg uppercase tracking-wider text-white shadow-sm bg-emerald-600">
                    TKJ
                </span>
                <span id="modalPredikatBadge" class="text-xs bg-white/20 backdrop-blur-md text-white px-3 py-1 rounded-md font-medium">
                    Predikat A
                </span>
            </div>
        </div>

        <!-- Modal Body -->
        <div class="px-4 sm:px-6 pb-6 pt-4">
            
            <!-- Avatar & Profile Header -->
            <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4 -mt-12 sm:-mt-14 mb-4">
                <div class="relative w-16 h-16 sm:w-20 sm:h-20 rounded-2xl border-4 border-white object-cover shadow-lg bg-white shrink-0 flex items-center justify-center text-xl sm:text-2xl font-bold text-brand ring-1 ring-slate-100" id="modalStudentAvatar">
                    AF
                </div>
                <div class="sm:pt-6">
                    <h2 id="modalStudentName" class="text-lg sm:text-xl font-bold text-slate-900 leading-tight">Nama Santri</h2>
                    <p id="modalStudentSubtitle" class="text-xs sm:text-sm font-semibold text-brand mt-0.5">Teknik Komputer dan Jaringan • NIS: SG-2026-001</p>
                </div>
            </div>

            <!-- Stats Counter 3-Columns -->
            <div class="grid grid-cols-3 gap-2 sm:gap-3 p-3 sm:p-3.5 bg-slate-50 rounded-xl border border-slate-100 text-center mb-5">
                <div>
                    <span class="block text-lg sm:text-xl font-extrabold text-[#0066CC]" id="modalNilaiAkhir">88.50</span>
                    <span class="text-3xs text-slate-500 font-medium">Nilai Terbobot</span>
                </div>
                <div class="border-x border-slate-200">
                    <span class="block text-lg sm:text-xl font-extrabold text-slate-800" id="modalRataAkademik">87.50</span>
                    <span class="text-3xs text-slate-500 font-medium">Akademik (80%)</span>
                </div>
                <div>
                    <span class="block text-lg sm:text-xl font-extrabold text-rose-600" id="modalNilaiAdab">92.00</span>
                    <span class="text-3xs text-slate-500 font-medium">Adab (20%)</span>
                </div>
            </div>

            <!-- Breakdown 4 Mapel + 1 Adab Progress Bars -->
            <div class="space-y-3">
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider flex items-center gap-1.5">
                    <i class="fa-solid fa-chart-simple text-[#0066CC]"></i> Rincian Nilai Per Mata Pelajaran
                </h4>

                <!-- Tauhid -->
                <div class="p-2.5 sm:p-3 bg-slate-50 rounded-xl border border-slate-100">
                    <div class="flex items-center justify-between text-xs mb-1.5">
                        <span class="font-bold text-slate-700 flex items-center gap-1.5 truncate">
                            <i class="fa-solid fa-book-quran text-emerald-600"></i> Tauhid (Ust. Kamal Malawi)
                        </span>
                        <span class="font-extrabold text-emerald-600 shrink-0 ml-2" id="modalScoreTauhid">89 / 100</span>
                    </div>
                    <div class="w-full bg-slate-200 h-2 rounded-full overflow-hidden">
                        <div id="modalBarTauhid" class="bg-emerald-500 h-full rounded-full transition-all duration-500" style="width: 89%;"></div>
                    </div>
                </div>

                <!-- Fiqih -->
                <div class="p-2.5 sm:p-3 bg-slate-50 rounded-xl border border-slate-100">
                    <div class="flex items-center justify-between text-xs mb-1.5">
                        <span class="font-bold text-slate-700 flex items-center gap-1.5 truncate">
                            <i class="fa-solid fa-hands-praying text-[#0066CC]"></i> Fiqih (Usth. Yanni Susanti)
                        </span>
                        <span class="font-extrabold text-[#0066CC] shrink-0 ml-2" id="modalScoreFiqih">90 / 100</span>
                    </div>
                    <div class="w-full bg-slate-200 h-2 rounded-full overflow-hidden">
                        <div id="modalBarFiqih" class="bg-[#0066CC] h-full rounded-full transition-all duration-500" style="width: 90%;"></div>
                    </div>
                </div>

                <!-- B. Inggris -->
                <div class="p-2.5 sm:p-3 bg-slate-50 rounded-xl border border-slate-100">
                    <div class="flex items-center justify-between text-xs mb-1.5">
                        <span class="font-bold text-slate-700 flex items-center gap-1.5 truncate">
                            <i class="fa-solid fa-language text-indigo-600"></i> Bahasa Inggris (Mr. Alex Chandra)
                        </span>
                        <span class="font-extrabold text-indigo-600 shrink-0 ml-2" id="modalScoreBing">85 / 100</span>
                    </div>
                    <div class="w-full bg-slate-200 h-2 rounded-full overflow-hidden">
                        <div id="modalBarBing" class="bg-indigo-500 h-full rounded-full transition-all duration-500" style="width: 85%;"></div>
                    </div>
                </div>

                <!-- Menulis Kreatif -->
                <div class="p-2.5 sm:p-3 bg-slate-50 rounded-xl border border-slate-100">
                    <div class="flex items-center justify-between text-xs mb-1.5">
                        <span class="font-bold text-slate-700 flex items-center gap-1.5 truncate">
                            <i class="fa-solid fa-pen-fancy text-amber-600"></i> Menulis Kreatif (Ust. M. Syakir)
                        </span>
                        <span class="font-extrabold text-amber-600 shrink-0 ml-2" id="modalScoreMenulis">87 / 100</span>
                    </div>
                    <div class="w-full bg-slate-200 h-2 rounded-full overflow-hidden">
                        <div id="modalBarMenulis" class="bg-amber-500 h-full rounded-full transition-all duration-500" style="width: 87%;"></div>
                    </div>
                </div>

                <!-- Adab & Kehadiran Strip -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 pt-1">
                    <div class="p-3 bg-rose-50/70 rounded-xl border border-rose-100 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-heart-pulse text-rose-600"></i>
                            <div>
                                <span class="text-3xs text-slate-500 block">Adab & Akhlaq (20%)</span>
                                <span class="text-xs font-bold text-rose-700" id="modalTextAdab">92 (Sangat Baik)</span>
                            </div>
                        </div>
                        <span class="text-xs font-extrabold text-rose-600">20%</span>
                    </div>

                    <div class="p-3 bg-emerald-50/70 rounded-xl border border-emerald-100 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-clipboard-check text-emerald-600"></i>
                            <div>
                                <span class="text-3xs text-slate-500 block">Tingkat Kehadiran</span>
                                <span class="text-xs font-bold text-emerald-700" id="modalTextKehadiran">96% Hadir</span>
                            </div>
                        </div>
                        <span class="text-xs font-extrabold text-emerald-600">Disiplin</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons Footer (WhatsApp button removed as requested) -->
            <div class="mt-5 pt-4 border-t border-slate-100 flex flex-wrap items-center justify-between gap-2.5">
                <div class="flex items-center gap-2">
                    <button id="btnCopyReport" onclick="copyStudentReport()" class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-medium flex items-center gap-1.5 transition cursor-pointer">
                        <i class="fa-regular fa-copy"></i> Salin Rincian Nilai
                    </button>
                    <a id="btnModalEditGrade" href="<?= base_url('instruktur/nilai'); ?>" class="px-3.5 py-2 rounded-xl bg-[#0066CC]/10 hover:bg-[#0066CC]/20 text-[#0066CC] text-xs font-semibold flex items-center gap-1.5 transition">
                        <i class="fa-solid fa-pen-to-square"></i> Update Nilai
                    </a>
                </div>
                <button onclick="closeStudentModal()" class="px-4 py-2 text-xs font-semibold text-slate-500 hover:text-slate-800 transition cursor-pointer">
                    Tutup
                </button>
            </div>

        </div>
    </div>
</div>

<!-- ================= MODAL DETAIL MATA PELAJARAN (MAPEL MODAL) ================= -->
<div id="mapelDetailModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-3 sm:p-6 overflow-y-auto">
    <!-- Backdrop Blur -->
    <div onclick="closeMapelModal()" class="modal-backdrop fixed inset-0 bg-slate-900/60 backdrop-blur-xs"></div>

    <div class="modal-box relative bg-white w-full max-w-xl rounded-2xl shadow-2xl overflow-hidden z-10 border border-slate-100 my-8">
        <div id="mapelModalCover" class="h-32 sm:h-36 w-full bg-cover bg-center relative bg-[#073B66]">
            <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/40 to-black/20"></div>
            <button onclick="closeMapelModal()" class="absolute top-4 right-4 w-9 h-9 rounded-full bg-black/40 hover:bg-black/70 text-white flex items-center justify-center backdrop-blur-xs transition cursor-pointer">
                <i class="fa-solid fa-xmark text-base"></i>
            </button>
            <div class="absolute bottom-3 left-6 right-6 flex items-end justify-between">
                <span id="mapelModalBadge" class="px-3 py-1 text-xs font-bold rounded-lg uppercase tracking-wider text-white shadow-sm bg-[#0066CC]">
                    MAPEL UTAMA
                </span>
                <span id="mapelModalKkm" class="text-xs bg-white/20 backdrop-blur-md text-white px-3 py-1 rounded-md font-medium">
                    KKM 75
                </span>
            </div>
        </div>

        <div class="p-4 sm:p-6">
            <div class="flex items-center gap-3 -mt-10 mb-4">
                <div class="w-14 h-14 rounded-2xl border-4 border-white bg-white shadow-md flex items-center justify-center text-xl text-brand ring-1 ring-slate-100" id="mapelModalIcon">
                    <i class="fa-solid fa-book"></i>
                </div>
                <div class="pt-4">
                    <h3 id="mapelModalTitle" class="text-lg font-bold text-slate-900 leading-tight">Nama Mata Pelajaran</h3>
                    <p id="mapelModalPengampu" class="text-xs font-semibold text-[#0066CC] mt-0.5">Pengampu: Ustadz</p>
                </div>
            </div>

            <p id="mapelModalDesc" class="text-xs text-slate-600 leading-relaxed mb-4">
                Deskripsi mata pelajaran...
            </p>

            <div class="grid grid-cols-3 gap-2 sm:gap-3 p-3 bg-slate-50 rounded-xl border border-slate-100 text-center mb-4">
                <div>
                    <span class="text-3xs text-slate-400 block font-medium">Rata-Rata</span>
                    <span class="text-base font-bold text-[#0066CC]" id="mapelModalAvg">85.0</span>
                </div>
                <div class="border-x border-slate-200">
                    <span class="text-3xs text-slate-400 block font-medium">Tertinggi</span>
                    <span class="text-base font-bold text-slate-800" id="mapelModalMax">98</span>
                </div>
                <div>
                    <span class="text-3xs text-slate-400 block font-medium">Kelulusan</span>
                    <span class="text-base font-bold text-emerald-600" id="mapelModalPass">100%</span>
                </div>
            </div>

            <div class="space-y-2 mb-4 text-xs text-slate-600">
                <div class="flex items-center gap-2 p-2.5 rounded-lg bg-sky-50 text-sky-800 border border-sky-100">
                    <i class="fa-regular fa-clock text-[#0066CC]"></i>
                    <span>Jadwal: <strong id="mapelModalSchedule">Senin (07:00 - 09:00 WIB)</strong></span>
                </div>
                <div class="flex items-center gap-2 p-2.5 rounded-lg bg-slate-50 text-slate-700 border border-slate-200">
                    <i class="fa-solid fa-location-dot text-slate-500"></i>
                    <span>Lokasi: <strong id="mapelModalRoom">Aula Serbaguna RGI</strong></span>
                </div>
            </div>

            <div class="mb-5">
                <h5 class="text-3xs font-bold text-slate-400 uppercase tracking-wider mb-2">Fokus Materi & Kompetensi:</h5>
                <div id="mapelModalTags" class="flex flex-wrap gap-1.5">
                    <!-- Tags -->
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                <span class="text-3xs text-slate-400">Syiar Gemilang LMS E-RGI</span>
                <button onclick="closeMapelModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition cursor-pointer">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ================= FLOATING TOAST NOTIFICATION ================= -->
<div id="toastNotification" class="fixed bottom-6 right-6 z-50 hidden bg-slate-900 text-white text-xs sm:text-sm px-4 py-3 rounded-xl shadow-xl flex items-center gap-3 border border-slate-700 transition transform duration-200">
    <i class="fa-solid fa-circle-check text-emerald-400 text-base"></i>
    <span id="toastMessage">Pemberitahuan berhasil</span>
</div>

<!-- ================= JAVASCRIPT LOGIC ================= -->
<script>
    // DATA DARI SERVER PHP CODEIGNITER
    const studentsData = <?= json_encode($data_siswa); ?>;
    const mapelStatsData = <?= json_encode($mapel_stats); ?>;
    const classStatsData = <?= json_encode($kelas_stats); ?>;

    // State Aplikasi
    let currentClass = 'ALL';
    let searchQuery = '';
    let currentSort = 'highest';
    let currentViewMode = 'grid'; // 'grid' atau 'table'
    let currentSelectedStudent = null;

    // Helper Warna Jurusan Resmi:
    // Desain G: Merah, TKJ: Hijau, AP: Oren, Tata Busana: Kuning, Otomotif: Hitam, FV: Biru
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

    // Helper Predikat Nilai
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

    // Inisialisasi Event Listener
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
                closeMapelModal();
            }
        });
        document.getElementById('studentModalBackdrop').addEventListener('click', closeStudentModal);
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

    // Filter Berdasarkan Kelas (Pemisah Kelas)
    function filterClass(className) {
        currentClass = className;

        // Update pills
        const pills = document.querySelectorAll('.class-pill');
        pills.forEach(pill => {
            if (pill.getAttribute('data-class') === className) {
                pill.className = "class-pill active-pill px-3.5 py-2 rounded-xl transition whitespace-nowrap bg-[#0066CC] text-white shadow-sm shadow-[#0066CC]/20";
            } else {
                pill.className = "class-pill px-3.5 py-2 rounded-xl transition whitespace-nowrap bg-slate-100 text-slate-600 hover:bg-slate-200";
            }
        });

        // Update label
        const statusLabel = document.getElementById('filterStatusLabel');
        const curClassLabel = document.getElementById('currentClassFilterName');
        if (className === 'ALL') {
            statusLabel.textContent = "Menampilkan Semua Kelas";
            curClassLabel.textContent = "Semua Kelas";
        } else {
            statusLabel.textContent = `Pemisah Aktif: Kelas ${className}`;
            curClassLabel.textContent = className;
        }

        renderStudents();
        showToast(`Memfilter tampilan untuk: ${className === 'ALL' ? 'Semua Kelas' : className}`);
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

    // Render Santri ke Grid dan Tabel
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

            return `
                <div class="instructor-card bg-white rounded-xl sm:rounded-2xl border border-[#E2E8F0] overflow-hidden flex flex-col justify-between group shadow-xs">
                    
                    <!-- Cover Header -->
                    <div>
                        <div class="relative h-28 w-full bg-slate-800 overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-tr from-[#073B66] to-[#0066CC] opacity-90"></div>
                            
                            <!-- Jurusan & Predikat Badges -->
                            <div class="absolute top-2.5 left-2.5 right-2.5 flex items-center justify-between z-10">
                                <span class="px-2 py-0.5 rounded-lg text-3xs font-bold ${theme.bgClass} shadow-xs uppercase tracking-wider">
                                    ${theme.code}
                                </span>
                                <span class="px-2 py-0.5 rounded-md text-3xs font-bold bg-white/95 text-slate-800 shadow-2xs">
                                    Predikat ${pred.grade}
                                </span>
                            </div>

                            <div class="absolute bottom-2 right-2.5 text-3xs text-white/90 font-medium">
                                NIS: SG-2026-${String(s.id).padStart(3, '0')}
                            </div>
                        </div>

                        <!-- Avatar & Info -->
                        <div class="px-4 pb-3 relative">
                            <div class="-mt-7 mb-2 flex items-end justify-between">
                                <div class="w-14 h-14 rounded-full border-3 border-white bg-white shadow-md flex items-center justify-center font-bold text-base text-[#0066CC] ring-1 ring-slate-100">
                                    ${initials}
                                </div>
                                <span class="text-3xs font-semibold px-2 py-0.5 rounded-md border truncate max-w-[130px] ${theme.badge}">
                                    ${s.kelas}
                                </span>
                            </div>

                            <h3 class="font-bold text-slate-900 text-sm leading-snug group-hover:text-[#0066CC] transition line-clamp-1">
                                ${s.nama}
                            </h3>

                            <!-- 4 Mapel Chips Mini -->
                            <div class="mt-3 grid grid-cols-4 gap-1 text-center">
                                <div class="bg-slate-50 p-1 rounded-md border border-slate-100">
                                    <span class="text-3xs text-slate-400 block">Tauhid</span>
                                    <span class="text-xs font-bold text-slate-700">${s.tauhid}</span>
                                </div>
                                <div class="bg-slate-50 p-1 rounded-md border border-slate-100">
                                    <span class="text-3xs text-slate-400 block">Fiqih</span>
                                    <span class="text-xs font-bold text-slate-700">${s.fiqih}</span>
                                </div>
                                <div class="bg-slate-50 p-1 rounded-md border border-slate-100">
                                    <span class="text-3xs text-slate-400 block">B.Ing</span>
                                    <span class="text-xs font-bold text-slate-700">${s.b_ing}</span>
                                </div>
                                <div class="bg-slate-50 p-1 rounded-md border border-slate-100">
                                    <span class="text-3xs text-slate-400 block">Menulis</span>
                                    <span class="text-xs font-bold text-slate-700">${s.menulis_kreatif}</span>
                                </div>
                            </div>

                            <!-- Adab & Akhlaq strip -->
                            <div class="mt-2.5 flex items-center justify-between text-2xs p-1.5 rounded-lg bg-rose-50/70 border border-rose-100">
                                <span class="text-rose-700 font-semibold flex items-center gap-1">
                                    <i class="fa-solid fa-heart-pulse text-rose-500"></i> Adab (20%):
                                </span>
                                <span class="font-extrabold text-rose-700">${s.adab_akhlaq}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Footer: Final Score & Action -->
                    <div class="px-4 py-3 border-t border-slate-100 bg-slate-50/60">
                        <div class="flex items-center justify-between text-xs mb-2.5">
                            <div>
                                <span class="text-3xs text-slate-400 block font-medium">Nilai Akhir</span>
                                <span class="text-base font-extrabold text-[#0066CC]">${parseFloat(s.rata_rata).toFixed(2)}</span>
                            </div>
                            <div class="text-right">
                                <span class="text-3xs text-slate-400 block font-medium">Kehadiran</span>
                                <span class="text-xs font-bold text-emerald-600">${s.kehadiran}%</span>
                            </div>
                        </div>

                        <button onclick="openStudentModal(${s.id})" class="w-full py-1.5 px-3 bg-white hover:bg-[#0066CC] text-[#0066CC] hover:text-white border border-[#0066CC]/30 hover:border-transparent text-2xs font-semibold rounded-xl transition duration-200 flex items-center justify-center gap-1.5 shadow-2xs cursor-pointer">
                            <i class="fa-regular fa-clipboard"></i>
                            <span>Rincian Nilai & Raport</span>
                        </button>
                    </div>

                </div>
            `;
        }).join('');

        // 4. Render Table Rows
        tableBody.innerHTML = filtered.map((s, idx) => {
            const pred = getPredikat(parseFloat(s.rata_rata));
            const theme = getDepartmentTheme(s.kelas);

            return `
                <tr class="hover:bg-slate-50/80 transition">
                    <td class="py-3 px-4 font-semibold text-slate-400">${idx + 1}</td>
                    <td class="py-3 px-4">
                        <div class="font-bold text-slate-900">${s.nama}</div>
                        <div class="text-3xs text-slate-400">NIS: SG-2026-${String(s.id).padStart(3, '0')}</div>
                    </td>
                    <td class="py-3 px-4">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-3xs font-semibold border ${theme.badge}">
                            <span class="w-1.5 h-1.5 rounded-full ${theme.dot || 'bg-slate-400'}"></span>
                            ${s.kelas}
                        </span>
                    </td>
                    <td class="py-3 px-3 text-center font-semibold text-slate-700">${s.tauhid}</td>
                    <td class="py-3 px-3 text-center font-semibold text-slate-700">${s.fiqih}</td>
                    <td class="py-3 px-3 text-center font-semibold text-slate-700">${s.b_ing}</td>
                    <td class="py-3 px-3 text-center font-semibold text-slate-700">${s.menulis_kreatif}</td>
                    <td class="py-3 px-3 text-center font-bold text-rose-700 bg-rose-50/30">${s.adab_akhlaq}</td>
                    <td class="py-3 px-3 text-center font-extrabold text-[#0066CC] bg-brand-light/30">${parseFloat(s.rata_rata).toFixed(2)}</td>
                    <td class="py-3 px-3 text-center font-semibold text-emerald-600">${s.kehadiran}%</td>
                    <td class="py-3 px-4 text-center">
                        <button onclick="openStudentModal(${s.id})" class="px-2.5 py-1 bg-white hover:bg-[#0066CC] text-[#0066CC] hover:text-white border border-[#0066CC]/30 rounded-lg text-3xs font-bold transition cursor-pointer">
                            Rincian
                        </button>
                    </td>
                </tr>
            `;
        }).join('');
    }

    // Buka Modal Detail Santri
    function openStudentModal(id) {
        const student = studentsData.find(item => item.id == id);
        if (!student) return;

        currentSelectedStudent = student;
        const pred = getPredikat(parseFloat(student.rata_rata));
        const initials = student.nama.split(' ').map(n => n[0]).slice(0, 2).join('').toUpperCase();
        const theme = getDepartmentTheme(student.kelas);

        document.getElementById('modalStudentAvatar').textContent = initials;
        document.getElementById('modalStudentName').textContent = student.nama;
        document.getElementById('modalStudentSubtitle').textContent = `${student.kelas} • NIS: SG-2026-${String(student.id).padStart(3, '0')}`;
        
        const classBadge = document.getElementById('modalStudentClassBadge');
        classBadge.textContent = student.kelas;
        classBadge.className = `px-3 py-1 text-xs font-bold rounded-lg uppercase tracking-wider shadow-sm ${theme.bgClass}`;

        document.getElementById('modalPredikatBadge').textContent = `Predikat ${pred.grade} (${pred.text})`;

        // Stats
        document.getElementById('modalNilaiAkhir').textContent = parseFloat(student.rata_rata).toFixed(2);
        document.getElementById('modalRataAkademik').textContent = parseFloat(student.rata_akademik || ((student.tauhid + student.fiqih + student.b_ing + student.menulis_kreatif)/4)).toFixed(2);
        document.getElementById('modalNilaiAdab').textContent = parseFloat(student.adab_akhlaq).toFixed(2);

        // Scores
        document.getElementById('modalScoreTauhid').textContent = `${student.tauhid} / 100`;
        document.getElementById('modalBarTauhid').style.width = `${student.tauhid}%`;

        document.getElementById('modalScoreFiqih').textContent = `${student.fiqih} / 100`;
        document.getElementById('modalBarFiqih').style.width = `${student.fiqih}%`;

        document.getElementById('modalScoreBing').textContent = `${student.b_ing} / 100`;
        document.getElementById('modalBarBing').style.width = `${student.b_ing}%`;

        document.getElementById('modalScoreMenulis').textContent = `${student.menulis_kreatif} / 100`;
        document.getElementById('modalBarMenulis').style.width = `${student.menulis_kreatif}%`;

        document.getElementById('modalTextAdab').textContent = `${student.adab_akhlaq} / 100 (${student.adab_akhlaq >= 85 ? 'Sangat Terpuji' : 'Baik'})`;
        document.getElementById('modalTextKehadiran').textContent = `${student.kehadiran}% Kehadiran`;

        // Edit Nilai Link
        document.getElementById('btnModalEditGrade').href = `<?= base_url('instruktur/nilai'); ?>?search=${encodeURIComponent(student.nama)}`;

        // Open
        const modal = document.getElementById('studentDetailModal');
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    // Tutup Modal Santri
    function closeStudentModal() {
        const modal = document.getElementById('studentDetailModal');
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    // Salin Raport Ringkas
    function copyStudentReport() {
        if (!currentSelectedStudent) return;
        const s = currentSelectedStudent;
        const pred = getPredikat(parseFloat(s.rata_rata));

        const text = `=== RAPORT SINGKAT SANTRI SYIAR GEMILANG ===\nNama: ${s.nama}\nKelas: ${s.kelas}\nNIS: SG-2026-${String(s.id).padStart(3, '0')}\n\n- Tauhid & Aqidah: ${s.tauhid}\n- Fiqih Ibadah: ${s.fiqih}\n- Bahasa Inggris: ${s.b_ing}\n- Menulis Kreatif: ${s.menulis_kreatif}\n- Adab & Akhlaq (20%): ${s.adab_akhlaq}\n--------------------------------------------\nNILAI AKHIR: ${parseFloat(s.rata_rata).toFixed(2)} (Predikat ${pred.grade})\nKehadiran: ${s.kehadiran}%\n============================================`;

        const tempInput = document.createElement('textarea');
        tempInput.value = text;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand('copy');
        document.body.removeChild(tempInput);

        showToast(`Rincian nilai santri ${s.nama} telah disalin!`);
    }

    // Buka Modal Mapel
    function openMapelModal(mapelKey) {
        const m = mapelStatsData[mapelKey];
        if (!m) return;

        document.getElementById('mapelModalCover').style.backgroundImage = `url('${m.cover}')`;
        document.getElementById('mapelModalBadge').textContent = m.short;
        document.getElementById('mapelModalBadge').className = `px-3 py-1 text-xs font-bold rounded-lg uppercase tracking-wider text-white shadow-sm ${m.badge_color}`;
        document.getElementById('mapelModalKkm').textContent = `KKM ${m.kkm}`;

        document.getElementById('mapelModalTitle').textContent = m.nama;
        document.getElementById('mapelModalPengampu').textContent = `Pengampu: ${m.pengampu} (${m.gelar})`;
        document.getElementById('mapelModalDesc').textContent = m.deskripsi;

        document.getElementById('mapelModalAvg').textContent = m.rata_rata;
        document.getElementById('mapelModalMax').textContent = m.tertinggi;
        document.getElementById('mapelModalPass').textContent = `${m.kelulusan}%`;

        document.getElementById('mapelModalSchedule').textContent = m.jadwal;
        document.getElementById('mapelModalRoom').textContent = m.ruang;

        const tagsContainer = document.getElementById('mapelModalTags');
        tagsContainer.innerHTML = (m.tags || []).map(t => `
            <span class="px-2.5 py-1 bg-slate-100 text-slate-700 text-3xs font-semibold rounded-lg border border-slate-200">
                #${t}
            </span>
        `).join('');

        const modal = document.getElementById('mapelDetailModal');
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    // Tutup Modal Mapel
    function closeMapelModal() {
        const modal = document.getElementById('mapelDetailModal');
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    // Toast Notification
    function showToast(message) {
        const toast = document.getElementById('toastNotification');
        const toastMsg = document.getElementById('toastMessage');

        toastMsg.textContent = message;
        toast.classList.remove('hidden');

        setTimeout(() => {
            toast.classList.add('hidden');
        }, 3200);
    }
</script>

</body>
</html>
