<?php require_once 'navbar.php'; ?>

<div class="flex-1 flex flex-col overflow-hidden">
        
    <!-- Top Navbar -->
    <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 z-10 shrink-0">
        <div class="flex items-center gap-3">
            <h1 class="text-lg font-bold text-slate-800"><?= esc($title); ?></h1>
            <span class="hidden sm:inline-flex bg-indigo-50 text-indigo-700 text-xs font-semibold px-2.5 py-0.5 rounded-full border border-indigo-100 items-center gap-1">
                <i class="fa-solid fa-graduation-cap"></i> Portal Manajemen Nilai & Presensi
            </span>
        </div>
        <span class="bg-indigo-50 text-indigo-700 text-xs font-semibold px-3 py-1 rounded-full border border-indigo-100 flex items-center gap-1.5">
            <i class="fa-solid fa-calendar-days"></i> Tahun Ajaran: 2026/2027 (Ganjil)
        </span>
    </header>

    <!-- Main Scrollable Area -->
    <main class="flex-1 overflow-y-auto p-6 space-y-6">
        
        <!-- Summary Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl font-bold shrink-0">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium">Total Santri</p>
                    <h3 class="text-2xl font-bold text-slate-800"><?= esc($total_siswa); ?></h3>
                    <span class="text-3xs text-slate-400">Terdaftar Aktif</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center text-xl font-bold shrink-0">
                    <i class="fa-solid fa-book-open"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium">Aspek Penilaian</p>
                    <h3 class="text-2xl font-bold text-slate-800"><?= esc($total_mapel); ?> Aspek</h3>
                    <span class="text-3xs text-purple-600 font-semibold">4 Mapel + 1 Adab</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-xl font-bold shrink-0">
                    <i class="fa-solid fa-award"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium">Rata-Rata Nilai Terbobot</p>
                    <h3 class="text-2xl font-bold text-slate-800"><?= esc($rata_rata); ?></h3>
                    <span class="text-3xs text-amber-600 font-semibold">80% Akademik + 20% Adab</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-bold shrink-0">
                    <i class="fa-solid fa-clipboard-check"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium">Rata-Rata Kehadiran</p>
                    <h3 class="text-2xl font-bold text-slate-800"><?= esc($rata_kehadiran); ?>%</h3>
                    <span class="text-3xs text-emerald-600 font-semibold">Tingkat Disiplin Tinggi</span>
                </div>
            </div>
        </div>

        <!-- Info Bobot Penilaian Adab & Akhlaq (20%) -->
        <div class="bg-gradient-to-r from-indigo-50/80 via-white to-amber-50/80 border border-indigo-100 rounded-xl p-4 shadow-2xs flex flex-col md:flex-row md:items-center justify-between gap-3">
            <div class="flex items-start gap-3">
                <div class="w-9 h-9 rounded-lg bg-indigo-600 text-white flex items-center justify-center text-base shrink-0 mt-0.5">
                    <i class="fa-solid fa-scale-balanced"></i>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                        Formula Penilaian Terbobot
                        <span class="text-2xs bg-amber-100 text-amber-800 font-bold px-2 py-0.5 rounded-full border border-amber-300">
                            Adab & Akhlaq: 20%
                        </span>
                    </h4>
                    <p class="text-xs text-slate-600 mt-0.5 leading-relaxed">
                        Nilai akhir santri dikalkulasikan dengan komposisi: <strong class="text-indigo-900">80% Nilai Akademik</strong> (Tauhid, Fiqih, B. Inggris, dan Menulis Kreatif) dan <strong class="text-amber-800">20% Nilai Adab & Akhlaq</strong> santri dalam keseharian.
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-2 shrink-0 self-end md:self-auto">
                <a href="<?= base_url('admin/data'); ?>" class="text-xs font-semibold px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-slate-700 hover:bg-slate-50 transition shadow-2xs">
                    <i class="fa-solid fa-user-graduate mr-1"></i> Data Santri
                </a>
                <a href="<?= base_url('admin/kehadiran'); ?>" class="text-xs font-semibold px-3 py-1.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition shadow-2xs">
                    <i class="fa-solid fa-clipboard-user mr-1"></i> Sesi Kehadiran
                </a>
            </div>
        </div>

        <!-- Section: Persentase dari Setiap Jurusan -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-3 border-b border-slate-100">
                <div>
                    <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-chart-pie text-indigo-600"></i> Persentase & Distribusi Santri per Jurusan
                    </h3>
                    <p class="text-xs text-slate-500">Distribusi jumlah santri dan persentase keterwakilan di setiap jurusan / kelas rombel.</p>
                </div>
                <span class="text-xs font-semibold px-3 py-1 rounded-full bg-slate-100 text-slate-700 border border-slate-200 w-fit">
                    Total: <?= count($persentase_jurusan); ?> Jurusan
                </span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">
                <!-- Chart Container (Doughnut Chart) -->
                <div class="lg:col-span-5 flex flex-col items-center justify-center p-2">
                    <div class="relative w-56 h-56">
                        <canvas id="jurusanDoughnutChart"></canvas>
                        <!-- Center text in doughnut -->
                        <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                            <span class="text-2xl font-black text-slate-800"><?= esc($total_siswa); ?></span>
                            <span class="text-3xs font-bold text-slate-400 uppercase tracking-wider">Santri</span>
                        </div>
                    </div>
                    <p class="text-3xs text-slate-400 mt-2 text-center">Arahkan kursor pada bagan untuk detail jumlah & persentase</p>
                </div>

                <!-- Jurusan Cards & Progress Bars -->
                <div class="lg:col-span-7 space-y-3">
                    <?php
                    $jurusanColors = [
                        'Teknik Komputer dan Jaringan' => ['bg' => 'bg-emerald-500', 'text' => 'text-emerald-600', 'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200', 'icon' => 'fa-network-wired'],
                        'Tata Busana'                  => ['bg' => 'bg-yellow-500',   'text' => 'text-yellow-600',   'badge' => 'bg-yellow-50 text-yellow-700 border-yellow-200',     'icon' => 'fa-scissors'],
                        'Fotografi dan Videografi'     => ['bg' => 'bg-sky-500',    'text' => 'text-sky-600',    'badge' => 'bg-sky-50 text-sky-700 border-sky-200',       'icon' => 'fa-camera'],
                        'Desain Grafis'                => ['bg' => 'bg-red-500', 'text' => 'text-red-600', 'badge' => 'bg-red-50 text-red-700 border-red-200', 'icon' => 'fa-palette'],
                        'Otomotif'                     => ['bg' => 'bg-zinc-500',  'text' => 'text-zinc-600',  'badge' => 'bg-zinc-50 text-zinc-700 border-zinc-200',   'icon' => 'fa-wrench'],
                        'Aplikasi Perkantoran'         => ['bg' => 'bg-amber-500','text' => 'text-amber-600','badge' => 'bg-amber-50 text-amber-700 border-amber-200','icon' => 'fa-briefcase'],
                    ];
                    ?>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <?php foreach ($persentase_jurusan as $j): ?>
                            <?php 
                                $kName = $j['kelas'];
                                $theme = $jurusanColors[$kName] ?? ['bg' => 'bg-indigo-500', 'text' => 'text-indigo-600', 'badge' => 'bg-indigo-50 text-indigo-700 border-indigo-200', 'icon' => 'fa-graduation-cap'];
                            ?>
                            <div class="p-3 rounded-lg border border-slate-200 bg-slate-50/50 hover:bg-white hover:border-slate-300 transition shadow-2xs">
                                <div class="flex items-center justify-between mb-1.5">
                                    <div class="flex items-center gap-2 truncate">
                                        <i class="fa-solid <?= $theme['icon']; ?> <?= $theme['text']; ?> text-xs"></i>
                                        <h4 class="text-xs font-bold text-slate-800 truncate" title="<?= esc($kName); ?>">
                                            <?= esc($kName); ?>
                                        </h4>
                                    </div>
                                    <span class="text-xs font-extrabold px-2 py-0.5 rounded-full border <?= $theme['badge']; ?>">
                                        <?= $j['persentase']; ?>%
                                    </span>
                                </div>

                                <!-- Progress bar visual -->
                                <div class="w-full bg-slate-200/80 rounded-full h-2 overflow-hidden mb-1.5">
                                    <div class="<?= $theme['bg']; ?> h-2 rounded-full transition-all duration-500" style="width: <?= min(100, $j['persentase'] * 3.5); ?>%"></div>
                                </div>

                                <div class="flex items-center justify-between text-3xs text-slate-500 font-medium">
                                    <span><i class="fa-solid fa-user-group text-slate-400 mr-1"></i><?= $j['total_santri']; ?> Santri</span>
                                    <span><i class="fa-solid fa-clipboard-check text-emerald-500 mr-1"></i>Kehadiran: <?= $j['avg_kehadiran'] ?? 95; ?>%</span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Leaderboard Section: Top 5 Siswa Terbaik -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-3 border-b border-slate-100">
                <div>
                    <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-trophy text-amber-500"></i> Top 5 Santri Terbaik (Nilai Terbobot)
                    </h3>
                    <p class="text-xs text-slate-500">Peringkat 5 besar santri berdasarkan nilai akhir 80% Akademik + 20% Adab & Akhlaq.</p>
                </div>
                <a href="<?= base_url('admin/pemeringkatan'); ?>" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 flex items-center gap-1 transition">
                    Lihat Peringkat Selengkapnya <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <div class="overflow-x-auto rounded-lg border border-slate-200">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold text-slate-700 uppercase">
                            <th class="py-3 px-3 text-center w-16 border-r border-slate-200">Rank</th>
                            <th class="py-3 px-3 border-r border-slate-200">Nama Santri</th>
                            <th class="py-3 px-3 border-r border-slate-200">Kelas / Jurusan</th>
                            <th class="py-3 px-3 text-center border-r border-slate-200">Akademik (80%)</th>
                            <th class="py-3 px-3 text-center border-r border-slate-200 bg-amber-50/50 text-amber-900">Adab & Akhlaq (20%)</th>
                            <th class="py-3 px-3 text-center border-r border-slate-200">Kehadiran</th>
                            <th class="py-3 px-3 text-center bg-indigo-50/60 text-indigo-900 font-extrabold w-32">Nilai Akhir</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-slate-200">
                        <?php foreach ($top_students as $index => $student): ?>
                        <?php
                            $rank = $index + 1;
                            if ($rank === 1) {
                                $rankBadge = '<span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-amber-400 text-slate-900 font-bold text-xs shadow-xs">🥇 1</span>';
                            } elseif ($rank === 2) {
                                $rankBadge = '<span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-slate-300 text-slate-800 font-bold text-xs shadow-xs">🥈 2</span>';
                            } elseif ($rank === 3) {
                                $rankBadge = '<span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-orange-400 text-white font-bold text-xs shadow-xs">🥉 3</span>';
                            } else {
                                $rankBadge = '<span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-slate-100 text-slate-700 font-bold text-xs">' . $rank . '</span>';
                            }
                        ?>
                        <tr class="<?= $index % 2 === 1 ? 'bg-slate-50/70' : 'bg-white'; ?> hover:bg-indigo-50/40 transition">
                            <td class="py-3 px-3 text-center border-r border-slate-200 font-bold">
                                <?= $rankBadge; ?>
                            </td>
                            <td class="py-3 px-3 border-r border-slate-200 font-medium text-slate-800"><?= esc($student['nama']); ?></td>
                            <td class="py-3 px-3 border-r border-slate-200 text-slate-600"><?= esc($student['kelas']); ?></td>
                            <td class="py-3 px-3 border-r border-slate-200 text-center font-semibold text-slate-700">
                                <?= number_format($student['rata_akademik'] ?? $student['rata_rata'], 2); ?>
                            </td>
                            <td class="py-3 px-3 border-r border-slate-200 text-center font-bold text-amber-700 bg-amber-50/30">
                                <?= esc($student['adab_akhlaq'] ?? 85); ?>
                            </td>
                            <td class="py-3 px-3 border-r border-slate-200 text-center">
                                <span class="px-2 py-0.5 rounded-full text-2xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <?= esc($student['kehadiran'] ?? 95); ?>%
                                </span>
                            </td>
                            <td class="py-3 px-3 text-center font-extrabold text-indigo-700 bg-indigo-50/40 text-base">
                                <?= number_format($student['rata_rata'], 2); ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>
