<?php require_once 'navbar.php'; ?>

<?php
/* ----------------------------------------------------------------------
 * Presentasi saja (bukan logika backend):
 * kehadiran di bawah ambang ini ditandai Crimson sebagai peringatan.
 * Ubah angkanya sesuai kebijakan lembaga.
 * -------------------------------------------------------------------- */
$ambangKehadiran = 75;
?>

<!-- Font: Plus Jakarta Sans (judul & angka) + Inter (isi) -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">

<style>
    /* Syiar Gemilang • Dashboard tokens
       Primary #0066CC | hover #0052A3 | active #003E7E | canvas #F8FAFC
       Ink #1E293B | body #475569 | muted #94A3B8 (ikon/dekorasi saja) */
    .sg-dash { font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, 'Segoe UI', sans-serif; color: #475569; -webkit-font-smoothing: antialiased; }
    .sg-dash .sg-display { font-family: 'Plus Jakarta Sans', 'Inter', ui-sans-serif, system-ui, sans-serif; }

    .sg-card { background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 12px; box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04); }
    .sg-banner { background: linear-gradient(100deg, rgba(0, 102, 204, 0.05) 0%, #FFFFFF 70%); }

    /* Fokus keyboard selalu terlihat */
    .sg-dash a:focus-visible,
    .sg-dash button:focus-visible { outline: 2px solid #0066CC; outline-offset: 2px; }

    /* Satu momen gerak saat halaman dimuat: bar terisi dari kiri (transform, bukan width) */
    @keyframes sg-fill { from { transform: scaleX(0); } to { transform: scaleX(1); } }
    .sg-bar { transform-origin: left center; animation: sg-fill 0.8s cubic-bezier(0.2, 0.7, 0.2, 1) both; }

    @media (prefers-reduced-motion: reduce) {
        .sg-bar { animation: none; }
        .sg-dash * { transition-duration: 0.01ms !important; }
    }
</style>

<div class="sg-dash flex-1 min-w-0 flex flex-col overflow-hidden bg-[#F8FAFC]">

    <!-- ===================== TOP NAVBAR ===================== -->
    <header class="relative z-20 min-h-[64px] shrink-0 flex items-center justify-between gap-3 border-b border-[#E2E8F0] bg-white px-4 sm:px-6">
        <div class="flex min-w-0 items-center gap-2 sm:gap-3">
            <button type="button" onclick="toggleMobileSidebar()" class="lg:hidden p-2 -ml-1 text-slate-600 hover:text-brand hover:bg-slate-100 rounded-lg transition" aria-label="Buka Menu Navigasi">
                <i class="fa-solid fa-bars text-lg"></i>
            </button>
            <h1 class="sg-display truncate text-lg font-extrabold tracking-tight text-[#1E293B]"><?= esc($title); ?></h1>
            <span class="hidden xl:inline-flex shrink-0 items-center gap-1.5 whitespace-nowrap rounded-full border border-[#0066CC]/20 bg-[#0066CC]/10 px-3 py-1 text-xs font-semibold text-[#0052A3]">
                <i class="fa-solid fa-graduation-cap" aria-hidden="true"></i> Syiar Gemilang • Portal Akademik
            </span>
        </div>

        <div class="flex shrink-0 items-center gap-2 sm:gap-3">
            <span class="hidden xl:inline-flex items-center gap-1.5 whitespace-nowrap rounded-lg border border-[#0066CC]/20 bg-[#0066CC]/10 px-3.5 py-1.5 text-xs font-semibold text-[#0052A3]">
                <i class="fa-solid fa-calendar-days" aria-hidden="true"></i> Tahun Ajaran: 2026/2027 (Ganjil)
            </span>

            <!-- Notifikasi -->
            <div class="relative">
                <button type="button" id="sgNotifBtn"
                        class="inline-flex h-11 w-11 cursor-pointer items-center justify-center rounded-full text-[#475569] transition-colors duration-200 hover:bg-[#0066CC]/10 hover:text-[#0066CC] active:text-[#003E7E]"
                        aria-label="Notifikasi" aria-haspopup="true" aria-expanded="false" aria-controls="sgNotifPanel">
                    <i class="fa-regular fa-bell text-lg" aria-hidden="true"></i>
                </button>
                <div id="sgNotifPanel" role="region" aria-label="Daftar notifikasi"
                     class="hidden absolute right-0 top-full z-30 mt-2 w-[min(20rem,calc(100vw-2rem))] rounded-xl border border-[#E2E8F0] bg-white p-4 shadow-[0_12px_32px_-8px_rgba(15,23,42,0.18)]">
                    <p class="sg-display text-sm font-bold text-[#1E293B]">Notifikasi</p>
                    <div class="flex flex-col items-center px-2 py-7 text-center">
                        <span class="mb-3 inline-flex h-11 w-11 items-center justify-center rounded-full bg-[#0066CC]/10 text-[#0066CC]">
                            <i class="fa-regular fa-bell-slash" aria-hidden="true"></i>
                        </span>
                        <p class="text-sm font-semibold text-[#1E293B]">Belum ada notifikasi baru</p>
                        <p class="mt-1 text-xs leading-relaxed text-[#64748B]">Pemberitahuan akademik akan muncul di sini.</p>
                    </div>
                </div>
            </div>

            <!-- Profil Admin / Instruktur (nama bisa diganti dengan data sesi login) -->
            <div class="flex items-center gap-3 border-l border-[#E2E8F0] pl-2 sm:pl-3">
                <span class="sg-display inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#0066CC] text-sm font-bold text-white" aria-hidden="true">A</span>
                <div class="hidden min-w-0 leading-tight sm:block">
                    <p class="truncate text-sm font-semibold text-[#1E293B]">Administrator</p>
                    <p class="text-xs text-[#64748B]">Admin / Instruktur</p>
                </div>
            </div>
        </div>
    </header>

    <!-- ===================== MAIN ===================== -->
    <main class="flex-1 overflow-y-auto p-4 sm:p-6">
        <div class="mx-auto w-full max-w-[1400px] space-y-5 sm:space-y-6">

            <!-- Info sistem untuk layar < xl (di xl tampil di header) -->
            <div class="flex flex-wrap items-center gap-2 xl:hidden">
                <span class="inline-flex items-center gap-1.5 rounded-full border border-[#0066CC]/20 bg-[#0066CC]/10 px-3 py-1 text-xs font-semibold text-[#0052A3]">
                    <i class="fa-solid fa-graduation-cap" aria-hidden="true"></i> Syiar Gemilang • Portal Akademik
                </span>
                <span class="inline-flex items-center gap-1.5 rounded-full border border-[#E2E8F0] bg-white px-3 py-1 text-xs font-semibold text-[#475569]">
                    <i class="fa-solid fa-calendar-days text-[#0066CC]" aria-hidden="true"></i> Tahun Ajaran: 2026/2027 (Ganjil)
                </span>
            </div>

            <!-- ============ SUMMARY STATS ============ -->
            <section aria-label="Ringkasan akademik" class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5 xl:grid-cols-4">

                <!-- Kartu 1: Total Santri Aktif -->
                <article class="sg-card p-5">
                    <div class="flex items-start justify-between gap-3">
                        <p class="text-sm font-medium text-[#475569]">Total Santri Aktif</p>
                        <span class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#0066CC]/10 text-lg text-[#0066CC]">
                            <i class="fa-solid fa-users" aria-hidden="true"></i>
                        </span>
                    </div>
                    <p class="sg-display mt-3 text-3xl font-extrabold tracking-tight tabular-nums text-[#1E293B]"><?= esc($total_siswa); ?></p>
                    <p class="mt-2 inline-flex items-center rounded-full bg-[#0066CC]/10 px-2.5 py-1 text-xs font-semibold text-[#0052A3]">
                        Terdaftar di <?= count($persentase_jurusan); ?> jurusan
                    </p>
                </article>

                <!-- Kartu 2: Aspek Penilaian -->
                <article class="sg-card p-5">
                    <div class="flex items-start justify-between gap-3">
                        <p class="text-sm font-medium text-[#475569]">Aspek Penilaian</p>
                        <span class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#0EA5E9]/10 text-lg text-[#0284C7]">
                            <i class="fa-solid fa-book-open" aria-hidden="true"></i>
                        </span>
                    </div>
                    <p class="sg-display mt-3 text-3xl font-extrabold tracking-tight tabular-nums text-[#1E293B]"><?= esc($total_mapel); ?> Aspek</p>
                    <p class="mt-2 inline-flex items-center rounded-full bg-[#0EA5E9]/10 px-2.5 py-1 text-xs font-semibold text-[#0369A1]">
                        4 Mapel + 1 Adab
                    </p>
                </article>

                <!-- Kartu 3: Rata-Rata Nilai Terbobot -->
                <article class="sg-card p-5">
                    <div class="flex items-start justify-between gap-3">
                        <p class="text-sm font-medium text-[#475569]">Rata-Rata Nilai Terbobot</p>
                        <span class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#F59E0B]/10 text-lg text-[#D97706]">
                            <i class="fa-solid fa-award" aria-hidden="true"></i>
                        </span>
                    </div>
                    <p class="sg-display mt-3 text-3xl font-extrabold tracking-tight tabular-nums text-[#1E293B]"><?= esc($rata_rata); ?></p>
                    <p class="mt-2 inline-flex items-center rounded-full bg-[#F59E0B]/10 px-2.5 py-1 text-xs font-semibold text-[#92400E]">
                        80% Akademik + 20% Adab
                    </p>
                </article>

                <!-- Kartu 4: Rata-Rata Kehadiran -->
                <?php
                    $hadirRata   = max(0, min(100, (float) $rata_kehadiran));
                    $hadirRendah = $hadirRata < $ambangKehadiran;
                ?>
                <article class="sg-card p-5">
                    <div class="flex items-start justify-between gap-3">
                        <p class="text-sm font-medium text-[#475569]">Rata-Rata Kehadiran</p>
                        <span class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-xl text-lg <?= $hadirRendah ? 'bg-[#EF4444]/10 text-[#DC2626]' : 'bg-[#10B981]/10 text-[#059669]'; ?>">
                            <i class="fa-solid fa-clipboard-check" aria-hidden="true"></i>
                        </span>
                    </div>
                    <p class="sg-display mt-3 text-3xl font-extrabold tracking-tight tabular-nums text-[#1E293B]"><?= esc($rata_kehadiran); ?>%</p>
                    <div class="mt-3 h-1.5 w-full overflow-hidden rounded-full bg-[#E2E8F0]" aria-hidden="true">
                        <div class="sg-bar h-full rounded-full <?= $hadirRendah ? 'bg-[#EF4444]' : 'bg-[#10B981]'; ?>" style="width: <?= $hadirRata; ?>%"></div>
                    </div>
                    <?php if ($hadirRendah): ?>
                        <p class="mt-2 inline-flex items-center gap-1.5 rounded-full bg-[#EF4444]/10 px-2.5 py-1 text-xs font-semibold text-[#B91C1C]">
                            <i class="fa-solid fa-triangle-exclamation" aria-hidden="true"></i> Di bawah ambang <?= (int) $ambangKehadiran; ?>%
                        </p>
                    <?php else: ?>
                        <p class="mt-2 inline-flex items-center rounded-full bg-[#10B981]/10 px-2.5 py-1 text-xs font-semibold text-[#047857]">
                            Persentase kehadiran santri
                        </p>
                    <?php endif; ?>
                </article>
            </section>

            <!-- ============ FORMULA BANNER ============ -->
            <section class="sg-banner rounded-xl border border-[#0066CC]/15 p-5 shadow-[0_1px_2px_rgba(15,23,42,0.04)] sm:p-6" aria-labelledby="sgFormulaTitle">
                <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between lg:gap-8">
                    <div class="min-w-0 flex-1">
                        <div class="flex items-start gap-3.5">
                            <span class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#0066CC] text-base text-white shadow-sm shadow-[#0066CC]/25">
                                <i class="fa-solid fa-scale-balanced" aria-hidden="true"></i>
                            </span>
                            <div class="min-w-0">
                                <h2 id="sgFormulaTitle" class="sg-display flex flex-wrap items-center gap-2 text-base font-bold text-[#1E293B]">
                                    Formula Penilaian Terbobot
                                    <span class="whitespace-nowrap rounded-full border border-[#F59E0B]/40 bg-[#F59E0B]/15 px-2.5 py-0.5 text-xs font-bold text-[#92400E]">
                                        Adab &amp; Akhlaq: 20%
                                    </span>
                                </h2>
                                <p class="mt-1.5 max-w-prose text-sm leading-relaxed text-[#475569]">
                                    Nilai akhir santri dikalkulasikan dengan komposisi: <strong class="font-semibold text-[#0052A3]">80% Nilai Akademik</strong> (Tauhid, Fiqih, B. Inggris, dan Menulis Kreatif) dan <strong class="font-semibold text-[#B45309]">20% Nilai Adab &amp; Akhlaq</strong> santri dalam keseharian.
                                </p>
                            </div>
                        </div>

                        <!-- Komposisi 80 / 20 -->
                        <div class="mt-5" role="img" aria-label="Komposisi nilai akhir: 80 persen akademik dan 20 persen adab dan akhlaq">
                            <div class="sg-bar flex h-3 w-full overflow-hidden rounded-full bg-[#E2E8F0]">
                                <span class="block h-full bg-[#0066CC]" style="width: 80%"></span>
                                <span class="block h-full bg-[#F59E0B]" style="width: 20%"></span>
                            </div>
                            <div class="mt-2.5 flex flex-wrap items-center justify-between gap-x-6 gap-y-1 text-xs font-medium">
                                <span class="inline-flex items-center gap-2 text-[#0052A3]">
                                    <span class="h-2.5 w-2.5 rounded-full bg-[#0066CC]" aria-hidden="true"></span>
                                    Akademik 80% • Tauhid, Fiqih, B. Inggris, Menulis Kreatif
                                </span>
                                <span class="inline-flex items-center gap-2 text-[#92400E]">
                                    <span class="h-2.5 w-2.5 rounded-full bg-[#F59E0B]" aria-hidden="true"></span>
                                    Adab &amp; Akhlaq 20%
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="flex shrink-0 flex-col gap-2.5 sm:flex-row lg:flex-col xl:flex-row">
                        <a href="<?= base_url('admin/data'); ?>"
                           class="inline-flex min-h-[44px] items-center justify-center gap-2 rounded-lg border border-[#CBD5E1] bg-white px-4 text-sm font-semibold text-[#1E293B] transition-colors duration-200 hover:border-[#0066CC]/50 hover:bg-[#F8FAFC] active:bg-[#E2E8F0]">
                            <i class="fa-solid fa-user-graduate text-[#0066CC]" aria-hidden="true"></i> Data Santri
                        </a>
                        <a href="<?= base_url('admin/kehadiran'); ?>"
                           class="inline-flex min-h-[44px] items-center justify-center gap-2 rounded-lg bg-[#0066CC] px-4 text-sm font-semibold text-white shadow-sm shadow-[#0066CC]/20 transition-colors duration-200 hover:bg-[#0052A3] active:bg-[#003E7E]">
                            <i class="fa-solid fa-clipboard-user" aria-hidden="true"></i> Sesi Kehadiran
                        </a>
                    </div>
                </div>
            </section>

            <!-- ============ DISTRIBUSI JURUSAN ============ -->
            <section class="sg-card p-5 sm:p-6" aria-labelledby="sgJurusanTitle">
                <div class="flex flex-col gap-2 border-b border-slate-100 pb-4 sm:flex-row sm:items-center sm:justify-between">
                    <div class="min-w-0">
                        <h2 id="sgJurusanTitle" class="sg-display flex items-center gap-2.5 text-base font-bold text-[#1E293B]">
                            <span class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#0066CC]/10 text-sm text-[#0066CC]">
                                <i class="fa-solid fa-chart-pie" aria-hidden="true"></i>
                            </span>
                            Persentase &amp; Distribusi Santri per Jurusan
                        </h2>
                        <p class="mt-1 max-w-2xl text-sm text-[#475569]">Distribusi jumlah santri dan persentase keterwakilan di setiap jurusan / kelas rombel Rumah Gemilang Indonesia.</p>
                    </div>
                    <span class="w-fit shrink-0 whitespace-nowrap rounded-full border border-[#0066CC]/20 bg-[#0066CC]/10 px-3 py-1 text-xs font-bold text-[#0052A3]">
                        Total: <?= count($persentase_jurusan); ?> Jurusan
                    </span>
                </div>

                <div class="mt-5 grid grid-cols-1 items-center gap-6 xl:grid-cols-12">

                    <!-- Doughnut Chart -->
                    <div class="flex flex-col items-center justify-center xl:col-span-5">
                        <div class="relative h-60 w-60 sm:h-64 sm:w-64">
                            <canvas id="jurusanDoughnutChart" role="img" aria-label="Diagram donat distribusi santri per jurusan. Rincian lengkap tersedia pada kartu jurusan.">
                                Diagram donat distribusi santri per jurusan.
                            </canvas>
                            <div class="pointer-events-none absolute inset-0 flex flex-col items-center justify-center">
                                <span class="sg-display text-4xl font-extrabold tracking-tight tabular-nums text-[#1E293B]"><?= esc($total_siswa); ?></span>
                                <span class="mt-0.5 text-xs font-semibold text-[#0052A3]">Total santri</span>
                            </div>
                        </div>
                        <p class="mt-3 text-center text-xs text-[#64748B]">Arahkan kursor atau ketuk bagan untuk melihat jumlah &amp; persentase</p>
                    </div>

                    <!-- Kartu Jurusan -->
                    <div class="xl:col-span-7">
                        <?php
                        $jurusanColors = [
                            'Desain Grafis'                => ['bg' => 'bg-red-500',     'text' => 'text-red-600',     'badge' => 'bg-red-50 text-red-700 border-red-200',         'icon' => 'fa-palette'],
                            'Teknik Komputer dan Jaringan' => ['bg' => 'bg-emerald-600', 'text' => 'text-emerald-700', 'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200', 'icon' => 'fa-network-wired'],
                            'Aplikasi Perkantoran'         => ['bg' => 'bg-orange-500',  'text' => 'text-orange-600',  'badge' => 'bg-orange-50 text-orange-700 border-orange-200', 'icon' => 'fa-file-excel'],
                            'Tata Busana'                  => ['bg' => 'bg-yellow-500',  'text' => 'text-yellow-800',  'badge' => 'bg-yellow-50 text-yellow-800 border-yellow-300', 'icon' => 'fa-scissors'],
                            'Otomotif'                     => ['bg' => 'bg-slate-900',   'text' => 'text-slate-900',   'badge' => 'bg-slate-100 text-slate-900 border-slate-300',   'icon' => 'fa-wrench'],
                            'Fotografi dan Videografi'     => ['bg' => 'bg-[#0066CC]',   'text' => 'text-[#0052A3]',   'badge' => 'bg-[#0066CC]/10 text-[#0052A3] border-[#0066CC]/20', 'icon' => 'fa-camera'],
                        ];
                        ?>

                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                            <?php foreach ($persentase_jurusan as $j): ?>
                                <?php
                                    $kName = $j['kelas'];
                                    $theme = $jurusanColors[$kName] ?? ['bg' => 'bg-[#0066CC]', 'text' => 'text-[#0066CC]', 'badge' => 'bg-[#0066CC]/10 text-[#0052A3] border-[#0066CC]/20', 'icon' => 'fa-graduation-cap'];
                                    $hadirJRendah = (float) ($j['avg_kehadiran'] ?? 95) < $ambangKehadiran;
                                ?>
                                <article class="rounded-xl border border-[#E2E8F0] bg-[#F8FAFC] p-4">
                                    <div class="flex items-start gap-3">
                                        <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border text-sm <?= $theme['badge']; ?>">
                                            <i class="fa-solid <?= $theme['icon']; ?>" aria-hidden="true"></i>
                                        </span>
                                        <h3 class="min-w-0 flex-1 text-sm font-semibold leading-snug text-[#1E293B]"><?= esc($kName); ?></h3>
                                        <span class="shrink-0 rounded-full border px-2.5 py-0.5 text-xs font-bold tabular-nums <?= $theme['badge']; ?>">
                                            <?= $j['persentase']; ?>%
                                        </span>
                                    </div>

                                    <!-- Progress bar -->
                                    <div class="mt-3 h-2 w-full overflow-hidden rounded-full bg-[#E2E8F0]" aria-hidden="true">
                                        <div class="sg-bar h-full rounded-full <?= $theme['bg']; ?>" style="width: <?= min(100, $j['persentase'] * 3.5); ?>%"></div>
                                    </div>

                                    <div class="mt-3 flex flex-wrap items-center justify-between gap-x-3 gap-y-1 text-xs text-[#475569]">
                                        <span class="inline-flex items-center gap-1.5">
                                            <i class="fa-solid fa-user-group text-[#94A3B8]" aria-hidden="true"></i>
                                            <span><strong class="font-semibold <?= $theme['text']; ?>"><?= $j['total_santri']; ?></strong> santri</span>
                                        </span>
                                        <span class="inline-flex items-center gap-1.5 font-medium <?= $hadirJRendah ? 'text-[#DC2626]' : 'text-[#047857]'; ?>">
                                            <i class="fa-solid <?= $hadirJRendah ? 'fa-triangle-exclamation' : 'fa-clipboard-check'; ?>" aria-hidden="true"></i>
                                            Kehadiran <?= $j['avg_kehadiran'] ?? 95; ?>%
                                        </span>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ============ LEADERBOARD TOP 5 ============ -->
            <section class="sg-card p-5 sm:p-6" aria-labelledby="sgTopTitle">
                <div class="flex flex-col gap-2 border-b border-slate-100 pb-4 sm:flex-row sm:items-center sm:justify-between">
                    <div class="min-w-0">
                        <h2 id="sgTopTitle" class="sg-display flex items-center gap-2.5 text-base font-bold text-[#1E293B]">
                            <span class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#F59E0B]/10 text-sm text-[#D97706]">
                                <i class="fa-solid fa-trophy" aria-hidden="true"></i>
                            </span>
                            Top 5 Santri Terbaik (Nilai Terbobot)
                        </h2>
                        <p class="mt-1 max-w-2xl text-sm text-[#475569]">Peringkat 5 besar santri berdasarkan nilai akhir 80% Akademik + 20% Adab &amp; Akhlaq.</p>
                    </div>
                    <a href="<?= base_url('admin/pemeringkatan'); ?>"
                       class="inline-flex min-h-[44px] w-fit shrink-0 items-center rounded-lg px-3 text-sm font-semibold text-[#0066CC] transition-colors duration-200 hover:bg-[#0066CC]/10 hover:text-[#0052A3] active:text-[#003E7E]">
                        Lihat Peringkat Selengkapnya
                    </a>
                </div>

                <div class="mt-4 overflow-x-auto rounded-xl border border-[#E2E8F0]">
                    <table class="w-full min-w-[680px] border-collapse text-left">
                        <caption class="sr-only">Lima santri dengan nilai akhir terbobot tertinggi</caption>
                        <thead>
                            <tr class="bg-[#F8FAFC] text-xs font-semibold text-[#475569]">
                                <th scope="col" class="w-28 px-4 py-3.5 text-center">Peringkat</th>
                                <th scope="col" class="px-4 py-3.5">Nama Santri</th>
                                <th scope="col" class="px-4 py-3.5">Kelas / Jurusan</th>
                                <th scope="col" class="px-4 py-3.5 text-center">Akademik (80%)</th>
                                <th scope="col" class="bg-[#F59E0B]/[0.07] px-4 py-3.5 text-center text-[#92400E]">Adab &amp; Akhlaq (20%)</th>
                                <th scope="col" class="px-4 py-3.5 text-center">Kehadiran</th>
                                <th scope="col" class="w-36 bg-[#0066CC]/[0.07] px-4 py-3.5 text-center font-bold text-[#0052A3]">Nilai Akhir</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            <?php foreach ($top_students as $index => $student): ?>
                            <?php
                                $rank = $index + 1;
                                if ($rank === 1) {
                                    $rankBadge = '<span class="inline-flex h-8 min-w-[3.25rem] items-center justify-center gap-1.5 rounded-full border border-[#F59E0B]/50 bg-[#FBBF24] px-3 text-sm font-extrabold text-[#451A03] shadow-sm"><i class="fa-solid fa-crown text-xs" aria-hidden="true"></i><span class="sr-only">Peringkat </span>1</span>';
                                } elseif ($rank === 2) {
                                    $rankBadge = '<span class="inline-flex h-8 min-w-[3.25rem] items-center justify-center gap-1.5 rounded-full border border-[#CBD5E1] bg-[#E2E8F0] px-3 text-sm font-extrabold text-[#1E293B]"><i class="fa-solid fa-medal text-xs text-[#64748B]" aria-hidden="true"></i><span class="sr-only">Peringkat </span>2</span>';
                                } elseif ($rank === 3) {
                                    $rankBadge = '<span class="inline-flex h-8 min-w-[3.25rem] items-center justify-center gap-1.5 rounded-full border border-[#FDBA74] bg-[#FED7AA] px-3 text-sm font-extrabold text-[#7C2D12]"><i class="fa-solid fa-medal text-xs text-[#C2410C]" aria-hidden="true"></i><span class="sr-only">Peringkat </span>3</span>';
                                } else {
                                    $rankBadge = '<span class="inline-flex h-8 min-w-[3.25rem] items-center justify-center rounded-full border border-slate-200 bg-slate-100 px-3 text-sm font-bold text-[#475569]"><span class="sr-only">Peringkat </span>' . $rank . '</span>';
                                }
                                $kTheme       = $jurusanColors[$student['kelas']] ?? null;
                                $hadirSRendah = (float) ($student['kehadiran'] ?? 95) < $ambangKehadiran;
                            ?>
                            <tr class="<?= $index % 2 === 1 ? 'bg-[#F8FAFC]/70' : 'bg-white'; ?> transition-colors duration-150 hover:bg-[#0066CC]/[0.04]">
                                <td class="px-4 py-3.5 text-center">
                                    <?= $rankBadge; ?>
                                </td>
                                <td class="px-4 py-3.5 font-semibold text-[#1E293B]"><?= esc($student['nama']); ?></td>
                                <td class="px-4 py-3.5 text-[#475569]">
                                    <span class="inline-flex items-center gap-2">
                                        <span class="h-2 w-2 shrink-0 rounded-full <?= $kTheme['bg'] ?? 'bg-slate-400'; ?>" aria-hidden="true"></span>
                                        <?= esc($student['kelas']); ?>
                                    </span>
                                </td>
                                <td class="px-4 py-3.5 text-center font-semibold tabular-nums text-[#475569]">
                                    <?= number_format($student['rata_akademik'] ?? $student['rata_rata'], 2); ?>
                                </td>
                                <td class="bg-[#F59E0B]/[0.05] px-4 py-3.5 text-center font-semibold tabular-nums text-[#92400E]">
                                    <?= esc($student['adab_akhlaq'] ?? 85); ?>
                                </td>
                                <td class="px-4 py-3.5 text-center">
                                    <span class="inline-flex items-center gap-1.5 rounded-full border px-2.5 py-0.5 text-xs font-bold tabular-nums <?= $hadirSRendah ? 'border-[#EF4444]/30 bg-[#EF4444]/10 text-[#B91C1C]' : 'border-[#10B981]/30 bg-[#10B981]/10 text-[#047857]'; ?>">
                                        <?php if ($hadirSRendah): ?><i class="fa-solid fa-triangle-exclamation" aria-hidden="true"></i><?php endif; ?>
                                        <?= esc($student['kehadiran'] ?? 95); ?>%
                                    </span>
                                </td>
                                <td class="sg-display bg-[#0066CC]/[0.06] px-4 py-3.5 text-center text-base font-extrabold tabular-nums text-[#0066CC]">
                                    <?= number_format($student['rata_rata'], 2); ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>

                            <?php if (empty($top_students)): ?>
                            <tr>
                                <td colspan="7" class="px-4 py-10 text-center text-sm text-[#64748B]">
                                    Belum ada data nilai. Peringkat akan muncul setelah nilai santri diinput.
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <p class="mt-2 text-xs text-[#64748B] xl:hidden">Geser tabel ke samping untuk melihat semua kolom.</p>
            </section>

        </div>
    </main>
</div>

<!-- Popover notifikasi -->
<script>
(function () {
    var btn = document.getElementById('sgNotifBtn');
    var panel = document.getElementById('sgNotifPanel');
    if (!btn || !panel) return;

    function setOpen(open) {
        panel.classList.toggle('hidden', !open);
        btn.setAttribute('aria-expanded', String(open));
    }
    btn.addEventListener('click', function (e) {
        e.stopPropagation();
        setOpen(panel.classList.contains('hidden'));
    });
    document.addEventListener('click', function (e) {
        if (!panel.contains(e.target)) setOpen(false);
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && !panel.classList.contains('hidden')) {
            setOpen(false);
            btn.focus();
        }
    });
})();
</script>

<!-- Chart.js Doughnut Script untuk Persentase Jurusan -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('jurusanDoughnutChart');
    if (!canvas || typeof Chart === 'undefined') return;

    const persentaseData = <?= json_encode($persentase_jurusan); ?>;

    const labels = persentaseData.map(d => d.kelas);
    const dataCounts = persentaseData.map(d => d.total_santri);
    const percentages = persentaseData.map(d => d.persentase);

    // Warna per jurusan (berdasarkan nama) — sinkron dengan kartu jurusan di sebelah kanan
    const warnaJurusan = {
        'Desain Grafis':                '#EF4444', // Merah
        'Teknik Komputer dan Jaringan': '#10B981', // Hijau
        'Aplikasi Perkantoran':         '#F97316', // Oren
        'Tata Busana':                  '#EAB308', // Kuning
        'Otomotif':                     '#0F172A', // Hitam
        'Fotografi dan Videografi':     '#0066CC'  // Biru
    };
    const warnaCadangan = ['#EF4444', '#10B981', '#F97316', '#EAB308', '#0F172A', '#0066CC'];
    const colors = labels.map((nama, i) => warnaJurusan[nama] || warnaCadangan[i % warnaCadangan.length]);

    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    new Chart(canvas.getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: dataCounts,
                backgroundColor: colors,
                borderColor: '#ffffff',
                borderWidth: 2,
                borderRadius: 4,
                hoverOffset: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '72%',
            animation: reduceMotion ? false : { duration: 800 },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(30, 41, 59, 0.96)',
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
