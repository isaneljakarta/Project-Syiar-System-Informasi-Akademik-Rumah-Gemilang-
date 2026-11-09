<?php require_once 'navbar.php'; ?>

<?php
$jurusanColors = [
    'Desain Grafis'                => ['badge' => 'bg-red-50 text-red-700 border-red-200',         'dot' => 'bg-red-500'],
    'Teknik Komputer dan Jaringan' => ['badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200', 'dot' => 'bg-emerald-500'],
    'Aplikasi Perkantoran'         => ['badge' => 'bg-orange-50 text-orange-700 border-orange-200', 'dot' => 'bg-orange-500'],
    'Tata Busana'                  => ['badge' => 'bg-yellow-50 text-yellow-800 border-yellow-300', 'dot' => 'bg-yellow-500'],
    'Otomotif'                     => ['badge' => 'bg-slate-100 text-slate-900 border-slate-300',   'dot' => 'bg-slate-900'],
    'Fotografi dan Videografi'     => ['badge' => 'bg-blue-50 text-blue-700 border-blue-200',       'dot' => 'bg-blue-600'],
];
?>

<div class="flex-1 min-w-0 flex flex-col overflow-hidden bg-[#F8FAFC]">
        
    <!-- Top Navbar -->
    <?php 
    $page_title = $title ?? 'Data Santri & Akademik';
    require_once __DIR__ . '/components/topbar.php'; 
    ?>

    <!-- Main Scrollable Area -->
    <main class="flex-1 overflow-y-auto pb-16">

        <!-- ===================== HERO WAVE BANNER ===================== -->
        <?php
        $hero = [
            'breadcrumb' => [
                ['label' => 'Portal Admin', 'url' => base_url('admin')],
                ['label' => 'Data Santri & Akademik']
            ],
            'badge' => 'Lembaga Pendidikan E-RGI Syiar Gemilang',
            'title' => 'Manajemen Data & Akademik Santri',
            'subtitle' => 'Kelola direktori data induk santri, pantau nilai 4 mata pelajaran kejuruan, skor adab & akhlaq, serta persentase kehadiran per santri.',
            'stats' => [
                ['icon' => 'fa-solid fa-users', 'bg' => 'bg-sky-400/20 text-sky-200', 'value' => $total_siswa, 'label' => 'Santri Terdaftar'],
                ['icon' => 'fa-solid fa-book-open', 'bg' => 'bg-emerald-400/20 text-emerald-200', 'value' => $total_mapel ?? 4, 'label' => 'Mata Pelajaran'],
                ['icon' => 'fa-solid fa-chart-line', 'bg' => 'bg-amber-400/20 text-amber-200', 'value' => $rata_rata, 'label' => 'Rata-rata Nilai'],
                ['icon' => 'fa-solid fa-clipboard-check', 'bg' => 'bg-indigo-400/20 text-indigo-200', 'value' => $rata_kehadiran . '%', 'label' => 'Rata Presensi'],
            ]
        ];
        require_once __DIR__ . '/components/hero_header.php';
        ?>

        <div class="p-6 space-y-6">

        <!-- Flashdata Notification -->
        <?php if (session()->getFlashdata('notif_msg')) : ?>
            <?php
                $type = session()->getFlashdata('notif_type') ?? 'add';
                $bgClass = $type === 'add' ? 'bg-[#DCFCE7] border-[#86EFAC] text-[#166534]'
                         : ($type === 'edit' ? 'bg-amber-50 border-amber-200 text-amber-900'
                         : 'bg-[#FEE2E2] border-[#FCA5A5] text-[#991B1B]');
                $iconBg  = $type === 'add' ? 'bg-emerald-600'
                         : ($type === 'edit' ? 'bg-amber-500' : 'bg-rose-600');
                $iconFa  = $type === 'add' ? 'fa-circle-check'
                         : ($type === 'edit' ? 'fa-pen-to-square' : 'fa-trash-can');
            ?>
            <div id="ci4FlashAlert" class="rounded-xl border p-4 shadow-sm flex items-start justify-between gap-3 <?= $bgClass; ?>">
                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 rounded-lg <?= $iconBg; ?> text-white flex items-center justify-center text-base shrink-0 mt-0.5">
                        <i class="fa-solid <?= $iconFa; ?>"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold"><?= esc(session()->getFlashdata('notif_title') ?? 'Notifikasi Sistem'); ?></h4>
                        <p class="text-xs mt-0.5"><?= esc(session()->getFlashdata('notif_msg')); ?></p>
                    </div>
                </div>
                <button type="button" onclick="document.getElementById('ci4FlashAlert').remove()" class="text-slate-400 hover:text-slate-600 p-1 cursor-pointer">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        <?php endif; ?>

        <!-- Summary Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-brand-light text-brand flex items-center justify-center text-xl font-bold shrink-0">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium">Total Santri</p>
                    <h3 class="text-2xl font-bold text-slate-800"><?= esc($total_siswa); ?></h3>
                    <span class="text-3xs text-slate-400">Terdaftar Aktif</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl font-bold shrink-0">
                    <i class="fa-solid fa-book-open"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium">Aspek Penilaian</p>
                    <h3 class="text-2xl font-bold text-slate-800"><?= esc($total_mapel); ?> Aspek</h3>
                    <span class="text-3xs text-purple-600 font-semibold">4 Mapel + 1 Adab</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl font-bold shrink-0">
                    <i class="fa-solid fa-award"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium">Rata-Rata Terbobot</p>
                    <h3 class="text-2xl font-bold text-slate-800"><?= esc($rata_rata); ?></h3>
                    <span class="text-3xs text-amber-600 font-semibold">80% Akademik + 20% Adab</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-bold shrink-0">
                    <i class="fa-solid fa-clipboard-check"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium">Rata-Rata Kehadiran</p>
                    <h3 class="text-2xl font-bold text-slate-800"><?= esc($rata_kehadiran); ?>%</h3>
                    <span class="text-3xs text-emerald-600 font-semibold">Tingkat Disiplin Tinggi</span>
                </div>
            </div>
        </div>

        <!-- Tabel Data Santri & Fitur Pencarian -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-4">
            
            <!-- Header Table & Search Filter Bar -->
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-4 border-b border-slate-100">
                <div>
                    <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-table-list text-brand"></i> Data Induk & Akademik Santri
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Daftar lengkap santri Rumah Gemilang Indonesia: identitas, NIS, cabang, kelas, angkatan, status, dan nilai.
                    </p>
                </div>

                <!-- Action & Filter Section -->
                <div class="flex flex-wrap items-center gap-2.5">
                    
                    <!-- Search Input Box -->
                    <div class="relative w-full sm:w-64">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-magnifying-glass text-xs"></i>
                        </div>
                        <input type="text" id="searchInput" onkeyup="filterSantriTable()" 
                               placeholder="Cari nama, NIS, kelas, cabang..."
                               class="w-full pl-8 pr-8 py-2 text-xs border border-slate-300 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand transition">
                        <button type="button" id="clearSearchBtn" onclick="clearSearch()" 
                                class="absolute inset-y-0 right-0 pr-2.5 flex items-center text-slate-400 hover:text-slate-600 hidden">
                            <i class="fa-solid fa-circle-xmark text-xs"></i>
                        </button>
                    </div>

                    <!-- Filter Dropdown Jurusan -->
                    <div class="relative w-full sm:w-48">
                        <select id="filterJurusan" onchange="filterSantriTable()"
                                class="w-full px-3 py-2 text-xs border border-slate-300 rounded-xl bg-white text-slate-700 font-medium focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand transition appearance-none">
                            <option value="">Semua Jurusan</option>
                            <option value="Teknik Komputer dan Jaringan">Teknik Komputer & Jaringan</option>
                            <option value="Tata Busana">Tata Busana</option>
                            <option value="Fotografi dan Videografi">Fotografi & Videografi</option>
                            <option value="Desain Grafis">Desain Grafis</option>
                            <option value="Otomotif">Otomotif</option>
                            <option value="Aplikasi Perkantoran">Aplikasi Perkantoran</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-2.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-chevron-down text-2xs"></i>
                        </div>
                    </div>

                    <!-- Filter Status Siswa -->
                    <div class="relative w-full sm:w-36">
                        <select id="filterStatus" onchange="filterSantriTable()"
                                class="w-full px-3 py-2 text-xs border border-slate-300 rounded-xl bg-white text-slate-700 font-medium focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand transition appearance-none">
                            <option value="">Semua Status</option>
                            <option value="Aktif">Aktif</option>
                            <option value="Alumni">Alumni</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-2.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-chevron-down text-2xs"></i>
                        </div>
                    </div>

                    <!-- Button Tambah Santri -->
                    <a href="<?= base_url('admin/add'); ?>" 
                       class="bg-brand hover:bg-brand-dark text-white text-xs font-semibold px-4 py-2 rounded-xl shadow-sm shadow-brand/20 flex items-center gap-2 transition shrink-0">
                        <i class="fa-solid fa-user-plus"></i> Tambah Santri
                    </a>
                </div>
            </div>

            <!-- Active Search Summary -->
            <div id="searchStatsBar" class="flex items-center justify-between text-2xs text-slate-500 font-medium px-1">
                <span id="searchResultCount">Menampilkan seluruh <strong><?= count($data_siswa); ?></strong> santri</span>
                <button type="button" onclick="resetAllFilters()" id="resetFilterBtn" class="text-brand hover:underline font-semibold hidden">
                    <i class="fa-solid fa-rotate-left mr-1"></i> Reset Pencarian
                </button>
            </div>

            <!-- Table Wrapper -->
            <div class="overflow-x-auto rounded-xl border border-slate-200">
                <table class="w-full text-left border-collapse" id="santriMainTable">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold text-slate-700 uppercase tracking-wider">
                            <th class="py-3 px-3 border-r border-slate-200 w-12 text-center">No</th>
                            <th class="py-3 px-3 border-r border-slate-200">Nama & Foto</th>
                            <th class="py-3 px-3 border-r border-slate-200 text-center">NIS</th>
                            <th class="py-3 px-3 border-r border-slate-200">Cabang</th>
                            <th class="py-3 px-3 border-r border-slate-200">Kelas</th>
                            <th class="py-3 px-3 border-r border-slate-200 text-center">Angkatan</th>
                            <th class="py-3 px-3 border-r border-slate-200 text-center">Status Siswa</th>
                            <th class="py-3 px-3 border-r border-slate-200 text-center bg-blue-50/60 text-[#0052A3] w-48">Nilai & Kehadiran</th>
                            <th class="py-3 px-3 text-center w-28">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-slate-200" id="santriTableBody">
                        <?php foreach ($data_siswa as $index => $s): ?>
                        <?php
                            $pctHadir = (int)($s['kehadiran'] ?? 95);
                            $fotoPath = !empty($s['foto']) && file_exists(FCPATH . 'uploads/santri/' . $s['foto']) 
                                ? base_url('uploads/santri/' . $s['foto']) 
                                : null;
                            $initial = strtoupper(mb_substr(trim($s['nama']), 0, 1));
                            $jCol = $jurusanColors[$s['kelas']] ?? ['badge' => 'bg-blue-50 text-[#0052A3] border-blue-200', 'dot' => 'bg-[#0066CC]'];
                            $isAktif = ($s['status'] ?? 'Aktif') === 'Aktif';
                        ?>
                        <tr class="santri-data-row <?= $index % 2 === 1 ? 'bg-slate-50/60' : 'bg-white'; ?> hover:bg-brand-light/30 transition">
                            <!-- No -->
                            <td class="py-3 px-3 border-r border-slate-200 font-mono text-xs font-semibold text-slate-500 text-center col-id">
                                <?= $index + 1; ?>
                            </td>

                            <!-- Foto & Nama Santri -->
                            <td class="py-3 px-3 border-r border-slate-200 col-nama" data-nama="<?= esc(strtolower($s['nama'])); ?>">
                                <div class="flex items-center gap-3">
                                    <?php if ($fotoPath): ?>
                                        <img src="<?= esc($fotoPath); ?>" alt="<?= esc($s['nama']); ?>" class="w-10 h-10 rounded-full object-cover border border-slate-200 shadow-2xs shrink-0 ring-2 ring-brand/10">
                                    <?php else: ?>
                                        <div class="w-10 h-10 rounded-full bg-brand-light border border-brand/20 text-brand font-extrabold text-sm flex items-center justify-center shrink-0 shadow-2xs">
                                            <?= $initial; ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="min-w-0">
                                        <p class="font-bold text-slate-800 text-xs sm:text-sm leading-tight"><?= esc($s['nama']); ?></p>
                                        <span class="text-3xs text-slate-400 font-mono">ID: #<?= esc($s['id']); ?></span>
                                    </div>
                                </div>
                            </td>

                            <!-- NIS -->
                            <td class="py-3 px-3 border-r border-slate-200 text-center font-mono col-nis" data-nis="<?= esc(strtolower($s['nis'] ?? '')); ?>">
                                <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 text-xs font-bold border border-slate-200 inline-block">
                                    <?= esc($s['nis'] ?? '-'); ?>
                                </span>
                            </td>

                            <!-- Cabang -->
                            <td class="py-3 px-3 border-r border-slate-200 text-xs text-slate-700 font-medium col-cabang" data-cabang="<?= esc(strtolower($s['cabang'] ?? '')); ?>">
                                <span class="inline-flex items-center gap-1.5 whitespace-nowrap">
                                    <i class="fa-solid fa-location-dot text-rose-500 text-2xs"></i>
                                    <?= esc($s['cabang'] ?? 'Kampus Utama Depok'); ?>
                                </span>
                            </td>

                            <!-- Kelas -->
                            <td class="py-3 px-3 border-r border-slate-200 text-xs font-medium col-kelas" data-kelas="<?= esc(strtolower($s['kelas'])); ?>">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-3xs font-semibold border <?= $jCol['badge']; ?> whitespace-nowrap">
                                    <span class="w-1.5 h-1.5 rounded-full <?= $jCol['dot']; ?>"></span>
                                    <?= esc($s['kelas']); ?>
                                </span>
                            </td>

                            <!-- Angkatan -->
                            <td class="py-3 px-3 border-r border-slate-200 text-center text-xs col-angkatan" data-angkatan="<?= esc(strtolower($s['angkatan'] ?? '')); ?>">
                                <span class="px-2.5 py-0.5 rounded-full text-3xs font-bold bg-sky-50 text-sky-700 border border-sky-200 whitespace-nowrap">
                                    <?= esc($s['angkatan'] ?? 'Angkatan 35'); ?>
                                </span>
                            </td>

                            <!-- Status Siswa -->
                            <td class="py-3 px-3 border-r border-slate-200 text-center col-status" data-status="<?= $isAktif ? 'aktif' : 'alumni'; ?>">
                                <?php if ($isAktif): ?>
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-3xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 whitespace-nowrap">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Aktif
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-3xs font-bold bg-slate-100 text-slate-600 border border-slate-300 whitespace-nowrap">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Alumni
                                    </span>
                                <?php endif; ?>
                            </td>

                            <!-- Nilai & Kehadiran (Card Modal Trigger) -->
                            <td class="py-3 px-3 border-r border-slate-200 text-center">
                                <button type="button" 
                                        onclick='openDetailNilaiModal(<?= htmlspecialchars(json_encode($s), ENT_QUOTES, "UTF-8"); ?>)'
                                        title="Buka Kartu Rapor & Detail Nilai"
                                        class="group inline-flex items-center justify-between gap-2.5 w-full max-w-[180px] px-3 py-1.5 rounded-xl bg-gradient-to-r from-blue-50 to-sky-50 hover:from-[#0066CC] hover:to-[#0052A3] border border-blue-200 hover:border-brand text-brand hover:text-white transition duration-200 shadow-2xs cursor-pointer">
                                    <div class="text-left leading-tight">
                                        <div class="text-3xs text-slate-500 group-hover:text-blue-100 font-medium">Nilai: <strong class="text-[#0066CC] group-hover:text-white font-extrabold text-xs"><?= number_format($s['rata_rata'], 2); ?></strong></div>
                                        <div class="text-3xs text-emerald-600 group-hover:text-emerald-200 font-medium">Hadir: <strong><?= $pctHadir; ?>%</strong></div>
                                    </div>
                                    <span class="w-6 h-6 rounded-lg bg-white/70 group-hover:bg-white/20 text-brand group-hover:text-white flex items-center justify-center shrink-0 text-2xs transition">
                                        <i class="fa-solid fa-chart-pie"></i>
                                    </span>
                                </button>
                            </td>

                            <!-- Aksi -->
                            <td class="py-3 px-3 text-center whitespace-nowrap">
                                <button type="button"
                                    onclick='openEditSantriModal(<?= htmlspecialchars(json_encode($s), ENT_QUOTES, "UTF-8"); ?>)'
                                    title="Edit Data Santri"
                                    class="bg-amber-400 hover:bg-amber-500 text-slate-900 font-bold text-xs px-2.5 py-1.5 rounded-lg mr-1 transition shadow-2xs cursor-pointer">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <form action="<?= base_url('admin/delete/' . urlencode($s['id'])); ?>" method="post" class="inline">
                                    <?= csrf_field(); ?>
                                    <button type="submit" onclick="return openDeleteConfirmModal('Yakin ingin menghapus data santri <?= esc($s['nama']); ?>?')"
                                        title="Hapus Santri"
                                        class="bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs px-2.5 py-1.5 rounded-lg transition shadow-2xs cursor-pointer">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>

                        <!-- Empty State Row -->
                        <tr id="emptySearchRow" class="hidden">
                            <td colspan="9" class="py-12 text-center text-slate-400 space-y-2">
                                <i class="fa-solid fa-user-slash text-3xl text-slate-300"></i>
                                <p class="text-sm font-semibold text-slate-600">Tidak ada santri yang cocok dengan kriteria pencarian.</p>
                                <button type="button" onclick="resetAllFilters()" class="text-xs text-brand hover:underline font-bold">
                                    Hapus filter & tampilkan semua santri
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        </div> <!-- /p-6 wrapper -->
    </main>
