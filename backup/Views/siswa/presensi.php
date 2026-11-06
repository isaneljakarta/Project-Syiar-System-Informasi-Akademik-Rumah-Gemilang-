<?php 
require_once 'navbar.php'; 

$jurusanColors = [
    'Desain Grafis'                => ['bg' => 'bg-red-500',     'badge' => 'bg-red-50 text-red-700 border-red-200'],
    'Teknik Komputer dan Jaringan' => ['bg' => 'bg-emerald-600', 'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200'],
    'Aplikasi Perkantoran'         => ['bg' => 'bg-orange-500',  'badge' => 'bg-orange-50 text-orange-700 border-orange-200'],
    'Tata Busana'                  => ['bg' => 'bg-yellow-500',  'badge' => 'bg-yellow-50 text-yellow-800 border-yellow-300'],
    'Otomotif'                     => ['bg' => 'bg-slate-900',   'badge' => 'bg-slate-100 text-slate-900 border-slate-300'],
    'Fotografi dan Videografi'     => ['bg' => 'bg-[#0066CC]',   'badge' => 'bg-blue-50 text-blue-700 border-blue-200'],
];
$myKelasBadge = $jurusanColors[$santri['kelas']]['badge'] ?? 'bg-blue-50 text-blue-700 border-blue-200';
?>

