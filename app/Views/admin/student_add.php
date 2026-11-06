<?php require_once 'navbar.php'; ?>

<div class="flex-1 min-w-0 flex flex-col overflow-hidden bg-[#F8FAFC]">

    <!-- Top Navbar -->
    <header class="h-16 bg-white border-b border-[#E2E8F0] flex items-center justify-between px-4 sm:px-6 z-10 shrink-0">
        <div class="flex items-center gap-2 sm:gap-3 min-w-0">
            <button type="button" onclick="toggleMobileSidebar()" class="lg:hidden p-2 -ml-1 text-slate-600 hover:text-brand hover:bg-slate-100 rounded-lg transition" aria-label="Buka Menu Navigasi">
                <i class="fa-solid fa-bars text-lg"></i>
            </button>
            <h1 class="text-base sm:text-lg font-bold text-[#1E293B] truncate sg-display"><?= esc($title); ?></h1>
            <span class="hidden md:inline-flex bg-brand-light text-brand text-xs font-semibold px-2.5 py-0.5 rounded-full border border-brand-border items-center gap-1 shrink-0">
                <i class="fa-solid fa-user-plus"></i> Formulir Santri Baru
            </span>
        </div>
        <span class="hidden sm:inline-flex bg-brand-light text-brand text-xs font-semibold px-3 py-1 rounded-full border border-brand-border items-center gap-1.5 shrink-0">
            <i class="fa-solid fa-calendar-days"></i> Tahun Ajaran: 2026/2027 (Ganjil)
        </span>
    </header>

    <!-- Main Scrollable Area -->
    <main class="flex-1 overflow-y-auto p-6">
        <div class="max-w-xl mx-auto bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
            <div class="border-b border-slate-100 pb-3">
                <h2 class="text-base font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-id-card text-brand"></i> Formulir Tambah Data Santri
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">Lengkapi identitas santri dan nilai awal aspek penilaian.</p>
            </div>

            <!-- Form Input -->
            <form action="<?= base_url('/admin/save'); ?>" method="post" class="space-y-4">
                <?= csrf_field(); ?>

                <!-- Nama Santri -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Nama Lengkap Santri <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-user text-xs"></i>
                        </div>
                        <input type="text" name="nama" required 
                               class="w-full pl-9 pr-3 py-2.5 bg-white border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand transition" 
                               placeholder="Contoh: Muhammad Pradipta">
                    </div>
                </div>

                <!-- Dropdown Kelas / Jurusan -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Kelas / Jurusan Santri <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-graduation-cap text-xs"></i>
                        </div>
                        <select name="kelas" required 
                                class="w-full pl-9 pr-8 py-2.5 bg-white border border-slate-300 rounded-xl text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand transition appearance-none font-medium">
                            <option value="" disabled selected>-- Pilih Jurusan / Rombel --</option>
                            <option value="Teknik Komputer dan Jaringan">Teknik Komputer dan Jaringan</option>
                            <option value="Tata Busana">Tata Busana</option>
                            <option value="Fotografi dan Videografi">Fotografi dan Videografi</option>
                            <option value="Desain Grafis">Desain Grafis</option>
                            <option value="Otomotif">Otomotif</option>
                            <option value="Aplikasi Perkantoran">Aplikasi Perkantoran</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                <!-- Nilai 4 Mapel Akademik -->
                <div class="grid grid-cols-2 gap-3 pt-1">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nilai Tauhid</label>
                        <input type="number" step="0.1" min="0" max="100" name="tauhid" required 
                               class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand transition" 
                               placeholder="0 - 100">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nilai Fiqih</label>
                        <input type="number" step="0.1" min="0" max="100" name="fiqih" required 
                               class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand transition" 
                               placeholder="0 - 100">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nilai B. Inggris</label>
                        <input type="number" step="0.1" min="0" max="100" name="b_ing" required 
                               class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand transition" 
                               placeholder="0 - 100">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nilai Menulis Kreatif</label>
                        <input type="number" step="0.1" min="0" max="100" name="menulis_kreatif" required 
                               class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand transition" 
                               placeholder="0 - 100">
                    </div>
                </div>

                <!-- Adab & Kehadiran Highlight Box -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-4 bg-slate-50/80 rounded-xl border border-slate-200">
                    <div>
                        <label class="block text-xs font-bold text-amber-800 mb-1">
                            <i class="fa-solid fa-scale-balanced mr-1"></i> Nilai Adab & Akhlaq (20%)
                        </label>
                        <input type="number" step="0.1" name="adab_akhlaq" value="85" min="0" max="100" required 
                               class="w-full px-3 py-2 border border-amber-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 text-sm font-bold bg-white text-amber-900" 
                               placeholder="Contoh: 85">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-emerald-800 mb-1">
                            <i class="fa-solid fa-clipboard-check mr-1"></i> Kehadiran Awal (%)
                        </label>
                        <input type="number" step="0.1" name="kehadiran" value="95" min="0" max="100" required 
                               class="w-full px-3 py-2 border border-emerald-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm font-bold bg-white text-emerald-900" 
                               placeholder="Contoh: 95">
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100">
                    <a href="<?= base_url('admin/data'); ?>" 
                       class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-5 py-2.5 bg-brand hover:bg-brand-dark text-white rounded-xl text-xs font-bold shadow-md shadow-brand/20 transition flex items-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Data Santri
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>
</body>
</html>