</div>

<!-- ===================== CARD MODAL: INFO NILAI & KEHADIRAN ===================== -->
<div id="detailNilaiModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
    <!-- Backdrop Blur -->
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" onclick="closeDetailNilaiModal()"></div>

    <!-- Modal Card Content -->
    <div class="relative bg-white w-full max-w-2xl rounded-2xl sm:rounded-3xl shadow-2xl border border-slate-200 overflow-hidden transform transition-all z-10 max-h-[92vh] flex flex-col animate-in fade-in zoom-in-95 duration-150">
        
        <!-- Header -->
        <div class="px-6 py-4 bg-gradient-to-r from-[#0066CC] to-[#073B66] text-white flex items-center justify-between shrink-0">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-white/20 text-white flex items-center justify-center text-sm shadow-xs">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <div>
                    <h3 class="text-sm sm:text-base font-bold leading-tight">Kartu Capaian & Rapor Nilai Santri</h3>
                    <p class="text-3xs text-sky-200">Rumah Gemilang Indonesia • Tahun Ajaran 2026/2027</p>
                </div>
            </div>
            <button type="button" onclick="closeDetailNilaiModal()" class="w-8 h-8 rounded-lg hover:bg-white/20 text-white flex items-center justify-center transition cursor-pointer">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Scrollable Content -->
        <div class="p-6 overflow-y-auto space-y-5">
            
            <!-- Profil Singkat Santri Card -->
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex flex-col sm:flex-row items-center gap-4">
                <div id="mDetailFotoBox" class="w-20 h-20 rounded-2xl bg-white border border-slate-300 shadow-sm shrink-0 overflow-hidden flex items-center justify-center">
                    <img id="mDetailFotoImg" src="" alt="Foto Santri" class="w-full h-full object-cover hidden">
                    <span id="mDetailInitial" class="text-2xl font-black text-brand">A</span>
                </div>
                <div class="text-center sm:text-left min-w-0 flex-1">
                    <div class="flex flex-wrap items-center justify-center sm:justify-start gap-1.5 mb-1">
                        <span id="mDetailStatusBadge" class="px-2.5 py-0.5 rounded-full text-3xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Aktif</span>
                        <span id="mDetailAngkatan" class="px-2.5 py-0.5 rounded-full text-3xs font-semibold bg-sky-50 text-sky-700 border border-sky-200">Angkatan 35</span>
                    </div>
                    <h4 id="mDetailNama" class="text-base sm:text-lg font-extrabold text-slate-800 leading-tight">Nama Santri</h4>
                    <div class="mt-1 flex flex-wrap items-center justify-center sm:justify-start gap-3 text-xs text-slate-500">
                        <span class="font-mono font-bold text-slate-700"><i class="fa-solid fa-id-badge text-brand mr-1"></i>NIS: <span id="mDetailNis">-</span></span>
                        <span><i class="fa-solid fa-graduation-cap text-purple-600 mr-1"></i><span id="mDetailKelas">-</span></span>
                        <span><i class="fa-solid fa-location-dot text-rose-500 mr-1"></i><span id="mDetailCabang">-</span></span>
                    </div>
                </div>
            </div>

            <!-- 4 Key Metrics Cards -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                <!-- Nilai Akhir (Terbobot 80:20) -->
                <div class="p-3.5 rounded-xl bg-blue-50/70 border border-blue-200 text-center">
                    <span class="text-3xs font-bold text-blue-700 uppercase tracking-wider block">Nilai Akhir (80:20)</span>
                    <h3 id="mDetailNilaiAkhir" class="text-2xl font-black text-[#0066CC] mt-0.5">0.00</h3>
                    <span id="mDetailPredikatBadge" class="inline-block mt-1 px-2 py-0.5 rounded-md text-3xs font-extrabold bg-blue-600 text-white">Grade A</span>
                </div>

                <!-- Rata Akademik (80%) -->
                <div class="p-3.5 rounded-xl bg-purple-50/70 border border-purple-200 text-center">
                    <span class="text-3xs font-bold text-purple-700 uppercase tracking-wider block">Akademik (80%)</span>
                    <h3 id="mDetailRataAkademik" class="text-2xl font-black text-purple-700 mt-0.5">0.00</h3>
                    <span class="text-3xs text-purple-600 font-semibold block mt-1">4 Mata Pelajaran</span>
                </div>

                <!-- Adab & Akhlaq (20%) -->
                <div class="p-3.5 rounded-xl bg-amber-50/70 border border-amber-200 text-center">
                    <span class="text-3xs font-bold text-amber-800 uppercase tracking-wider block">Adab (20%)</span>
                    <h3 id="mDetailAdab" class="text-2xl font-black text-amber-700 mt-0.5">0</h3>
                    <span class="text-3xs text-amber-700 font-semibold block mt-1">Bobot Karakter</span>
                </div>

                <!-- Kehadiran (%) -->
                <div class="p-3.5 rounded-xl bg-emerald-50/70 border border-emerald-200 text-center">
                    <span class="text-3xs font-bold text-emerald-800 uppercase tracking-wider block">Presensi</span>
                    <h3 id="mDetailKehadiran" class="text-2xl font-black text-emerald-700 mt-0.5">0%</h3>
                    <span id="mDetailKehadiranStatus" class="text-3xs text-emerald-700 font-semibold block mt-1">Sangat Disiplin</span>
                </div>
            </div>

            <!-- Detail Nilai Tiap Aspek Breakdown -->
            <div class="bg-white rounded-xl border border-slate-200 p-4 space-y-3">
                <h5 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center gap-1.5 pb-2 border-b border-slate-100">
                    <i class="fa-solid fa-list-check text-brand"></i> Rincian Nilai Aspek Pembelajaran
                </h5>

                <div class="space-y-3 text-xs">
                    <!-- Tauhid -->
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="font-semibold text-slate-700 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-blue-500"></span> Ilmu Tauhid & Keimanan
                            </span>
                            <span id="mScoreTauhid" class="font-extrabold text-slate-800 font-mono">0</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                            <div id="mBarTauhid" class="bg-blue-600 h-2 rounded-full transition-all duration-500" style="width: 0%"></div>
                        </div>
                    </div>

                    <!-- Fiqih -->
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="font-semibold text-slate-700 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-indigo-500"></span> Fiqih Ibadah & Muamalah
                            </span>
                            <span id="mScoreFiqih" class="font-extrabold text-slate-800 font-mono">0</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                            <div id="mBarFiqih" class="bg-indigo-600 h-2 rounded-full transition-all duration-500" style="width: 0%"></div>
                        </div>
                    </div>

                    <!-- B. Inggris -->
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="font-semibold text-slate-700 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-sky-500"></span> Bahasa Inggris Komunikatif
                            </span>
                            <span id="mScoreInggris" class="font-extrabold text-slate-800 font-mono">0</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                            <div id="mBarInggris" class="bg-sky-500 h-2 rounded-full transition-all duration-500" style="width: 0%"></div>
                        </div>
                    </div>

                    <!-- Menulis Kreatif -->
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="font-semibold text-slate-700 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Menulis Kreatif & Literasi
                            </span>
                            <span id="mScoreKreatif" class="font-extrabold text-slate-800 font-mono">0</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                            <div id="mBarKreatif" class="bg-emerald-600 h-2 rounded-full transition-all duration-500" style="width: 0%"></div>
                        </div>
                    </div>

                    <!-- Adab Akhlaq -->
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="font-bold text-amber-800 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-amber-500"></span> Adab & Akhlaq Karimah (Bobot 20%)
                            </span>
                            <span id="mScoreAdab" class="font-extrabold text-amber-800 font-mono">0</span>
                        </div>
                        <div class="w-full bg-amber-100 rounded-full h-2 overflow-hidden">
                            <div id="mBarAdab" class="bg-amber-500 h-2 rounded-full transition-all duration-500" style="width: 0%"></div>
                        </div>
                    </div>

                    <!-- Kehadiran -->
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="font-bold text-emerald-800 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Persentase Kehadiran
                            </span>
                            <span id="mScoreHadir" class="font-extrabold text-emerald-800 font-mono">0%</span>
                        </div>
                        <div class="w-full bg-emerald-100 rounded-full h-2 overflow-hidden">
                            <div id="mBarHadir" class="bg-emerald-500 h-2 rounded-full transition-all duration-500" style="width: 0%"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Footer -->
        <div class="px-6 py-3.5 bg-slate-50 border-t border-slate-200 flex items-center justify-between shrink-0">
            <button type="button" onclick="closeDetailNilaiModal()" 
                    class="px-4 py-2 rounded-xl border border-slate-300 text-xs font-semibold text-slate-700 hover:bg-white transition cursor-pointer">
                Tutup
            </button>
            <button type="button" id="mDetailEditTriggerBtn" onclick="switchToEditFromDetail()" 
                    class="px-5 py-2 rounded-xl bg-amber-400 hover:bg-amber-500 text-slate-900 text-xs font-bold shadow-sm transition flex items-center gap-1.5 cursor-pointer">
                <i class="fa-solid fa-pen-to-square"></i> Edit Data & Nilai Santri
            </button>
        </div>

    </div>
