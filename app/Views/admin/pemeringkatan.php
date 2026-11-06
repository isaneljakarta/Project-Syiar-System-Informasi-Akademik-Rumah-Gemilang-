<?php require_once 'navbar.php'; ?>

<div class="flex-1 min-w-0 flex flex-col overflow-hidden bg-[#F8FAFC]">

    <!-- Top Navbar -->
    <?php 
    $page_title = $title ?? 'Pemeringkatan Siswa';
    require_once __DIR__ . '/components/topbar.php'; 
    ?>

    <!-- Main Scrollable Area -->
    <main class="flex-1 overflow-y-auto pb-16">

        <!-- ===================== HERO WAVE BANNER ===================== -->
        <?php
        $hero = [
            'breadcrumb' => [
                ['label' => 'Portal Admin', 'url' => base_url('admin')],
                ['label' => 'Pemeringkatan Santri']
            ],
            'badge' => 'Lembaga Pendidikan E-RGI Syiar Gemilang',
            'title' => 'Pemeringkatan & Analisis Prestasi Santri',
            'subtitle' => 'Leaderboard prestasi santri terbaik berdasarkan kalkulasi bobot terpadu: 80% nilai akademik (4 mapel utama) dan 20% nilai adab & akhlaq karimah.',
            'stats' => [
                ['icon' => 'fa-solid fa-trophy', 'bg' => 'bg-amber-400/20 text-amber-200', 'value' => 'Top 3', 'label' => 'Peringkat Terbaik'],
                ['icon' => 'fa-solid fa-users', 'bg' => 'bg-sky-400/20 text-sky-200', 'value' => $total_siswa, 'label' => 'Santri Dinilai'],
                ['icon' => 'fa-solid fa-chalkboard-user', 'bg' => 'bg-emerald-400/20 text-emerald-200', 'value' => count($top3_per_kelas ?? []) . ' Kelas', 'label' => 'Kelas Kejuruan'],
                ['icon' => 'fa-solid fa-award', 'bg' => 'bg-indigo-400/20 text-indigo-200', 'value' => $rata_rata, 'label' => 'Rata-rata Nilai'],
            ]
        ];
        require_once __DIR__ . '/components/hero_header.php';
        ?>

        <div class="p-6 space-y-6">

        <!-- Summary Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-brand-light text-brand flex items-center justify-center text-xl font-bold shrink-0">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium">Total Santri</p>
                    <h3 class="text-2xl font-bold text-slate-800"><?= esc($total_siswa); ?></h3>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-bold shrink-0">
                    <i class="fa-solid fa-chalkboard-user"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium">Jumlah Kelas / Rombel</p>
                    <h3 class="text-2xl font-bold text-slate-800"><?= count($top3_per_kelas); ?> Kelas</h3>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-xl font-bold shrink-0">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium">Rata-Rata Keseluruhan</p>
                    <h3 class="text-2xl font-bold text-slate-800"><?= esc($rata_rata); ?></h3>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-yellow-50 text-amber-500 flex items-center justify-center text-xl font-bold shrink-0">
                    <i class="fa-solid fa-crown"></i>
                </div>
                <div class="truncate">
                    <p class="text-xs text-slate-500 font-medium">Peringkat 1 Global</p>
                    <?php if (!empty($ranking_all)): ?>
                        <h3 class="text-base font-bold text-slate-800 truncate" title="<?= esc($ranking_all[0]['nama']); ?>">
                            <?= esc($ranking_all[0]['nama']); ?>
                        </h3>
                        <span class="text-xs font-semibold text-emerald-600">Nilai: <?= number_format($ranking_all[0]['rata_rata'], 2); ?></span>
                    <?php else: ?>
                        <h3 class="text-sm font-bold text-slate-400">-</h3>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Section: Chart.js Bar Chart -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm space-y-4">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 pb-3 border-b border-slate-100">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-brand-light text-brand flex items-center justify-center text-sm">
                            <i class="fa-solid fa-chart-simple"></i>
                        </span>
                        <h3 class="text-base font-bold text-slate-800">Grafik Nilai Top 3 Tiap Kelas (Model Bar)</h3>
                    </div>
                    <p class="text-xs text-slate-500 mt-1">Perbandingan rata-rata nilai Juara 1 (Emas), Juara 2 (Perak), dan Juara 3 (Perunggu) di setiap kelas.</p>
                </div>

                <!-- Legend Indicator Badges -->
                <div class="flex flex-wrap items-center gap-2 text-xs font-semibold">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 border border-amber-200 text-amber-800">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span> Juara 1
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 border border-slate-300 text-slate-700">
                        <span class="w-2.5 h-2.5 rounded-full bg-slate-500"></span> Juara 2
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-orange-50 border border-orange-200 text-orange-800">
                        <span class="w-2.5 h-2.5 rounded-full bg-orange-600"></span> Juara 3
                    </span>
                </div>
            </div>

            <!-- Quick Class Filter for Chart -->
            <div class="flex items-center gap-2 overflow-x-auto pb-1 text-xs">
                <span class="text-slate-400 font-medium shrink-0"><i class="fa-solid fa-filter mr-1"></i>Filter Kelas:</span>
                <button type="button" onclick="filterChartByClass('all')" id="btn-chart-all" class="chart-filter-btn px-3 py-1 rounded-lg bg-brand text-white font-medium shadow-sm transition shrink-0">
                    Semua Kelas
                </button>
                <?php foreach (array_keys($top3_per_kelas) as $idx => $kName): ?>
                    <button type="button" onclick="filterChartByClass('<?= esc($kName, 'js'); ?>')" id="btn-chart-<?= $idx; ?>" class="chart-filter-btn px-3 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium transition shrink-0">
                        <?= esc($kName); ?>
                    </button>
                <?php endforeach; ?>
            </div>

            <!-- Chart Canvas Container -->
            <div class="relative w-full h-80 md:h-96">
                <canvas id="rankingBarChart"></canvas>
            </div>
        </div>

        <!-- Section: Kartu Podium Top 3 Tiap Kelas -->
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-award text-amber-500"></i> Daftar Peringkat Top 3 Tiap Kelas
                    </h3>
                    <p class="text-xs text-slate-500">Rincian siswa berprestasi peringkat 1, 2, dan 3 beserta perolehan nilai mata pelajaran.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="classCardsGrid">
                <?php
                // Helper mapping icon per jurusan
                $classIcons = [
                    'Desain Grafis'                => 'fa-palette text-red-500',
                    'Teknik Komputer dan Jaringan' => 'fa-network-wired text-emerald-600',
                    'Aplikasi Perkantoran'         => 'fa-file-excel text-orange-500',
                    'Tata Busana'                  => 'fa-scissors text-yellow-600',
                    'Otomotif'                     => 'fa-wrench text-slate-900',
                    'Fotografi dan Videografi'     => 'fa-camera text-blue-600',
                ];
                ?>

                <?php foreach ($top3_per_kelas as $kelasName => $students): ?>
                    <?php
                        $iconClass = $classIcons[$kelasName] ?? 'fa-graduation-cap text-brand';
                    ?>
                    <div class="class-card bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden flex flex-col hover:border-brand/40 transition" data-class="<?= esc($kelasName); ?>">
                        <!-- Card Header -->
                        <div class="p-4 bg-slate-50/70 border-b border-slate-200 flex items-center justify-between">
                            <div class="flex items-center gap-2.5 truncate">
                                <div class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-sm shadow-2xs shrink-0">
                                    <i class="fa-solid <?= $iconClass; ?>"></i>
                                </div>
                                <h4 class="text-sm font-bold text-slate-800 truncate" title="<?= esc($kelasName); ?>">
                                    <?= esc($kelasName); ?>
                                </h4>
                            </div>
                            <span class="text-xs bg-brand-light text-brand font-semibold px-2 py-0.5 rounded-full border border-brand-border shrink-0">
                                <?= count($students); ?> Santri
                            </span>
                        </div>

                        <!-- Card Body: Ranking List -->
                        <div class="p-4 space-y-3 flex-1 flex flex-col justify-between">
                            <?php foreach ($students as $i => $s): ?>
                                <?php
                                    $rank = $s['rank'] ?? ($i + 1);
                                    if ($rank === 1) {
                                        $rankBg = 'bg-amber-50/80 border-amber-200';
                                        $badgeBg = 'bg-gradient-to-r from-amber-400 to-amber-500 text-white shadow-xs';
                                        $medal = '🥇 Juara 1';
                                        $scoreColor = 'text-amber-700';
                                    } elseif ($rank === 2) {
                                        $rankBg = 'bg-slate-50 border-slate-200';
                                        $badgeBg = 'bg-gradient-to-r from-slate-400 to-slate-500 text-white shadow-xs';
                                        $medal = '🥈 Juara 2';
                                        $scoreColor = 'text-slate-700';
                                    } else {
                                        $rankBg = 'bg-orange-50/60 border-orange-200';
                                        $badgeBg = 'bg-gradient-to-r from-orange-400 to-orange-500 text-white shadow-xs';
                                        $medal = '🥉 Juara 3';
                                        $scoreColor = 'text-orange-700';
                                    }
                                ?>
                                <div class="p-3 rounded-lg border <?= $rankBg; ?> transition hover:shadow-xs">
                                    <div class="flex items-center justify-between gap-2 mb-1.5">
                                        <div class="flex items-center gap-2 truncate">
                                            <span class="text-xs font-bold px-2 py-0.5 rounded-full <?= $badgeBg; ?>">
                                                <?= $medal; ?>
                                            </span>
                                            <span class="text-sm font-bold text-slate-800 truncate" title="<?= esc($s['nama']); ?>">
                                                <?= esc($s['nama']); ?>
                                            </span>
                                        </div>
                                        <div class="text-right shrink-0">
                                            <span class="text-sm font-black <?= $scoreColor; ?>">
                                                <?= number_format($s['rata_rata'], 2); ?>
                                            </span>
                                            <span class="text-2xs text-slate-400 block font-medium">Rata-Rata</span>
                                        </div>
                                    </div>

                                    <!-- Nilai Mapel Pill Details (5 Aspek: 4 Mapel + 1 Adab 20%) -->
                                    <div class="grid grid-cols-5 gap-1 text-2xs text-center font-medium pt-1 border-t border-slate-200/60">
                                        <div class="bg-white/80 py-1 px-0.5 rounded border border-slate-100">
                                            <span class="text-slate-400 block text-3xs uppercase">Tauhid</span>
                                            <span class="font-bold text-slate-700"><?= esc($s['tauhid']); ?></span>
                                        </div>
                                        <div class="bg-white/80 py-1 px-0.5 rounded border border-slate-100">
                                            <span class="text-slate-400 block text-3xs uppercase">Fiqih</span>
                                            <span class="font-bold text-slate-700"><?= esc($s['fiqih']); ?></span>
                                        </div>
                                        <div class="bg-white/80 py-1 px-0.5 rounded border border-slate-100">
                                            <span class="text-slate-400 block text-3xs uppercase">B.Ing</span>
                                            <span class="font-bold text-slate-700"><?= esc($s['b_ing']); ?></span>
                                        </div>
                                        <div class="bg-white/80 py-1 px-0.5 rounded border border-slate-100">
                                            <span class="text-slate-400 block text-3xs uppercase">Kreatif</span>
                                            <span class="font-bold text-slate-700"><?= esc($s['menulis_kreatif']); ?></span>
                                        </div>
                                        <div class="bg-amber-50/80 py-1 px-0.5 rounded border border-amber-200">
                                            <span class="text-amber-700 block text-3xs uppercase font-semibold">Adab 20%</span>
                                            <span class="font-extrabold text-amber-900"><?= esc($s['adab_akhlaq'] ?? 85); ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Section: Tabel Pemeringkatan Lengkap -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-3 border-b border-slate-100">
                <div>
                    <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-list-ol text-brand"></i> Tabel Pemeringkatan Siswa
                    </h3>
                    <p class="text-xs text-slate-500">Daftar peringkat lengkap berdasarkan nilai rata-rata 4 mata pelajaran.</p>
                </div>

                <!-- View Toggle Buttons & Search Filter -->
                <div class="flex flex-wrap items-center gap-2">
                    <div class="inline-flex rounded-lg border border-slate-200 p-0.5 bg-slate-50 text-xs">
                        <button type="button" onclick="setTableView('top3')" id="btnTabTop3" class="px-3 py-1.5 rounded-md font-semibold bg-white text-brand shadow-xs transition cursor-pointer">
                            Top 3 Tiap Kelas (<?= count($top3_per_kelas) * 3; ?> Siswa)
                        </button>
                        <button type="button" onclick="setTableView('all')" id="btnTabAll" class="px-3 py-1.5 rounded-md font-semibold text-slate-600 hover:text-slate-800 transition cursor-pointer">
                            Seluruh Siswa (<?= count($ranking_all); ?> Siswa)
                        </button>
                    </div>

                    <div class="relative">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-xs text-slate-400"></i>
                        <input type="text" id="tableSearchInput" onkeyup="searchRankingTable()" placeholder="Cari nama atau kelas..." class="pl-8 pr-3 py-1.5 text-xs rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand focus:border-brand w-44 sm:w-56">
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto rounded-lg border border-slate-200">
                <table class="w-full text-left border-collapse" id="rankingTable">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold text-slate-700 uppercase">
                            <th class="py-3 px-3 text-center w-16 border-r border-slate-200">Rank</th>
                            <th class="py-3 px-3 border-r border-slate-200">ID</th>
                            <th class="py-3 px-3 border-r border-slate-200">Nama Santri</th>
                            <th class="py-3 px-3 border-r border-slate-200">Kelas</th>
                            <th class="py-3 px-2 text-center border-r border-slate-200">Tauhid</th>
                            <th class="py-3 px-2 text-center border-r border-slate-200">Fiqih</th>
                            <th class="py-3 px-2 text-center border-r border-slate-200">B. Inggris</th>
                            <th class="py-3 px-2 text-center border-r border-slate-200">Menulis</th>
                            <th class="py-3 px-2 text-center border-r border-slate-200 bg-amber-50/60 text-amber-900">Adab (20%)</th>
                            <th class="py-3 px-3 text-center border-r border-slate-200 bg-emerald-50/60 text-emerald-900">Kehadiran</th>
                            <th class="py-3 px-3 text-center bg-brand-light text-brand font-extrabold border-r border-slate-200">Nilai Akhir</th>
                            <th class="py-3 px-3 text-center w-28">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-slate-200" id="rankingTableBody">
                        <!-- Populated dynamically via JS from $allRankingData -->
                    </tbody>
                </table>
            </div>
        </div>

        </div> <!-- /p-6 wrapper -->
    </main>
