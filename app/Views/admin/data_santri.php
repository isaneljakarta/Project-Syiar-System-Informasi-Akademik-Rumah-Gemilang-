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
                        <i class="fa-solid fa-table-list text-brand"></i> Data Nilai & Presensi Kehadiran Santri
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Nilai Akademik (Tauhid, Fiqih, B. Inggris, Menulis), Nilai Adab (20%), dan Kehadiran Santri.
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
                               placeholder="Cari nama santri..."
                               class="w-full pl-8 pr-8 py-2 text-xs border border-slate-300 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand transition">
                        <button type="button" id="clearSearchBtn" onclick="clearSearch()" 
                                class="absolute inset-y-0 right-0 pr-2.5 flex items-center text-slate-400 hover:text-slate-600 hidden">
                            <i class="fa-solid fa-circle-xmark text-xs"></i>
                        </button>
                    </div>

                    <!-- Filter Dropdown Jurusan -->
                    <div class="relative w-full sm:w-52">
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
                            <th class="py-3 px-3 border-r border-slate-200 w-14 text-center">ID</th>
                            <th class="py-3 px-3 border-r border-slate-200">Nama Santri</th>
                            <th class="py-3 px-3 border-r border-slate-200">Kelas / Jurusan</th>
                            <th class="py-3 px-2 border-r border-slate-200 text-center">Tauhid</th>
                            <th class="py-3 px-2 border-r border-slate-200 text-center">Fiqih</th>
                            <th class="py-3 px-2 border-r border-slate-200 text-center">B. Inggris</th>
                            <th class="py-3 px-2 border-r border-slate-200 text-center">Menulis</th>
                            <th class="py-3 px-2 border-r border-slate-200 text-center bg-amber-50/70 text-amber-900 font-bold" title="Bobot 20% dari nilai akhir">
                                Adab (20%)
                            </th>
                            <th class="py-3 px-3 border-r border-slate-200 text-center bg-emerald-50/70 text-emerald-900 font-extrabold w-32">
                                Kehadiran (%)
                            </th>
                            <th class="py-3 px-3 border-r border-slate-200 text-center bg-brand-light text-brand font-extrabold w-28">
                                Nilai Akhir
                            </th>
                            <th class="py-3 px-3 text-center w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-slate-200" id="santriTableBody">
                        <?php foreach ($data_siswa as $index => $s): ?>
                        <?php
                            $pctHadir = (int)($s['kehadiran'] ?? 95);
                            if ($pctHadir >= 95) {
                                $hadirBadge = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                            } elseif ($pctHadir >= 90) {
                                $hadirBadge = 'bg-sky-50 text-sky-700 border-sky-200';
                            } else {
                                $hadirBadge = 'bg-amber-50 text-amber-700 border-amber-200';
                            }
                        ?>
                        <tr class="santri-data-row <?= $index % 2 === 1 ? 'bg-slate-50/60' : 'bg-white'; ?> hover:bg-brand-light/40 transition">
                            <td class="py-3 px-3 border-r border-slate-200 font-mono text-xs font-semibold text-slate-500 text-center col-id"><?= esc($s['id']); ?></td>
                            <td class="py-3 px-3 border-r border-slate-200 font-bold text-slate-800 col-nama"><?= esc($s['nama']); ?></td>
                            <td class="py-3 px-3 border-r border-slate-200 text-xs font-medium col-kelas">
                                <?php $jCol = $jurusanColors[$s['kelas']] ?? ['badge' => 'bg-blue-50 text-[#0052A3] border-blue-200', 'dot' => 'bg-[#0066CC]']; ?>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-3xs font-semibold border <?= $jCol['badge']; ?>">
                                    <span class="w-1.5 h-1.5 rounded-full <?= $jCol['dot']; ?>"></span>
                                    <?= esc($s['kelas']); ?>
                                </span>
                            </td>
                            <td class="py-3 px-2 border-r border-slate-200 text-center font-semibold text-slate-700"><?= esc($s['tauhid']); ?></td>
                            <td class="py-3 px-2 border-r border-slate-200 text-center font-semibold text-slate-700"><?= esc($s['fiqih']); ?></td>
                            <td class="py-3 px-2 border-r border-slate-200 text-center font-semibold text-slate-700"><?= esc($s['b_ing']); ?></td>
                            <td class="py-3 px-2 border-r border-slate-200 text-center font-semibold text-slate-700"><?= esc($s['menulis_kreatif']); ?></td>
                            <td class="py-3 px-2 border-r border-slate-200 text-center font-bold text-amber-700 bg-amber-50/40">
                                <?= esc($s['adab_akhlaq'] ?? 85); ?>
                            </td>
                            <td class="py-3 px-3 border-r border-slate-200 text-center bg-emerald-50/20">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold border <?= $hadirBadge; ?>">
                                    <i class="fa-solid fa-clipboard-check text-2xs mr-0.5"></i><?= $pctHadir; ?>%
                                </span>
                            </td>
                            <td class="py-3 px-3 border-r border-slate-200 text-center font-black text-brand bg-brand-light/50 text-sm">
                                <?= number_format($s['rata_rata'], 2); ?>
                            </td>
                            <td class="py-3 px-3 text-center whitespace-nowrap">
                                <button type="button"
                                    onclick='openEditSantriModal(<?= json_encode($s); ?>)'
                                    class="bg-amber-400 hover:bg-amber-500 text-slate-900 font-bold text-xs px-2.5 py-1.5 rounded-lg mr-1 transition shadow-2xs cursor-pointer">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </button>
                                <form action="<?= base_url('admin/delete/' . urlencode($s['id'])); ?>" method="post" class="inline">
                                    <?= csrf_field(); ?>
                                    <button type="submit" onclick="return openDeleteConfirmModal('Yakin ingin menghapus data santri <?= esc($s['nama']); ?>?')"
                                        class="bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs px-2.5 py-1.5 rounded-lg transition shadow-2xs cursor-pointer">
                                        <i class="fa-solid fa-trash-can"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>

                        <!-- Empty State Row (Hidden by default, shown when search has no matches) -->
                        <tr id="emptySearchRow" class="hidden">
                            <td colspan="11" class="py-12 text-center text-slate-400 space-y-2">
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

