<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Masuk ke Sistem'); ?> - SIA Syiar Gemilang</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'] },
                    colors: {
                        brand: { DEFAULT: '#0077D4', dark: '#0062AE', deep: '#073B66' }
                    }
                }
            }
        };
    </script>
    <!-- FontAwesome 6.4 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }

        /*
         * Hero image: letakkan foto santri/instruktur di public/assets/img/login-hero.jpg
         * Selama file belum ada, gradien brand di bawah akan tampil sebagai fallback.
         */
        .hero-bg {
            background-color: #073B66;
            background-image:
                linear-gradient(160deg, rgba(7, 59, 102, 0.55) 0%, rgba(0, 119, 212, 0.35) 55%, rgba(4, 30, 56, 0.85) 100%),
                url('<?= base_url('assets/img/rgi.png'); ?>'),
                linear-gradient(135deg, #0077D4 0%, #073B66 100%);
            background-size: cover;
            background-position: center;
        }

        @keyframes spin-btn { to { transform: rotate(360deg); } }
        .btn-spinner {
            width: 1rem; height: 1rem; border-radius: 9999px;
            border: 2px solid rgba(255, 255, 255, .4);
            border-top-color: #fff;
            animation: spin-btn .7s linear infinite;
        }
        @media (prefers-reduced-motion: reduce) {
            .btn-spinner { animation-duration: 1.6s; }
        }
    </style>
</head>
<body class="min-h-screen bg-white text-slate-800 antialiased">

<div class="min-h-screen lg:grid lg:grid-cols-[55fr_45fr]">

    <!-- ===================== SISI KIRI: HERO (desktop) ===================== -->
    <aside class="hero-bg relative hidden lg:flex lg:h-screen lg:sticky lg:top-0 flex-col justify-end p-12 xl:p-16 text-white" aria-hidden="true">
        <div class="max-w-lg">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-white/15 backdrop-blur-sm border border-white/25 mb-6">
                <i class="fa-solid fa-book-open-reader text-xl"></i>
            </div>
            <h2 class="text-3xl xl:text-4xl font-bold leading-tight tracking-tight">
                Belajar, mengajar, dan mengelola akademik dalam satu portal.
            </h2>
            <p class="mt-4 text-sm xl:text-base text-white/80 leading-relaxed">
                Pantau nilai dan absensi, kelola jadwal kelas, serta atur data santri dengan mudah di Rumah Gemilang Indonesia.
            </p>
        </div>
    </aside>

    <!-- ===================== SISI KANAN: FORM LOGIN ===================== -->
    <main class="flex flex-col min-h-screen">

        <!-- Banner kecil hero (tablet & mobile) -->
        <div class="hero-bg lg:hidden h-28 sm:h-40 w-full" aria-hidden="true"></div>

        <div class="flex-1 flex items-center justify-center px-6 py-10 sm:px-10">
            <div class="w-full max-w-md mx-auto">

                <!-- Header -->
                <div class="mb-8">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-brand text-white shadow-md shadow-brand/25 shrink-0">
                            <i class="fa-solid fa-graduation-cap text-xl"></i>
                        </div>
                        <div class="leading-tight">
                            <p class="text-lg font-extrabold tracking-tight text-slate-900">Syiar Gemilang</p>
                            <p class="text-xs text-slate-500">Sistem Informasi Akademik Rumah Gemilang Indonesia</p>
                        </div>
                    </div>
                    <h1 class="text-3xl font-bold tracking-tight text-slate-900">Masuk</h1>
                </div>

                <!-- Flash Error Message -->
                <?php if (session()->getFlashdata('error')): ?>
                    <div role="alert" class="mb-5 p-3.5 rounded-lg bg-[#FEE2E2] text-[#991B1B] text-sm flex items-start gap-2.5">
                        <i class="fa-solid fa-circle-exclamation text-base mt-0.5 shrink-0"></i>
                        <span><?= esc(session()->getFlashdata('error')); ?></span>
                    </div>
                <?php endif; ?>

                <!-- Flash Success Message -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div role="status" class="mb-5 p-3.5 rounded-lg bg-[#DCFCE7] text-[#166534] text-sm flex items-start gap-2.5">
                        <i class="fa-solid fa-circle-check text-base mt-0.5 shrink-0"></i>
                        <span><?= esc(session()->getFlashdata('success')); ?></span>
                    </div>
                <?php endif; ?>

                <!-- Alert validasi sisi klien (tersembunyi secara default) -->
                <div id="clientAlert" role="alert" class="hidden mb-5 p-3.5 rounded-lg bg-[#FEE2E2] text-[#991B1B] text-sm flex items-start gap-2.5">
                    <i class="fa-solid fa-circle-exclamation text-base mt-0.5 shrink-0"></i>
                    <span id="clientAlertText"></span>
                </div>

                <!-- Login Form -->
                <form id="loginForm" action="<?= base_url('/login'); ?>" method="POST" class="space-y-5" novalidate>
                    <?= csrf_field(); ?>

                    <!-- Username Field -->
                    <div>
                        <label for="username" class="block text-sm font-medium text-slate-700 mb-1.5">
                            Nomor Induk Santri (NIS) / Username
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-user text-sm"></i>
                            </div>
                            <input type="text" id="username" name="username" required autocomplete="username"
                                   value="<?= esc(old('username')); ?>"
                                   placeholder="Nomor Induk Santri (NIS) / Username"
                                   class="w-full pl-10 pr-4 py-3 bg-white border border-slate-300 rounded-lg text-slate-900 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand transition">
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">
                            Kata sandi
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-lock text-sm"></i>
                            </div>
                            <input type="password" id="password" name="password" required autocomplete="current-password"
                                   placeholder="Kata sandi"
                                   class="w-full pl-10 pr-11 py-3 bg-white border border-slate-300 rounded-lg text-slate-900 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand transition">
                            <button type="button" onclick="togglePasswordVisibility()"
                                    aria-label="Tampilkan atau sembunyikan kata sandi"
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-700 focus:outline-none focus-visible:text-brand transition">
                                <i id="passwordToggleIcon" class="fa-solid fa-eye text-sm"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Link Bantuan -->
                    <div>
                        <!-- TODO: ganti href dengan route lupa sandi milik aplikasi, mis. base_url('/forgot-password') -->
                        <!-- <a href="#" class="text-sm text-brand hover:underline focus:outline-none focus-visible:underline">
                            Lupa nama pengguna atau kata sandi?
                        </a> -->
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" id="submitBtn"
                            class="w-full py-3 px-4 bg-brand hover:bg-brand-dark disabled:opacity-80 disabled:cursor-not-allowed text-white font-semibold rounded-lg text-sm shadow-sm transition duration-150 flex items-center justify-center gap-2 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-brand">
                        <span id="submitSpinner" class="btn-spinner hidden" aria-hidden="true"></span>
                        <span id="submitLabel">Masuk</span>
                    </button>
                </form>

                <!-- Catatan -->
                <p class="mt-5 text-xs text-slate-500 flex items-start gap-2">
                    <i class="fa-solid fa-circle-info mt-0.5 text-slate-400"></i>
                    <span>Pastikan Browser Anda mengaktifkan cookie untuk pengalaman terbaik.</span>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <footer class="px-6 sm:px-10 pb-6 pt-2">
            <div class="max-w-md mx-auto text-center space-y-2">
                <p class="text-xs text-slate-500">
                    Copyright &copy; Syiar Gemilang 2026. Rumah Gemilang Indonesia. All rights reserved.
                </p>
                <p class="text-xs text-slate-400">
                    <span class="font-semibold text-slate-700">Indonesia</span>
                    <span class="mx-1.5">|</span>
                    <span lang="en">English</span>
                    <span class="mx-1.5">|</span>
                    <span lang="ar" dir="rtl">العربية</span>
                </p>
            </div>
        </footer>
    </main>
</div>

<!-- Toggle Password, Validasi & Loading Script -->
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

    (function () {
        const form      = document.getElementById('loginForm');
        const btn       = document.getElementById('submitBtn');
        const label     = document.getElementById('submitLabel');
        const spinner   = document.getElementById('submitSpinner');
        const alertBox  = document.getElementById('clientAlert');
        const alertText = document.getElementById('clientAlertText');
        const userInput = document.getElementById('username');
        const passInput = document.getElementById('password');

        function showClientError(msg, field) {
            alertText.textContent = msg;
            alertBox.classList.remove('hidden');
            if (field) field.focus();
        }

        function setLoading(isLoading) {
            btn.disabled = isLoading;
            spinner.classList.toggle('hidden', !isLoading);
            label.textContent = isLoading ? 'Memproses...' : 'Masuk';
        }

        [userInput, passInput].forEach(function (el) {
            el.addEventListener('input', function () { alertBox.classList.add('hidden'); });
        });

        form.addEventListener('submit', function (e) {
            if (!userInput.value.trim()) {
                e.preventDefault();
                showClientError('Nomor Induk Santri (NIS), email, atau username wajib diisi.', userInput);
                return;
            }
            if (!passInput.value) {
                e.preventDefault();
                showClientError('Kata sandi wajib diisi.', passInput);
                return;
            }
            alertBox.classList.add('hidden');
            setLoading(true);
        });

        // Reset tombol jika halaman dimuat dari cache (tombol "Kembali" peramban)
        window.addEventListener('pageshow', function (e) {
            if (e.persisted) setLoading(false);
        });
    })();
</script>
</body>
</html>