</div>

<!-- Inline CSS Helper for 3xs font -->
<style>
    .text-2xs { font-size: 0.70rem; line-height: 0.95rem; }
    .text-3xs { font-size: 0.625rem; line-height: 0.85rem; }
</style>

<!-- Chart.js & Table Dynamic Script -->
<script>
// Data dari PHP
const top3PerKelasData = <?= json_encode($top3_per_kelas); ?>;
const allRankingData   = <?= json_encode($ranking_all); ?>;

// Siapkan Data untuk Chart.js (Model Bar Grouped)
const classLabels = Object.keys(top3PerKelasData);

// Siapkan 3 dataset: Juara 1, Juara 2, Juara 3
const juara1Scores = [];
const juara2Scores = [];
const juara3Scores = [];

// Meta info untuk tooltip
const tooltipMeta = {
    juara1: [],
    juara2: [],
    juara3: []
};

classLabels.forEach(k => {
    const list = top3PerKelasData[k] || [];
    
    // Juara 1
    if (list[0]) {
        juara1Scores.push(parseFloat(list[0].rata_rata));
        tooltipMeta.juara1.push(list[0]);
    } else {
        juara1Scores.push(null);
        tooltipMeta.juara1.push(null);
    }
    
    // Juara 2
    if (list[1]) {
        juara2Scores.push(parseFloat(list[1].rata_rata));
        tooltipMeta.juara2.push(list[1]);
    } else {
        juara2Scores.push(null);
        tooltipMeta.juara2.push(null);
    }
    
    // Juara 3
    if (list[2]) {
        juara3Scores.push(parseFloat(list[2].rata_rata));
        tooltipMeta.juara3.push(list[2]);
    } else {
        juara3Scores.push(null);
        tooltipMeta.juara3.push(null);
    }
});

