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

        <!-- Tombol Cepat Ganti Password -->
        <a href="<?= base_url('ganti-password'); ?>" 
           title="Pengaturan & Ganti Kata Sandi" 
           class="inline-flex h-10 w-10 cursor-pointer items-center justify-center rounded-full text-[#475569] transition-colors duration-200 hover:bg-[#0066CC]/10 hover:text-[#0066CC] active:text-[#003E7E]">
            <i class="fa-solid fa-key text-base" aria-hidden="true"></i>
        </a>

        <!-- Ikon & Dropdown Notifikasi -->
        <div class="relative">
            <button type="button" id="sgNotifBtn"
                    class="inline-flex h-10 w-10 cursor-pointer items-center justify-center rounded-full text-[#475569] transition-colors duration-200 hover:bg-[#0066CC]/10 hover:text-[#0066CC] active:text-[#003E7E]"
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

        <!-- Profil Pengguna & Dropdown Menu -->
        <div class="relative border-l border-[#E2E8F0] pl-2 sm:pl-3">
            <button type="button" id="sgUserMenuBtn" onclick="toggleUserDropdownMenu()" 
                    class="flex items-center gap-2.5 p-1 rounded-xl hover:bg-slate-100 transition cursor-pointer text-left">
                <?php if (!empty($topbar_user_avatar)): ?>
                    <img src="<?= esc($topbar_user_avatar); ?>" alt="<?= esc($topbar_user_name); ?>" class="h-10 w-10 shrink-0 rounded-full object-cover ring-2 ring-[#0066CC]/20">
                <?php else: ?>
                    <span class="sg-display inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#0066CC] text-sm font-bold text-white shadow-sm" aria-hidden="true"><?= esc($topbar_user_initial); ?></span>
                <?php endif; ?>
                <div class="hidden min-w-0 leading-tight sm:block">
                    <p class="truncate text-sm font-semibold text-[#1E293B] max-w-[140px]"><?= esc($topbar_user_name); ?></p>
                    <p class="text-xs text-[#64748B]"><?= esc($topbar_user_role); ?></p>
                </div>
                <i class="fa-solid fa-chevron-down text-2xs text-slate-400 hidden sm:block"></i>
            </button>

            <!-- Dropdown Menu Profil & Setting Password -->
            <div id="sgUserDropdownMenu" 
                 class="hidden absolute right-0 top-full z-30 mt-2 w-56 rounded-xl border border-slate-200 bg-white p-2 shadow-[0_12px_32px_-8px_rgba(15,23,42,0.18)]">
                <div class="px-3 py-2 border-b border-slate-100 mb-1">
                    <p class="text-xs font-bold text-slate-800 truncate"><?= esc($topbar_user_name); ?></p>
                    <span class="inline-block mt-0.5 text-3xs font-semibold px-2 py-0.5 rounded-full bg-sky-100 text-[#0052A3]">
                        <?= esc($topbar_user_role); ?>
                    </span>
                </div>
                <button type="button" onclick="openGlobalPasswordModal()" 
                        class="w-full flex items-center gap-2.5 px-3 py-2 text-xs font-semibold text-slate-700 hover:text-brand hover:bg-[#0066CC]/10 rounded-lg transition text-left cursor-pointer">
                    <i class="fa-solid fa-key text-brand text-xs w-4 text-center"></i> Ganti Password
                </button>
                <a href="<?= base_url('ganti-password'); ?>" 
                   class="flex items-center gap-2.5 px-3 py-2 text-xs font-semibold text-slate-700 hover:text-brand hover:bg-[#0066CC]/10 rounded-lg transition">
                    <i class="fa-solid fa-user-gear text-slate-500 text-xs w-4 text-center"></i> Halaman Sandi
                </a>
                <div class="border-t border-slate-100 my-1"></div>
                <a href="<?= base_url('logout'); ?>" 
                   class="flex items-center gap-2.5 px-3 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50 rounded-lg transition">
                    <i class="fa-solid fa-arrow-right-from-bracket text-xs w-4 text-center"></i> Keluar
                </a>
            </div>
        </div>
    </div>
</header>

