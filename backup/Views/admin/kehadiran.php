<?php 
require_once 'navbar.php'; 

// Helper Nama Hari & Bulan Bahasa Indonesia untuk Realtime Date
$daftarHariIndo = [
    'Sun' => 'Minggu', 'Mon' => 'Senin', 'Tue' => 'Selasa',
    'Wed' => 'Rabu',   'Thu' => 'Kamis', 'Fri' => 'Jumat', 'Sat' => 'Sabtu'
];
$daftarBulanIndo = [
    '01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr',
    '05' => 'Mei', '06' => 'Jun', '07' => 'Jul', '08' => 'Agu',
    '09' => 'Sep', '10' => 'Okt', '11' => 'Nov', '12' => 'Des'
];

$todayRealtimeDate     = date('Y-m-d');
$yesterdayRealtimeDate = date('Y-m-d', strtotime('-1 day'));
$todayLabel            = date('d') . ' ' . $daftarBulanIndo[date('m')];
$yesterdayLabel        = date('d', strtotime('-1 day')) . ' ' . $daftarBulanIndo[date('m', strtotime('-1 day'))];
$todayFullIndo         = $daftarHariIndo[date('D')] . ', ' . date('d') . ' ' . $daftarBulanIndo[date('m')] . ' ' . date('Y');

$currentMonthKey       = date('Y-m');
$currentMonthLabel     = $daftarBulanIndo[date('m')] . ' ' . date('Y');

$periodeAwal           = date('d', strtotime('-1 month')) . ' ' . $daftarBulanIndo[date('m', strtotime('-1 month'))] . ' ' . date('Y', strtotime('-1 month'));
$periodeAkhir          = date('d') . ' ' . $daftarBulanIndo[date('m')] . ' ' . date('Y');

// Ekstrak minggu-minggu sesi yang ada secara otomatis dari database
$listMingguSesi = [];
$seenWeeks = [];
foreach ($sesi_kehadiran as $s) {
    $t = $s['tanggal'];
    $ts = strtotime($t);
    $mon = date('Y-m-d', strtotime('monday this week', $ts));
    $fri = date('Y-m-d', strtotime('friday this week', $ts));
    $wKey = $mon . '_' . $fri;
    if (!isset($seenWeeks[$wKey])) {
        $seenWeeks[$wKey] = true;
        $dMon = date('d', strtotime($mon));
        $dFri = date('d', strtotime($fri));
        $mFri = $daftarBulanIndo[date('m', strtotime($fri))];
        $mMon = $daftarBulanIndo[date('m', strtotime($mon))];
        $label = ($mMon === $mFri) ? "{$dMon} - {$dFri} {$mFri}" : "{$dMon} {$mMon} - {$dFri} {$mFri}";
        
        $listMingguSesi[] = [
            'start' => $mon,
            'end'   => $fri,
            'label' => $label
        ];
    }
}
?>

