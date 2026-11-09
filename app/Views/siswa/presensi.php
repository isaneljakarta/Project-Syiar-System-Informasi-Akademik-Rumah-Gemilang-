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
    <?php 
    $page_title = $title ?? 'Presensi Mandiri';
    require_once __DIR__ . '/components/topbar.php'; 
    ?>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto pb-16">

        <!-- ===================== HERO WAVE BANNER ===================== -->
        <?php
        $hero = [
            'breadcrumb' => [
                ['label' => 'Portal Santri', 'url' => base_url('siswa')],
                ['label' => 'Presensi Mandiri']
            ],
            'badge' => 'Lembaga Pendidikan E-RGI Syiar Gemilang',
            'title' => 'Presensi & Kehadiran Mandiri Santri',
            'subtitle' => 'Formulir pencatatan absensi harian santri, verifikasi kehadiran sesi pembelajaran kejuruan, dan riwayat presensi mandiri.',
            'stats' => [
                ['icon' => 'fa-solid fa-user-check', 'bg' => 'bg-emerald-400/20 text-emerald-200', 'value' => ($my_rekap['count_hadir'] ?? 0) . ' Sesi', 'label' => 'Hadir Tepat Waktu'],
                ['icon' => 'fa-solid fa-clock', 'bg' => 'bg-amber-400/20 text-amber-200', 'value' => ($my_rekap['count_telat'] ?? 0) . ' Sesi', 'label' => 'Terlambat'],
                ['icon' => 'fa-solid fa-clipboard-list', 'bg' => 'bg-sky-400/20 text-sky-200', 'value' => count($my_logs ?? []) . ' Log', 'label' => 'Total Riwayat'],
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

        <!-- Alert Peringatan Absen Melebihi Batas (>3x) -->
        <?php if (!empty($is_warning_absen)) : ?>
            <div class="rounded-2xl bg-gradient-to-r from-rose-500 via-rose-600 to-red-700 text-white p-5 sm:p-6 shadow-lg shadow-rose-600/20 border border-rose-400/40 relative overflow-hidden">
                <div class="absolute -right-6 -bottom-6 w-32 h-32 rounded-full bg-white/10 pointer-events-none"></div>
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 relative z-10">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur-md text-white flex items-center justify-center text-2xl shrink-0 border border-white/30 shadow-inner">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </div>
                        <div>
                            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-white/25 text-white text-3xs font-extrabold uppercase tracking-wider mb-1.5 border border-white/30">
                                <i class="fa-solid fa-bell"></i> Peringatan Kedisiplinan Akademik
                            </div>
                            <h3 class="text-base sm:text-lg font-black tracking-tight text-white leading-tight">
                                Perhatian: Anda Telah Tercatat Absen / Alpa Sebanyak <?= (int)$absen_count; ?> Kali!
                            </h3>
                            <p class="text-xs text-white/90 mt-1 max-w-2xl leading-relaxed">
                                Anda telah absen lebih dari 3 kali pertemuan tanpa surat keterangan resmi. Segera konsultasikan kendala presensi Anda kepada <strong>Instruktur Kejuruan</strong> atau <strong>Wali Kelas</strong> sebelum sesi evaluasi bulanan ditutup.
                            </p>
                        </div>
                    </div>
                    <div class="px-3.5 py-2 bg-white/20 backdrop-blur-sm rounded-xl text-xs font-bold border border-white/30 shrink-0 text-center">
                        <span class="block text-3xs uppercase tracking-wider text-white/80">Total Alpa</span>
                        <span class="text-lg font-black text-white"><?= (int)$absen_count; ?> Kali</span>
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

        </div> <!-- /p-4 wrapper -->
    </main>
</div>
</body>
</html>