// Inisialisasi Chart.js
const ctx = document.getElementById('rankingBarChart').getContext('2d');
let currentFilterClass = 'all';

const chartConfig = {
    type: 'bar',
    data: {
        labels: classLabels,
        datasets: [
            {
                label: 'Juara 1 (Emas)',
                data: juara1Scores,
                backgroundColor: 'rgba(245, 158, 11, 0.85)', // Amber 500
                borderColor: '#d97706',
                borderWidth: 1.5,
                borderRadius: 6,
                maxBarThickness: 36
            },
            {
                label: 'Juara 2 (Perak)',
                data: juara2Scores,
                backgroundColor: 'rgba(100, 116, 139, 0.85)', // Slate 500
                borderColor: '#475569',
                borderWidth: 1.5,
                borderRadius: 6,
                maxBarThickness: 36
            },
            {
                label: 'Juara 3 (Perunggu)',
                data: juara3Scores,
                backgroundColor: 'rgba(234, 88, 12, 0.85)', // Orange 600
                borderColor: '#c2410c',
                borderWidth: 1.5,
                borderRadius: 6,
                maxBarThickness: 36
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: {
            mode: 'index',
            intersect: false
        },
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    boxWidth: 14,
                    boxHeight: 14,
                    usePointStyle: true,
                    pointStyle: 'circle',
                    font: {
                        family: "'Inter', sans-serif",
                        size: 12,
                        weight: '600'
                    },
                    padding: 20
                }
            },
            tooltip: {
                backgroundColor: 'rgba(15, 23, 42, 0.95)',
                titleFont: { family: "'Inter', sans-serif", size: 13, weight: '700' },
                bodyFont: { family: "'Inter', sans-serif", size: 12 },
                padding: 12,
                cornerRadius: 8,
                callbacks: {
                    title: function(items) {
                        return 'Kelas: ' + items[0].label;
                    },
                    label: function(context) {
                        const dsIndex = context.datasetIndex;
                        const dataIndex = context.dataIndex;
                        let item = null;
                        let rankTitle = 'Juara 1';
                        if (dsIndex === 0) { item = tooltipMeta.juara1[dataIndex]; rankTitle = '🥇 Juara 1'; }
                        else if (dsIndex === 1) { item = tooltipMeta.juara2[dataIndex]; rankTitle = '🥈 Juara 2'; }
                        else if (dsIndex === 2) { item = tooltipMeta.juara3[dataIndex]; rankTitle = '🥉 Juara 3'; }

                        if (item) {
                            return `${rankTitle}: ${item.nama} (${parseFloat(item.rata_rata).toFixed(2)})`;
                        }
                        return `${context.dataset.label}: ${context.raw ?? '-'}`;
                    },
                    afterLabel: function(context) {
                        const dsIndex = context.datasetIndex;
                        const dataIndex = context.dataIndex;
                        let item = null;
                        if (dsIndex === 0) item = tooltipMeta.juara1[dataIndex];
                        else if (dsIndex === 1) item = tooltipMeta.juara2[dataIndex];
                        else if (dsIndex === 2) item = tooltipMeta.juara3[dataIndex];

                        if (item) {
                            return `   • Tauhid: ${item.tauhid} | Fiqih: ${item.fiqih} | B.Ing: ${item.b_ing} | Kreatif: ${item.menulis_kreatif} | Adab(20%): ${item.adab_akhlaq || 85}`;
                        }
                        return '';
                    }
                }
            }
        },
        scales: {
            x: {
                grid: { display: false },
                ticks: {
                    font: { family: "'Inter', sans-serif", size: 11, weight: '500' },
                    color: '#475569'
                }
            },
            y: {
                min: 60,
                max: 100,
                ticks: {
                    stepSize: 10,
                    font: { family: "'Inter', sans-serif", size: 11 },
                    color: '#64748b'
                },
                grid: {
                    color: '#f1f5f9'
                },
                title: {
                    display: true,
                    text: 'Nilai Rata-Rata',
                    font: { family: "'Inter', sans-serif", size: 12, weight: '600' },
                    color: '#64748b'
                }
            }
        }
    }
};