<!-- ===================== MODAL GANTI PASSWORD GLOBAL ===================== -->
<div id="modalGlobalGantiPassword" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
    <!-- Backdrop Blur -->
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" onclick="closeGlobalPasswordModal()"></div>

    <!-- Modal Card Content -->
    <div class="relative bg-white w-full max-w-md rounded-2xl shadow-2xl border border-slate-200 overflow-hidden transform transition-all z-10 animate-in fade-in zoom-in-95 duration-150">
        <div class="px-6 py-4 bg-[#0066CC] text-white flex items-center justify-between">
            <h3 class="text-sm font-bold flex items-center gap-2">
                <i class="fa-solid fa-key"></i> Ganti Kata Sandi Login
            </h3>
            <button type="button" onclick="closeGlobalPasswordModal()" class="text-white/80 hover:text-white cursor-pointer">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <form action="<?= base_url('ganti-password'); ?>" method="post" class="p-6 space-y-4" autocomplete="off">
            <?= csrf_field(); ?>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Kata Sandi Saat Ini</label>
                <div class="relative">
                    <input type="password" name="current_password" id="mCurPwd" required
                           class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand font-medium pr-8"
                           placeholder="Masukkan kata sandi lama">
                    <button type="button" onclick="togglePasswordVisibility('mCurPwd', 'mCurEye')" class="absolute inset-y-0 right-0 pr-2.5 flex items-center text-slate-400">
                        <i id="mCurEye" class="fa-regular fa-eye text-2xs"></i>
                    </button>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Kata Sandi Baru (Min. 6 Karakter)</label>
                <div class="relative">
                    <input type="password" name="new_password" id="mNewPwd" required minlength="6"
                           class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand font-medium pr-8"
                           placeholder="Ketik kata sandi baru">
                    <button type="button" onclick="togglePasswordVisibility('mNewPwd', 'mNewEye')" class="absolute inset-y-0 right-0 pr-2.5 flex items-center text-slate-400">
                        <i id="mNewEye" class="fa-regular fa-eye text-2xs"></i>
                    </button>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Konfirmasi Kata Sandi Baru</label>
                <div class="relative">
                    <input type="password" name="confirm_password" id="mConfPwd" required minlength="6"
                           class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand font-medium pr-8"
                           placeholder="Ketik ulang kata sandi baru">
                    <button type="button" onclick="togglePasswordVisibility('mConfPwd', 'mConfEye')" class="absolute inset-y-0 right-0 pr-2.5 flex items-center text-slate-400">
                        <i id="mConfEye" class="fa-regular fa-eye text-2xs"></i>
                    </button>
                </div>
            </div>

            <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeGlobalPasswordModal()" class="px-4 py-2 rounded-xl border border-slate-300 text-xs font-semibold text-slate-700 hover:bg-slate-50 cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-[#0066CC] hover:bg-[#0052A3] text-white text-xs font-bold shadow-sm shadow-[#0066CC]/20 cursor-pointer flex items-center gap-1.5">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Sandi
                </button>
            </div>
        </form>
    </div>
</div>

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

function toggleUserDropdownMenu() {
    var menu = document.getElementById('sgUserDropdownMenu');
    if (menu) {
        menu.classList.toggle('hidden');
    }
}

document.addEventListener('click', function(e) {
    var menu = document.getElementById('sgUserDropdownMenu');
    var btn = document.getElementById('sgUserMenuBtn');
    if (menu && btn && !menu.contains(e.target) && !btn.contains(e.target)) {
        menu.classList.add('hidden');
    }
});

function openGlobalPasswordModal() {
    var modal = document.getElementById('modalGlobalGantiPassword');
    var menu = document.getElementById('sgUserDropdownMenu');
    if (menu) menu.classList.add('hidden');
    if (modal) modal.classList.remove('hidden');
}

function closeGlobalPasswordModal() {
    var modal = document.getElementById('modalGlobalGantiPassword');
    if (modal) modal.classList.add('hidden');
}

if (typeof togglePasswordVisibility === 'undefined') {
    window.togglePasswordVisibility = function(inputId, iconId) {
        var input = document.getElementById(inputId);
        var icon = document.getElementById(iconId);
        if (!input) return;
        if (input.type === 'password') {
            input.type = 'text';
            if (icon) {
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        } else {
            input.type = 'password';
            if (icon) {
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    };
}
</script>
