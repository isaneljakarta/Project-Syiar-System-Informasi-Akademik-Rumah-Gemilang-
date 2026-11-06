<?php 
require_once 'navbar.php'; 

$jurusanColors = [
    'Desain Grafis'                => ['bg' => 'bg-red-500',     'badge' => 'bg-red-50 text-red-700 border-red-200',         'dot' => 'bg-red-500'],
    'Teknik Komputer dan Jaringan' => ['bg' => 'bg-emerald-600', 'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200', 'dot' => 'bg-emerald-500'],
    'Aplikasi Perkantoran'         => ['bg' => 'bg-orange-500',  'badge' => 'bg-orange-50 text-orange-700 border-orange-200', 'dot' => 'bg-orange-500'],
    'Tata Busana'                  => ['bg' => 'bg-yellow-500',  'badge' => 'bg-yellow-50 text-yellow-800 border-yellow-300', 'dot' => 'bg-yellow-500'],
    'Otomotif'                     => ['bg' => 'bg-slate-900',   'badge' => 'bg-slate-100 text-slate-900 border-slate-300',   'dot' => 'bg-slate-900'],
    'Fotografi dan Videografi'     => ['bg' => 'bg-[#0066CC]',   'badge' => 'bg-blue-50 text-blue-700 border-blue-200',       'dot' => 'bg-blue-600'],
];
$myKelasBadge = $jurusanColors[$santri['kelas']]['badge'] ?? 'bg-blue-50 text-blue-700 border-blue-200';
?>