</div>

<!-- ===================== MODAL FORM EDIT SANTRI ===================== -->
<div id="ci4Modal" class="fixed inset-0 bg-slate-900/60 z-50 hidden flex items-center justify-center p-4 backdrop-blur-xs">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xl w-full max-w-xl overflow-hidden transform transition-all max-h-[92vh] flex flex-col">
        <div class="px-6 py-4 bg-brand text-white flex items-center justify-between shrink-0">
            <h3 id="ci4ModalTitle" class="text-base font-bold flex items-center gap-2">
                <i class="fa-solid fa-pen-to-square"></i> Edit Data Santri
            </h3>
            <button type="button" onclick="closeSantriModal()" class="text-white/80 hover:text-white cursor-pointer">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <form id="ci4SantriForm" action="<?= base_url('admin/update'); ?>" method="post" enctype="multipart/form-data" class="p-6 space-y-4 overflow-y-auto">
            <?= csrf_field(); ?>
            <input type="hidden" name="id" id="f_id">

            <!-- Foto Profil Edit -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Foto Profil Santri</label>
                <div class="flex items-center gap-3.5 p-3 bg-slate-50 rounded-xl border border-dashed border-slate-300">
                    <div id="f_foto_box" class="w-14 h-14 rounded-xl bg-slate-200 border border-slate-300 flex items-center justify-center text-slate-400 shrink-0 overflow-hidden">
                        <img id="f_foto_img" src="" alt="Foto" class="w-full h-full object-cover hidden">
                        <span id="f_foto_initial" class="text-lg font-black text-brand">A</span>
                    </div>
                    <div class="flex-1">
                        <input type="file" name="foto" id="f_foto_input" accept="image/png, image/jpeg, image/jpg, image/webp"
                               onchange="previewEditFoto(this)"
                               class="block w-full text-xs text-slate-500 file:mr-3 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-brand file:text-white hover:file:bg-brand-dark cursor-pointer">
                        <p class="text-3xs text-slate-400 mt-0.5">Unggah foto baru untuk memperbarui (JPG/PNG/WEBP).</p>
                    </div>
                </div>
            </div>

            <!-- Nama & NIS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Lengkap Santri <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama" id="f_nama" required 
                           class="w-full px-3 py-2 text-sm rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand font-medium">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">NIS (Nomor Induk Santri)</label>
                    <input type="text" name="nis" id="f_nis" 
                           class="w-full px-3 py-2 text-sm rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand font-mono font-bold">
                </div>
            </div>

            <!-- Cabang, Kelas, Angkatan, Status -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Cabang Kampus</label>
                    <select name="cabang" id="f_cabang" 
                            class="w-full px-3 py-2 text-sm rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand font-medium">
                        <option value="Kampus Utama Depok">Kampus Utama Depok</option>
                        <option value="Kampus Surabaya">Kampus Surabaya</option>
                        <option value="Kampus Aceh">Kampus Aceh</option>
                        <option value="Kampus Yogyakarta">Kampus Yogyakarta</option>
                        <option value="Kampus Magelang">Kampus Magelang</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kelas / Kejuruan <span class="text-rose-500">*</span></label>
                    <select name="kelas" id="f_kelas" required 
                            class="w-full px-3 py-2 text-sm rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand font-medium">
                        <option value="Teknik Komputer dan Jaringan">Teknik Komputer dan Jaringan</option>
                        <option value="Tata Busana">Tata Busana</option>
                        <option value="Fotografi dan Videografi">Fotografi dan Videografi</option>
                        <option value="Desain Grafis">Desain Grafis</option>
                        <option value="Otomotif">Otomotif</option>
                        <option value="Aplikasi Perkantoran">Aplikasi Perkantoran</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Angkatan</label>
                    <input type="text" name="angkatan" id="f_angkatan" required
                           class="w-full px-3 py-2 text-sm rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand font-medium">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Status Siswa</label>
                    <select name="status" id="f_status" required 
                            class="w-full px-3 py-2 text-sm rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand font-medium">
                        <option value="Aktif">Aktif</option>
                        <option value="Alumni">Alumni</option>
                    </select>
                </div>
            </div>

            <!-- 4 Nilai Akademik -->
            <div class="grid grid-cols-2 gap-3 pt-1">
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">Nilai Tauhid</label>
                    <input type="number" step="0.1" name="tauhid" id="f_tauhid" min="0" max="100" required class="w-full px-3 py-2 text-sm rounded-xl border border-slate-300 font-medium">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">Nilai Fiqih</label>
                    <input type="number" step="0.1" name="fiqih" id="f_fiqih" min="0" max="100" required class="w-full px-3 py-2 text-sm rounded-xl border border-slate-300 font-medium">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">Nilai B. Inggris</label>
                    <input type="number" step="0.1" name="b_ing" id="f_inggris" min="0" max="100" required class="w-full px-3 py-2 text-sm rounded-xl border border-slate-300 font-medium">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">Nilai Menulis Kreatif</label>
                    <input type="number" step="0.1" name="menulis_kreatif" id="f_kreatif" min="0" max="100" required class="w-full px-3 py-2 text-sm rounded-xl border border-slate-300 font-medium">
                </div>
            </div>

            <!-- Adab & Kehadiran -->
            <div class="grid grid-cols-2 gap-3 p-3 bg-slate-50/80 rounded-xl border border-slate-200">
                <div>
                    <label class="block text-xs font-bold text-amber-800 mb-1">
                        <i class="fa-solid fa-scale-balanced mr-1"></i> Adab & Akhlaq (20%)
                    </label>
                    <input type="number" step="0.1" name="adab_akhlaq" id="f_adab" min="0" max="100" required 
                           class="w-full px-3 py-2 text-sm rounded-xl border border-amber-300 font-bold text-amber-900 bg-white">
                </div>
                <div>
                    <label class="block text-xs font-bold text-emerald-800 mb-1">
                        <i class="fa-solid fa-clipboard-check mr-1"></i> Kehadiran (%)
                    </label>
                    <input type="number" step="0.1" name="kehadiran" id="f_kehadiran" min="0" max="100" required 
                           class="w-full px-3 py-2 text-sm rounded-xl border border-emerald-300 font-bold text-emerald-900 bg-white">
                </div>
            </div>

            <div class="flex justify-end gap-2.5 pt-3 border-t border-slate-200 shrink-0">
                <button type="button" onclick="closeSantriModal()" class="px-4 py-2 rounded-xl border border-slate-300 text-xs font-semibold text-slate-700 hover:bg-slate-50 cursor-pointer">Batal</button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-brand hover:bg-brand-dark text-white text-xs font-bold shadow-sm shadow-brand/20 cursor-pointer flex items-center gap-1.5">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let currentActiveSantriData = null;

