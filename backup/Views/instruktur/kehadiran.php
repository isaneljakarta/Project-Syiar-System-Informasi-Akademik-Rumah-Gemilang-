<?php require_once 'navbar.php'; ?>

<div class="flex-1 min-w-0 flex flex-col overflow-hidden bg-[#F8FAFC]">
        
    <!-- Top Navbar -->
    <header class="h-16 bg-white border-b border-[#E2E8F0] flex items-center justify-between px-4 sm:px-6 z-10 shrink-0">
        <div class="flex items-center gap-2 sm:gap-3 min-w-0">
            <button type="button" onclick="toggleMobileSidebar()" class="lg:hidden p-2 -ml-1 text-slate-600 hover:text-brand hover:bg-slate-100 rounded-lg transition" aria-label="Buka Menu Navigasi">
                <i class="fa-solid fa-bars text-lg"></i>
            </button>
            <h1 class="text-base sm:text-lg font-bold text-[#1E293B] truncate sg-display"><?= esc($title); ?></h1>
            <span class="hidden sm:inline-flex bg-emerald-50 text-emerald-700 text-xs font-semibold px-2.5 py-0.5 rounded-full border border-emerald-100 items-center gap-1 shrink-0">
                <i class="fa-solid fa-clipboard-user"></i> Presensi Kehadiran Santri
            </span>
        </div>
        <span class="hidden sm:inline-flex text-xs text-slate-500 font-medium">
            <i class="fa-solid fa-calendar-day text-emerald-600 mr-1"></i> Tanggal Hari Ini: <?= date('d M Y'); ?>
        </span>
    </header>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto p-4 sm:p-6 space-y-6">

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
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                    <i class="fa-solid fa-clipboard-check"></i>
                </div>
                <div>
                    <span class="text-2xs text-slate-400 font-semibold uppercase">Rata-Rata Kehadiran</span>
                    <p class="text-xl font-bold text-slate-800"><?= esc($rata_kehadiran); ?>%</p>
                </div>
            </div>

            <div class="bg-white p-4 rounded-xl sm:rounded-2xl border border-[#E2E8F0] shadow-xs flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center font-bold">
                    <i class="fa-solid fa-calendar-days"></i>
                </div>
                <div>
                    <span class="text-2xs text-slate-400 font-semibold uppercase">Total Sesi Terjadwal</span>
                    <p class="text-xl font-bold text-slate-800"><?= count($sesi_kehadiran); ?> Sesi</p>
                </div>
            </div>
        </div>

        <!-- Student Attendance Marking Section -->
        <div class="bg-white p-4 sm:p-5 rounded-xl sm:rounded-2xl border border-[#E2E8F0] shadow-xs space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-100">
                <div>
                    <h3 class="text-base font-bold text-slate-800 flex items-center gap-2 sg-display">
                        <i class="fa-solid fa-user-check text-emerald-600"></i> Form Presensi Santri per Sesi
                    </h3>
                    <p class="text-xs text-slate-500">Pilih status (Hadir, Telat, Sakit, Absen) pada santri untuk mencatat presensi.</p>
                </div>
                <!-- Live Search Box -->
                <div class="relative w-full sm:w-64">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-slate-400 text-xs"></i>
                    <input type="text" id="searchSantriKehadiran" onkeyup="filterTableKehadiran()" placeholder="Cari santri / kelas..." 
                           class="w-full pl-9 pr-3 py-2 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-brand focus:border-brand focus:outline-none">
                </div>
            </div>

            <div class="overflow-x-auto rounded-xl border border-slate-200">
                <table class="w-full text-left border-collapse" id="tableKehadiran">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold text-slate-700 uppercase">
                            <th class="py-3 px-3 text-center w-12 border-r border-slate-200">No</th>
                            <th class="py-3 px-3 border-r border-slate-200">Nama Santri</th>
                            <th class="py-3 px-3 border-r border-slate-200">Kelas / Jurusan</th>
                            <th class="py-3 px-3 text-center border-r border-slate-200">Kehadiran (%)</th>
                            <th class="py-3 px-3 border-r border-slate-200">Presensi Terakhir</th>
                            <th class="py-3 px-3 text-center w-64">Catat Presensi Cepat</th>
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
                            $lastLog = $presensi_terbaru[$s['id']] ?? null;
                            $bdg = $jTheme[$s['kelas']] ?? 'bg-blue-50 text-blue-700 border-blue-200';
                        ?>
                        <tr class="hover:bg-slate-50 transition santri-presensi-row">
                            <td class="py-2.5 px-3 text-center border-r border-slate-200 font-medium text-slate-500"><?= $idx + 1; ?></td>
                            <td class="py-2.5 px-3 border-r border-slate-200 font-bold text-slate-800 nama-col"><?= esc($s['nama']); ?></td>
                            <td class="py-2.5 px-3 border-r border-slate-200 kelas-col">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-3xs font-semibold border <?= $bdg; ?>">
                                    <?= esc($s['kelas']); ?>
                                </span>
                            </td>
                            <td class="py-2.5 px-3 text-center border-r border-slate-200">
                                <span class="px-2 py-0.5 rounded-full font-bold text-2xs <?= ($s['kehadiran'] ?? 95) >= 90 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200' ?>">
                                    <?= esc($s['kehadiran'] ?? 95); ?>%
                                </span>
                            </td>
                            <td class="py-2.5 px-3 border-r border-slate-200">
                                <?php if ($lastLog): ?>
                                    <div class="flex items-center gap-1.5">
                                        <span class="px-2 py-0.5 rounded text-3xs font-bold 
                                            <?= $lastLog['status'] === 'Hadir' ? 'bg-emerald-100 text-emerald-800' : 
                                               ($lastLog['status'] === 'Telat' ? 'bg-amber-100 text-amber-800' : 
                                               ($lastLog['status'] === 'Sakit' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')); ?>">
                                            <?= esc($lastLog['status']); ?>
                                        </span>
                                        <span class="text-3xs text-slate-500 truncate" title="<?= esc($lastLog['nama_sesi']); ?>">
                                            <?= esc($lastLog['nama_sesi']); ?> (<?= esc($lastLog['tanggal']); ?>)
                                        </span>
                                    </div>
                                <?php else: ?>
                                    <span class="text-3xs text-slate-400 italic">Belum ada riwayat</span>
                                <?php endif; ?>
                            </td>
                            <td class="py-2.5 px-3 text-center">
                                <div class="flex items-center justify-center gap-1">
                                    <button type="button" onclick="openModalPresensi(<?= $s['id']; ?>, '<?= esc($s['nama'], 'js'); ?>', 'Hadir')"
                                            class="px-2 py-1 rounded bg-emerald-100 hover:bg-emerald-200 text-emerald-800 font-bold text-3xs transition">
                                        Hadir
                                    </button>
                                    <button type="button" onclick="openModalPresensi(<?= $s['id']; ?>, '<?= esc($s['nama'], 'js'); ?>', 'Telat')"
                                            class="px-2 py-1 rounded bg-amber-100 hover:bg-amber-200 text-amber-800 font-bold text-3xs transition">
                                        Telat
                                    </button>
                                    <button type="button" onclick="openModalPresensi(<?= $s['id']; ?>, '<?= esc($s['nama'], 'js'); ?>', 'Sakit')"
                                            class="px-2 py-1 rounded bg-blue-100 hover:bg-blue-200 text-blue-800 font-bold text-3xs transition">
                                        Sakit
                                    </button>
                                    <button type="button" onclick="openModalPresensi(<?= $s['id']; ?>, '<?= esc($s['nama'], 'js'); ?>', 'Absen')"
                                            class="px-2 py-1 rounded bg-red-100 hover:bg-red-200 text-red-800 font-bold text-3xs transition">
                                        Absen
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Logs Table -->
        <div class="bg-white p-4 sm:p-5 rounded-xl sm:rounded-2xl border border-[#E2E8F0] shadow-xs space-y-3">
            <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2 sg-display">
                <i class="fa-solid fa-clock-rotate-left text-slate-500"></i> Riwayat Presensi Terbaru
            </h3>
            <div class="overflow-x-auto rounded-xl border border-slate-200 max-h-72">
                <table class="w-full text-left border-collapse">
                    <thead class="sticky top-0 bg-slate-50 border-b border-slate-200 text-2xs font-bold text-slate-600 uppercase">
                        <tr>
                            <th class="py-2 px-3">Tanggal</th>
                            <th class="py-2 px-3">Santri ID</th>
                            <th class="py-2 px-3">Sesi Pertemuan</th>
                            <th class="py-2 px-3 text-center">Status</th>
                            <th class="py-2 px-3">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="text-xs divide-y divide-slate-100">
                        <?php foreach (array_slice($all_logs, 0, 15) as $log): ?>
                        <tr class="hover:bg-slate-50">
                            <td class="py-2 px-3 text-slate-600"><?= esc($log['tanggal']); ?></td>
                            <td class="py-2 px-3 font-semibold text-slate-800">Santri #<?= esc($log['santri_id']); ?></td>
                            <td class="py-2 px-3 text-slate-700"><?= esc($log['nama_sesi']); ?></td>
                            <td class="py-2 px-3 text-center">
                                <span class="px-2 py-0.5 rounded text-3xs font-bold 
                                    <?= $log['status'] === 'Hadir' ? 'bg-emerald-100 text-emerald-800' : 
                                       ($log['status'] === 'Telat' ? 'bg-amber-100 text-amber-800' : 
                                       ($log['status'] === 'Sakit' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')); ?>">
                                    <?= esc($log['status']); ?>
                                </span>
                            </td>
                            <td class="py-2 px-3 text-slate-500 text-2xs"><?= esc($log['keterangan'] ?: '-'); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>
</div>

<!-- Modal Presensi Instruktur -->
<div id="modalPresensi" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center z-50 p-4 hidden">
    <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl border border-slate-200 overflow-hidden transform transition-all">
        <div class="px-6 py-4 bg-emerald-600 text-white flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-clipboard-check text-lg"></i>
                <h3 class="font-bold text-sm">Konfirmasi Presensi Santri</h3>
            </div>
            <button type="button" onclick="closeModalPresensi()" class="text-emerald-100 hover:text-white text-lg">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form action="<?= base_url('/instruktur/kehadiran/catat'); ?>" method="POST" class="p-6 space-y-4">
            <?= csrf_field(); ?>
            <input type="hidden" name="santri_id" id="presensi_santri_id">

            <div>
                <label class="block text-2xs font-bold text-slate-500 uppercase tracking-wider mb-1">Nama Santri</label>
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 font-bold text-slate-800 text-sm" id="presensi_santri_nama">
                    -
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Pilih Sesi Pertemuan</label>
                <select name="sesi_id" id="presensi_sesi_id" required class="w-full px-3 py-2 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    <?php foreach ($sesi_kehadiran as $sesi): ?>
                        <option value="<?= $sesi['id']; ?>">
                            <?= esc($sesi['tanggal']); ?> - <?= esc($sesi['nama_sesi']); ?> (<?= esc($sesi['waktu']); ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Status Kehadiran</label>
                    <select name="status" id="presensi_status" required class="w-full px-3 py-2 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none font-bold">
                        <option value="Hadir">Hadir</option>
                        <option value="Telat">Telat</option>
                        <option value="Sakit">Sakit</option>
                        <option value="Absen">Absen</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Tanggal</label>
                    <input type="date" name="tanggal" id="presensi_tanggal" value="<?= date('Y-m-d'); ?>" required
                           class="w-full px-3 py-2 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Catatan / Keterangan (Opsional)</label>
                <input type="text" name="keterangan" placeholder="Contoh: Izin terlambat 15 menit"
                       class="w-full px-3 py-2 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none">
            </div>

            <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
                <button type="button" onclick="closeModalPresensi()" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-lg transition">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 text-xs font-bold bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg shadow-sm transition flex items-center gap-1.5">
                    <i class="fa-solid fa-check"></i> Simpan Presensi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openModalPresensi(santriId, santriNama, status) {
    document.getElementById('presensi_santri_id').value = santriId;
    document.getElementById('presensi_santri_nama').textContent = santriNama;
    document.getElementById('presensi_status').value = status;
    document.getElementById('modalPresensi').classList.remove('hidden');
}

function closeModalPresensi() {
    document.getElementById('modalPresensi').classList.add('hidden');
}

function filterTableKehadiran() {
    const query = document.getElementById('searchSantriKehadiran').value.toLowerCase();
    const rows = document.querySelectorAll('.santri-presensi-row');
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