const rankingChart = new Chart(ctx, chartConfig);

// Filter Chart Berdasarkan Kelas
function filterChartByClass(className) {
    currentFilterClass = className;
    
    // Update button states
    document.querySelectorAll('.chart-filter-btn').forEach(btn => {
        btn.classList.remove('bg-brand', 'text-white', 'shadow-sm');
        btn.classList.add('bg-slate-100', 'text-slate-700');
    });

    if (className === 'all') {
        document.getElementById('btn-chart-all').classList.add('bg-brand', 'text-white', 'shadow-sm');
        document.getElementById('btn-chart-all').classList.remove('bg-slate-100', 'text-slate-700');
        
        rankingChart.data.labels = classLabels;
        rankingChart.data.datasets[0].data = juara1Scores;
        rankingChart.data.datasets[1].data = juara2Scores;
        rankingChart.data.datasets[2].data = juara3Scores;
    } else {
        const idx = classLabels.indexOf(className);
        if (idx !== -1) {
            const activeBtn = document.getElementById(`btn-chart-${idx}`);
            if (activeBtn) {
                activeBtn.classList.add('bg-brand', 'text-white', 'shadow-sm');
                activeBtn.classList.remove('bg-slate-100', 'text-slate-700');
            }
            rankingChart.data.labels = [className];
            rankingChart.data.datasets[0].data = [juara1Scores[idx]];
            rankingChart.data.datasets[1].data = [juara2Scores[idx]];
            rankingChart.data.datasets[2].data = [juara3Scores[idx]];
        }
    }
    rankingChart.update();

    // Filter cards
    const cards = document.querySelectorAll('.class-card');
    cards.forEach(card => {
        if (className === 'all' || card.getAttribute('data-class') === className) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
}

// Flat list Top 3 untuk tabel
const flatTop3List = [];
classLabels.forEach(k => {
    (top3PerKelasData[k] || []).forEach((s, idx) => {
        flatTop3List.push({
            ...s,
            rankKelas: idx + 1
        });
    });
});

let currentTableView = 'top3';

function renderTable(dataList, isTop3View = true) {
    const tbody = document.getElementById('rankingTableBody');
    tbody.innerHTML = '';

    if (!dataList || dataList.length === 0) {
        tbody.innerHTML = `<tr><td colspan="12" class="py-8 text-center text-slate-400 font-medium">Tidak ada data ditemukan</td></tr>`;
        return;
    }

    dataList.forEach((s, idx) => {
        const globalRank = idx + 1;
        let rankBadge = '';

        if (isTop3View) {
            const rk = s.rankKelas || s.rank || 1;
            if (rk === 1) {
                rankBadge = `<span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-amber-100 text-amber-700 font-bold text-xs border border-amber-300 shadow-2xs">🥇 1</span>`;
            } else if (rk === 2) {
                rankBadge = `<span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-slate-100 text-slate-700 font-bold text-xs border border-slate-300 shadow-2xs">🥈 2</span>`;
            } else {
                rankBadge = `<span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-orange-100 text-orange-700 font-bold text-xs border border-orange-300 shadow-2xs">🥉 3</span>`;
            }
        } else {
            if (globalRank === 1) {
                rankBadge = `<span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-amber-400 text-slate-900 font-bold text-xs shadow-xs">#1</span>`;
            } else if (globalRank === 2) {
                rankBadge = `<span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-slate-300 text-slate-800 font-bold text-xs shadow-xs">#2</span>`;
            } else if (globalRank === 3) {
                rankBadge = `<span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-amber-600 text-white font-bold text-xs shadow-xs">#3</span>`;
            } else {
                rankBadge = `<span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-slate-100 text-slate-600 font-bold text-xs">${globalRank}</span>`;
            }
        }

        const scoreNum = parseFloat(s.rata_rata);
        const adabVal = s.adab_akhlaq || 85;
        const hadirVal = s.kehadiran || 95;
        let ketBadge = '';
        if (scoreNum >= 90) {
            ketBadge = `<span class="px-2.5 py-0.5 rounded-full text-2xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Sangat Baik</span>`;
        } else if (scoreNum >= 80) {
            ketBadge = `<span class="px-2.5 py-0.5 rounded-full text-2xs font-bold bg-brand-light text-brand border border-brand-border">Baik</span>`;
        } else {
            ketBadge = `<span class="px-2.5 py-0.5 rounded-full text-2xs font-bold bg-slate-100 text-slate-600 border border-slate-200">Cukup</span>`;
        }

        const tr = document.createElement('tr');
        tr.className = (idx % 2 === 1 ? 'bg-slate-50/70' : 'bg-white') + ' hover:bg-brand-light/40 transition';
        tr.innerHTML = `
            <td class="py-3 px-3 text-center border-r border-slate-200 font-bold">${rankBadge}</td>
            <td class="py-3 px-3 border-r border-slate-200 font-mono text-xs text-slate-500 font-semibold">${s.id || '-'}</td>
            <td class="py-3 px-3 border-r border-slate-200 font-medium text-slate-800">
                ${s.nama}
                ${isTop3View ? `<span class="text-3xs text-amber-600 font-bold block sm:hidden">Juara ${s.rankKelas}</span>` : ''}
            </td>
            <td class="py-3 px-3 border-r border-slate-200 text-slate-600">${s.kelas}</td>
            <td class="py-3 px-2 border-r border-slate-200 text-center font-semibold text-slate-700">${s.tauhid}</td>
            <td class="py-3 px-2 border-r border-slate-200 text-center font-semibold text-slate-700">${s.fiqih}</td>
            <td class="py-3 px-2 border-r border-slate-200 text-center font-semibold text-slate-700">${s.b_ing}</td>
            <td class="py-3 px-2 border-r border-slate-200 text-center font-semibold text-slate-700">${s.menulis_kreatif}</td>
            <td class="py-3 px-2 border-r border-slate-200 text-center font-bold text-amber-700 bg-amber-50/30">${adabVal}</td>
            <td class="py-3 px-3 border-r border-slate-200 text-center">
                <span class="px-2 py-0.5 rounded-full text-2xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">${hadirVal}%</span>
            </td>
            <td class="py-3 px-3 border-r border-slate-200 text-center font-bold text-brand bg-brand-light/50 text-sm">
                ${scoreNum.toFixed(2)}
            </td>
            <td class="py-3 px-3 text-center">${ketBadge}</td>
        `;
        tbody.appendChild(tr);
    });
}

function setTableView(view) {
    currentTableView = view;
    const btnTop3 = document.getElementById('btnTabTop3');
    const btnAll  = document.getElementById('btnTabAll');
    const searchInput = document.getElementById('tableSearchInput');
    searchInput.value = '';

    if (view === 'top3') {
        btnTop3.className = 'px-3 py-1.5 rounded-md font-semibold bg-white text-brand shadow-xs transition cursor-pointer';
        btnAll.className  = 'px-3 py-1.5 rounded-md font-semibold text-slate-600 hover:text-slate-800 transition cursor-pointer';
        renderTable(flatTop3List, true);
    } else {
        btnAll.className  = 'px-3 py-1.5 rounded-md font-semibold bg-white text-brand shadow-xs transition cursor-pointer';
        btnTop3.className = 'px-3 py-1.5 rounded-md font-semibold text-slate-600 hover:text-slate-800 transition cursor-pointer';
        renderTable(allRankingData, false);
    }
}

function searchRankingTable() {
    const q = document.getElementById('tableSearchInput').value.toLowerCase().trim();
    const sourceList = (currentTableView === 'top3') ? flatTop3List : allRankingData;
    
    if (!q) {
        renderTable(sourceList, currentTableView === 'top3');
        return;
    }

    const filtered = sourceList.filter(s => {
        return (s.nama && s.nama.toLowerCase().includes(q)) ||
               (s.kelas && s.kelas.toLowerCase().includes(q)) ||
               (s.id && s.id.toString().toLowerCase().includes(q));
    });

    renderTable(filtered, currentTableView === 'top3');
}

// Render awal tabel dengan Top 3
renderTable(flatTop3List, true);
</script>
</body>
</html>
