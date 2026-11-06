<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Masuk ke Sistem'); ?> - SIA Syiar Gemilang</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome 6.4 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-950 via-slate-900 to-indigo-950 text-slate-100 flex items-center justify-center p-4 relative overflow-x-hidden">

    <!-- Background Decorative Glow Elements -->
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-indigo-600/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-emerald-600/15 rounded-full blur-3xl pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10 my-8">

        <!-- Logo & Brand Header -->
        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-tr from-indigo-600 to-indigo-400 text-white shadow-lg shadow-indigo-500/30 mb-3">
                <i class="fa-solid fa-graduation-cap text-3xl"></i>
            </div>
            <h1 class="text-2xl font-black tracking-tight text-white">Syiar Gemilang</h1>
            <p class="text-xs text-indigo-300/80 mt-1 font-medium">Sistem Informasi Akademik, Nilai & Presensi</p>
        </div>

        <!-- Login Card -->
        <div class="bg-slate-900/90 border border-slate-800 rounded-2xl shadow-2xl backdrop-blur-xl p-6 sm:p-8">

            <div class="mb-5 text-center sm:text-left">
                <h2 class="text-lg font-bold text-white">Selamat Datang Kembali</h2>
                <p class="text-xs text-slate-400 mt-0.5">Silakan masukkan kredensial akun Anda untuk masuk.</p>
            </div>

            <!-- Flash Error Message -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="mb-4 p-3.5 rounded-xl bg-red-500/15 border border-red-500/30 text-red-200 text-xs flex items-center gap-2.5">
                    <i class="fa-solid fa-triangle-exclamation text-red-400 text-base shrink-0"></i>
                    <span><?= esc(session()->getFlashdata('error')); ?></span>
                </div>
            <?php endif; ?>

            <!-- Flash Success Message -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="mb-4 p-3.5 rounded-xl bg-emerald-500/15 border border-emerald-500/30 text-emerald-200 text-xs flex items-center gap-2.5">
                    <i class="fa-solid fa-circle-check text-emerald-400 text-base shrink-0"></i>
                    <span><?= esc(session()->getFlashdata('success')); ?></span>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form action="<?= base_url('/login'); ?>" method="POST" class="space-y-4">
                <?= csrf_field(); ?>

                <!-- Username Field -->
                <div>
                    <label for="username" class="block text-xs font-semibold text-slate-300 mb-1.5">
                        Username / Nama Pengguna
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                            <i class="fa-solid fa-user text-sm"></i>
                        </div>
                        <input type="text" id="username" name="username" required
                               value="<?= esc(old('username')); ?>"
                               placeholder="Contoh: admin / instruktur / ahmad.fauzi"
                               class="w-full pl-10 pr-4 py-2.5 bg-slate-950/70 border border-slate-700/80 rounded-xl text-white placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition shadow-inner">
                    </div>
                </div>

                <!-- Password Field -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-xs font-semibold text-slate-300">
                            Kata Sandi / Password
                        </label>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                            <i class="fa-solid fa-lock text-sm"></i>
                        </div>
                        <input type="password" id="password" name="password" required
                               placeholder="Masukkan kata sandi..."
                               class="w-full pl-10 pr-10 py-2.5 bg-slate-950/70 border border-slate-700/80 rounded-xl text-white placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition shadow-inner">
                        <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-white transition">
                            <i id="passwordToggleIcon" class="fa-solid fa-eye text-sm"></i>
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full mt-2 py-2.5 px-4 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-500 hover:to-indigo-600 text-white font-semibold rounded-xl text-sm shadow-lg shadow-indigo-600/30 transition duration-150 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    <span>Masuk ke Akun</span>
                </button>
            </form>

            <!-- Quick Demo Credential Autofill (Interactive Helper) -->
            <div class="mt-6 pt-5 border-t border-slate-800">
                <p class="text-2xs uppercase tracking-wider text-slate-400 font-bold mb-2.5 text-center">
                    <i class="fa-solid fa-key mr-1 text-amber-400"></i> Pilih Akun Cepat (Demo 4 Kategori)
                </p>
                
                <div class="grid grid-cols-2 gap-2 text-2xs">
                    <!-- Admin -->
                    <button type="button" onclick="fillCredential('admin', 'admin123')"
                            class="p-2 rounded-lg bg-slate-800/80 hover:bg-indigo-600/20 border border-slate-700 hover:border-indigo-500/50 text-left transition group">
                        <div class="flex items-center gap-1.5 text-indigo-400 font-bold">
                            <i class="fa-solid fa-shield-halved"></i>
                            <span>Admin</span>
                        </div>
                        <p class="text-slate-400 group-hover:text-slate-200 mt-0.5 truncate font-mono">admin / admin123</p>
                        <span class="text-3xs text-emerald-400">Akses Full Sistem</span>
                    </button>

                    <!-- Instruktur -->
                    <button type="button" onclick="fillCredential('instruktur', 'instruktur123')"
                            class="p-2 rounded-lg bg-slate-800/80 hover:bg-emerald-600/20 border border-slate-700 hover:border-emerald-500/50 text-left transition group">
                        <div class="flex items-center gap-1.5 text-emerald-400 font-bold">
                            <i class="fa-solid fa-chalkboard-user"></i>
                            <span>Instruktur</span>
                        </div>
                        <p class="text-slate-400 group-hover:text-slate-200 mt-0.5 truncate font-mono">instruktur / instruktur123</p>
                        <span class="text-3xs text-emerald-400">Input Nilai & Presensi</span>
                    </button>

                    <!-- Siswa -->
                    <button type="button" onclick="fillCredential('ahmad.fauzi', 'santri123')"
                            class="p-2 rounded-lg bg-slate-800/80 hover:bg-sky-600/20 border border-slate-700 hover:border-sky-500/50 text-left transition group">
                        <div class="flex items-center gap-1.5 text-sky-400 font-bold">
                            <i class="fa-solid fa-user-graduate"></i>
                            <span>Siswa (50 Santri)</span>
                        </div>
                        <p class="text-slate-400 group-hover:text-slate-200 mt-0.5 truncate font-mono">ahmad.fauzi / santri123</p>
                        <span class="text-3xs text-sky-400">Presensi Mandiri</span>
                    </button>

                    <!-- Wali Santri -->
                    <button type="button" onclick="fillCredential('wali.ahmad.fauzi', 'wali123')"
                            class="p-2 rounded-lg bg-slate-800/80 hover:bg-purple-600/20 border border-slate-700 hover:border-purple-500/50 text-left transition group">
                        <div class="flex items-center gap-1.5 text-purple-400 font-bold">
                            <i class="fa-solid fa-people-roof"></i>
                            <span>Wali Santri</span>
                        </div>
                        <p class="text-slate-400 group-hover:text-slate-200 mt-0.5 truncate font-mono">wali.ahmad.fauzi / wali123</p>
                        <span class="text-3xs text-purple-400">Lihat Detail Nilai</span>
                    </button>
                </div>
            </div>

        </div>

        <!-- Footer -->
        <p class="text-center text-xs text-slate-500 mt-6 font-medium">
            &copy; 2026 Syiar Gemilang. Hak Cipta Dilindungi.
        </p>

    </div>

    <!-- Toggle Password & Autofill Script -->
    <script>
        function togglePasswordVisibility() {
            const passInput = document.getElementById('password');
            const icon = document.getElementById('passwordToggleIcon');
            if (passInput.type === 'password') {
                passInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        function fillCredential(user, pass) {
            document.getElementById('username').value = user;
            document.getElementById('password').value = pass;
        }
    </script>

    <style>
        .text-2xs { font-size: 0.70rem; line-height: 0.95rem; }
        .text-3xs { font-size: 0.625rem; line-height: 0.85rem; }
    </style>
</body>
</html>

