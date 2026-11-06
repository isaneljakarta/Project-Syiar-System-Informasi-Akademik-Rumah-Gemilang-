<?php require_once 'navbar.php'; ?>

<div class="flex-1 flex flex-col overflow-hidden bg-[#F8FAFC]">
        
    <!-- Top Navbar -->
    <?php 
    $page_title = $title ?? 'Dashboard Akademik';
    require_once __DIR__ . '/components/topbar.php'; 
    ?>

    <!-- Main Scrollable Area -->
    <main class="flex-1 overflow-y-auto pb-16">

        <!-- ===================== HERO WAVE BANNER ===================== -->
        <?php
        $hero = [
            'breadcrumb' => [
                ['label' => 'Portal Admin', 'url' => base_url('admin')],
                ['label' => 'Dashboard Akademik']
            ],
            'badge' => 'Lembaga Pendidikan E-RGI Syiar Gemilang',
            'title' => 'Dashboard Akademik & Kejuruan',
            'subtitle' => 'Pusat komando dan ringkasan eksekutif capaian akademik, presensi santri, serta distribusi kejuruan Rumah Gemilang Indonesia.',
            'stats' => [
                ['icon' => 'fa-solid fa-users', 'bg' => 'bg-sky-400/20 text-sky-200', 'value' => $total_siswa, 'label' => 'Total Santri'],
                ['icon' => 'fa-solid fa-book-open', 'bg' => 'bg-emerald-400/20 text-emerald-200', 'value' => $total_mapel . ' Aspek', 'label' => 'Aspek Penilaian'],
                ['icon' => 'fa-solid fa-award', 'bg' => 'bg-amber-400/20 text-amber-200', 'value' => $rata_rata, 'label' => 'Rata-rata Nilai'],
            ]
        ];
        require_once __DIR__ . '/components/hero_header.php';
        ?>

        <div class="p-6 space-y-6">
        
        <!-- Summary Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <!-- Card 1: Total Santri -->
            <div class="bg-white p-5 rounded-xl border border-slate-200/90 shadow-xs hover:shadow-md hover:border-brand/30 transition-all duration-200 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-brand-light text-brand flex items-center justify-center text-xl font-bold shrink-0">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium">Total Santri</p>
                    <h3 class="text-2xl font-extrabold text-[#1E293B] tracking-tight"><?= esc($total_siswa); ?></h3>
                    <span class="text-3xs text-brand font-semibold">Terdaftar Aktif</span>
                </div>
            </div>

            <!-- Card 2: Aspek Penilaian -->
            <div class="bg-white p-5 rounded-xl border border-slate-200/90 shadow-xs hover:shadow-md hover:border-brand/30 transition-all duration-200 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center text-xl font-bold shrink-0">
                    <i class="fa-solid fa-book-open"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium">Aspek Penilaian</p>
                    <h3 class="text-2xl font-extrabold text-[#1E293B] tracking-tight"><?= esc($total_mapel); ?> Aspek</h3>
                    <span class="text-3xs text-sky-600 font-semibold">4 Mapel + 1 Adab</span>
                </div>
            </div>

            <!-- Card 3: Rata-Rata Nilai -->
            <div class="bg-white p-5 rounded-xl border border-slate-200/90 shadow-xs hover:shadow-md hover:border-brand/30 transition-all duration-200 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl font-bold shrink-0">
                    <i class="fa-solid fa-award"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium">Rata-Rata Nilai Terbobot</p>
                    <h3 class="text-2xl font-extrabold text-[#1E293B] tracking-tight"><?= esc($rata_rata); ?></h3>
                    <span class="text-3xs text-amber-600 font-semibold">80% Akademik + 20% Adab</span>
                </div>
            </div>

            <!-- Card 4: Rata-Rata Kehadiran -->
            <div class="bg-white p-5 rounded-xl border border-slate-200/90 shadow-xs hover:shadow-md hover:border-brand/30 transition-all duration-200 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-bold shrink-0">
                    <i class="fa-solid fa-clipboard-check"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium">Rata-Rata Kehadiran</p>
                    <h3 class="text-2xl font-extrabold text-[#1E293B] tracking-tight"><?= esc($rata_kehadiran); ?>%</h3>
                    <span class="text-3xs text-emerald-600 font-semibold">Tingkat Disiplin Tinggi</span>
                </div>
            </div>
        </div>

        <!-- Info Bobot Penilaian Adab & Akhlaq (20%) - Syiar Gemilang Sapphire Banner -->
        <div class="bg-gradient-to-r from-brand-light via-white to-sky-50/70 border border-brand-border rounded-xl p-4 shadow-2xs flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-start gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-brand text-white flex items-center justify-center text-base shrink-0 mt-0.5 shadow-xs shadow-brand/25">
                    <i class="fa-solid fa-scale-balanced"></i>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-[#1E293B] flex flex-wrap items-center gap-2">
                        Formula Penilaian Terbobot
                        <span class="text-2xs bg-amber-100 text-amber-800 font-bold px-2.5 py-0.5 rounded-full border border-amber-300/80">
                            Adab & Akhlaq: 20%
                        </span>
                    </h4>
                    <p class="text-xs text-slate-600 mt-1 leading-relaxed">
                        Nilai akhir santri dikalkulasikan dengan komposisi: <strong class="text-brand font-bold">80% Nilai Akademik</strong> (Tauhid, Fiqih, B. Inggris, dan Menulis Kreatif) dan <strong class="text-amber-700 font-bold">20% Nilai Adab & Akhlaq</strong> santri dalam keseharian.
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-2.5 shrink-0 self-end md:self-auto">
                <a href="<?= base_url('admin/data'); ?>" class="text-xs font-semibold px-3.5 py-2 bg-white border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 hover:border-slate-400 transition shadow-2xs">
                    <i class="fa-solid fa-user-graduate mr-1 text-brand"></i> Data Santri
                </a>
                <a href="<?= base_url('admin/kehadiran'); ?>" class="text-xs font-semibold px-3.5 py-2 bg-brand text-white rounded-lg hover:bg-brand-dark active:bg-brand-deep transition shadow-xs shadow-brand/20">
                    <i class="fa-solid fa-clipboard-user mr-1"></i> Sesi Kehadiran
                </a>
            </div>
        </div>

        <!-- Section: Persentase dari Setiap Jurusan -->
        <div class="bg-white p-6 rounded-xl border border-slate-200/90 shadow-xs space-y-5">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-4 border-b border-slate-100">
                <div>
                    <h3 class="text-base font-bold text-[#1E293B] flex items-center gap-2">
                        <span class="w-7 h-7 rounded-lg bg-brand-light text-brand inline-flex items-center justify-center text-xs">
                            <i class="fa-solid fa-chart-pie"></i>
                        </span>
                        Persentase & Distribusi Santri per Jurusan
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Distribusi jumlah santri dan persentase keterwakilan di setiap jurusan / kelas rombel Rumah Gemilang Indonesia.</p>
                </div>
                <span class="text-xs font-bold px-3 py-1 rounded-full bg-brand-light text-brand border border-brand-border w-fit">
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
                            <span class="text-3xl font-black text-[#1E293B] tracking-tight"><?= esc($total_siswa); ?></span>
                            <span class="text-3xs font-bold text-brand uppercase tracking-widest mt-0.5">Santri RGI</span>
                        </div>
                    </div>
                    <p class="text-3xs text-slate-400 mt-3 text-center">Arahkan kursor pada bagan untuk detail jumlah & persentase</p>
                </div>

                <!-- Jurusan Cards & Progress Bars -->
                <div class="lg:col-span-7 space-y-3">
                    <?php
                    $jurusanColors = [
                        'Teknik Komputer dan Jaringan' => ['bg' => 'bg-emerald-500', 'text' => 'text-emerald-600', 'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200', 'icon' => 'fa-network-wired'],
                        'Tata Busana'                  => ['bg' => 'bg-amber-500',   'text' => 'text-amber-600',   'badge' => 'bg-amber-50 text-amber-700 border-amber-200',     'icon' => 'fa-scissors'],
                        'Fotografi dan Videografi'     => ['bg' => 'bg-sky-500',     'text' => 'text-sky-600',     'badge' => 'bg-sky-50 text-sky-700 border-sky-200',       'icon' => 'fa-camera'],
                        'Desain Grafis'                => ['bg' => 'bg-brand',       'text' => 'text-brand',       'badge' => 'bg-brand-light text-brand border-brand-border', 'icon' => 'fa-palette'],
                        'Otomotif'                     => ['bg' => 'bg-slate-600',   'text' => 'text-slate-700',  'badge' => 'bg-slate-100 text-slate-700 border-slate-200',   'icon' => 'fa-wrench'],
                        'Aplikasi Perkantoran'         => ['bg' => 'bg-indigo-500',  'text' => 'text-indigo-600',  'badge' => 'bg-indigo-50 text-indigo-700 border-indigo-200','icon' => 'fa-briefcase'],
                    ];
                    ?>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <?php foreach ($persentase_jurusan as $j): ?>
                            <?php 
                                $kName = $j['kelas'];
                                $theme = $jurusanColors[$kName] ?? ['bg' => 'bg-brand', 'text' => 'text-brand', 'badge' => 'bg-brand-light text-brand border-brand-border', 'icon' => 'fa-graduation-cap'];
                            ?>
                            <div class="p-3.5 rounded-xl border border-slate-200/90 bg-[#F8FAFC] hover:bg-white hover:border-brand/40 hover:shadow-xs transition-all duration-150">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-2 truncate">
                                        <i class="fa-solid <?= $theme['icon']; ?> <?= $theme['text']; ?> text-xs"></i>
                                        <h4 class="text-xs font-bold text-[#1E293B] truncate" title="<?= esc($kName); ?>">
                                            <?= esc($kName); ?>
                                        </h4>
                                    </div>
                                    <span class="text-xs font-extrabold px-2 py-0.5 rounded-full border <?= $theme['badge']; ?>">
                                        <?= $j['persentase']; ?>%
                                    </span>
                                </div>

                                <!-- Progress bar visual -->
                                <div class="w-full bg-slate-200/80 rounded-full h-2 overflow-hidden mb-2">
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
        <div class="bg-white p-6 rounded-xl border border-slate-200/90 shadow-xs space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-4 border-b border-slate-100">
                <div>
                    <h3 class="text-base font-bold text-[#1E293B] flex items-center gap-2">
                        <span class="w-7 h-7 rounded-lg bg-amber-50 text-amber-500 inline-flex items-center justify-center text-xs border border-amber-200/60">
                            <i class="fa-solid fa-trophy"></i>
                        </span>
                        Top 5 Santri Terbaik (Nilai Terbobot)
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Peringkat 5 besar santri berdasarkan nilai akhir 80% Akademik + 20% Adab & Akhlaq.</p>
                </div>
                <a href="<?= base_url('admin/pemeringkatan'); ?>" class="text-xs font-semibold text-brand hover:text-brand-dark flex items-center gap-1.5 px-3 py-1.5 rounded-lg hover:bg-brand-light transition">
                    Lihat Peringkat Selengkapnya <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <div class="overflow-x-auto rounded-xl border border-slate-200/90">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#F8FAFC] border-b border-slate-200 text-xs font-bold text-slate-600 uppercase tracking-wider">
                            <th class="py-3.5 px-3 text-center w-16 border-r border-slate-200/80">Rank</th>
                            <th class="py-3.5 px-4 border-r border-slate-200/80">Nama Santri</th>
                            <th class="py-3.5 px-4 border-r border-slate-200/80">Kelas / Jurusan</th>
                            <th class="py-3.5 px-3 text-center border-r border-slate-200/80">Akademik (80%)</th>
                            <th class="py-3.5 px-3 text-center border-r border-slate-200/80 bg-amber-50/60 text-amber-900">Adab & Akhlaq (20%)</th>
                            <th class="py-3.5 px-3 text-center border-r border-slate-200/80">Kehadiran</th>
                            <th class="py-3.5 px-3 text-center bg-brand-light text-brand font-extrabold w-32">Nilai Akhir</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-slate-200/80">
                        <?php foreach ($top_students as $index => $student): ?>
                        <?php
                            $rank = $index + 1;
                            if ($rank === 1) {
                                $rankBadge = '<span class="inline-flex items-center justify-center gap-1 px-2 py-1 rounded-full bg-amber-400 text-slate-900 font-extrabold text-xs shadow-2xs"><i class="fa-solid fa-crown text-[10px]"></i> 1</span>';
                            } elseif ($rank === 2) {
                                $rankBadge = '<span class="inline-flex items-center justify-center gap-1 px-2 py-1 rounded-full bg-slate-300 text-slate-800 font-extrabold text-xs shadow-2xs"><i class="fa-solid fa-medal text-[10px]"></i> 2</span>';
                            } elseif ($rank === 3) {
                                $rankBadge = '<span class="inline-flex items-center justify-center gap-1 px-2 py-1 rounded-full bg-amber-600 text-white font-extrabold text-xs shadow-2xs"><i class="fa-solid fa-medal text-[10px]"></i> 3</span>';
                            } else {
                                $rankBadge = '<span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-slate-100 text-slate-700 font-bold text-xs border border-slate-200">' . $rank . '</span>';
                            }
                        ?>
                        <tr class="<?= $index % 2 === 1 ? 'bg-slate-50/50' : 'bg-white'; ?> hover:bg-brand-light/50 transition-colors">
                            <td class="py-3 px-3 text-center border-r border-slate-200/80 font-bold">
                                <?= $rankBadge; ?>
                            </td>
                            <td class="py-3 px-4 border-r border-slate-200/80 font-semibold text-[#1E293B]"><?= esc($student['nama']); ?></td>
                            <td class="py-3 px-4 border-r border-slate-200/80 text-slate-600"><?= esc($student['kelas']); ?></td>
                            <td class="py-3 px-3 border-r border-slate-200/80 text-center font-semibold text-slate-700">
                                <?= number_format($student['rata_akademik'] ?? $student['rata_rata'], 2); ?>
                            </td>
                            <td class="py-3 px-3 border-r border-slate-200/80 text-center font-bold text-amber-700 bg-amber-50/30">
                                <?= esc($student['adab_akhlaq'] ?? 85); ?>
                            </td>
                            <td class="py-3 px-3 border-r border-slate-200/80 text-center">
                                <span class="px-2.5 py-0.5 rounded-full text-2xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <?= esc($student['kehadiran'] ?? 95); ?>%
                                </span>
                            </td>
                            <td class="py-3 px-3 text-center font-extrabold text-brand bg-brand-light/70 text-base">
                                <?= number_format($student['rata_rata'], 2); ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        </div> <!-- /p-6 wrapper -->
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
        '#FBBF24', // Tata Busana (amber-400)
        '#10B981', // TKJ (emerald-500)
        '#6366F1', // Aplikasi Perkantoran (indigo-500)
        '#0077D4', // Desain Grafis (brand)
        '#0EA5E9', // Fotografi & Videografi (sky-500)
        '#475569'  // Otomotif (slate-600)
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
                borderWidth: 2,
                hoverOffset: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '72%',
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(7, 59, 102, 0.95)',
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
</body>
</html>