<div class="flex-1 min-w-0 flex flex-col overflow-hidden bg-[#F8FAFC]">
        
    <!-- Top Navbar -->
    <?php 
    $page_title = $title ?? 'Dashboard Santri';
    ob_start();
    ?>
    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border <?= $myKelasBadge; ?>">
        <i class="fa-solid fa-graduation-cap mr-1.5"></i> <?= esc($santri['kelas']); ?>
    </span>
    <?php
    $topbar_extra_right = ob_get_clean();
    require_once __DIR__ . '/components/topbar.php'; 
    ?>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto pb-16">

        <!-- ===================== HERO WAVE BANNER ===================== -->
        <?php
        ob_start();
        ?>
        <a href="<?= base_url('siswa/presensi'); ?>" class="px-3.5 py-2.5 bg-white text-brand-deep hover:bg-brand-light rounded-xl font-bold text-xs shadow-md transition flex items-center gap-1.5 shrink-0">
            <i class="fa-solid fa-clipboard-user text-brand"></i> Presensi Saya
        </a>
        <?php
        $extra_presensi = ob_get_clean();

        $hero = [
            'breadcrumb' => [
                ['label' => 'Portal Santri', 'url' => base_url('siswa')],
                ['label' => 'Dashboard Mandiri']
            ],
            'badge' => 'Lembaga Pendidikan E-RGI Syiar Gemilang',
            'title' => 'Portal Belajar & Capaian: ' . esc($santri['nama']),
            'subtitle' => 'ID Santri: #' . esc($santri['id']) . ' &bull; Jurusan: ' . esc($santri['kelas']) . '. Pantau rekapitulasi nilai 4 mapel kejuruan, penilaian adab akhlaq, serta catatan kehadiran mandiri.',
            'extra_action' => $extra_presensi,
            'stats' => [
                ['icon' => 'fa-solid fa-graduation-cap', 'bg' => 'bg-sky-400/20 text-sky-200', 'value' => esc($santri['kelas']), 'label' => 'Kelas Kejuruan'],
                ['icon' => 'fa-solid fa-trophy', 'bg' => 'bg-amber-400/20 text-amber-200', 'value' => '#' . ($rank ?? '-'), 'label' => 'Peringkat Kelas'],
                ['icon' => 'fa-solid fa-calendar-check', 'bg' => 'bg-emerald-400/20 text-emerald-200', 'value' => esc($santri['kehadiran']) . '%', 'label' => 'Kehadiran Anda'],
            ]
        ];
        require_once __DIR__ . '/components/hero_header.php';
        ?>

        <div class="p-4 sm:p-6 space-y-6">

        <!-- Grade Summary & Final Score -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-5">

            <!-- Left: Final Score Hero (5 cols) -->
            <div class="md:col-span-5 bg-white rounded-2xl p-6 border border-[#E2E8F0] shadow-xs flex flex-col justify-between space-y-4">
                <div>
                    <div class="flex items-center justify-between">
                        <span class="text-2xs font-bold text-slate-400 uppercase tracking-wider">Nilai Akhir Terbobot</span>
                        <span class="text-2xs bg-brand-light text-brand font-extrabold px-2.5 py-0.5 rounded-full border border-brand-border">
                            80% Akad. + 20% Adab
                        </span>
                    </div>
                    <div class="mt-4 text-center py-4 bg-gradient-to-b from-brand-light/60 to-white rounded-xl border border-brand-border">
                        <div class="text-5xl font-black text-brand tracking-tight">
                            <?= number_format($santri['rata_rata'], 2); ?>
                        </div>
                        <p class="text-xs text-slate-500 font-medium mt-1">Akumulasi Rata-Rata Terbobot</p>
                        <div class="mt-3 inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 text-amber-800 border border-amber-200 text-2xs font-bold">
                            <i class="fa-solid fa-award text-amber-500"></i> Peringkat Ke-<?= $rank; ?> Keseluruhan
                        </div>
                    </div>
                </div>

                <div class="space-y-2 pt-2 border-t border-slate-100 text-xs">
                    <div class="flex items-center justify-between text-slate-600">
                        <span>Rata-Rata Akademik (80%)</span>
                        <span class="font-bold text-slate-800"><?= number_format($santri['rata_akademik'], 2); ?></span>
                    </div>
                    <div class="flex items-center justify-between text-slate-600">
                        <span>Nilai Adab & Akhlaq (20%)</span>
                        <span class="font-bold text-amber-700"><?= esc($santri['adab_akhlaq']); ?></span>
                    </div>
                    <div class="flex items-center justify-between text-slate-600">
                        <span>Persentase Kehadiran</span>
                        <span class="font-bold text-emerald-700"><?= esc($santri['kehadiran']); ?>%</span>
                    </div>
                </div>
            </div>

            <!-- Right: Subject Scores Cards (7 cols) -->
            <div class="md:col-span-7 space-y-4">
                <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2 sg-display">
                    <i class="fa-solid fa-book-bookmark text-brand"></i> Rincian Nilai per Mata Pelajaran & Adab
                </h3>

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    <!-- Tauhid -->
                    <div class="bg-white p-3.5 rounded-xl border border-[#E2E8F0] shadow-2xs">
                        <span class="text-3xs font-bold text-slate-400 uppercase">Mata Pelajaran</span>
                        <h4 class="text-xs font-bold text-slate-700 mt-0.5">Tauhid</h4>
                        <div class="text-2xl font-black text-slate-800 mt-2"><?= esc($santri['tauhid']); ?></div>
                        <span class="text-3xs text-brand font-semibold">Bobot Akademik</span>
                    </div>

                    <!-- Fiqih -->
                    <div class="bg-white p-3.5 rounded-xl border border-[#E2E8F0] shadow-2xs">
                        <span class="text-3xs font-bold text-slate-400 uppercase">Mata Pelajaran</span>
                        <h4 class="text-xs font-bold text-slate-700 mt-0.5">Fiqih</h4>
                        <div class="text-2xl font-black text-slate-800 mt-2"><?= esc($santri['fiqih']); ?></div>
                        <span class="text-3xs text-brand font-semibold">Bobot Akademik</span>
                    </div>

                    <!-- B. Inggris -->
                    <div class="bg-white p-3.5 rounded-xl border border-[#E2E8F0] shadow-2xs">
                        <span class="text-3xs font-bold text-slate-400 uppercase">Mata Pelajaran</span>
                        <h4 class="text-xs font-bold text-slate-700 mt-0.5">B. Inggris</h4>
                        <div class="text-2xl font-black text-slate-800 mt-2"><?= esc($santri['b_ing']); ?></div>
                        <span class="text-3xs text-brand font-semibold">Bobot Akademik</span>
                    </div>

                    <!-- Menulis Kreatif -->
                    <div class="bg-white p-3.5 rounded-xl border border-[#E2E8F0] shadow-2xs">
                        <span class="text-3xs font-bold text-slate-400 uppercase">Mata Pelajaran</span>
                        <h4 class="text-xs font-bold text-slate-700 mt-0.5">Menulis Kreatif</h4>
                        <div class="text-2xl font-black text-slate-800 mt-2"><?= esc($santri['menulis_kreatif']); ?></div>
                        <span class="text-3xs text-brand font-semibold">Bobot Akademik</span>
                    </div>

                    <!-- Adab & Akhlaq (Special) -->
                    <div class="col-span-2 bg-gradient-to-r from-amber-50 to-orange-50 p-3.5 rounded-xl border border-amber-200 shadow-2xs flex items-center justify-between">
                        <div>
                            <span class="text-3xs font-bold text-amber-700 uppercase">Karakter & Disiplin</span>
                            <h4 class="text-xs font-extrabold text-amber-900 mt-0.5 flex items-center gap-1.5">
                                <i class="fa-solid fa-heart text-amber-600"></i> Adab & Akhlaq
                            </h4>
                            <span class="text-3xs text-amber-800 font-semibold mt-1 inline-block">
                                Berkontribusi 20% langsung ke nilai akhir
                            </span>
                        </div>
                        <div class="text-3xl font-black text-amber-700">
                            <?= esc($santri['adab_akhlaq']); ?>
                        </div>
                    </div>
                </div>

                <!-- Presensi Stats Badges -->
                <div class="bg-white p-3.5 rounded-xl border border-[#E2E8F0] flex items-center justify-between text-xs">
                    <span class="font-semibold text-slate-700">Rekap Presensi Saya:</span>
                    <div class="flex items-center gap-2 font-bold text-2xs">
                        <span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-800">Hadir: <?= $my_rekap['count_hadir'] ?? 0; ?></span>
                        <span class="px-2 py-0.5 rounded bg-amber-100 text-amber-800">Telat: <?= $my_rekap['count_telat'] ?? 0; ?></span>
                        <span class="px-2 py-0.5 rounded bg-blue-100 text-blue-800">Sakit: <?= $my_rekap['count_sakit'] ?? 0; ?></span>
                        <span class="px-2 py-0.5 rounded bg-red-100 text-red-800">Absen: <?= $my_rekap['count_absen'] ?? 0; ?></span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Attendance Logs Table for this Student -->
        <div class="bg-white p-4 sm:p-5 rounded-xl sm:rounded-2xl border border-[#E2E8F0] shadow-xs space-y-3">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2 sg-display">
                    <i class="fa-solid fa-clock-rotate-left text-brand"></i> Riwayat Presensi Kehadiran Saya
                </h3>
                <a href="<?= base_url('siswa/presensi'); ?>" class="text-xs font-semibold text-brand hover:text-brand-dark transition">
                    Isi Presensi Sesi Baru &rarr;
                </a>
            </div>

            <div class="overflow-x-auto rounded-lg border border-slate-200 max-h-80">
                <table class="w-full text-left border-collapse">
                    <thead class="sticky top-0 bg-slate-50 border-b border-slate-200 text-2xs font-bold text-slate-600 uppercase">
                        <tr>
                            <th class="py-2.5 px-3">Tanggal</th>
                            <th class="py-2.5 px-3">Sesi Pembelajaran</th>
                            <th class="py-2.5 px-3">Waktu & Lokasi</th>
                            <th class="py-2.5 px-3 text-center">Status</th>
                            <th class="py-2.5 px-3">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="text-xs divide-y divide-slate-100">
                        <?php if (empty($my_logs)): ?>
                            <tr>
                                <td colspan="5" class="py-4 text-center text-slate-400 italic">Belum ada catatan presensi.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($my_logs as $log): ?>
                            <tr class="hover:bg-slate-50">
                                <td class="py-2.5 px-3 text-slate-600 font-medium"><?= esc($log['tanggal']); ?></td>
                                <td class="py-2.5 px-3 font-bold text-slate-800"><?= esc($log['nama_sesi']); ?></td>
                                <td class="py-2.5 px-3 text-slate-500 text-2xs"><?= esc($log['waktu']); ?> &bull; <?= esc($log['lokasi'] ?? 'Aula Serbaguna'); ?></td>
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

        </div> <!-- /p-4 wrapper -->
    </main>
</div>
</body>
</html>

