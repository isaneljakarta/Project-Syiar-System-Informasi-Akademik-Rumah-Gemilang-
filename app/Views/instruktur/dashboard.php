<?php require_once 'navbar.php'; ?>

<div class="flex-1 min-w-0 flex flex-col overflow-hidden bg-[#F8FAFC]">
        
    <!-- Top Navbar -->
    <?php 
    $page_title = $title ?? 'Dashboard Instruktur';
    require_once __DIR__ . '/components/topbar.php'; 
    ?>

    <!-- Main Scrollable Area -->
    <main class="flex-1 overflow-y-auto pb-16">

        <!-- ===================== HERO WAVE BANNER ===================== -->
        <?php
        ob_start();
        ?>
        <div class="flex flex-wrap items-center gap-2 sm:gap-2.5">
            <a href="<?= base_url('instruktur/kelas'); ?>" class="px-3.5 py-2.5 bg-white text-brand-deep hover:bg-brand-light rounded-xl font-bold text-xs shadow-md transition flex items-center gap-1.5">
                <i class="fa-solid fa-layer-group text-brand"></i> Nilai per Kelas
            </a>
            <a href="<?= base_url('instruktur/nilai'); ?>" class="px-3.5 py-2.5 bg-sky-500/80 hover:bg-sky-500 text-white rounded-xl font-bold text-xs shadow-md transition flex items-center gap-1.5">
                <i class="fa-solid fa-pen-to-square"></i> Kelola Nilai
            </a>
            <a href="<?= base_url('instruktur/kehadiran'); ?>" class="px-3.5 py-2.5 bg-emerald-600/80 hover:bg-emerald-600 text-white rounded-xl font-bold text-xs shadow-md transition flex items-center gap-1.5">
                <i class="fa-solid fa-clipboard-user"></i> Isi Presensi
            </a>
        </div>
        <?php
        $extra_btn = ob_get_clean();

        $hero = [
            'breadcrumb' => [
                ['label' => 'Portal Instruktur', 'url' => base_url('instruktur')],
                ['label' => 'Dashboard Pengajar']
            ],
            'badge' => 'Lembaga Pendidikan E-RGI Syiar Gemilang',
            'title' => 'Portal Pengelolaan Nilai & Presensi Santri',
            'subtitle' => 'Selamat Datang, <strong>' . esc(session()->get('nama')) . '</strong>! Kelola pencatatan evaluasi akademik 4 mapel, integrasi adab akhlaq 20%, serta presensi kelas kejuruan.',
            'extra_action' => $extra_btn,
            'stats' => [
                ['icon' => 'fa-solid fa-users', 'bg' => 'bg-sky-400/20 text-sky-200', 'value' => $total_siswa, 'label' => 'Santri Dibina'],
                ['icon' => 'fa-solid fa-chart-line', 'bg' => 'bg-amber-400/20 text-amber-200', 'value' => $rata_rata, 'label' => 'Rata-rata Nilai'],
                ['icon' => 'fa-solid fa-clipboard-check', 'bg' => 'bg-emerald-400/20 text-emerald-200', 'value' => $rata_kehadiran . '%', 'label' => 'Presensi Santri'],
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
                    <span class="text-3xs text-brand font-semibold">Terdaftar Aktif</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center text-xl font-bold shrink-0">
                    <i class="fa-solid fa-book-open"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium">Aspek Penilaian</p>
                    <h3 class="text-2xl font-bold text-slate-800"><?= esc($total_mapel); ?> Aspek</h3>
                    <span class="text-3xs text-sky-600 font-semibold">4 Mapel + 1 Adab</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-xl font-bold shrink-0">
                    <i class="fa-solid fa-award"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium">Rata-Rata Nilai</p>
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
                    <span class="text-3xs text-emerald-600 font-semibold">Tingkat Disiplin Santri</span>
                </div>
            </div>
        </div>

        <!-- Formula Bobot Info -->
        <div class="bg-gradient-to-r from-emerald-50 via-white to-amber-50 border border-emerald-100 rounded-xl p-4 shadow-2xs flex flex-col md:flex-row md:items-center justify-between gap-3">
            <div class="flex items-start gap-3">
                <div class="w-9 h-9 rounded-lg bg-emerald-600 text-white flex items-center justify-center text-base shrink-0 mt-0.5">
                    <i class="fa-solid fa-scale-balanced"></i>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                        Petunjuk Penilaian Instruktur
                        <span class="text-2xs bg-amber-100 text-amber-800 font-bold px-2 py-0.5 rounded-full border border-amber-300">
                            Adab & Akhlaq: 20%
                        </span>
                    </h4>
                    <p class="text-xs text-slate-600 mt-0.5 leading-relaxed">
                        Nilai akhir dihitung otomatis berdasarkan rumus: <strong>80% Rata-rata Akademik</strong> (Tauhid, Fiqih, B. Inggris, Menulis Kreatif) + <strong>20% Nilai Adab & Akhlaq</strong>. Silakan perbarui nilai melalui menu <a href="<?= base_url('instruktur/nilai'); ?>" class="text-emerald-700 font-semibold underline">Input & Update Nilai</a>.
                    </p>
                </div>
            </div>
        </div>

        <!-- Top 5 Santri -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div>
                    <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-trophy text-amber-500"></i> Top 5 Santri Berprestasi
                    </h3>
                    <p class="text-xs text-slate-500">Santri dengan akumulasi nilai tertinggi (Akademik + Adab).</p>
                </div>
                <a href="<?= base_url('instruktur/nilai'); ?>" class="text-xs font-semibold text-brand hover:text-brand-dark flex items-center gap-1 transition">
                    Kelola Nilai Santri <i class="fa-solid fa-arrow-right"></i>
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
                            <th class="py-3 px-3 text-center border-r border-slate-200 bg-amber-50/50 text-amber-900">Adab (20%)</th>
                            <th class="py-3 px-3 text-center border-r border-slate-200">Kehadiran</th>
                            <th class="py-3 px-3 text-center bg-brand-light text-brand font-extrabold w-32">Nilai Akhir</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-slate-200">
                        <?php foreach ($top_students as $index => $student): ?>
                        <tr class="<?= $index % 2 === 1 ? 'bg-slate-50/70' : 'bg-white'; ?> hover:bg-brand-light/40 transition">
                            <td class="py-3 px-3 text-center border-r border-slate-200 font-bold">
                                <?php if ($index === 0): ?>🥇 1
                                <?php elseif ($index === 1): ?>🥈 2
                                <?php elseif ($index === 2): ?>🥉 3
                                <?php else: ?><?= $index + 1; ?>
                                <?php endif; ?>
                            </td>
                            <td class="py-3 px-3 border-r border-slate-200 font-medium text-slate-800"><?= esc($student['nama']); ?></td>
                            <td class="py-3 px-3 border-r border-slate-200 text-slate-600">
                                <?php
                                    $jTheme = [
                                        'Desain Grafis'                => 'bg-red-50 text-red-700 border-red-200',
                                        'Teknik Komputer dan Jaringan' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        'Aplikasi Perkantoran'         => 'bg-orange-50 text-orange-700 border-orange-200',
                                        'Tata Busana'                  => 'bg-yellow-50 text-yellow-800 border-yellow-300',
                                        'Otomotif'                     => 'bg-slate-100 text-slate-900 border-slate-300',
                                        'Fotografi dan Videografi'     => 'bg-blue-50 text-blue-700 border-blue-200',
                                    ];
                                    $bdg = $jTheme[$student['kelas']] ?? 'bg-blue-50 text-blue-700 border-blue-200';
                                ?>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-3xs font-semibold border <?= $bdg; ?>">
                                    <?= esc($student['kelas']); ?>
                                </span>
                            </td>
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
</body>
</html>