</div>

<!-- Inline CSS Helper -->
<style>
    .text-2xs { font-size: 0.70rem; line-height: 0.95rem; }
    .text-3xs { font-size: 0.625rem; line-height: 0.85rem; }
</style>

<!-- Chart.js Doughnut Script for Persentase Jurusan -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const persentaseData = <?= json_encode($persentase_jurusan); ?>;
    
    const labels = persentaseData.map(d => d.kelas);
    const dataCounts = persentaseData.map(d => d.total_santri);
    const percentages = persentaseData.map(d => d.persentase);

    const colors = [
        '#FBBF24', // Indigo (tabus)
        '#10B981', // Pink (tkj)
        '#F59E0B', // Sky (ap)
        '#DD4814', // Purple (Desain Grafis)
        '#0284c7', // Amber (potpid)
        '#3a3838'  // Emerald (otomotip)
    ];

    const ctx = document.getElementById('jurusanDoughnutChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: dataCounts,
                backgroundColor: colors,
                borderColor: '#ffffff',
                borderWidth: 1,
                hoverOffset: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '72%',
            plugins: {
                legend: {
                    display: false // Menggunakan kartu visual di samping
                },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.95)',
                    titleFont: { family: "'Inter', sans-serif", size: 12, weight: '700' },
                    bodyFont: { family: "'Inter', sans-serif", size: 12 },
                    padding: 10,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            const idx = context.dataIndex;
                            const count = context.raw;
                            const pct = percentages[idx];
                            return ` ${context.label}: ${count} Santri (${pct}%)`;
                        }
                    }
                }
            }
        }
    });
});
</script>
