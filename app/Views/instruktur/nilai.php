<?php require_once 'navbar.php'; ?>

<div class="flex-1 min-w-0 flex flex-col overflow-hidden bg-[#F8FAFC]">
        
    <!-- Top Navbar -->
    <?php 
    $page_title = $title ?? 'Input & Update Nilai Santri';
    require_once __DIR__ . '/components/topbar.php'; 
    ?>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto pb-16">

        <!-- ===================== HERO WAVE BANNER ===================== -->
        <?php
        $hero = [
            'breadcrumb' => [
                ['label' => 'Portal Instruktur', 'url' => base_url('instruktur')],
                ['label' => 'Input & Update Nilai']
            ],
            'badge' => 'Lembaga Pendidikan E-RGI Syiar Gemilang',
            'title' => 'Input & Evaluasi Nilai Santri',
            'subtitle' => 'Pencatatan dan pembaruan berkala nilai akademik 4 mata pelajaran dan pembobotan adab santri untuk evaluasi capaian kompetensi.',
            'stats' => [
                ['icon' => 'fa-solid fa-users', 'bg' => 'bg-sky-400/20 text-sky-200', 'value' => count($data_siswa ?? []), 'label' => 'Santri Dinilai'],
                ['icon' => 'fa-solid fa-book-open', 'bg' => 'bg-emerald-400/20 text-emerald-200', 'value' => $total_mapel ?? 4, 'label' => 'Mata Pelajaran'],
                ['icon' => 'fa-solid fa-chart-line', 'bg' => 'bg-amber-400/20 text-amber-200', 'value' => $rata_rata, 'label' => 'Rata-rata Nilai'],
            ]
        ];
        require_once __DIR__ . '/components/hero_header.php';
        ?>

        <div class="p-4 sm:p-6 space-y-6">

        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('notif_title')): ?>
            <div class="p-4 rounded-xl border <?= session()->getFlashdata('notif_type') === 'delete' ? 'bg-red-50 border-red-200 text-red-800' : 'bg-emerald-50 border-emerald-200 text-emerald-800' ?> flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-3">
                    <i class="fa-solid <?= session()->getFlashdata('notif_type') === 'delete' ? 'fa-triangle-exclamation text-red-500' : 'fa-circle-check text-emerald-500' ?> text-xl"></i>
                    <div>
                        <h4 class="text-xs font-bold"><?= esc(session()->getFlashdata('notif_title')); ?></h4>
                        <p class="text-xs opacity-90 mt-0.5"><?= esc(session()->getFlashdata('notif_msg')); ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Stat Overview -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white p-4 rounded-xl sm:rounded-2xl border border-[#E2E8F0] shadow-xs flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-brand-light text-brand flex items-center justify-center font-bold">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div>
                    <span class="text-2xs text-slate-400 font-semibold uppercase">Total Santri</span>
                    <p class="text-xl font-bold text-slate-800"><?= count($data_siswa); ?> Santri</p>
                </div>
            </div>

            <div class="bg-white p-4 rounded-xl sm:rounded-2xl border border-[#E2E8F0] shadow-xs flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                    <i class="fa-solid fa-scale-balanced"></i>
                </div>
                <div>
                    <span class="text-2xs text-slate-400 font-semibold uppercase">Bobot Adab & Akhlaq</span>
                    <p class="text-xl font-bold text-slate-800">20% Nilai Akhir</p>
                </div>
            </div>

            <div class="bg-white p-4 rounded-xl sm:rounded-2xl border border-[#E2E8F0] shadow-xs flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <div>
                    <span class="text-2xs text-slate-400 font-semibold uppercase">Rata-Rata Terbobot</span>
                    <p class="text-xl font-bold text-slate-800"><?= esc($rata_rata); ?></p>
                </div>
            </div>
        </div>

        <!-- Student Table & Search Filter -->
        <div class="bg-white p-4 sm:p-5 rounded-xl sm:rounded-2xl border border-[#E2E8F0] shadow-xs space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-100">
                <div>
                    <h3 class="text-base font-bold text-slate-800 flex items-center gap-2 sg-display">
                        <i class="fa-solid fa-list-check text-emerald-600"></i> Daftar Penilaian Nilai Santri
                    </h3>
                    <p class="text-xs text-slate-500">Klik tombol "Edit Nilai" pada santri untuk mengupdate nilai mata pelajaran & adab.</p>
                </div>
                <!-- Live Search Box -->
                <div class="relative w-full sm:w-64">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-slate-400 text-xs"></i>
                    <input type="text" id="searchSantri" onkeyup="filterTable()" placeholder="Cari santri / kelas..." 
                           class="w-full pl-9 pr-3 py-2 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-brand focus:border-brand focus:outline-none">
                </div>
            </div>

            <div class="overflow-x-auto rounded-xl border border-slate-200">
                <table class="w-full text-left border-collapse" id="santriTable">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold text-slate-700 uppercase">
                            <th class="py-3 px-3 text-center w-12 border-r border-slate-200">No</th>
                            <th class="py-3 px-3 border-r border-slate-200">Nama Santri</th>
                            <th class="py-3 px-3 border-r border-slate-200">Kelas / Jurusan</th>
                            <th class="py-3 px-2 text-center border-r border-slate-200">Tauhid</th>
                            <th class="py-3 px-2 text-center border-r border-slate-200">Fiqih</th>
                            <th class="py-3 px-2 text-center border-r border-slate-200">B. Inggris</th>
                            <th class="py-3 px-2 text-center border-r border-slate-200">Menulis</th>
                            <th class="py-3 px-2 text-center border-r border-slate-200 bg-amber-50/70 text-amber-900 font-bold">Adab (20%)</th>
                            <th class="py-3 px-2 text-center border-r border-slate-200 bg-emerald-50/70 text-emerald-900 font-extrabold">Nilai Akhir</th>
                            <th class="py-3 px-3 text-center w-28">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-xs divide-y divide-slate-200">
                        <?php 
                        $jTheme = [
                            'Desain Grafis'                => 'bg-red-50 text-red-700 border-red-200',
                            'Teknik Komputer dan Jaringan' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                            'Aplikasi Perkantoran'         => 'bg-orange-50 text-orange-700 border-orange-200',
                            'Tata Busana'                  => 'bg-yellow-50 text-yellow-800 border-yellow-300',
                            'Otomotif'                     => 'bg-slate-100 text-slate-900 border-slate-300',
                            'Fotografi dan Videografi'     => 'bg-blue-50 text-blue-700 border-blue-200',
                        ];
                        foreach ($data_siswa as $idx => $s): 
                            $bdg = $jTheme[$s['kelas']] ?? 'bg-blue-50 text-blue-700 border-blue-200';
                        ?>
                        <tr class="hover:bg-slate-50 transition santri-row">
                            <td class="py-2.5 px-3 text-center border-r border-slate-200 font-medium text-slate-500"><?= $idx + 1; ?></td>
                            <td class="py-2.5 px-3 border-r border-slate-200 font-bold text-slate-800 nama-col"><?= esc($s['nama']); ?></td>
                            <td class="py-2.5 px-3 border-r border-slate-200 kelas-col">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-3xs font-semibold border <?= $bdg; ?>">
                                    <?= esc($s['kelas']); ?>
                                </span>
                            </td>
                            <td class="py-2.5 px-2 text-center border-r border-slate-200 font-semibold"><?= esc($s['tauhid']); ?></td>
                            <td class="py-2.5 px-2 text-center border-r border-slate-200 font-semibold"><?= esc($s['fiqih']); ?></td>
                            <td class="py-2.5 px-2 text-center border-r border-slate-200 font-semibold"><?= esc($s['b_ing']); ?></td>
                            <td class="py-2.5 px-2 text-center border-r border-slate-200 font-semibold"><?= esc($s['menulis_kreatif']); ?></td>
                            <td class="py-2.5 px-2 text-center border-r border-slate-200 font-bold text-amber-700 bg-amber-50/30">
                                <?= esc($s['adab_akhlaq']); ?>
                            </td>
                            <td class="py-2.5 px-2 text-center border-r border-slate-200 font-black text-emerald-700 bg-emerald-50/40">
                                <?= number_format($s['rata_rata'], 2); ?>
                            </td>
                            <td class="py-2.5 px-3 text-center">
                                <button type="button" 
                                        onclick="openEditModal(<?= htmlspecialchars(json_encode($s)); ?>)"
                                        class="px-2.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-semibold text-2xs transition flex items-center justify-center gap-1.5 mx-auto shadow-2xs">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit Nilai
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        </div> <!-- /p-4 wrapper -->
    </main>
</div>

<!-- Modal Edit Nilai Santri -->
<div id="modalEditNilai" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center z-50 p-4 hidden">
    <div class="bg-white rounded-2xl max-w-lg w-full shadow-2xl border border-slate-200 overflow-hidden transform transition-all">
        <div class="px-6 py-4 bg-emerald-600 text-white flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-pen-to-square text-lg"></i>
                <h3 class="font-bold text-sm">Update Nilai Santri</h3>
            </div>
            <button type="button" onclick="closeEditModal()" class="text-emerald-100 hover:text-white text-lg">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form action="<?= base_url('/instruktur/nilai/update'); ?>" method="POST" class="p-6 space-y-4">
            <?= csrf_field(); ?>
            <input type="hidden" name="id" id="edit_id">

            <div>
                <label class="block text-2xs font-bold text-slate-500 uppercase tracking-wider mb-1">Nama Santri & Jurusan</label>
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200">
                    <p class="font-bold text-slate-800 text-sm" id="edit_nama">-</p>
                    <p class="text-xs text-slate-500" id="edit_kelas">-</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nilai Tauhid</label>
                    <input type="number" step="0.1" min="0" max="100" name="tauhid" id="edit_tauhid" required
                           class="w-full px-3 py-2 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nilai Fiqih</label>
                    <input type="number" step="0.1" min="0" max="100" name="fiqih" id="edit_fiqih" required
                           class="w-full px-3 py-2 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nilai B. Inggris</label>
                    <input type="number" step="0.1" min="0" max="100" name="b_ing" id="edit_b_ing" required
                           class="w-full px-3 py-2 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Menulis Kreatif</label>
                    <input type="number" step="0.1" min="0" max="100" name="menulis_kreatif" id="edit_menulis_kreatif" required
                           class="w-full px-3 py-2 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
            </div>

            <!-- Adab & Akhlaq with 20% weight highlight -->
            <div class="p-3 bg-amber-50/70 border border-amber-200 rounded-xl space-y-1">
                <div class="flex items-center justify-between">
                    <label class="block text-xs font-bold text-amber-900">
                        <i class="fa-solid fa-award mr-1 text-amber-600"></i> Nilai Adab & Akhlaq
                    </label>
                    <span class="text-2xs font-extrabold bg-amber-200 text-amber-900 px-2 py-0.5 rounded-full">Bobot 20%</span>
                </div>
                <p class="text-2xs text-amber-800">Menentukan 20% nilai rata-rata akhir santri.</p>
                <input type="number" step="0.1" min="0" max="100" name="adab_akhlaq" id="edit_adab_akhlaq" required
                       class="w-full px-3 py-2 text-xs border border-amber-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:outline-none bg-white font-bold text-amber-900">
            </div>

            <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-lg transition">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 text-xs font-bold bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg shadow-sm transition flex items-center gap-1.5">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModal(santri) {
    document.getElementById('edit_id').value = santri.id;
    document.getElementById('edit_nama').textContent = santri.nama;
    document.getElementById('edit_kelas').textContent = santri.kelas;
    document.getElementById('edit_tauhid').value = santri.tauhid;
    document.getElementById('edit_fiqih').value = santri.fiqih;
    document.getElementById('edit_b_ing').value = santri.b_ing;
    document.getElementById('edit_menulis_kreatif').value = santri.menulis_kreatif;
    document.getElementById('edit_adab_akhlaq').value = santri.adab_akhlaq;

    document.getElementById('modalEditNilai').classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('modalEditNilai').classList.add('hidden');
}

function filterTable() {
    const query = document.getElementById('searchSantri').value.toLowerCase();
    const rows = document.querySelectorAll('.santri-row');
    rows.forEach(row => {
        const nama = row.querySelector('.nama-col').textContent.toLowerCase();
        const kelas = row.querySelector('.kelas-col').textContent.toLowerCase();
        if (nama.includes(query) || kelas.includes(query)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script>
</body>
</html>