<div class="flex-1 min-w-0 flex flex-col overflow-hidden bg-[#F8FAFC]">
        
    <!-- Top Navbar -->
    <header class="h-16 bg-white border-b border-[#E2E8F0] flex items-center justify-between px-4 sm:px-6 z-10 shrink-0">
        <div class="flex items-center gap-2 sm:gap-3 min-w-0">
            <button type="button" onclick="toggleMobileSidebar()" class="lg:hidden p-2 -ml-1 text-slate-600 hover:text-brand hover:bg-slate-100 rounded-lg transition" aria-label="Buka Menu Navigasi">
                <i class="fa-solid fa-bars text-lg"></i>
            </button>
            <h1 class="text-base sm:text-lg font-bold text-[#1E293B] truncate sg-display"><?= esc($title); ?></h1>
            <span class="hidden md:inline-flex bg-emerald-50 text-emerald-700 text-xs font-semibold px-2.5 py-0.5 rounded-full border border-emerald-100 items-center gap-1 shrink-0">
                <i class="fa-solid fa-clipboard-user"></i> Riwayat 1 Bulan
            </span>
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <span class="bg-emerald-50 text-emerald-800 text-xs font-bold px-3 py-1 rounded-full border border-emerald-200 flex items-center gap-1.5 shadow-2xs">
                <i class="fa-solid fa-calendar-check text-emerald-600"></i> <span class="hidden sm:inline">Tanggal Sistem: </span><?= $todayLabel; ?>
            </span>
        </div>
    </header>

    <!-- Main Scrollable Area -->
    <main class="flex-1 overflow-y-auto p-6 space-y-6">

        <!-- Flashdata Notification -->
        <?php if (session()->getFlashdata('notif_msg')) : ?>
            <?php
                $type = session()->getFlashdata('notif_type') ?? 'add';
                $alertBg = ($type === 'delete') ? 'bg-rose-50 border-rose-200 text-rose-900' : 'bg-emerald-50 border-emerald-200 text-emerald-900';
                $iconBg  = ($type === 'delete') ? 'bg-rose-600' : 'bg-emerald-600';
                $iconFa  = ($type === 'delete') ? 'fa-triangle-exclamation' : 'fa-circle-check';
            ?>
            <div id="ci4FlashAlert" class="rounded-xl border p-4 shadow-sm flex items-start justify-between gap-3 <?= $alertBg; ?>">
                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 rounded-lg <?= $iconBg; ?> text-white flex items-center justify-center text-base shrink-0 mt-0.5">
                        <i class="fa-solid <?= $iconFa; ?>"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold"><?= esc(session()->getFlashdata('notif_title') ?? 'Notifikasi Presensi'); ?></h4>
                        <p class="text-xs mt-0.5"><?= esc(session()->getFlashdata('notif_msg')); ?></p>
                    </div>
                </div>
                <button type="button" onclick="document.getElementById('ci4FlashAlert').remove()" class="text-slate-400 hover:text-slate-600 p-1">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        <?php endif; ?>

        <!-- Summary Stats Cards (Riwayat 1 Bulan) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-bold shrink-0">
                    <i class="fa-solid fa-clipboard-check"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium">Rata-Rata Kehadiran</p>
                    <h3 class="text-2xl font-bold text-slate-800"><?= esc($rata_kehadiran); ?>%</h3>
                    <span class="text-3xs text-emerald-600 font-semibold">Akumulasi 1 Bulan Terakhir</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-brand-light text-brand flex items-center justify-center text-xl font-bold shrink-0">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium">Total Santri Aktif</p>
                    <h3 class="text-2xl font-bold text-slate-800"><?= esc($total_siswa); ?> Santri</h3>
                    <span class="text-3xs text-slate-400">Terdata di 6 Jurusan</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-xl font-bold shrink-0">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium">Total Sesi 1 Bulan</p>
                    <h3 class="text-2xl font-bold text-slate-800"><?= count($sesi_kehadiran); ?> Sesi</h3>
                    <span class="text-3xs text-amber-600 font-semibold"><?= count($all_logs); ?> Log Presensi</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center text-xl font-bold shrink-0">
                    <i class="fa-solid fa-award"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium">Presensi Prima (&ge;95%)</p>
                    <?php
                        $primaCount = 0;
                        foreach ($data_siswa as $s) {
                            if (($s['kehadiran'] ?? 0) >= 95) $primaCount++;
                        }
                    ?>
                    <h3 class="text-2xl font-bold text-slate-800"><?= $primaCount; ?> Santri</h3>
                    <span class="text-3xs text-sky-600 font-semibold">Kedisiplinan Sangat Baik</span>
                </div>
            </div>
        </div>

        <!-- Banner Info Riwayat 1 Bulan & Dinamisasi Tanggal -->
        <div class="bg-gradient-to-r from-emerald-50/80 via-white to-brand-light/80 border border-emerald-200/80 rounded-xl p-4 shadow-2xs flex flex-col md:flex-row md:items-center justify-between gap-3">
            <div class="flex items-start gap-3">
                <div class="w-9 h-9 rounded-lg bg-emerald-600 text-white flex items-center justify-center text-base shrink-0 mt-0.5">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                        Presensi Berjalan Dinamis Sesuai Kalender & Tanggal
                        <span class="text-2xs bg-emerald-100 text-emerald-800 font-bold px-2 py-0.5 rounded-full border border-emerald-300">
                            <?= $periodeAwal; ?> - <?= $periodeAkhir; ?>
                        </span>
                    </h4>
                    <p class="text-xs text-slate-600 mt-0.5 leading-relaxed">
                        Sistem mencatat presensi secara <strong class="text-brand-deep">spesifik per tanggal realtime</strong>. Anda dapat melihat <strong>akumulasi 1 bulan</strong> (total <?= count($sesi_kehadiran); ?> sesi kegiatan), atau memfilter untuk memeriksa status presensi santri pada <strong>hari ini (<?= $todayFullIndo; ?>)</strong>, kemarin, maupun tanggal tertentu.
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-2 shrink-0 self-end md:self-auto">
                <span class="text-xs font-semibold text-slate-600 bg-white px-3 py-1.5 rounded-lg border border-slate-200 shadow-2xs">
                    <i class="fa-solid fa-calendar-check text-emerald-600 mr-1.5"></i>Hari Ini: <?= $todayFullIndo; ?>
                </span>
            </div>
        </div>

        <!-- Section: Riwayat Sesi Pertemuan (1 Bulan Terakhir) -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-100">
                <div>
                    <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-calendar-days text-brand"></i> Riwayat Sesi Pertemuan
                        <span id="sesiCountBadge" class="text-xs font-bold text-brand bg-brand-light border border-brand-border px-2 py-0.5 rounded-full">
                            <?= count($sesi_kehadiran); ?> Sesi
                        </span>
                    </h3>
                    <p class="text-xs text-slate-500">Daftar seluruh sesi kegiatan halaqah, pembelajaran teori, dan praktikum yang telah dilaksanakan.</p>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" onclick="openAddSesiModal()" class="bg-brand hover:bg-brand-dark text-white text-xs font-semibold px-3.5 py-2 rounded-lg shadow-xs flex items-center gap-1.5 transition shrink-0 cursor-pointer">
                        <i class="fa-solid fa-plus"></i> Catat Sesi Baru
                    </button>
                </div>
            </div>

            <!-- Filter Tanggal & Minggu untuk Sesi (Otomatis & Realtime) -->
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3 pt-1">
                <div class="flex items-center gap-1.5 overflow-x-auto pb-1 text-xs">
                    <span class="text-slate-400 font-medium shrink-0"><i class="fa-solid fa-filter mr-1"></i>Filter Sesi:</span>
                    <button type="button" onclick="filterSesiByFilter('all', event)" id="btnSesiAll" class="btn-filter-sesi px-2.5 py-1 rounded-lg bg-brand text-white font-semibold shadow-xs transition shrink-0 cursor-pointer">
                        Semua (<?= count($sesi_kehadiran); ?>)
                    </button>
                    <button type="button" onclick="filterSesiByFilter('today', event)" id="btnSesiToday" class="btn-filter-sesi px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold transition shrink-0 cursor-pointer">
                        Hari Ini (<?= $todayLabel; ?>)
                    </button>
                    <button type="button" onclick="filterSesiByFilter('yesterday', event)" id="btnSesiYesterday" class="btn-filter-sesi px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold transition shrink-0 cursor-pointer">
                        Kemarin (<?= $yesterdayLabel; ?>)
                    </button>
                    <button type="button" onclick="filterSesiByFilter('month:<?= $currentMonthKey; ?>', event)" id="btnSesiNov" class="btn-filter-sesi px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium transition shrink-0 cursor-pointer">
                        <?= $currentMonthLabel; ?>
                    </button>
                    <?php foreach ($listMingguSesi as $wIdx => $w): ?>
                        <button type="button" onclick="filterSesiByFilter('range:<?= $w['start']; ?>:<?= $w['end']; ?>', event)" class="btn-filter-sesi px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium transition shrink-0 cursor-pointer">
                            <?= esc($w['label']); ?>
                        </button>
                    <?php endforeach; ?>
                </div>

                <!-- Input Pilih Tanggal Sesi Spesifik (Realtime Datepicker) -->
                <div class="flex items-center gap-2 text-xs shrink-0 self-end lg:self-auto">
                    <span class="text-slate-500 font-medium"><i class="fa-regular fa-calendar text-brand mr-1"></i>Pilih Tanggal:</span>
                    <input type="date" id="inputCustomDateSesi" value="<?= $todayRealtimeDate; ?>" onchange="filterSesiByCustomDate(this.value)" class="px-2.5 py-1 text-xs rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand bg-white cursor-pointer" title="Pilih Tanggal Sesi Realtime">
                </div>
            </div>

            <!-- Scrollable Grid Sesi Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 max-h-96 overflow-y-auto pr-1" id="sesiContainer">
                <div id="sesiEmptyState" class="hidden col-span-full py-10 text-center bg-slate-50 rounded-xl border border-dashed border-slate-300">
                    <div class="w-12 h-12 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center mx-auto mb-2 text-xl">
                        <i class="fa-solid fa-calendar-xmark"></i>
                    </div>
                    <p class="text-sm font-bold text-slate-700">Tidak ada sesi pertemuan pada tanggal ini</p>
                    <p class="text-xs text-slate-500 mt-0.5">Pilih tanggal lain atau klik "Catat Sesi Baru" untuk membuat sesi kegiatan baru.</p>
                </div>
                <?php 
                    $daysIndo = ['Mon' => 'Senin', 'Tue' => 'Selasa', 'Wed' => 'Rabu', 'Thu' => 'Kamis', 'Fri' => 'Jumat', 'Sat' => 'Sabtu', 'Sun' => 'Minggu'];
                ?>
                <?php foreach ($sesi_kehadiran as $sesi): ?>
                    <?php
                        $totPeserta = $sesi['total_hadir'] + ($sesi['total_telat'] ?? 0) + $sesi['total_sakit'] + $sesi['total_alpa'];
                        $persenHadir = $totPeserta > 0 ? round(($sesi['total_hadir'] / $totPeserta) * 100, 1) : 100;
                        $tglSesi = $sesi['tanggal'];
                        $hariName = $daysIndo[date('D', strtotime($tglSesi))] ?? date('D', strtotime($tglSesi));
                        $isTauhid = stripos($sesi['nama_sesi'], 'Tauhid') !== false;
                    ?>
                    <div class="card-sesi p-4 rounded-xl border border-slate-200 bg-slate-50/40 hover:bg-white hover:border-brand/40 transition shadow-2xs flex flex-col justify-between" data-date="<?= esc($tglSesi); ?>">
                        <div>
                            <div class="flex items-start justify-between gap-2 mb-2">
                                <div class="flex items-center gap-1.5 min-w-0">
                                    <span class="w-6 h-6 rounded-md <?= $isTauhid ? 'bg-brand-light text-brand' : 'bg-emerald-100 text-emerald-700'; ?> flex items-center justify-center text-xs font-bold shrink-0">
                                        <i class="fa-solid <?= $isTauhid ? 'fa-book-quran' : 'fa-kaaba'; ?>"></i>
                                    </span>
                                    <h4 class="text-sm font-bold text-slate-800 line-clamp-1" title="<?= esc($sesi['nama_sesi']); ?>">
                                        <?= esc($sesi['nama_sesi']); ?>
                                    </h4>
                                </div>
                                <span class="text-2xs font-extrabold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 shrink-0">
                                    <?= $persenHadir; ?>% Hadir
                                </span>
                            </div>

                            <div class="space-y-1 text-xs text-slate-500 mb-3">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-calendar text-slate-400 w-4"></i>
                                    <span class="font-semibold text-slate-700"><?= $hariName; ?>, <?= date('d M Y', strtotime($sesi['tanggal'])); ?></span>
                                    <span class="text-slate-300">•</span>
                                    <span class="font-mono text-brand font-bold"><?= esc($sesi['waktu']); ?></span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-location-dot text-slate-400 w-4"></i>
                                    <span class="truncate font-medium text-slate-600"><?= esc($sesi['lokasi']); ?></span>
                                </div>
                                <?php if (!empty($sesi['keterangan'])): ?>
                                    <div class="flex items-center gap-2 text-3xs text-slate-600 mt-1">
                                        <i class="fa-solid fa-chalkboard-user text-brand w-4"></i>
                                        <span class="truncate font-semibold"><?= esc($sesi['keterangan']); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Breakdown Pills (Hadir, Telat, Sakit, Absen) -->
                        <div class="grid grid-cols-4 gap-1.5 pt-2.5 border-t border-slate-200/70 text-center text-2xs">
                            <div class="bg-emerald-50 border border-emerald-200 rounded p-1">
                                <span class="text-3xs text-emerald-600 block font-semibold">Hadir</span>
                                <span class="font-bold text-emerald-800"><?= $sesi['total_hadir']; ?></span>
                            </div>
                            <div class="bg-amber-50 border border-amber-200 rounded p-1">
                                <span class="text-3xs text-amber-600 block font-semibold">Telat</span>
                                <span class="font-bold text-amber-800"><?= $sesi['total_telat'] ?? 0; ?></span>
                            </div>
                            <div class="bg-sky-50 border border-sky-200 rounded p-1">
                                <span class="text-3xs text-sky-600 block font-semibold">Sakit</span>
                                <span class="font-bold text-sky-800"><?= $sesi['total_sakit']; ?></span>
                            </div>
                            <div class="bg-rose-50 border border-rose-200 rounded p-1">
                                <span class="text-3xs text-rose-600 block font-semibold">Absen</span>
                                <span class="font-bold text-rose-800"><?= $sesi['total_alpa']; ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Section: Tabel Santri dengan Pilihan Kehadiran & Rekap 1 Bulan -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm space-y-4">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3 pb-3 border-b border-slate-100">
                <div>
                    <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-clipboard-check text-brand"></i> Presensi Santri & Rekap Kehadiran
                    </h3>
                    <p class="text-xs text-slate-500">
                        Mode Tampilan: <span id="labelTampilanMode" class="font-bold text-brand">Akumulasi 1 Bulan (<?= count($sesi_kehadiran); ?> Sesi)</span>. Ubah filter tanggal di samping untuk memeriksa status santri pada hari spesifik.
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-2">
                    <!-- Filter Tanggal Tabel Santri (Realtime) -->
                    <div class="flex items-center gap-1 bg-slate-100/90 p-1 rounded-lg border border-slate-200 text-xs">
                        <button type="button" id="btnTblAll" onclick="setTableDateFilter('all')" class="btn-tbl-date px-2.5 py-1 rounded-md font-bold bg-brand text-white shadow-2xs transition cursor-pointer">
                            Semua (<?= count($sesi_kehadiran); ?> Sesi)
                        </button>
                        <button type="button" id="btnTblToday" onclick="setTableDateFilter('today')" class="btn-tbl-date px-2.5 py-1 rounded-md font-semibold text-slate-600 hover:text-slate-900 transition cursor-pointer">
                            Hari Ini (<?= $todayLabel; ?>)
                        </button>
                        <button type="button" id="btnTblYesterday" onclick="setTableDateFilter('yesterday')" class="btn-tbl-date px-2.5 py-1 rounded-md font-semibold text-slate-600 hover:text-slate-900 transition cursor-pointer">
                            Kemarin (<?= $yesterdayLabel; ?>)
                        </button>
                        <div class="flex items-center gap-1 pl-1 border-l border-slate-200">
                            <input type="date" id="inputCustomDateTbl" value="<?= $todayRealtimeDate; ?>" onchange="setTableDateFilter(this.value)" class="px-2 py-0.5 text-xs rounded border border-slate-300 focus:outline-none focus:ring-1 focus:ring-brand bg-white cursor-pointer" title="Pilih Tanggal Presensi Santri Realtime">
                        </div>
                    </div>

                    <select id="filterKelasKehadiran" onchange="filterKehadiranTable()" class="px-3 py-1.5 text-xs rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand">
                        <option value="all">Semua Jurusan</option>
                        <?php foreach ($rekap_kehadiran_kelas as $rk): ?>
                            <option value="<?= esc($rk['kelas']); ?>"><?= esc($rk['kelas']); ?></option>
                        <?php endforeach; ?>
                    </select>

                    <div class="relative">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-xs text-slate-400"></i>
                        <input type="text" id="searchKehadiranInput" onkeyup="filterKehadiranTable()" placeholder="Cari santri..." class="pl-8 pr-3 py-1.5 text-xs rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand w-36 sm:w-44">
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto rounded-lg border border-slate-200">
                <table class="w-full text-left border-collapse" id="tableKehadiran">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold text-slate-700 uppercase">
                            <th class="py-3 px-3 text-center w-12 border-r border-slate-200">No</th>
                            <th class="py-3 px-3 border-r border-slate-200 w-16">ID</th>
                            <th class="py-3 px-3 border-r border-slate-200">Nama Santri</th>
                            <th class="py-3 px-3 border-r border-slate-200">Kelas / Jurusan</th>
                            <th class="py-3 px-3 text-center border-r border-slate-200 bg-brand-light text-brand-deep w-64">
                                Catat Kehadiran (Pilih Sesi)
                            </th>
                            <th class="py-3 px-3 text-center border-r border-slate-200 bg-slate-100/60 w-56" id="thRekapHeader">
                                Rekap 1 Bulan (<?= count($sesi_kehadiran); ?> Sesi)
                            </th>
                            <th class="py-3 px-3 text-center border-r border-slate-200 bg-emerald-50/60 text-emerald-900 w-24">
                                Kehadiran (%)
                            </th>
                            <th class="py-3 px-3 text-center w-28">Riwayat</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-slate-200" id="tbodyKehadiran">
                        <?php foreach ($data_siswa as $idx => $s): ?>
                        <?php 
                            $pct = (int)($s['kehadiran'] ?? 95);
                            $lastLog = $presensi_terbaru[$s['id']] ?? null;
                            $rekap = $rekap_bulanan[$s['id']] ?? ['total_sesi' => count($sesi_kehadiran), 'count_hadir' => count($sesi_kehadiran), 'count_telat' => 0, 'count_sakit' => 0, 'count_absen' => 0];

                            if ($pct >= 95) {
                                $badgeClass = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                                $statusLabel = 'Sangat Rajin';
                            } elseif ($pct >= 90) {
                                $badgeClass = 'bg-brand-light text-brand border-brand-border';
                                $statusLabel = 'Disiplin';
                            } else {
                                $badgeClass = 'bg-amber-50 text-amber-700 border-amber-200';
                                $statusLabel = 'Cukup';
                            }
                        ?>
                        <tr class="row-santri <?= $idx % 2 === 1 ? 'bg-slate-50/70' : 'bg-white'; ?> hover:bg-brand-light/50 transition" data-nama="<?= strtolower(esc($s['nama'])); ?>" data-kelas="<?= esc($s['kelas']); ?>">
                            <td class="py-3 px-3 text-center border-r border-slate-200 font-bold text-xs text-slate-500"><?= $idx + 1; ?></td>
                            <td class="py-3 px-3 border-r border-slate-200 font-mono text-xs text-slate-500 font-semibold"><?= esc($s['id']); ?></td>
                            <td class="py-3 px-3 border-r border-slate-200 font-medium text-slate-800">
                                <?= esc($s['nama']); ?>
                                <?php if ($lastLog): ?>
                                    <span class="block text-3xs text-slate-400 mt-0.5 truncate" title="<?= esc($lastLog['nama_sesi']); ?>">
                                        Terakhir: <strong class="<?= $lastLog['status'] === 'Hadir' ? 'text-emerald-600' : ($lastLog['status'] === 'Telat' ? 'text-amber-600' : 'text-sky-600'); ?>"><?= esc($lastLog['status']); ?></strong> (<?= date('d/m', strtotime($lastLog['tanggal'])); ?>)
                                    </span>
                                <?php endif; ?>
                            </td>
                            <?php
                                $jThemeKehadiran = [
                                    'Desain Grafis'                => 'bg-red-50 text-red-700 border-red-200',
                                    'Teknik Komputer dan Jaringan' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'Aplikasi Perkantoran'         => 'bg-orange-50 text-orange-700 border-orange-200',
                                    'Tata Busana'                  => 'bg-yellow-50 text-yellow-800 border-yellow-300',
                                    'Otomotif'                     => 'bg-slate-100 text-slate-900 border-slate-300',
                                    'Fotografi dan Videografi'     => 'bg-blue-50 text-blue-700 border-blue-200',
                                ];
                                $bdgK = $jThemeKehadiran[$s['kelas']] ?? 'bg-blue-50 text-blue-700 border-blue-200';
                            ?>
                            <td class="py-3 px-3 border-r border-slate-200 text-xs">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-3xs font-semibold border <?= $bdgK; ?>">
                                    <?= esc($s['kelas']); ?>
                                </span>
                            </td>
                            
                            <!-- Pilihan Tombol Kehadiran: Hadir, Telat, Sakit, Absen -->
                            <td class="py-2.5 px-3 border-r border-slate-200 text-center bg-brand-light/30">
                                <div class="inline-flex items-center gap-1.5">
                                    <!-- Tombol Hadir -->
                                    <button type="button" 
                                        onclick='openPilihSesiModal(<?= json_encode($s); ?>, "Hadir")'
                                        title="Tandai Hadir"
                                        class="px-2.5 py-1 rounded-md text-xs font-bold bg-emerald-50 hover:bg-emerald-600 text-emerald-700 hover:text-white border border-emerald-300 shadow-2xs transition flex items-center gap-1">
                                        <i class="fa-solid fa-check"></i> Hadir
                                    </button>

                                    <!-- Tombol Telat -->
                                    <button type="button" 
                                        onclick='openPilihSesiModal(<?= json_encode($s); ?>, "Telat")'
                                        title="Tandai Terlambat"
                                        class="px-2.5 py-1 rounded-md text-xs font-bold bg-amber-50 hover:bg-amber-600 text-amber-700 hover:text-white border border-amber-300 shadow-2xs transition flex items-center gap-1">
                                        <i class="fa-solid fa-clock"></i> Telat
                                    </button>

                                    <!-- Tombol Sakit -->
                                    <button type="button" 
                                        onclick='openPilihSesiModal(<?= json_encode($s); ?>, "Sakit")'
                                        title="Tandai Izin Sakit"
                                        class="px-2.5 py-1 rounded-md text-xs font-bold bg-sky-50 hover:bg-sky-600 text-sky-700 hover:text-white border border-sky-300 shadow-2xs transition flex items-center gap-1">
                                        <i class="fa-solid fa-stethoscope"></i> Sakit
                                    </button>

                                    <!-- Tombol Absen -->
                                    <button type="button" 
                                        onclick='openPilihSesiModal(<?= json_encode($s); ?>, "Absen")'
                                        title="Tandai Alpa / Tidak Hadir"
                                        class="px-2.5 py-1 rounded-md text-xs font-bold bg-rose-50 hover:bg-rose-600 text-rose-700 hover:text-white border border-rose-300 shadow-2xs transition flex items-center gap-1">
                                        <i class="fa-solid fa-xmark"></i> Absen
                                    </button>
                                </div>
                            </td>

                            <!-- Rekapitulasi 1 Bulan / Status Presensi Tanggal Spesifik -->
                            <td class="py-3 px-2 border-r border-slate-200 text-center td-status-col" data-santri-id="<?= $s['id']; ?>">
                                <!-- View 1: Akumulasi 1 Bulan (<?= count($sesi_kehadiran); ?> Sesi) -->
                                <div class="view-rekap-akumulasi grid grid-cols-4 gap-1 text-2xs font-bold" id="view-rekap-<?= $s['id']; ?>">
                                    <span class="px-1.5 py-0.5 rounded bg-emerald-50 text-emerald-700 border border-emerald-200" title="Hadir: <?= $rekap['count_hadir']; ?> Sesi">
                                        <?= $rekap['count_hadir']; ?> H
                                    </span>
                                    <span class="px-1.5 py-0.5 rounded bg-amber-50 text-amber-700 border border-amber-200" title="Telat: <?= $rekap['count_telat']; ?> Sesi">
                                        <?= $rekap['count_telat']; ?> T
                                    </span>
                                    <span class="px-1.5 py-0.5 rounded bg-sky-50 text-sky-700 border border-sky-200" title="Sakit: <?= $rekap['count_sakit']; ?> Sesi">
                                        <?= $rekap['count_sakit']; ?> S
                                    </span>
                                    <span class="px-1.5 py-0.5 rounded bg-rose-50 text-rose-700 border border-rose-200" title="Absen: <?= $rekap['count_absen']; ?> Sesi">
                                        <?= $rekap['count_absen']; ?> A
                                    </span>
                                </div>
                                <!-- View 2: Status Spesifik Tanggal (Dinamis via JS) -->
                                <div class="view-status-tanggal hidden" id="view-tgl-<?= $s['id']; ?>"></div>
                            </td>

                            <!-- Persentase Kehadiran 1 Bulan -->
                            <td class="py-3 px-3 border-r border-slate-200 text-center bg-emerald-50/20">
                                <span class="font-black text-emerald-700 text-sm"><?= $pct; ?>%</span>
                            </td>

                            <!-- Tombol Aksi Detail Riwayat -->
                            <td class="py-3 px-3 text-center">
                                <button type="button" 
                                    onclick='openRiwayatSantriModal(<?= json_encode($s); ?>)'
                                    class="px-2.5 py-1 bg-white hover:bg-brand-light border border-brand-border text-brand hover:text-brand-deep rounded-md text-xs font-semibold shadow-2xs transition flex items-center justify-center gap-1 mx-auto">
                                    <i class="fa-solid fa-list-ul"></i> Detail
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>
</div>