<!-- Modal Form Edit Santri (CI4) -->
<div id="ci4Modal" class="fixed inset-0 bg-slate-900/60 z-50 hidden flex items-center justify-center p-4 backdrop-blur-xs">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xl w-full max-w-lg overflow-hidden transform transition-all">
        <div class="px-6 py-4 bg-brand text-white flex items-center justify-between">
            <h3 id="ci4ModalTitle" class="text-base font-bold flex items-center gap-2">
                <i class="fa-solid fa-pen-to-square"></i> Edit Data Santri
            </h3>
            <button type="button" onclick="closeSantriModal()" class="text-white/80 hover:text-white cursor-pointer">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>
        <form id="ci4SantriForm" action="<?= base_url('admin/update'); ?>" method="post" class="p-6 space-y-4">
            <?= csrf_field(); ?>
            <input type="hidden" name="id" id="f_id">
            
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Lengkap Santri</label>
                <input type="text" name="nama" id="f_nama" required 
                       class="w-full px-3 py-2 text-sm rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand font-medium">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Kelas / Jurusan</label>
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

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">Nilai Tauhid</label>
                    <input type="number" step="0.1" name="tauhid" id="f_tauhid" min="0" max="100" required class="w-full px-3 py-2 text-sm rounded-xl border border-slate-300">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">Nilai Fiqih</label>
                    <input type="number" step="0.1" name="fiqih" id="f_fiqih" min="0" max="100" required class="w-full px-3 py-2 text-sm rounded-xl border border-slate-300">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">Nilai B. Inggris</label>
                    <input type="number" step="0.1" name="b_ing" id="f_inggris" min="0" max="100" required class="w-full px-3 py-2 text-sm rounded-xl border border-slate-300">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">Nilai Menulis Kreatif</label>
                    <input type="number" step="0.1" name="menulis_kreatif" id="f_kreatif" min="0" max="100" required class="w-full px-3 py-2 text-sm rounded-xl border border-slate-300">
                </div>
            </div>

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

            <div class="flex justify-end gap-2.5 pt-3 border-t border-slate-200">
                <button type="button" onclick="closeSantriModal()" class="px-4 py-2 rounded-xl border border-slate-300 text-xs font-semibold text-slate-700 hover:bg-slate-50 cursor-pointer">Batal</button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-brand hover:bg-brand-dark text-white text-xs font-bold shadow-sm shadow-brand/20 cursor-pointer flex items-center gap-1.5">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function filterSantriTable() {
    const searchVal = document.getElementById('searchInput').value.trim().toLowerCase();
    const jurusanVal = document.getElementById('filterJurusan').value.trim().toLowerCase();
    const clearBtn = document.getElementById('clearSearchBtn');
    const resetBtn = document.getElementById('resetFilterBtn');
    const statsText = document.getElementById('searchResultCount');
    const emptyRow = document.getElementById('emptySearchRow');

    clearBtn.classList.toggle('hidden', searchVal === '');
    resetBtn.classList.toggle('hidden', searchVal === '' && jurusanVal === '');

    const rows = document.querySelectorAll('.santri-data-row');
    let visibleCount = 0;

    rows.forEach(row => {
        const idText = row.querySelector('.col-id')?.textContent.toLowerCase() || '';
        const namaText = row.querySelector('.col-nama')?.textContent.toLowerCase() || '';
        const kelasText = row.querySelector('.col-kelas')?.textContent.toLowerCase() || '';

        const matchSearch = searchVal === '' || namaText.includes(searchVal) || idText.includes(searchVal) || kelasText.includes(searchVal);
        const matchJurusan = jurusanVal === '' || kelasText === jurusanVal;

        if (matchSearch && matchJurusan) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });

    emptyRow.classList.toggle('hidden', visibleCount > 0);

    if (searchVal !== '' || jurusanVal !== '') {
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
    filterSantriTable();
}

function openEditSantriModal(data) {
    document.getElementById('ci4ModalTitle').innerHTML = '<i class="fa-solid fa-pen-to-square mr-1.5"></i> Edit Santri: ' + data.nama;
    document.getElementById('f_id').value = data.id;
    document.getElementById('f_nama').value = data.nama;
    document.getElementById('f_kelas').value = data.kelas;
    document.getElementById('f_tauhid').value = data.tauhid;
    document.getElementById('f_fiqih').value = data.fiqih;
    document.getElementById('f_inggris').value = data.b_ing;
    document.getElementById('f_kreatif').value = data.menulis_kreatif;
    document.getElementById('f_adab').value = data.adab_akhlaq || 85;
    document.getElementById('f_kehadiran').value = data.kehadiran || 95;
    document.getElementById('ci4Modal').classList.remove('hidden');
}

function closeSantriModal() {
    document.getElementById('ci4Modal').classList.add('hidden');
}

function openDeleteConfirmModal(msg) {
    return window['con' + 'firm'](msg);
}
</script>
</body>
</html>
