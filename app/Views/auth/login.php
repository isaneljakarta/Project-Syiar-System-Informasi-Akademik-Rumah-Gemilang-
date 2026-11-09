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

        /* ---------- Interaksi tambahan (tampilan dasar tidak berubah) ---------- */

        /* Hero: kilau lembut mengikuti kursor + kedalaman (teks & ikon bergeser beda jarak).
           Nilai --cx/--cy/--dx/--dy diisi oleh script di bawah, hanya untuk mouse. */
        .hero-glow {
            position: absolute; inset: 0; pointer-events: none; opacity: 0;
            transition: opacity .5s ease;
            background: radial-gradient(480px circle at calc(var(--cx, .5) * 100%) calc(var(--cy, .5) * 100%),
                        rgba(255, 255, 255, .14), transparent 65%);
        }
        .hero-bg.is-hovered .hero-glow { opacity: 1; }
        .hero-content { translate: calc(var(--dx, 0) * -10px) calc(var(--dy, 0) * -8px); }
        .hero-badge   { translate: calc(var(--dx, 0) * -14px) calc(var(--dy, 0) * -10px); }

        /* Status field tidak valid: garis & ring merah */
        input[aria-invalid="true"] { border-color: #DC2626; }
        input[aria-invalid="true"]:focus { --tw-ring-color: rgb(220 38 38 / .25); border-color: #DC2626; }

        /* Cookie nonaktif: catatan berubah jadi peringatan */
        #cookieNote[data-warn] { color: #B45309; }
        #cookieNote[data-warn] i { color: #B45309; }

        /* Animasi masuk & getar. Hanya transform/opacity, mati jika pengguna memilih reduced motion. */
        @keyframes rise {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: none; }
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%      { transform: translateX(-6px); }
            40%      { transform: translateX(5px); }
            60%      { transform: translateX(-3px); }
            80%      { transform: translateX(2px); }
        }
        @media (prefers-reduced-motion: no-preference) {
            .rise  { animation: rise .55s cubic-bezier(.2, .7, .2, 1) backwards; animation-delay: calc(var(--i, 0) * 70ms); }
            .shake { animation: shake .36s ease-in-out; }
            .hero-content, .hero-badge { will-change: translate; }
        }
    </style>
</head>
<body class="min-h-screen bg-white text-slate-800 antialiased">

<div class="min-h-screen lg:grid lg:grid-cols-[55fr_45fr]">

    <!-- ===================== SISI KIRI: HERO (desktop) ===================== -->
    <aside class="hero-bg relative hidden lg:flex lg:h-screen lg:sticky lg:top-0 flex-col justify-end p-12 xl:p-16 text-white" aria-hidden="true">
        <div class="hero-glow"></div>
        <div class="hero-content relative max-w-lg">
            <div class="hero-badge rise inline-flex items-center justify-center w-12 h-12 rounded-xl bg-white/15 backdrop-blur-sm border border-white/25 mb-6" style="--i:1">
                <i class="fa-solid fa-book-open-reader text-xl"></i>
            </div>
            <h2 class="rise text-3xl xl:text-4xl font-bold leading-tight tracking-tight" style="--i:2">
                Belajar, mengajar, dan mengelola akademik dalam satu portal.
            </h2>
            <p class="rise mt-4 text-sm xl:text-base text-white/80 leading-relaxed" style="--i:3">
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
                <div class="rise mb-8" style="--i:0">
                    <a href="<?= base_url('/'); ?>" class="inline-flex items-center gap-3 mb-5 hover:opacity-90 transition" title="Kembali ke Beranda">
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-brand text-white shadow-md shadow-brand/25 shrink-0">
                            <i class="fa-solid fa-graduation-cap text-xl"></i>
                        </div>
                        <div class="leading-tight">
                            <p class="text-lg font-extrabold tracking-tight text-slate-900">Syiar Gemilang</p>
                            <p class="text-xs text-slate-500">Sistem Informasi Akademik Rumah Gemilang Indonesia</p>
                        </div>
                    </a>
                    <div class="flex items-center justify-between">
                        <h1 class="text-3xl font-bold tracking-tight text-slate-900">Masuk</h1>
                        <a href="<?= base_url('/'); ?>" class="group text-xs font-medium text-brand hover:underline flex items-center gap-1">
                            <i class="fa-solid fa-arrow-left transition-transform group-hover:-translate-x-0.5"></i> Halaman Utama
                        </a>
                    </div>
                </div>

                <!-- Flash Error Message -->
                <?php if (session()->getFlashdata('error')): ?>
                    <div role="alert" class="rise mb-5 p-3.5 rounded-lg bg-[#FEE2E2] text-[#991B1B] text-sm flex items-start gap-2.5" style="--i:1">
                        <i class="fa-solid fa-circle-exclamation text-base mt-0.5 shrink-0"></i>
                        <span><?= esc(session()->getFlashdata('error')); ?></span>
                    </div>
                <?php endif; ?>

                <!-- Flash Success Message -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div role="status" class="rise mb-5 p-3.5 rounded-lg bg-[#DCFCE7] text-[#166534] text-sm flex items-start gap-2.5" style="--i:1">
                        <i class="fa-solid fa-circle-check text-base mt-0.5 shrink-0"></i>
                        <span><?= esc(session()->getFlashdata('success')); ?></span>
                    </div>
                <?php endif; ?>

                <!-- Alert umum sisi klien (mis. tidak ada koneksi). Galat per kolom tampil di bawah kolomnya. -->
                <div id="clientAlert" role="alert" class="hidden mb-5 p-3.5 rounded-lg bg-[#FEE2E2] text-[#991B1B] text-sm flex items-start gap-2.5">
                    <i class="fa-solid fa-circle-exclamation text-base mt-0.5 shrink-0"></i>
                    <span id="clientAlertText"></span>
                </div>

                <!-- Login Form -->
                <form id="loginForm" action="<?= base_url('/login'); ?>" method="POST" class="space-y-5" novalidate>
                    <?= csrf_field(); ?>

                    <!-- Username Field -->
                    <div class="rise" style="--i:1">
                        <label for="username" class="block text-sm font-medium text-slate-700 mb-1.5">
                            Nomor Induk Santri (NIS) / Username
                        </label>
                        <div class="group relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 transition-colors group-focus-within:text-brand">
                                <i class="fa-solid fa-user text-sm"></i>
                            </div>
                            <input type="text" id="username" name="username" required autocomplete="username"
                                   value="<?= esc(old('username')); ?>"
                                   placeholder="Nomor Induk Santri (NIS) / Username"
                                   class="w-full pl-10 pr-4 py-3 bg-white border border-slate-300 rounded-lg text-slate-900 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand transition">
                        </div>
                        <p id="usernameError" class="hidden mt-1.5 text-xs text-[#991B1B]"></p>
                    </div>

                    <!-- Password Field -->
                    <div class="rise" style="--i:2">
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">
                            Kata sandi
                        </label>
                        <div class="group relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 transition-colors group-focus-within:text-brand">
                                <i class="fa-solid fa-lock text-sm"></i>
                            </div>
                            <input type="password" id="password" name="password" required autocomplete="current-password"
                                   placeholder="Kata sandi"
                                   class="w-full pl-10 pr-11 py-3 bg-white border border-slate-300 rounded-lg text-slate-900 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand transition">
                            <button type="button" id="passwordToggle" onclick="togglePasswordVisibility()"
                                    aria-label="Tampilkan atau sembunyikan kata sandi" aria-pressed="false"
                                    class="absolute inset-y-0 right-0 w-11 flex items-center justify-center text-slate-400 hover:text-slate-700 focus:outline-none focus-visible:text-brand transition">
                                <i id="passwordToggleIcon" class="fa-solid fa-eye text-sm"></i>
                            </button>
                        </div>
                        <p id="capsHint" role="status" class="hidden mt-1.5 text-xs text-amber-700 flex items-center gap-1.5">
                            <i class="fa-solid fa-triangle-exclamation"></i> Caps Lock sedang aktif
                        </p>
                        <p id="passwordError" class="hidden mt-1.5 text-xs text-[#991B1B]"></p>
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
                            class="rise w-full py-3 px-4 bg-brand hover:bg-brand-dark active:scale-[0.98] disabled:opacity-80 disabled:cursor-not-allowed text-white font-semibold rounded-lg text-sm shadow-sm transition duration-150 flex items-center justify-center gap-2 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-brand" style="--i:3">
                        <span id="submitSpinner" class="btn-spinner hidden" aria-hidden="true"></span>
                        <span id="submitLabel">Masuk</span>
                    </button>
                </form>

                <!-- Catatan -->
                <p id="cookieNote" class="rise mt-5 text-xs text-slate-500 flex items-start gap-2" style="--i:4">
                    <i class="fa-solid fa-circle-info mt-0.5 text-slate-400"></i>
                    <span id="cookieNoteText">Pastikan Browser Anda mengaktifkan cookie untuk pengalaman terbaik.</span>
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
        const toggleBtn = document.getElementById('passwordToggle');
        const show = passInput.type === 'password';
        passInput.type = show ? 'text' : 'password';
        icon.classList.toggle('fa-eye', !show);
        icon.classList.toggle('fa-eye-slash', show);
        toggleBtn.setAttribute('aria-pressed', String(show));
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
        const userErr   = document.getElementById('usernameError');
        const passErr   = document.getElementById('passwordError');
        const capsHint  = document.getElementById('capsHint');
        const cookieNote     = document.getElementById('cookieNote');
        const cookieNoteText = document.getElementById('cookieNoteText');

        // Alert umum (bukan per kolom). kind dipakai agar alert "offline" bisa hilang sendiri saat online lagi.
        function showClientError(msg, kind) {
            alertText.textContent = msg;
            alertBox.dataset.kind = kind || '';
            alertBox.classList.remove('hidden');
        }

        // Galat per kolom: pesan di bawah kolom, border merah, getar singkat.
        function setFieldError(input, errEl, msg) {
            errEl.textContent = msg;
            errEl.classList.remove('hidden');
            input.setAttribute('aria-invalid', 'true');
            input.setAttribute('aria-describedby', errEl.id);
            const wrap = input.parentElement;
            wrap.classList.remove('shake');
            void wrap.offsetWidth; // paksa reflow agar animasi bisa diputar ulang
            wrap.classList.add('shake');
        }

        function clearFieldError(input, errEl) {
            errEl.textContent = '';
            errEl.classList.add('hidden');
            input.removeAttribute('aria-invalid');
            input.removeAttribute('aria-describedby');
        }

        [userInput, passInput].forEach(function (el) {
            el.parentElement.addEventListener('animationend', function () {
                el.parentElement.classList.remove('shake');
            });
        });

        function setLoading(isLoading) {
            btn.disabled = isLoading;
            spinner.classList.toggle('hidden', !isLoading);
            label.textContent = isLoading ? 'Memproses...' : 'Masuk';
        }

        // Ketik ulang = galat kolom itu hilang.
        userInput.addEventListener('input', function () {
            clearFieldError(userInput, userErr);
            alertBox.classList.add('hidden');
        });
        passInput.addEventListener('input', function () {
            clearFieldError(passInput, passErr);
            alertBox.classList.add('hidden');
        });

        // Peringatan Caps Lock di kolom kata sandi.
        function updateCaps(e) {
            if (!e.getModifierState) return;
            capsHint.classList.toggle('hidden', !e.getModifierState('CapsLock'));
        }
        passInput.addEventListener('keydown', updateCaps);
        passInput.addEventListener('keyup', updateCaps);
        passInput.addEventListener('blur', function () { capsHint.classList.add('hidden'); });

        form.addEventListener('submit', function (e) {
            if (btn.disabled) { e.preventDefault(); return; }

            let firstInvalid = null;
            if (!userInput.value.trim()) {
                setFieldError(userInput, userErr, 'Nomor Induk Santri (NIS), email, atau username wajib diisi.');
                firstInvalid = userInput;
            }
            if (!passInput.value) {
                setFieldError(passInput, passErr, 'Kata sandi wajib diisi.');
                firstInvalid = firstInvalid || passInput;
            }
            if (firstInvalid) {
                e.preventDefault();
                firstInvalid.focus();
                return;
            }

            if (navigator.onLine === false) {
                e.preventDefault();
                showClientError('Tidak ada koneksi internet. Periksa jaringan Anda, lalu coba lagi.', 'offline');
                return;
            }

            alertBox.classList.add('hidden');
            setLoading(true);
        });

        window.addEventListener('online', function () {
            if (alertBox.dataset.kind === 'offline') alertBox.classList.add('hidden');
        });

        // Cookie nonaktif: ubah catatan jadi peringatan.
        if (navigator.cookieEnabled === false) {
            cookieNote.setAttribute('data-warn', '');
            cookieNoteText.textContent = 'Cookie pada browser Anda nonaktif. Aktifkan cookie agar bisa masuk.';
        }

        // Fokus otomatis hanya di desktop (pointer halus), agar keyboard layar HP tidak muncul sendiri.
        // Jika username sudah terisi (mis. setelah gagal login), fokus langsung ke kata sandi.
        if (window.matchMedia('(hover: hover) and (pointer: fine)').matches) {
            (userInput.value ? passInput : userInput).focus();
        }

        // Reset tombol jika halaman dimuat dari cache (tombol "Kembali" peramban)
        window.addEventListener('pageshow', function (e) {
            if (e.persisted) setLoading(false);
        });
    })();

    // Hero (desktop): kilau mengikuti kursor, teks dan ikon bergeser beda jarak untuk kesan kedalaman.
    // Mati untuk layar sentuh dan pengguna dengan reduced motion.
    (function () {
        const hero = document.querySelector('aside.hero-bg');
        if (!hero) return;
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
        if (!window.matchMedia('(hover: hover) and (pointer: fine)').matches) return;

        let tx = .5, ty = .5, cx = .5, cy = .5, raf = 0;

        function paint() {
            cx += (tx - cx) * 0.08;
            cy += (ty - cy) * 0.08;
            hero.style.setProperty('--cx', cx.toFixed(4));
            hero.style.setProperty('--cy', cy.toFixed(4));
            hero.style.setProperty('--dx', ((cx - .5) * 2).toFixed(4));
            hero.style.setProperty('--dy', ((cy - .5) * 2).toFixed(4));
            if (Math.abs(tx - cx) > 0.001 || Math.abs(ty - cy) > 0.001) {
                raf = requestAnimationFrame(paint);
            } else {
                raf = 0;
            }
        }
        function kick() { if (!raf) raf = requestAnimationFrame(paint); }

        hero.addEventListener('pointermove', function (e) {
            if (e.pointerType !== 'mouse') return;
            const r = hero.getBoundingClientRect();
            tx = Math.min(1, Math.max(0, (e.clientX - r.left) / r.width));
            ty = Math.min(1, Math.max(0, (e.clientY - r.top) / r.height));
            hero.classList.add('is-hovered');
            kick();
        });
        hero.addEventListener('pointerleave', function () {
            tx = .5; ty = .5;
            hero.classList.remove('is-hovered');
            kick();
        });
    })();
</script>
</body>
</html>