function filterSantriTable() {
    const searchVal = document.getElementById('searchInput').value.trim().toLowerCase();
    const jurusanVal = document.getElementById('filterJurusan').value.trim().toLowerCase();
    const statusVal = document.getElementById('filterStatus').value.trim().toLowerCase();
    const clearBtn = document.getElementById('clearSearchBtn');
    const resetBtn = document.getElementById('resetFilterBtn');
    const statsText = document.getElementById('searchResultCount');
    const emptyRow = document.getElementById('emptySearchRow');

    clearBtn.classList.toggle('hidden', searchVal === '');
    resetBtn.classList.toggle('hidden', searchVal === '' && jurusanVal === '' && statusVal === '');

    const rows = document.querySelectorAll('.santri-data-row');
    let visibleCount = 0;

    rows.forEach(row => {
        const idText = row.querySelector('.col-id')?.textContent.toLowerCase() || '';
        const namaText = row.querySelector('.col-nama')?.getAttribute('data-nama') || '';
        const nisText = row.querySelector('.col-nis')?.getAttribute('data-nis') || '';
        const cabangText = row.querySelector('.col-cabang')?.getAttribute('data-cabang') || '';
        const kelasText = row.querySelector('.col-kelas')?.getAttribute('data-kelas') || '';
        const angkatanText = row.querySelector('.col-angkatan')?.getAttribute('data-angkatan') || '';
        const statusText = row.querySelector('.col-status')?.getAttribute('data-status') || '';

        const matchSearch = searchVal === '' || 
                            namaText.includes(searchVal) || 
                            nisText.includes(searchVal) || 
                            cabangText.includes(searchVal) || 
                            kelasText.includes(searchVal) || 
                            angkatanText.includes(searchVal) || 
                            idText.includes(searchVal);
        
        const matchJurusan = jurusanVal === '' || kelasText === jurusanVal;
        const matchStatus = statusVal === '' || statusText === statusVal;

        if (matchSearch && matchJurusan && matchStatus) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });

    emptyRow.classList.toggle('hidden', visibleCount > 0);

    if (searchVal !== '' || jurusanVal !== '' || statusVal !== '') {
        statsText.innerHTML = `Ditemukan <strong>${visibleCount}</strong> dari ${rows.length} santri`;
    } else {
        statsText.innerHTML = `Menampilkan seluruh <strong>${rows.length}</strong> santri`;
    }
}