<div class="flex-1 min-w-0 flex flex-col overflow-hidden bg-[#F8FAFC]">
        
    <!-- Top Navbar -->
    <header class="h-16 bg-white border-b border-[#E2E8F0] flex items-center justify-between px-4 sm:px-6 z-10 shrink-0">
        <div class="flex items-center gap-2 sm:gap-3 min-w-0">
            <button type="button" onclick="toggleMobileSidebar()" class="lg:hidden p-2 -ml-1 text-slate-600 hover:text-brand hover:bg-slate-100 rounded-lg transition" aria-label="Buka Menu Navigasi">
                <i class="fa-solid fa-bars text-lg"></i>
            </button>
            <h1 class="text-base sm:text-lg font-bold text-[#1E293B] truncate sg-display"><?= esc($title); ?></h1>
            <span class="hidden sm:inline-flex bg-brand-light text-brand text-xs font-semibold px-2.5 py-0.5 rounded-full border border-brand-border items-center gap-1 shrink-0">
                <i class="fa-solid fa-clipboard-check"></i> Presensi Mandiri
            </span>
        </div>
        <span class="hidden sm:inline-flex text-xs text-slate-500 font-medium">
            <i class="fa-solid fa-calendar-day text-brand mr-1"></i> Tanggal: <?= date('d M Y'); ?>
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

        <!-- Two Column Layout: Presensi Form (Left) & Riwayat Kehadiran (Right) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

            <!-- Presensi Input Form (5 cols) -->
            <div class="lg:col-span-5 bg-white p-5 sm:p-6 rounded-2xl border border-[#E2E8F0] shadow-xs space-y-5">
                <div class="border-b border-slate-100 pb-3">
                    <span class="text-2xs font-bold text-brand uppercase tracking-wider">Formulir Kehadiran</span>
                    <h3 class="text-base font-bold text-slate-800 flex items-center gap-2 mt-0.5 sg-display">
                        <i class="fa-solid fa-clipboard-user text-brand"></i> Catat Kehadiran Saya
                    </h3>
                    <p class="text-xs text-slate-500 mt-1">Presensi ini terkunci khusus atas nama akun santri Anda.</p>
                </div>

                <!-- Locked User Info Box -->
                <div class="p-3.5 bg-brand-light/70 rounded-xl border border-brand-border flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-brand text-white flex items-center justify-center font-bold text-lg shrink-0">
                        <i class="fa-solid fa-user-graduate"></i>
                    </div>
                    <div class="overflow-hidden flex-1">
                        <span class="text-3xs font-extrabold uppercase tracking-wider text-brand-dark">Nama Santri Terverifikasi</span>
                        <h4 class="text-xs font-bold text-slate-800 truncate"><?= esc($santri['nama']); ?></h4>
                        <div class="flex items-center gap-2 mt-0.5">
                            <span class="inline-flex items-center px-1.5 py-0.2 rounded text-3xs font-semibold border <?= $myKelasBadge; ?>">
                                <?= esc($santri['kelas']); ?>
                            </span>
                            <span class="text-3xs text-slate-500">ID #<?= esc($santri['id']); ?></span>
                        </div>
                    </div>
                </div>

                <!-- Self-attendance form -->
                <form action="<?= base_url('/siswa/presensi/catat'); ?>" method="POST" class="space-y-4">
                    <?= csrf_field(); ?>

                    <div>
                        <label for="sesi_id" class="block text-xs font-semibold text-slate-700 mb-1">
                            Pilih Sesi Pembelajaran / Pertemuan
                        </label>
                        <select name="sesi_id" id="sesi_id" required class="w-full px-3 py-2 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-brand focus:border-brand focus:outline-none">
                            <option value="">-- Pilih Sesi Pertemuan --</option>
                            <?php foreach ($sesi_kehadiran as $sesi): ?>
                                <option value="<?= $sesi['id']; ?>">
                                    <?= esc($sesi['tanggal']); ?> - <?= esc($sesi['nama_sesi']); ?> (<?= esc($sesi['waktu']); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label for="status" class="block text-xs font-semibold text-slate-700 mb-1">
                                Status Kehadiran
                            </label>
                            <select name="status" id="status" required class="w-full px-3 py-2 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-brand focus:border-brand focus:outline-none font-bold">
                                <option value="Hadir" class="text-emerald-700">Hadir</option>
                                <option value="Telat" class="text-amber-700">Telat</option>
                                <option value="Sakit" class="text-blue-700">Sakit</option>
                                <option value="Absen" class="text-red-700">Absen</option>
                            </select>
                        </div>
                        <div>
                            <label for="tanggal" class="block text-xs font-semibold text-slate-700 mb-1">
                                Tanggal Presensi
                            </label>
                            <input type="date" name="tanggal" id="tanggal" value="<?= date('Y-m-d'); ?>" required
                                   class="w-full px-3 py-2 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-brand focus:border-brand focus:outline-none">
                        </div>
                    </div>

                    <div>
                        <label for="keterangan" class="block text-xs font-semibold text-slate-700 mb-1">
                            Keterangan / Catatan Tambahan (Opsional)
                        </label>
                        <input type="text" name="keterangan" id="keterangan" placeholder="Contoh: Mengikuti sesi di Aula Serbaguna"
                               class="w-full px-3 py-2 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-brand focus:border-brand focus:outline-none">
                    </div>

                    <button type="submit" class="w-full py-2.5 px-4 bg-brand hover:bg-brand-dark text-white font-bold rounded-xl text-xs shadow-md shadow-brand/25 transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span>Kirim Presensi Kehadiran</span>
                    </button>
                </form>
            </div>

            <!-- Riwayat & Rekap Santri (7 cols) -->
            <div class="lg:col-span-7 space-y-4">

                <!-- Rekap Stats Badges -->
                <div class="grid grid-cols-4 gap-2.5">
                    <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-3 text-center">
                        <span class="text-3xs font-bold text-emerald-700 uppercase">Hadir</span>
                        <div class="text-xl font-black text-emerald-800 mt-0.5"><?= $my_rekap['count_hadir'] ?? 0; ?></div>
                    </div>
                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-3 text-center">
                        <span class="text-3xs font-bold text-amber-700 uppercase">Telat</span>
                        <div class="text-xl font-black text-amber-800 mt-0.5"><?= $my_rekap['count_telat'] ?? 0; ?></div>
                    </div>
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-3 text-center">
                        <span class="text-3xs font-bold text-blue-700 uppercase">Sakit</span>
                        <div class="text-xl font-black text-blue-800 mt-0.5"><?= $my_rekap['count_sakit'] ?? 0; ?></div>
                    </div>
                    <div class="bg-red-50 border border-red-200 rounded-xl p-3 text-center">
                        <span class="text-3xs font-bold text-red-700 uppercase">Absen</span>
                        <div class="text-xl font-black text-red-800 mt-0.5"><?= $my_rekap['count_absen'] ?? 0; ?></div>
                    </div>
                </div>

                <!-- Detailed History Table -->
                <div class="bg-white p-4 sm:p-5 rounded-xl sm:rounded-2xl border border-[#E2E8F0] shadow-xs space-y-3">
                    <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2 sg-display">
                        <i class="fa-solid fa-clock-rotate-left text-brand"></i> Riwayat Presensi Saya (<?= count($my_logs); ?> Catatan)
                    </h3>

                    <div class="overflow-x-auto rounded-xl border border-slate-200 max-h-96">
                        <table class="w-full text-left border-collapse">
                            <thead class="sticky top-0 bg-slate-50 border-b border-slate-200 text-2xs font-bold text-slate-600 uppercase">
                                <tr>
                                    <th class="py-2.5 px-3">Tanggal</th>
                                    <th class="py-2.5 px-3">Sesi Pertemuan</th>
                                    <th class="py-2.5 px-3 text-center">Status</th>
                                    <th class="py-2.5 px-3">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="text-xs divide-y divide-slate-100">
                                <?php if (empty($my_logs)): ?>
                                    <tr>
                                        <td colspan="4" class="py-6 text-center text-slate-400 italic">Belum ada data presensi yang tercatat.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($my_logs as $log): ?>
                                    <tr class="hover:bg-slate-50">
                                        <td class="py-2.5 px-3 text-slate-600 font-medium"><?= esc($log['tanggal']); ?></td>
                                        <td class="py-2.5 px-3">
                                            <div class="font-bold text-slate-800"><?= esc($log['nama_sesi']); ?></div>
                                            <div class="text-3xs text-slate-400"><?= esc($log['waktu']); ?> &bull; <?= esc($log['lokasi'] ?? 'Aula Serbaguna'); ?></div>
                                        </td>
                                        <td class="py-2.5 px-3 text-center">
                                            <span class="px-2.5 py-0.5 rounded text-3xs font-bold 
                                                <?= $log['status'] === 'Hadir' ? 'bg-emerald-100 text-emerald-800' : 
                                                   ($log['status'] === 'Telat' ? 'bg-amber-100 text-amber-800' : 
                                                   ($log['status'] === 'Sakit' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')); ?>">
                                                <?= esc($log['status']); ?>
                                            </span>
                                        </td>
                                        <td class="py-2.5 px-3 text-slate-500 text-2xs"><?= esc($log['keterangan'] ?: '-'); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>

    </main>
</div>
</body>
</html>

