<?php
/**
 * ============================================================================
 * Komponen Top Bar Modular - Syiar Gemilang
 * ============================================================================
 * Komponen header navigasi atas yang konsisten dan modular untuk seluruh halaman.
 *
 * Parameter / Variabel yang Didukung:
 * - $page_title (string) : Judul halaman (fallback ke $title, lalu 'Dashboard')
 * - $user (array|object) : Data pengguna kustom:
 *     - 'name' / 'nama'  : Nama user (fallback: session('nama') / 'Administrator')
 *     - 'role'           : Role/subtitle (fallback: session('role') / 'Admin / Instruktur')
 *     - 'avatar'/'foto'  : URL gambar profil (opsional)
 *     - 'initial'        : Inisial huruf profil (fallback: huruf pertama nama)
 * - $portal_badge (string) : Badge teks portal (default: 'Syiar Gemilang • Portal Akademik')
 * - $tahun_ajaran (string) : Teks tahun ajaran (default: '2026/2027 (Ganjil)')
 */

// Pastikan fungsi esc() tersedia jika di luar environment CodeIgniter
if (!function_exists('esc')) {
    function esc($data) {
        return htmlspecialchars((string)$data, ENT_QUOTES, 'UTF-8');
    }
}

// 1. Judul Halaman Dinamis
$topbar_title = $page_title ?? $title ?? 'Dashboard';

// 2. Data Pengguna Dinamis
$userData = $user ?? [];
if (is_object($userData)) {
    $userData = (array)$userData;
}

// Nama User
$topbar_user_name = $userData['name']
    ?? $userData['nama']
    ?? (function_exists('session') && session()->has('nama') ? session()->get('nama') : null)
    ?? (function_exists('session') && session()->has('username') ? session()->get('username') : null)
    ?? 'Administrator';

// Role / Subtitle
$topbar_user_role = $userData['role'] ?? $userData['role_label'] ?? null;
if (empty($topbar_user_role) && function_exists('session') && session()->has('role')) {
    $sessionRole = session()->get('role');
    $roleMap = [
        'admin'       => 'Admin / Instruktur',
        'instruktur'  => 'Instruktur',
        'siswa'       => 'Santri',
        'wali_santri' => 'Wali Santri'
    ];
    $topbar_user_role = $roleMap[strtolower($sessionRole)] ?? ucfirst($sessionRole);
}
if (empty($topbar_user_role)) {
    $topbar_user_role = 'Admin / Instruktur';
}

// Avatar Gambar (URL / Path)
$topbar_user_avatar = $userData['avatar']
    ?? $userData['photo']
    ?? $userData['foto']
    ?? (function_exists('session') && session()->has('avatar') ? session()->get('avatar') : null);

// Avatar Inisial Huruf
$topbar_user_initial = $userData['initial'] ?? null;
if (empty($topbar_user_initial)) {
    $cleanName = trim($topbar_user_name);
    $topbar_user_initial = !empty($cleanName) ? strtoupper(mb_substr($cleanName, 0, 1, 'UTF-8')) : 'A';
}

// 3. Badge Dinamis
$topbar_badge = $portal_badge ?? 'Syiar Gemilang • Portal Akademik';
$topbar_badge_icon = $portal_badge_icon ?? 'fa-solid fa-graduation-cap';
$topbar_tahun_ajaran = $tahun_ajaran ?? '2026/2027 (Ganjil)';
?>

<!-- ===================== TOP NAVBAR ===================== -->
<header class="relative z-20 min-h-[64px] shrink-0 flex items-center justify-between gap-3 border-b border-[#E2E8F0] bg-white px-4 sm:px-6">
    <div class="flex min-w-0 items-center gap-2 sm:gap-3">
        <!-- Tombol Hamburger Mobile -->
        <button type="button" onclick="toggleMobileSidebar()" class="lg:hidden p-2 -ml-1 text-slate-600 hover:text-brand hover:bg-slate-100 rounded-lg transition" aria-label="Buka Menu Navigasi">
            <i class="fa-solid fa-bars text-lg"></i>
        </button>

        <!-- Judul Halaman -->
        <h1 class="sg-display truncate text-lg font-extrabold tracking-tight text-[#1E293B]"><?= esc($topbar_title); ?></h1>

        <!-- Badge Portal Akademik -->
        <span class="hidden xl:inline-flex shrink-0 items-center gap-1.5 whitespace-nowrap rounded-full border border-[#0066CC]/20 bg-[#0066CC]/10 px-3 py-1 text-xs font-semibold text-[#0052A3]">
            <i class="<?= esc($topbar_badge_icon); ?>" aria-hidden="true"></i> <?= esc($topbar_badge); ?>
        </span>
    </div>

    <div class="flex shrink-0 items-center gap-2 sm:gap-3">
        <?php if (!empty($topbar_extra_right)): ?>
            <?= $topbar_extra_right; ?>
        <?php endif; ?>

        <!-- Badge Tahun Ajaran -->
        <span class="hidden xl:inline-flex items-center gap-1.5 whitespace-nowrap rounded-lg border border-[#0066CC]/20 bg-[#0066CC]/10 px-3.5 py-1.5 text-xs font-semibold text-[#0052A3]">
            <i class="fa-solid fa-calendar-days" aria-hidden="true"></i> Tahun Ajaran: <?= esc($topbar_tahun_ajaran); ?>
        </span>

        <!-- Ikon & Dropdown Notifikasi -->
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

        <!-- Profil Pengguna (Avatar, Nama, & Role) -->
        <div class="flex items-center gap-3 border-l border-[#E2E8F0] pl-2 sm:pl-3">
            <?php if (!empty($topbar_user_avatar)): ?>
                <img src="<?= esc($topbar_user_avatar); ?>" alt="<?= esc($topbar_user_name); ?>" class="h-10 w-10 shrink-0 rounded-full object-cover ring-2 ring-[#0066CC]/20">
            <?php else: ?>
                <span class="sg-display inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#0066CC] text-sm font-bold text-white" aria-hidden="true"><?= esc($topbar_user_initial); ?></span>
            <?php endif; ?>
            <div class="hidden min-w-0 leading-tight sm:block">
                <p class="truncate text-sm font-semibold text-[#1E293B]"><?= esc($topbar_user_name); ?></p>
                <p class="text-xs text-[#64748B]"><?= esc($topbar_user_role); ?></p>
            </div>
        </div>
    </div>
</header>

<!-- Script Popover Notifikasi -->
<script>
(function () {
    var btn = document.getElementById('sgNotifBtn');
    var panel = document.getElementById('sgNotifPanel');
    if (!btn || !panel || btn.dataset.sgInit === 'true') return;
    btn.dataset.sgInit = 'true';

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