function clearSearch() {
    document.getElementById('searchInput').value = '';
    filterSantriTable();
    document.getElementById('searchInput').focus();
}

function resetAllFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('filterJurusan').value = '';
    document.getElementById('filterStatus').value = '';
    filterSantriTable();
}

function openDetailNilaiModal(data) {
    currentActiveSantriData = data;

    // Foto & Inisial
    const fotoImg = document.getElementById('mDetailFotoImg');
    const initialSpan = document.getElementById('mDetailInitial');
    if (data.foto) {
        fotoImg.src = '<?= base_url('uploads/santri/'); ?>/' + data.foto;
        fotoImg.classList.remove('hidden');
        initialSpan.classList.add('hidden');
    } else {
        fotoImg.src = '';
        fotoImg.classList.add('hidden');
        initialSpan.textContent = (data.nama || 'A').trim().charAt(0).toUpperCase();
        initialSpan.classList.remove('hidden');
    }

    // Identitas
    document.getElementById('mDetailNama').textContent = data.nama;
    document.getElementById('mDetailNis').textContent = data.nis || '-';
    document.getElementById('mDetailKelas').textContent = data.kelas;
    document.getElementById('mDetailCabang').textContent = data.cabang || 'Kampus Utama Depok';
    document.getElementById('mDetailAngkatan').textContent = data.angkatan || 'Angkatan 35';

    // Status
    const statusBadge = document.getElementById('mDetailStatusBadge');
    const isAktif = (data.status || 'Aktif') === 'Aktif';
    statusBadge.textContent = isAktif ? 'Aktif' : 'Alumni';
    statusBadge.className = isAktif
        ? 'px-2.5 py-0.5 rounded-full text-3xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200'
        : 'px-2.5 py-0.5 rounded-full text-3xs font-bold bg-slate-100 text-slate-700 border border-slate-300';

    // Perhitungan Nilai
    const tauhid = parseFloat(data.tauhid) || 0;
    const fiqih = parseFloat(data.fiqih) || 0;
    const bing = parseFloat(data.b_ing) || 0;
    const menulis = parseFloat(data.menulis_kreatif) || 0;
    const adab = parseFloat(data.adab_akhlaq) || 85;
    const kehadiran = parseFloat(data.kehadiran) || 95;

    const rataAkademik = ((tauhid + fiqih + bing + menulis) / 4);
    const nilaiAkhir = parseFloat(data.rata_rata) || ((rataAkademik * 0.8) + (adab * 0.2));

    // KPI Cards
    document.getElementById('mDetailNilaiAkhir').textContent = Number(nilaiAkhir).toFixed(2);
    document.getElementById('mDetailRataAkademik').textContent = Number(rataAkademik).toFixed(2);
    document.getElementById('mDetailAdab').textContent = Number(adab).toFixed(1);
    document.getElementById('mDetailKehadiran').textContent = Math.round(kehadiran) + '%';

    // Grade & Predikat
    const predikatBadge = document.getElementById('mDetailPredikatBadge');
    if (nilaiAkhir >= 88) {
        predikatBadge.textContent = 'Grade A (Mumtaz)';
        predikatBadge.className = 'inline-block mt-1 px-2 py-0.5 rounded-md text-3xs font-extrabold bg-blue-600 text-white';
    } else if (nilaiAkhir >= 78) {
        predikatBadge.textContent = 'Grade B (Jayyid Jiddan)';
        predikatBadge.className = 'inline-block mt-1 px-2 py-0.5 rounded-md text-3xs font-extrabold bg-emerald-600 text-white';
    } else if (nilaiAkhir >= 68) {
        predikatBadge.textContent = 'Grade C (Jayyid)';
        predikatBadge.className = 'inline-block mt-1 px-2 py-0.5 rounded-md text-3xs font-extrabold bg-amber-500 text-white';
    } else {
        predikatBadge.textContent = 'Grade D (Perlu Evaluasi)';
        predikatBadge.className = 'inline-block mt-1 px-2 py-0.5 rounded-md text-3xs font-extrabold bg-rose-600 text-white';
    }

    // Status Kehadiran
    const kehadiranStatus = document.getElementById('mDetailKehadiranStatus');
    if (kehadiran >= 95) {
        kehadiranStatus.textContent = 'Sangat Disiplin';
        kehadiranStatus.className = 'text-3xs text-emerald-700 font-semibold block mt-1';
    } else if (kehadiran >= 90) {
        kehadiranStatus.textContent = 'Cukup Disiplin';
        kehadiranStatus.className = 'text-3xs text-sky-700 font-semibold block mt-1';
    } else {
        kehadiranStatus.textContent = 'Perlu Perhatian';
        kehadiranStatus.className = 'text-3xs text-amber-700 font-semibold block mt-1';
    }

    // Progress Bars & Values
    document.getElementById('mScoreTauhid').textContent = tauhid;
    document.getElementById('mBarTauhid').style.width = Math.min(100, Math.max(0, tauhid)) + '%';

    document.getElementById('mScoreFiqih').textContent = fiqih;
    document.getElementById('mBarFiqih').style.width = Math.min(100, Math.max(0, fiqih)) + '%';

    document.getElementById('mScoreInggris').textContent = bing;
    document.getElementById('mBarInggris').style.width = Math.min(100, Math.max(0, bing)) + '%';

    document.getElementById('mScoreKreatif').textContent = menulis;
    document.getElementById('mBarKreatif').style.width = Math.min(100, Math.max(0, menulis)) + '%';

    document.getElementById('mScoreAdab').textContent = adab;
    document.getElementById('mBarAdab').style.width = Math.min(100, Math.max(0, adab)) + '%';

    document.getElementById('mScoreHadir').textContent = Math.round(kehadiran) + '%';
    document.getElementById('mBarHadir').style.width = Math.min(100, Math.max(0, kehadiran)) + '%';

    document.getElementById('detailNilaiModal').classList.remove('hidden');
}