<!-- ========================================================================= -->
<!-- MODAL: Pilih Sesi Kehadiran (Muncul saat klik Hadir / Telat / Sakit / Absen) -->
<!-- ========================================================================= -->
<div id="modalPilihSesiKehadiran" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xl w-full max-w-lg overflow-hidden animate-in fade-in duration-200">
        
        <!-- Header Modal -->
        <div class="px-6 py-4 bg-slate-50 border-b border-slate-200 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-brand-light text-brand flex items-center justify-center text-sm font-bold">
                    <i class="fa-solid fa-calendar-check"></i>
                </span>
                <div>
                    <h3 class="text-base font-bold text-slate-800">Catat Presensi Sesi Santri</h3>
                    <p class="text-xs text-slate-500">Pilih sesi kegiatan yang dihadiri santri</p>
                </div>
            </div>
            <button type="button" onclick="closePilihSesiModal()" class="text-slate-400 hover:text-slate-600 p-1">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Form Presensi Sesi -->
        <form action="<?= base_url('admin/kehadiran/catat'); ?>" method="post" class="p-6 space-y-4">
            <?= csrf_field(); ?>
            <input type="hidden" name="santri_id" id="modal_santri_id">

            <!-- Card Profil Santri Terpilih -->
            <div class="p-3.5 bg-brand-light/80 rounded-xl border border-brand-border flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-brand text-white flex items-center justify-center font-bold text-sm shadow-2xs shrink-0">
                        <i class="fa-solid fa-user-graduate"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-900" id="modal_santri_nama">Nama Santri</h4>
                        <div class="flex items-center gap-2 text-2xs text-slate-500 mt-0.5">
                            <span id="modal_santri_id_badge" class="font-mono font-semibold">ID: -</span>
                            <span>•</span>
                            <span id="modal_santri_kelas" class="font-semibold text-brand">Kelas</span>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <span id="modal_santri_kehadiran_badge" class="px-2.5 py-1 rounded-full text-xs font-black bg-emerald-100 text-emerald-800 border border-emerald-300">
                        Kehadiran: 95%
                    </span>
                </div>
            </div>

            <!-- Pilihan Status Kehadiran (Hadir / Telat / Sakit / Absen) -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">
                    Status Presensi Santri
                </label>
                <div class="grid grid-cols-4 gap-2" id="modalStatusGroup">
                    <label class="status-option-label flex flex-col items-center justify-center p-2.5 rounded-xl border-2 border-slate-200 cursor-pointer hover:border-emerald-400 transition" id="label-status-hadir">
                        <input type="radio" name="status" value="Hadir" id="radio-hadir" class="sr-only" onchange="updateStatusVisuals('Hadir')">
                        <i class="fa-solid fa-check text-base text-emerald-600 mb-1"></i>
                        <span class="text-xs font-bold text-slate-800">Hadir</span>
                    </label>

                    <label class="status-option-label flex flex-col items-center justify-center p-2.5 rounded-xl border-2 border-slate-200 cursor-pointer hover:border-amber-400 transition" id="label-status-telat">
                        <input type="radio" name="status" value="Telat" id="radio-telat" class="sr-only" onchange="updateStatusVisuals('Telat')">
                        <i class="fa-solid fa-clock text-base text-amber-600 mb-1"></i>
                        <span class="text-xs font-bold text-slate-800">Telat</span>
                    </label>

                    <label class="status-option-label flex flex-col items-center justify-center p-2.5 rounded-xl border-2 border-slate-200 cursor-pointer hover:border-sky-400 transition" id="label-status-sakit">
                        <input type="radio" name="status" value="Sakit" id="radio-sakit" class="sr-only" onchange="updateStatusVisuals('Sakit')">
                        <i class="fa-solid fa-stethoscope text-base text-sky-600 mb-1"></i>
                        <span class="text-xs font-bold text-slate-800">Sakit</span>
                    </label>

                    <label class="status-option-label flex flex-col items-center justify-center p-2.5 rounded-xl border-2 border-slate-200 cursor-pointer hover:border-rose-400 transition" id="label-status-absen">
                        <input type="radio" name="status" value="Absen" id="radio-absen" class="sr-only" onchange="updateStatusVisuals('Absen')">
                        <i class="fa-solid fa-xmark text-base text-rose-600 mb-1"></i>
                        <span class="text-xs font-bold text-slate-800">Absen</span>
                    </label>
                </div>
            </div>

            <!-- Pilihan Sesi Pertemuan ("dia hadir di sesi apa") -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">
                    <i class="fa-solid fa-calendar-days text-brand mr-1"></i>Pilih Sesi Kegiatan (Riwayat 1 Bulan)
                </label>
                <select name="sesi_id" id="modal_sesi_id" onchange="onModalSesiChange()" required class="w-full px-3 py-2.5 text-sm rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand bg-white">
                    <?php foreach ($sesi_kehadiran as $idx => $sesi): ?>
                        <option value="<?= $sesi['id']; ?>" data-tanggal="<?= $sesi['tanggal']; ?>" <?= $idx === 0 ? 'selected' : ''; ?>>
                            [<?= date('d M Y', strtotime($sesi['tanggal'])); ?>] <?= esc($sesi['nama_sesi']); ?> (<?= esc($sesi['waktu']); ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
                <p class="text-3xs text-slate-400 mt-1">Sesi & tanggal otomatis tersinkronisasi. Anda dapat mengubah tanggal atau memilih sesi kapan pun.</p>
            </div>

            <!-- Tanggal Presensi -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Tanggal Presensi</label>
                    <input type="date" name="tanggal" id="modal_tanggal" value="<?= date('Y-m-d'); ?>" onchange="onModalTanggalChange()" required class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Waktu Pencatatan</label>
                    <input type="text" readonly value="<?= date('H:i'); ?> WIB" class="w-full px-3 py-2 text-xs rounded-lg border border-slate-200 bg-slate-50 text-slate-500 font-mono">
                </div>
            </div>

            <!-- Catatan / Keterangan Alasan -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Catatan / Alasan (Opsional)</label>
                <input type="text" name="keterangan" id="modal_keterangan" placeholder="Contoh: Hadir tepat waktu / Izin sakit flu / Terlambat 15 menit..." class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand">
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-end gap-2 pt-3 border-t border-slate-200">
                <button type="button" onclick="closePilihSesiModal()" class="px-4 py-2 rounded-lg border border-slate-300 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 rounded-lg bg-brand hover:bg-brand-dark text-white text-xs font-bold shadow-xs transition flex items-center gap-1.5">
                    <i class="fa-solid fa-check"></i> Simpan Presensi
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODAL: Detail Riwayat Presensi 1 Bulan Santri -->
<!-- ========================================================================= -->
<div id="modalDetailRiwayatSantri" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xl w-full max-w-2xl max-h-[90vh] flex flex-col overflow-hidden animate-in fade-in duration-200">
        
        <!-- Header Modal -->
        <div class="px-6 py-4 bg-slate-50 border-b border-slate-200 flex items-center justify-between shrink-0">
            <div class="flex items-center gap-2.5">
                <span class="w-9 h-9 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm font-bold">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </span>
                <div>
                    <h3 class="text-base font-bold text-slate-800" id="hist_nama">Riwayat Presensi Santri</h3>
                    <p class="text-xs text-slate-500" id="hist_sub">Catatan kehadiran seluruh sesi dalam 1 bulan terakhir</p>
                </div>
            </div>
            <button type="button" onclick="closeRiwayatSantriModal()" class="text-slate-400 hover:text-slate-600 p-1">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Body Modal: Ringkasan & Tabel Sesi -->
        <div class="p-6 space-y-4 overflow-y-auto flex-1">
            <!-- Ringkasan Statistik Santri -->
            <div class="grid grid-cols-4 gap-2 text-center text-xs" id="hist_stat_grid">
                <div class="p-2.5 rounded-xl bg-emerald-50 border border-emerald-200">
                    <span class="text-3xs text-emerald-700 block font-semibold uppercase">Hadir</span>
                    <span class="text-lg font-black text-emerald-800" id="hist_cnt_hadir">0</span>
                </div>
                <div class="p-2.5 rounded-xl bg-amber-50 border border-amber-200">
                    <span class="text-3xs text-amber-700 block font-semibold uppercase">Telat</span>
                    <span class="text-lg font-black text-amber-800" id="hist_cnt_telat">0</span>
                </div>
                <div class="p-2.5 rounded-xl bg-sky-50 border border-sky-200">
                    <span class="text-3xs text-sky-700 block font-semibold uppercase">Sakit</span>
                    <span class="text-lg font-black text-sky-800" id="hist_cnt_sakit">0</span>
                </div>
                <div class="p-2.5 rounded-xl bg-rose-50 border border-rose-200">
                    <span class="text-3xs text-rose-700 block font-semibold uppercase">Absen</span>
                    <span class="text-lg font-black text-rose-800" id="hist_cnt_absen">0</span>
                </div>
            </div>

            <!-- List Catatan Sesi -->
            <div class="border border-slate-200 rounded-xl overflow-hidden">
                <div class="px-4 py-2.5 bg-slate-50 border-b border-slate-200 flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-700 uppercase tracking-wider">Daftar Sesi Presensi (<?= count($sesi_kehadiran); ?> Sesi)</span>
                    <span class="text-2xs font-semibold text-slate-500" id="hist_pct_span">Persentase: 95%</span>
                </div>
                <div class="divide-y divide-slate-100 max-h-72 overflow-y-auto" id="hist_log_list">
                    <!-- Populated dynamically via JS -->
                </div>
            </div>
        </div>

        <!-- Footer Modal -->
        <div class="px-6 py-3 bg-slate-50 border-t border-slate-200 flex justify-end shrink-0">
            <button type="button" onclick="closeRiwayatSantriModal()" class="px-4 py-2 rounded-lg bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-semibold transition">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODAL: Tambah Sesi Kehadiran Baru -->
<!-- ========================================================================= -->
<div id="modalAddSesi" class="fixed inset-0 bg-slate-900/60 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xl w-full max-w-lg overflow-hidden">
        <div class="px-6 py-4 bg-slate-50 border-b border-slate-200 flex items-center justify-between">
            <h3 class="text-base font-bold text-slate-800">Catat Sesi Kehadiran Baru</h3>
            <button type="button" onclick="closeAddSesiModal()" class="text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <form action="<?= base_url('admin/kehadiran/add_sesi'); ?>" method="post" class="p-6 space-y-4">
            <?= csrf_field(); ?>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Sesi / Kegiatan</label>
                <input type="text" name="nama_sesi" required placeholder="Contoh: Kelas Tauhid - Ustadz Kamal Malawi / Kelas Fiqih - Ustadzah Yanni Susanti" class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Tanggal</label>
                    <input type="date" name="tanggal" value="<?= date('Y-m-d'); ?>" required class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Waktu</label>
                    <input type="text" name="waktu" value="07:00 - 09:00 WIB" required class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Lokasi Pertemuan</label>
                <input type="text" name="lokasi" value="Aula Serbaguna" required class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand">
            </div>
            <div class="grid grid-cols-4 gap-2">
                <div>
                    <label class="block text-2xs font-semibold text-emerald-700 mb-1">Hadir</label>
                    <input type="number" name="total_hadir" value="48" min="0" max="50" class="w-full px-2 py-1.5 text-xs text-center font-bold rounded-lg border border-slate-300">
                </div>
                <div>
                    <label class="block text-2xs font-semibold text-amber-700 mb-1">Telat</label>
                    <input type="number" name="total_telat" value="1" min="0" max="50" class="w-full px-2 py-1.5 text-xs text-center font-bold rounded-lg border border-slate-300">
                </div>
                <div>
                    <label class="block text-2xs font-semibold text-sky-700 mb-1">Sakit</label>
                    <input type="number" name="total_sakit" value="1" min="0" max="50" class="w-full px-2 py-1.5 text-xs text-center font-bold rounded-lg border border-slate-300">
                </div>
                <div>
                    <label class="block text-2xs font-semibold text-rose-700 mb-1">Absen</label>
                    <input type="number" name="total_alpa" value="0" min="0" max="50" class="w-full px-2 py-1.5 text-xs text-center font-bold rounded-lg border border-slate-300">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Catatan / Materi Pembelajaran</label>
                <input type="text" name="keterangan" placeholder="Contoh: Pembelajaran adab & kejuruan semester ganjil" class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand">
            </div>
            <div class="flex justify-end gap-2 pt-3 border-t border-slate-200">
                <button type="button" onclick="closeAddSesiModal()" class="px-4 py-2 rounded-lg border border-slate-300 text-xs font-semibold text-slate-700 hover:bg-slate-50">Batal</button>
                <button type="submit" class="px-5 py-2 rounded-lg bg-brand text-white text-xs font-semibold hover:bg-brand-dark shadow-xs">Simpan Sesi</button>
            </div>
        </form>
    </div>
</div>

<script>
// Data Logs Lengkap dari PHP
const allLogsData = <?= json_encode($all_logs); ?>;
const rekapBulananData = <?= json_encode($rekap_bulanan); ?>;

// Kelompokkan log per santri_id
const logsBySantri = {};
// Indeks cepat per tanggal dan santri_id
const logsByDateAndSantri = {};

allLogsData.forEach(l => {
    // Grouping per santri
    if (!logsBySantri[l.santri_id]) {
        logsBySantri[l.santri_id] = [];
    }
    logsBySantri[l.santri_id].push(l);

    // Grouping per date + santri
    const dateKey = l.tanggal + '_' + l.santri_id;
    if (!logsByDateAndSantri[dateKey]) {
        logsByDateAndSantri[dateKey] = [];
    }
    logsByDateAndSantri[dateKey].push(l);
});

// Format Tanggal ke Bahasa Indonesia (DD Mmm YYYY)
function formatDateIndo(dateStr) {
    if (!dateStr) return '';
    const parts = dateStr.split('-');
    if (parts.length !== 3) return dateStr;
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    const d = parseInt(parts[2], 10);
    const m = months[parseInt(parts[1], 10) - 1] || parts[1];
    const y = parts[0];
    return `${d < 10 ? '0' + d : d} ${m} ${y}`;
}

// Tanggal Realtime dari Server
const REALTIME_TODAY     = '<?= $todayRealtimeDate; ?>';
const REALTIME_YESTERDAY = '<?= $yesterdayRealtimeDate; ?>';

// State Aktif Tanggal Tabel
let activeTableDate = 'all';

// Fungsi Switch Filter Tanggal Tabel Santri
function setTableDateFilter(dateVal) {
    // Reset visual tombol tanggal
    document.querySelectorAll('.btn-tbl-date').forEach(btn => {
        btn.classList.remove('bg-brand', 'text-white', 'shadow-2xs', 'font-bold');
        btn.classList.add('text-slate-600', 'font-semibold');
    });

    let targetDate = dateVal;
    if (dateVal === 'today') {
        targetDate = REALTIME_TODAY;
        const b = document.getElementById('btnTblToday');
        if (b) { b.classList.add('bg-brand', 'text-white', 'shadow-2xs', 'font-bold'); b.classList.remove('text-slate-600'); }
        const inputTbl = document.getElementById('inputCustomDateTbl');
        if (inputTbl) inputTbl.value = targetDate;
    } else if (dateVal === 'yesterday') {
        targetDate = REALTIME_YESTERDAY;
        const b = document.getElementById('btnTblYesterday');
        if (b) { b.classList.add('bg-brand', 'text-white', 'shadow-2xs', 'font-bold'); b.classList.remove('text-slate-600'); }
        const inputTbl = document.getElementById('inputCustomDateTbl');
        if (inputTbl) inputTbl.value = targetDate;
    } else if (dateVal === 'all') {
        targetDate = 'all';
        const b = document.getElementById('btnTblAll');
        if (b) { b.classList.add('bg-brand', 'text-white', 'shadow-2xs', 'font-bold'); b.classList.remove('text-slate-600'); }
    } else {
        // Custom date picker
        targetDate = dateVal;
        const inputTbl = document.getElementById('inputCustomDateTbl');
        if (inputTbl) inputTbl.value = targetDate;
    }

    activeTableDate = targetDate;
    const labelMode = document.getElementById('labelTampilanMode');
    const thHeader  = document.getElementById('thRekapHeader');

    const allRekapEls = document.querySelectorAll('.view-rekap-akumulasi');
    const allDateEls  = document.querySelectorAll('.view-status-tanggal');

    if (targetDate === 'all') {
        const totalCount = <?= count($sesi_kehadiran); ?>;
        if (labelMode) labelMode.textContent = 'Akumulasi 1 Bulan (' + totalCount + ' Sesi)';
        if (thHeader) thHeader.innerHTML = 'Rekap 1 Bulan (' + totalCount + ' Sesi)';
        
        allRekapEls.forEach(el => el.classList.remove('hidden'));
        allDateEls.forEach(el => el.classList.add('hidden'));
    } else {
        const formatted = formatDateIndo(targetDate);
        if (labelMode) labelMode.textContent = 'Status Presensi Tanggal ' + formatted;
        if (thHeader) thHeader.innerHTML = `<span class="text-brand-dark"><i class="fa-solid fa-calendar-day mr-1"></i>Presensi: ${formatted}</span>`;

        allRekapEls.forEach(el => el.classList.add('hidden'));
        allDateEls.forEach(el => el.classList.remove('hidden'));

        // Render status masing-masing santri pada tanggal targetDate
        document.querySelectorAll('.td-status-col').forEach(td => {
            const santriId = td.getAttribute('data-santri-id');
            const container = document.getElementById('view-tgl-' + santriId);
            if (!container) return;

            const logs = logsByDateAndSantri[targetDate + '_' + santriId] || [];
            if (logs.length === 0) {
                container.innerHTML = `
                    <span class="px-2 py-0.5 rounded text-3xs text-slate-400 bg-slate-100 font-medium inline-flex items-center gap-1 border border-slate-200">
                        <i class="fa-solid fa-minus text-slate-300"></i> Tidak ada sesi
                    </span>
                `;
            } else {
                let html = '<div class="flex flex-col items-center gap-1">';
                logs.forEach(l => {
                    let badgeCls = 'bg-emerald-50 text-emerald-700 border-emerald-300';
                    let iconCls  = 'fa-check text-emerald-600';
                    if (l.status === 'Telat') {
                        badgeCls = 'bg-amber-50 text-amber-700 border-amber-300';
                        iconCls  = 'fa-clock text-amber-600';
                    } else if (l.status === 'Sakit') {
                        badgeCls = 'bg-sky-50 text-sky-700 border-sky-300';
                        iconCls  = 'fa-stethoscope text-sky-600';
                    } else if (l.status === 'Absen') {
                        badgeCls = 'bg-rose-50 text-rose-700 border-rose-300';
                        iconCls  = 'fa-xmark text-rose-600';
                    }

                    html += `
                        <div class="flex items-center gap-1.5" title="${l.nama_sesi || 'Sesi'}: ${l.keterangan || l.status}">
                            <span class="px-2 py-0.5 rounded-full text-2xs font-extrabold border ${badgeCls} inline-flex items-center gap-1 shadow-2xs">
                                <i class="fa-solid ${iconCls}"></i> ${l.status}
                            </span>
                            <span class="text-3xs text-slate-400 font-medium truncate max-w-[110px]">
                                ${l.waktu ? l.waktu.split('-')[0].trim() : ''}
                            </span>
                        </div>
                    `;
                });
                html += '</div>';
                container.innerHTML = html;
            }
        });
    }
}

// Filter Sesi Cards Berdasarkan Filter Cepat / Tanggal Spesifik
function filterSesiByFilter(filterVal, event) {
    document.querySelectorAll('.btn-filter-sesi').forEach(btn => {
        btn.classList.remove('bg-brand', 'text-white', 'shadow-xs', 'font-semibold');
        btn.classList.add('bg-slate-100', 'text-slate-700');
    });

    if (event && event.currentTarget) {
        event.currentTarget.classList.add('bg-brand', 'text-white', 'shadow-xs', 'font-semibold');
        event.currentTarget.classList.remove('bg-slate-100', 'text-slate-700');
    } else {
        const activeBtnMap = {
            'all': 'btnSesiAll',
            'today': 'btnSesiToday',
            'yesterday': 'btnSesiYesterday',
        };
        const activeId = activeBtnMap[filterVal];
        if (activeId) {
            const btn = document.getElementById(activeId);
            if (btn) {
                btn.classList.add('bg-brand', 'text-white', 'shadow-xs', 'font-semibold');
                btn.classList.remove('bg-slate-100', 'text-slate-700');
            }
        }
    }

    const cards = document.querySelectorAll('.card-sesi');
    let visibleCount = 0;

    cards.forEach(c => {
        const d = c.getAttribute('data-date'); // YYYY-MM-DD
        let match = false;
        if (filterVal === 'all') {
            match = true;
        } else if (filterVal === 'today') {
            match = (d === REALTIME_TODAY);
        } else if (filterVal === 'yesterday') {
            match = (d === REALTIME_YESTERDAY);
        } else if (filterVal.startsWith('month:')) {
            const mKey = filterVal.substring(6);
            match = d.startsWith(mKey);
        } else if (filterVal.startsWith('range:')) {
            const parts = filterVal.substring(6).split(':');
            match = (d >= parts[0] && d <= parts[1]);
        } else {
            // Tanggal spesifik YYYY-MM-DD
            match = (d === filterVal);
        }

        if (match) {
            c.style.display = '';
            visibleCount++;
        } else {
            c.style.display = 'none';
        }
    });

    const badge = document.getElementById('sesiCountBadge');
    if (badge) badge.textContent = `${visibleCount} Sesi`;

    const emptyState = document.getElementById('sesiEmptyState');
    if (emptyState) {
        if (visibleCount === 0) {
            emptyState.classList.remove('hidden');
        } else {
            emptyState.classList.add('hidden');
        }
    }
}

function filterSesiByCustomDate(val) {
    if (!val) return;
    filterSesiByFilter(val);
    document.querySelectorAll('.btn-filter-sesi').forEach(btn => {
        btn.classList.remove('bg-brand', 'text-white', 'shadow-xs', 'font-semibold');
        btn.classList.add('bg-slate-100', 'text-slate-700');
    });
}

// Sinkronisasi Sesi & Tanggal pada Modal
function onModalSesiChange() {
    const sel = document.getElementById('modal_sesi_id');
    const opt = sel.options[sel.selectedIndex];
    if (opt && opt.dataset.tanggal) {
        document.getElementById('modal_tanggal').value = opt.dataset.tanggal;
    }
}

function onModalTanggalChange() {
    const tgl = document.getElementById('modal_tanggal').value;
    const sel = document.getElementById('modal_sesi_id');
    // Cari opsi sesi yang sesuai dengan tanggal ini
    for (let i = 0; i < sel.options.length; i++) {
        if (sel.options[i].dataset.tanggal === tgl) {
            sel.selectedIndex = i;
            break;
        }
    }
}

// Fungsi Buka Modal Pilih Sesi Kehadiran (saat klik Hadir / Telat / Sakit / Absen)
function openPilihSesiModal(santri, statusTerpilih) {
    document.getElementById('modal_santri_id').value = santri.id;
    document.getElementById('modal_santri_nama').textContent = santri.nama;
    document.getElementById('modal_santri_kelas').textContent = santri.kelas;
    document.getElementById('modal_santri_id_badge').textContent = 'ID: ' + santri.id;
    document.getElementById('modal_santri_kehadiran_badge').textContent = 'Kehadiran: ' + (santri.kehadiran || 95) + '%';

    // Jika sedang dalam filter tanggal tertentu di tabel, sesuaikan modal ke tanggal tersebut
    if (activeTableDate && activeTableDate !== 'all') {
        document.getElementById('modal_tanggal').value = activeTableDate;
        onModalTanggalChange();
    } else {
        // Default ke sesi teratas
        const sel = document.getElementById('modal_sesi_id');
        if (sel && sel.options.length > 0) {
            onModalSesiChange();
        }
    }

    // Pilih radio status sesuai tombol yang diklik
    updateStatusVisuals(statusTerpilih);

    // Buka modal
    document.getElementById('modalPilihSesiKehadiran').classList.remove('hidden');
}

function updateStatusVisuals(status) {
    const radioHadir = document.getElementById('radio-hadir');
    const radioTelat = document.getElementById('radio-telat');
    const radioSakit = document.getElementById('radio-sakit');
    const radioAbsen = document.getElementById('radio-absen');

    const lblHadir = document.getElementById('label-status-hadir');
    const lblTelat = document.getElementById('label-status-telat');
    const lblSakit = document.getElementById('label-status-sakit');
    const lblAbsen = document.getElementById('label-status-absen');

    // Reset styles
    [lblHadir, lblTelat, lblSakit, lblAbsen].forEach(lbl => {
        lbl.className = 'status-option-label flex flex-col items-center justify-center p-2.5 rounded-xl border-2 border-slate-200 cursor-pointer transition bg-white';
    });

    if (status === 'Hadir') {
        radioHadir.checked = true;
        lblHadir.className = 'status-option-label flex flex-col items-center justify-center p-2.5 rounded-xl border-2 border-emerald-500 bg-emerald-50/80 shadow-xs cursor-pointer transition';
        document.getElementById('modal_keterangan').placeholder = 'Hadir tepat waktu & mengikuti sesi penuh';
    } else if (status === 'Telat') {
        radioTelat.checked = true;
        lblTelat.className = 'status-option-label flex flex-col items-center justify-center p-2.5 rounded-xl border-2 border-amber-500 bg-amber-50/80 shadow-xs cursor-pointer transition';
        document.getElementById('modal_keterangan').placeholder = 'Terlambat masuk sesi (alasan...)';
    } else if (status === 'Sakit') {
        radioSakit.checked = true;
        lblSakit.className = 'status-option-label flex flex-col items-center justify-center p-2.5 rounded-xl border-2 border-sky-500 bg-sky-50/80 shadow-xs cursor-pointer transition';
        document.getElementById('modal_keterangan').placeholder = 'Izin sakit / istirahat di asrama / UKS';
    } else if (status === 'Absen') {
        radioAbsen.checked = true;
        lblAbsen.className = 'status-option-label flex flex-col items-center justify-center p-2.5 rounded-xl border-2 border-rose-500 bg-rose-50/80 shadow-xs cursor-pointer transition';
        document.getElementById('modal_keterangan').placeholder = 'Tidak hadir / tanpa keterangan';
    }
}

function closePilihSesiModal() {
    document.getElementById('modalPilihSesiKehadiran').classList.add('hidden');
}

function openAddSesiModal() {
    document.getElementById('modalAddSesi').classList.remove('hidden');
}

function closeAddSesiModal() {
    document.getElementById('modalAddSesi').classList.add('hidden');
}

// Buka Modal Detail Riwayat 1 Bulan Santri
function openRiwayatSantriModal(santri) {
    document.getElementById('hist_nama').textContent = 'Riwayat Presensi: ' + santri.nama;
    document.getElementById('hist_sub').textContent = 'ID: ' + santri.id + ' • Kelas: ' + santri.kelas + ' • Periode: <?= $periodeAwal; ?> - <?= $periodeAkhir; ?>';
    
    const rekap = rekapBulananData[santri.id] || { count_hadir: 30, count_telat: 1, count_sakit: 1, count_absen: 0 };
    document.getElementById('hist_cnt_hadir').textContent = rekap.count_hadir || 0;
    document.getElementById('hist_cnt_telat').textContent = rekap.count_telat || 0;
    document.getElementById('hist_cnt_sakit').textContent = rekap.count_sakit || 0;
    document.getElementById('hist_cnt_absen').textContent = rekap.count_absen || 0;
    document.getElementById('hist_pct_span').textContent = 'Persentase Kehadiran: ' + (santri.kehadiran || 95) + '%';

    const listContainer = document.getElementById('hist_log_list');
    listContainer.innerHTML = '';

    const logs = logsBySantri[santri.id] || [];
    if (logs.length === 0) {
        listContainer.innerHTML = '<p class="p-4 text-center text-xs text-slate-400">Belum ada catatan log sesi.</p>';
    } else {
        logs.forEach(l => {
            let badgeBg = 'bg-emerald-50 text-emerald-700 border-emerald-200';
            let iconFa = 'fa-check text-emerald-600';
            if (l.status === 'Telat') {
                badgeBg = 'bg-amber-50 text-amber-700 border-amber-200';
                iconFa = 'fa-clock text-amber-600';
            } else if (l.status === 'Sakit') {
                badgeBg = 'bg-sky-50 text-sky-700 border-sky-200';
                iconFa = 'fa-stethoscope text-sky-600';
            } else if (l.status === 'Absen') {
                badgeBg = 'bg-rose-50 text-rose-700 border-rose-200';
                iconFa = 'fa-xmark text-rose-600';
            }

            const item = document.createElement('div');
            item.className = 'p-3 flex items-start justify-between gap-3 hover:bg-slate-50 transition';
            item.innerHTML = `
                <div class="flex items-start gap-2.5">
                    <span class="w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center text-xs shrink-0 mt-0.5">
                        <i class="fa-solid ${iconFa}"></i>
                    </span>
                    <div>
                        <h5 class="text-xs font-bold text-slate-800">${l.nama_sesi || 'Sesi Pertemuan'}</h5>
                        <p class="text-3xs text-slate-400 mt-0.5">
                            <i class="fa-solid fa-calendar mr-1"></i>${formatDateIndo(l.tanggal)} • <i class="fa-solid fa-clock mr-1"></i>${l.waktu || '-'}
                        </p>
                        ${l.keterangan ? `<p class="text-3xs text-slate-600 mt-0.5 italic">"${l.keterangan}"</p>` : ''}
                    </div>
                </div>
                <span class="px-2.5 py-0.5 rounded-full text-2xs font-extrabold border ${badgeBg} shrink-0">
                    ${l.status}
                </span>
            `;
            listContainer.appendChild(item);
        });
    }

    document.getElementById('modalDetailRiwayatSantri').classList.remove('hidden');
}

function closeRiwayatSantriModal() {
    document.getElementById('modalDetailRiwayatSantri').classList.add('hidden');
}

function filterKehadiranTable() {
    const kSelected = document.getElementById('filterKelasKehadiran').value;
    const qSearch   = document.getElementById('searchKehadiranInput').value.toLowerCase().trim();
    const rows      = document.querySelectorAll('.row-santri');

    rows.forEach(r => {
        const rNama  = r.getAttribute('data-nama');
        const rKelas = r.getAttribute('data-kelas');

        const matchKelas = (kSelected === 'all' || rKelas === kSelected);
        const matchSearch = (!qSearch || rNama.includes(qSearch) || rKelas.toLowerCase().includes(qSearch));

        if (matchKelas && matchSearch) {
            r.style.display = '';
        } else {
            r.style.display = 'none';
        }
    });
}
</script>
</body>
</html>
