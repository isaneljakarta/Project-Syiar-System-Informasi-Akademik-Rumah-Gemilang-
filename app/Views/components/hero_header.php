<?php
/**
 * ============================================================================
 * Komponen Hero Wave Header (E-RGI Style) - Syiar Gemilang
 * ============================================================================
 * Komponen header banner dengan gelombang gradient khas E-RGI Syiar Gemilang.
 *
 * Parameter / Variabel yang Didukung:
 * - $hero (array) : Array konfigurasi lengkap:
 *     - 'breadcrumb'   : Array of ['label' => '...', 'url' => '...']
 *     - 'badge'        : Teks badge (default: 'Lembaga Pendidikan E-RGI Syiar Gemilang')
 *     - 'badge_icon'   : Ikon badge (default: 'fa-solid fa-graduation-cap text-sky-300')
 *     - 'title'        : Judul besar banner (fallback: $title ?? 'Dashboard')
 *     - 'subtitle'     : Deskripsi/keterangan halaman
 *     - 'stats'        : Array of stat counter chips:
 *                        [['icon' => 'fa-solid fa-...', 'bg' => '...', 'value' => '...', 'label' => '...']]
 *     - 'extra_action' : HTML action button opsional di kanan
 */

if (!function_exists('esc')) {
    function esc($data) {
        return htmlspecialchars((string)$data, ENT_QUOTES, 'UTF-8');
    }
}

$heroConfig = $hero ?? [];

// 1. Breadcrumbs
$breadcrumbs = $heroConfig['breadcrumb'] ?? $breadcrumbs ?? [];
if (empty($breadcrumbs)) {
    // Auto fallback berdasarkan session role
    $sessRole = function_exists('session') && session()->has('role') ? session()->get('role') : 'admin';
    $roleHome = [
        'admin'       => ['label' => 'Portal Admin', 'url' => base_url('admin')],
        'instruktur'  => ['label' => 'Portal Instruktur', 'url' => base_url('instruktur')],
        'siswa'       => ['label' => 'Portal Santri', 'url' => base_url('siswa')],
        'wali_santri' => ['label' => 'Portal Wali Santri', 'url' => base_url('wali')],
    ];
    $homeEntry = $roleHome[strtolower($sessRole)] ?? ['label' => 'Beranda', 'url' => base_url('/')];
    $currentPageLabel = $heroConfig['title'] ?? $title ?? 'Dashboard';
    $breadcrumbs = [
        $homeEntry,
        ['label' => $currentPageLabel]
    ];
}

// 2. Badge & Typography
$heroBadgeText = $heroConfig['badge'] ?? $hero_badge ?? 'Lembaga Pendidikan E-RGI Syiar Gemilang';
$heroBadgeIcon = $heroConfig['badge_icon'] ?? $hero_badge_icon ?? 'fa-solid fa-graduation-cap text-sky-300';
$heroTitle = $heroConfig['title'] ?? $hero_title ?? $title ?? 'Dashboard';
$heroSubtitle = $heroConfig['subtitle'] ?? $heroConfig['description'] ?? $hero_subtitle ?? $hero_desc ?? '';

// 3. Stats Chips
$heroStats = $heroConfig['stats'] ?? $hero_stats ?? [];
$heroExtraAction = $heroConfig['extra_action'] ?? $hero_extra_action ?? null;
?>

<!-- Wave Background Generator Adopsi Konsep E-RGI -->
<style>
.hero-wave-pattern {
    background-color: #073B66;
    background-image: 
        radial-gradient(at 15% 20%, rgba(255, 255, 255, 0.18) 0px, transparent 50%),
        radial-gradient(at 85% 75%, rgba(0, 102, 204, 0.45) 0px, transparent 60%),
        linear-gradient(135deg, #073B66 0%, #0066CC 50%, #003E7E 100%);
}
</style>

<!-- ================= HERO WAVE BANNER (E-RGI STYLE) ================= -->
<section class="hero-wave-pattern text-white px-4 sm:px-6 lg:px-10 py-8 sm:py-10 relative overflow-hidden shadow-md">
    <!-- Elemen Aksen Grafis Abstrak Blur -->
    <div class="absolute -right-16 -top-16 w-80 h-80 rounded-full bg-white/5 blur-2xl pointer-events-none"></div>
    <div class="absolute right-1/4 -bottom-24 w-96 h-96 rounded-full bg-sky-400/10 blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto relative z-10">
        <!-- Breadcrumb navigation -->
        <nav class="flex items-center space-x-2 text-xs sm:text-sm text-sky-100 font-medium mb-3">
            <?php foreach ($breadcrumbs as $idx => $bc): ?>
                <?php if ($idx > 0): ?>
                    <span class="opacity-60 text-xs">/</span>
                <?php endif; ?>
                <?php if (!empty($bc['url'])): ?>
                    <a href="<?= $bc['url']; ?>" class="hover:text-white transition flex items-center gap-1.5 opacity-90 hover:opacity-100">
                        <?php if ($idx === 0): ?>
                            <i class="fa-solid fa-house text-xs"></i>
                        <?php endif; ?>
                        <span><?= esc($bc['label']); ?></span>
                    </a>
                <?php else: ?>
                    <span class="text-white font-semibold"><?= esc($bc['label']); ?></span>
                <?php endif; ?>
            <?php endforeach; ?>
        </nav>

        <!-- Banner Title & Stats Counters -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-xs font-semibold text-sky-100 mb-2">
                    <i class="<?= esc($heroBadgeIcon); ?>"></i> <?= esc($heroBadgeText); ?>
                </div>
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold tracking-tight text-white drop-shadow-xs sg-display">
                    <?= esc($heroTitle); ?>
                </h1>
                <?php if (!empty($heroSubtitle)): ?>
                    <p class="text-sky-100 text-xs sm:text-sm mt-2 max-w-2xl font-light leading-relaxed">
                        <?= $heroSubtitle; ?>
                    </p>
                <?php endif; ?>
            </div>

            <!-- Counter Badges & Action Buttons -->
            <div class="flex flex-wrap items-center gap-2.5 sm:gap-3 self-start md:self-auto shrink-0">
                <?php if (!empty($heroExtraAction)): ?>
                    <?= $heroExtraAction; ?>
                <?php endif; ?>

                <?php if (!empty($heroStats)): ?>
                    <?php foreach ($heroStats as $stat): ?>
                        <div class="flex items-center gap-3 bg-white/10 backdrop-blur-md px-3.5 sm:px-4 py-2 sm:py-2.5 rounded-xl border border-white/20 shadow-xs">
                            <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-lg <?= $stat['bg'] ?? 'bg-sky-400/20 text-sky-200'; ?> flex items-center justify-center shrink-0">
                                <i class="<?= $stat['icon']; ?> text-base sm:text-lg"></i>
                            </div>
                            <div>
                                <span class="block text-lg sm:text-xl font-bold text-white leading-none"><?= esc($stat['value']); ?></span>
                                <span class="text-3xs sm:text-2xs text-sky-100 font-medium"><?= esc($stat['label']); ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