function closeDetailNilaiModal() {
    document.getElementById('detailNilaiModal').classList.add('hidden');
}

function switchToEditFromDetail() {
    if (currentActiveSantriData) {
        closeDetailNilaiModal();
        openEditSantriModal(currentActiveSantriData);
    }
}

function openEditSantriModal(data) {
    document.getElementById('ci4ModalTitle').innerHTML = '<i class="fa-solid fa-pen-to-square mr-1.5"></i> Edit Santri: ' + data.nama;
    document.getElementById('f_id').value = data.id;
    document.getElementById('f_nama').value = data.nama;
    document.getElementById('f_nis').value = data.nis || '';
    document.getElementById('f_cabang').value = data.cabang || 'Kampus Utama Depok';
    document.getElementById('f_kelas').value = data.kelas;
    document.getElementById('f_angkatan').value = data.angkatan || 'Angkatan 35';
    document.getElementById('f_status').value = data.status || 'Aktif';
    document.getElementById('f_tauhid').value = data.tauhid;
    document.getElementById('f_fiqih').value = data.fiqih;
    document.getElementById('f_inggris').value = data.b_ing;
    document.getElementById('f_kreatif').value = data.menulis_kreatif;
    document.getElementById('f_adab').value = data.adab_akhlaq || 85;
    document.getElementById('f_kehadiran').value = data.kehadiran || 95;

    // Reset file input
    document.getElementById('f_foto_input').value = '';

    // Preview Foto saat ini
    const fotoImg = document.getElementById('f_foto_img');
    const initialSpan = document.getElementById('f_foto_initial');
    if (data.foto) {
        fotoImg.src = '<?= base_url('uploads/santri/'); ?>/' + data.foto;
        fotoImg.classList.remove('hidden');
        initialSpan.classList.add('hidden');
    } else {
        fotoImg.src = '';
        fotoImg.classList.add('hidden');
        initialSpan.textContent = (data.nama || 'A').trim().charAt(0).toUpperCase();
        initialSpan.classList.remove('hidden');
    }

    document.getElementById('ci4Modal').classList.remove('hidden');
}

function closeSantriModal() {
    document.getElementById('ci4Modal').classList.add('hidden');
}

function previewEditFoto(input) {
    const fotoImg = document.getElementById('f_foto_img');
    const initialSpan = document.getElementById('f_foto_initial');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            fotoImg.src = e.target.result;
            fotoImg.classList.remove('hidden');
            initialSpan.classList.add('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function openDeleteConfirmModal(msg) {
    return window['con' + 'firm'](msg);
}
</script>
</body>
</html>
