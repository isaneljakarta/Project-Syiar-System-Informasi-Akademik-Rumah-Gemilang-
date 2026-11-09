<?php
$currentRole = session()->get('role') ?? 'admin';
switch ($currentRole) {
    case 'instruktur':
        require_once APPPATH . 'Views/instruktur/navbar.php';
        $dashUrl = base_url('instruktur');
        $portalLabel = 'Portal Instruktur';
        break;
    case 'siswa':
        require_once APPPATH . 'Views/siswa/navbar.php';
        $dashUrl = base_url('siswa');
        $portalLabel = 'Portal Santri';
        break;
    case 'wali_santri':
        require_once APPPATH . 'Views/wali/navbar.php';
        $dashUrl = base_url('wali');
        $portalLabel = 'Portal Wali Santri';
        break;
    case 'admin':
    default:
        require_once APPPATH . 'Views/admin/navbar.php';
        $dashUrl = base_url('/');
        $portalLabel = 'Portal Admin';
        break;
}
?>

<div class="flex-1 min-w-0 flex flex-col overflow-hidden bg-[#F8FAFC]">

    <!-- Top Navbar -->
    <?php 
    $page_title = $title ?? 'Pengaturan Kata Sandi';
    require_once APPPATH . 'Views/components/topbar.php'; 
    ?>

    <!-- Main Scrollable Area -->
    <main class="flex-1 overflow-y-auto pb-16">

        <!-- ===================== HERO WAVE BANNER ===================== -->
        <?php
        $hero = [
            'breadcrumb' => [
                ['label' => $portalLabel, 'url' => $dashUrl],
                ['label' => 'Pengaturan Kata Sandi']
            ],
            'badge' => 'Keamanan Akun & Kredensial Pribadi',
            'title' => 'Pengaturan Kata Sandi Akun',
            'subtitle' => 'Perbarui kata sandi akun login Anda secara mandiri untuk menjaga privasi dan keamanan sistem informasi akademik.',
            'stats' => [
                ['icon' => 'fa-solid fa-lock', 'bg' => 'bg-sky-400/20 text-sky-200', 'value' => 'Bcrypt', 'label' => 'Proteksi Sandi'],
                ['icon' => 'fa-solid fa-user-shield', 'bg' => 'bg-emerald-400/20 text-emerald-200', 'value' => strtoupper(session()->get('role') ?? 'USER'), 'label' => 'Peran Akun'],
                ['icon' => 'fa-solid fa-clock-rotate-left', 'bg' => 'bg-amber-400/20 text-amber-200', 'value' => 'Mandiri', 'label' => 'Akses 24/7'],
            ]
        ];
        require_once APPPATH . 'Views/components/hero_header.php';
        ?>

        <div class="p-6">
            <div class="max-w-xl mx-auto space-y-6">

                <!-- Alert Feedback Flash Message -->
                <?php if (session()->getFlashdata('success')) : ?>
                    <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-start gap-3 shadow-sm">
                        <div class="w-8 h-8 rounded-lg bg-emerald-600 text-white flex items-center justify-center shrink-0 mt-0.5">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm">Berhasil Diperbarui!</h4>
                            <p class="mt-0.5"><?= esc(session()->getFlashdata('success')); ?></p>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')) : ?>
                    <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs flex items-start gap-3 shadow-sm">
                        <div class="w-8 h-8 rounded-lg bg-rose-600 text-white flex items-center justify-center shrink-0 mt-0.5">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm">Gagal Memperbarui Kata Sandi</h4>
                            <p class="mt-0.5"><?= esc(session()->getFlashdata('error')); ?></p>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- User Profile Summary Box -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-brand-light text-brand flex items-center justify-center text-xl font-bold shrink-0">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs text-slate-500 font-medium">Akun Sedang Masuk</p>
                        <h3 class="text-base font-bold text-slate-800 truncate"><?= esc(session()->get('nama') ?? 'Pengguna'); ?></h3>
                        <p class="text-xs text-slate-600 font-mono">@<?= esc(session()->get('username') ?? '-'); ?> • <span class="capitalize font-semibold text-brand"><?= esc(session()->get('role') ?? 'User'); ?></span></p>
                    </div>
                </div>

                <!-- Form Card -->
                <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
                    <div class="border-b border-slate-100 pb-3">
                        <h2 class="text-base font-bold text-slate-800 flex items-center gap-2">
                            <i class="fa-solid fa-key text-brand"></i> Ganti Kata Sandi
                        </h2>
                        <p class="text-xs text-slate-500 mt-0.5">Masukkan kata sandi lama Anda untuk verifikasi, lalu tentukan kata sandi baru.</p>
                    </div>

                    <form action="<?= base_url('ganti-password'); ?>" method="post" class="space-y-4" autocomplete="off">
                        <?= csrf_field(); ?>

                        <!-- Password Lama -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                                Kata Sandi Saat Ini (Lama) <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-unlock-keyhole text-xs"></i>
                                </div>
                                <input type="password" name="current_password" id="curPwdInput" required
                                       class="w-full pl-9 pr-10 py-2.5 bg-white border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand transition"
                                       placeholder="Ketik kata sandi Anda saat ini">
                                <button type="button" onclick="togglePasswordVisibility('curPwdInput', 'curEyeIcon')" 
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 transition cursor-pointer">
                                    <i id="curEyeIcon" class="fa-regular fa-eye text-xs"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Password Baru -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                                Kata Sandi Baru <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-lock text-xs"></i>
                                </div>
                                <input type="password" name="new_password" id="newPwdInput" required minlength="6"
                                       class="w-full pl-9 pr-10 py-2.5 bg-white border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand transition"
                                       placeholder="Minimal 6 karakter">
                                <button type="button" onclick="togglePasswordVisibility('newPwdInput', 'newEyeIcon')" 
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 transition cursor-pointer">
                                    <i id="newEyeIcon" class="fa-regular fa-eye text-xs"></i>
                                </button>
                            </div>
                            <p class="text-3xs text-slate-400 mt-1">Disarankan memadukan huruf, angka, dan simbol untuk keamanan maksimal.</p>
                        </div>

                        <!-- Konfirmasi Password Baru -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                                Ulangi Kata Sandi Baru <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-shield-halved text-xs"></i>
                                </div>
                                <input type="password" name="confirm_password" id="confPwdInput" required minlength="6"
                                       class="w-full pl-9 pr-10 py-2.5 bg-white border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand transition"
                                       placeholder="Ketik ulang kata sandi baru">
                                <button type="button" onclick="togglePasswordVisibility('confPwdInput', 'confEyeIcon')" 
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 transition cursor-pointer">
                                    <i id="confEyeIcon" class="fa-regular fa-eye text-xs"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                            <a href="<?= $dashUrl; ?>" 
                               class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition">
                                Batal
                            </a>
                            <button type="submit" 
                                    class="px-5 py-2.5 bg-brand hover:bg-brand-dark text-white rounded-xl text-xs font-bold shadow-md shadow-brand/20 transition flex items-center gap-2 cursor-pointer">
                                <i class="fa-solid fa-floppy-disk"></i> Simpan Kata Sandi
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </main>
</div>

<script>
function togglePasswordVisibility(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
</body>
</html>
