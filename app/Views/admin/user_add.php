<?php require_once 'navbar.php'; ?>

<div class="flex-1 min-w-0 flex flex-col overflow-hidden bg-[#F8FAFC]">

    <!-- Top Navbar -->
    <?php 
    $page_title = $title ?? 'Tambah User Login Baru';
    require_once __DIR__ . '/components/topbar.php'; 
    ?>

    <!-- Main Scrollable Area -->
    <main class="flex-1 overflow-y-auto pb-16">

        <!-- ===================== HERO WAVE BANNER ===================== -->
        <?php
        $hero = [
            'breadcrumb' => [
                ['label' => 'Portal Admin', 'url' => base_url('/')],
                ['label' => 'Manajemen User', 'url' => base_url('admin/users')],
                ['label' => 'Tambah User Login']
            ],
            'badge' => 'Keamanan & Autentikasi Pengguna E-RGI',
            'title' => 'Formulir Registrasi Pengguna Baru',
            'subtitle' => 'Daftarkan akun login baru untuk staf, pengajar, santri, atau wali santri dengan hak akses peran terverifikasi.',
            'stats' => [
                ['icon' => 'fa-solid fa-user-plus', 'bg' => 'bg-sky-400/20 text-sky-200', 'value' => 'Baru', 'label' => 'Akun Pengguna'],
                ['icon' => 'fa-solid fa-shield-halved', 'bg' => 'bg-emerald-400/20 text-emerald-200', 'value' => '4 Role', 'label' => 'Hak Akses'],
                ['icon' => 'fa-solid fa-key', 'bg' => 'bg-amber-400/20 text-amber-200', 'value' => 'Bcrypt', 'label' => 'Enkripsi Sandi'],
            ]
        ];
        require_once __DIR__ . '/components/hero_header.php';
        ?>

        <div class="p-6">
            <div class="max-w-2xl mx-auto bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
                
                <!-- Card Header -->
                <div class="border-b border-slate-100 pb-4 flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-bold text-slate-800 flex items-center gap-2">
                            <i class="fa-solid fa-user-lock text-brand"></i> Data Akun Login Baru
                        </h2>
                        <p class="text-xs text-slate-500 mt-0.5">Isi seluruh informasi kredensial dan hak akses pengguna.</p>
                    </div>
                    <a href="<?= base_url('admin/users'); ?>" class="text-xs text-slate-500 hover:text-brand font-semibold flex items-center gap-1.5 transition">
                        <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar User
                    </a>
                </div>

                <!-- Alert Feedback jika ada error -->
                <?php if (session()->getFlashdata('error')) : ?>
                    <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs flex items-center gap-2.5">
                        <i class="fa-solid fa-circle-exclamation text-rose-600 text-base shrink-0"></i>
                        <span><?= esc(session()->getFlashdata('error')); ?></span>
                    </div>
                <?php endif; ?>

                <!-- Form Pendaftaran User -->
                <form action="<?= base_url('admin/users/save'); ?>" method="post" class="space-y-5" autocomplete="off">
                    <?= csrf_field(); ?>

                    <!-- Nama Lengkap -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Nama Lengkap Pengguna <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-user text-xs"></i>
                            </div>
                            <input type="text" name="nama" value="<?= esc(old('nama') ?? ''); ?>" required 
                                   class="w-full pl-9 pr-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand transition font-medium" 
                                   placeholder="Contoh: Ustadz Muhammad Yusuf / Siti Khadijah">
                        </div>
                    </div>

                    <!-- Username & Password Row -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Username -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                                Username Login <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-at text-xs"></i>
                                </div>
                                <input type="text" name="username" value="<?= esc(old('username') ?? ''); ?>" required 
                                       pattern="[a-zA-Z0-9._-]+"
                                       class="w-full pl-9 pr-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand transition font-medium" 
                                       placeholder="yusuf.instruktur">
                            </div>
                            <p class="text-3xs text-slate-400 mt-1">Gunakan huruf kecil, angka, atau titik (tanpa spasi).</p>
                        </div>

                        <!-- Password -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                                Kata Sandi (Password) <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-lock text-xs"></i>
                                </div>
                                <input type="password" name="password" id="inputUserPassword" required minlength="6"
                                       class="w-full pl-9 pr-10 py-2.5 bg-white border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand transition font-medium" 
                                       placeholder="Minimal 6 karakter">
                                <button type="button" onclick="togglePasswordVisibility('inputUserPassword', 'pwdEyeIcon')" 
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 transition cursor-pointer">
                                    <i id="pwdEyeIcon" class="fa-regular fa-eye text-xs"></i>
                                </button>
                            </div>
                            <p class="text-3xs text-slate-400 mt-1">Kata sandi akan dienkripsi dengan algoritma Bcrypt aman.</p>
                        </div>
                    </div>

                    <!-- Role Selection -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-2">
                            Pilih Hak Akses (Role) <span class="text-rose-500">*</span>
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3" id="roleSelectorGroup">
                            
                            <!-- Option Admin -->
                            <label class="role-card relative flex items-start p-3.5 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition">
                                <input type="radio" name="role" value="admin" class="mt-0.5 text-brand focus:ring-brand" onchange="handleRoleChange(this.value)">
                                <div class="ml-3">
                                    <span class="block text-xs font-bold text-slate-800 flex items-center gap-1.5">
                                        <i class="fa-solid fa-user-shield text-[#0066CC]"></i> Administrator
                                    </span>
                                    <span class="block text-3xs text-slate-500 mt-0.5">Akses menyeluruh: kelola santri, nilai, sesi, dan akun pengguna.</span>
                                </div>
                            </label>

                            <!-- Option Instruktur -->
                            <label class="role-card relative flex items-start p-3.5 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition">
                                <input type="radio" name="role" value="instruktur" class="mt-0.5 text-brand focus:ring-brand" onchange="handleRoleChange(this.value)">
                                <div class="ml-3">
                                    <span class="block text-xs font-bold text-slate-800 flex items-center gap-1.5">
                                        <i class="fa-solid fa-chalkboard-user text-purple-600"></i> Instruktur
                                    </span>
                                    <span class="block text-3xs text-slate-500 mt-0.5">Mengajar kelas kejuruan, input nilai, dan catat presensi santri.</span>
                                </div>
                            </label>

                            <!-- Option Siswa -->
                            <label class="role-card relative flex items-start p-3.5 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition">
                                <input type="radio" name="role" value="siswa" checked class="mt-0.5 text-brand focus:ring-brand" onchange="handleRoleChange(this.value)">
                                <div class="ml-3">
                                    <span class="block text-xs font-bold text-slate-800 flex items-center gap-1.5">
                                        <i class="fa-solid fa-user-graduate text-emerald-600"></i> Siswa / Santri
                                    </span>
                                    <span class="block text-3xs text-slate-500 mt-0.5">Melihat riwayat nilai mandiri dan melakukan presensi kehadiran.</span>
                                </div>
                            </label>

                            <!-- Option Wali Santri -->
                            <label class="role-card relative flex items-start p-3.5 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition">
                                <input type="radio" name="role" value="wali_santri" class="mt-0.5 text-brand focus:ring-brand" onchange="handleRoleChange(this.value)">
                                <div class="ml-3">
                                    <span class="block text-xs font-bold text-slate-800 flex items-center gap-1.5">
                                        <i class="fa-solid fa-hands-holding-child text-amber-600"></i> Wali Santri
                                    </span>
                                    <span class="block text-3xs text-slate-500 mt-0.5">Memantau perkembangan nilai, adab, dan presensi santri asuhan.</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Hubungkan ke Data Santri (Muncul jika Role = Siswa atau Wali Santri) -->
                    <div id="santriLinkWrapper" class="p-4 bg-sky-50/70 rounded-xl border border-sky-200 space-y-2">
                        <label class="block text-xs font-bold text-[#073B66] flex items-center gap-1.5">
                            <i class="fa-solid fa-link text-[#0066CC]"></i> Hubungkan dengan Data Santri
                        </label>
                        <p class="text-3xs text-slate-600">Pilih santri yang terkait dengan akun ini agar portal otomatis menampilkan rapor dan absensi santri yang tepat.</p>
                        <div class="relative">
                            <select name="santri_id" id="santriSelectBox"
                                    class="w-full px-3.5 py-2.5 bg-white border border-sky-300 rounded-xl text-slate-900 text-xs font-medium focus:outline-none focus:ring-2 focus:ring-[#0066CC]/40 focus:border-[#0066CC] transition appearance-none">
                                <option value="">-- Pilih Santri (Opsional / Ditautkan Nanti) --</option>
                                <?php foreach ($santri_list as $st): ?>
                                    <option value="<?= esc($st['id']); ?>">
                                        <?= esc($st['nama']); ?> (NIS: <?= esc($st['nis'] ?? '-'); ?> - <?= esc($st['kelas']); ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-chevron-down text-2xs"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Status Akun (Aktif / Nonaktif) -->
                    <div class="pt-2">
                        <label class="block text-xs font-semibold text-slate-700 mb-2">Status Akun</label>
                        <div class="flex items-center gap-6">
                            <label class="inline-flex items-center gap-2 cursor-pointer text-xs font-medium text-slate-700">
                                <input type="radio" name="is_active" value="1" checked class="text-brand focus:ring-brand">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-2xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif Langsung
                                </span>
                            </label>
                            <label class="inline-flex items-center gap-2 cursor-pointer text-xs font-medium text-slate-700">
                                <input type="radio" name="is_active" value="0" class="text-brand focus:ring-brand">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-2xs font-bold bg-slate-100 text-slate-600 border border-slate-300">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Nonaktifkan Sementara
                                </span>
                            </label>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                        <a href="<?= base_url('admin/users'); ?>" 
                           class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition">
                            Batal
                        </a>
                        <button type="submit" 
                                class="px-5 py-2.5 bg-brand hover:bg-brand-dark text-white rounded-xl text-xs font-bold shadow-md shadow-brand/20 transition flex items-center gap-2 cursor-pointer">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan & Buat Akun
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </main>
</div>

<script>
function handleRoleChange(selectedRole) {
    const linkWrapper = document.getElementById('santriLinkWrapper');
    if (selectedRole === 'siswa' || selectedRole === 'wali_santri') {
        linkWrapper.style.display = 'block';
    } else {
        linkWrapper.style.display = 'none';
        document.getElementById('santriSelectBox').value = '';
    }
}

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
