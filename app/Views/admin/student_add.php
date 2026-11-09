<?php require_once 'navbar.php'; ?>

<div class="flex-1 min-w-0 flex flex-col overflow-hidden bg-[#F8FAFC]">

    <!-- Top Navbar -->
    <?php 
    $page_title = $title ?? 'Tambah Data Santri';
    require_once __DIR__ . '/components/topbar.php'; 
    ?>

    <!-- Main Scrollable Area -->
    <main class="flex-1 overflow-y-auto pb-16">

        <!-- ===================== HERO WAVE BANNER ===================== -->
        <?php
        $hero = [
            'breadcrumb' => [
                ['label' => 'Portal Admin', 'url' => base_url('admin')],
                ['label' => 'Data Santri', 'url' => base_url('admin/data')],
                ['label' => 'Tambah Santri']
            ],
            'badge' => 'Lembaga Pendidikan E-RGI Syiar Gemilang',
            'title' => 'Formulir Pendaftaran Santri Baru',
            'subtitle' => 'Registrasi identitas santri baru, penempatan kelas kejuruan, serta input skor awal aspek akademik dan adab akhlaq karimah.',
            'stats' => [
                ['icon' => 'fa-solid fa-user-plus', 'bg' => 'bg-sky-400/20 text-sky-200', 'value' => 'Baru', 'label' => 'Formulir Santri'],
                ['icon' => 'fa-solid fa-layer-group', 'bg' => 'bg-emerald-400/20 text-emerald-200', 'value' => '6 Kelas', 'label' => 'Pilihan Kejuruan'],
                ['icon' => 'fa-solid fa-scale-balanced', 'bg' => 'bg-amber-400/20 text-amber-200', 'value' => '80:20', 'label' => 'Bobot Nilai:Adab'],
            ]
        ];
        require_once __DIR__ . '/components/hero_header.php';
        ?>

        <div class="p-6">
        <div class="max-w-xl mx-auto bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
            <div class="border-b border-slate-100 pb-3">
                <h2 class="text-base font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-id-card text-brand"></i> Formulir Tambah Data Santri
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">Lengkapi identitas santri dan nilai awal aspek penilaian.</p>
            </div>

            <!-- Form Input -->
            <form action="<?= base_url('/admin/save'); ?>" method="post" enctype="multipart/form-data" class="space-y-4">
                <?= csrf_field(); ?>

                <!-- Foto Profil Santri -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Foto Profil Santri <span class="text-slate-400 font-normal">(Opsional)</span>
                    </label>
                    <div class="flex items-center gap-4 p-3 bg-slate-50 rounded-xl border border-dashed border-slate-300">
                        <div id="fotoPreviewBox" class="w-16 h-16 rounded-xl bg-slate-200 border border-slate-300 flex items-center justify-center text-slate-400 shrink-0 overflow-hidden">
                            <i class="fa-solid fa-camera text-xl" id="fotoDefaultIcon"></i>
                            <img id="fotoPreviewImg" src="" alt="Preview" class="w-full h-full object-cover hidden">
                        </div>
                        <div class="flex-1">
                            <input type="file" name="foto" id="fotoInput" accept="image/png, image/jpeg, image/jpg, image/webp"
                                   onchange="previewSantriFoto(this)"
                                   class="block w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-brand file:text-white hover:file:bg-brand-dark cursor-pointer">
                            <p class="text-3xs text-slate-400 mt-1">Format: JPG, PNG, WEBP (Maksimal 2MB).</p>
                        </div>
                    </div>
                </div>

                <!-- Nama Lengkap Santri -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Nama Lengkap Santri <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-user text-xs"></i>
                        </div>
                        <input type="text" name="nama" required 
                               class="w-full pl-9 pr-3 py-2.5 bg-white border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand transition font-medium" 
                               placeholder="Contoh: Muhammad Pradipta">
                    </div>
                </div>

                <!-- NIS & Cabang Row -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                            NIS (Nomor Induk Santri)
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-id-badge text-xs"></i>
                            </div>
                            <input type="text" name="nis" 
                                   class="w-full pl-9 pr-3 py-2.5 bg-white border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand transition font-mono" 
                                   placeholder="Otomatis (contoh: RGI-35052)">
                        </div>
                        <p class="text-3xs text-slate-400 mt-1">Kosongkan untuk nomor induk berurutan otomatis.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Cabang Kampus
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-location-dot text-xs text-rose-500"></i>
                            </div>
                            <select name="cabang" 
                                    class="w-full pl-9 pr-8 py-2.5 bg-white border border-slate-300 rounded-xl text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand transition appearance-none font-medium">
                                <option value="Kampus Utama Depok" selected>Kampus Utama Depok</option>
                                <option value="Kampus Surabaya">Kampus Surabaya</option>
                                <option value="Kampus Aceh">Kampus Aceh</option>
                                <option value="Kampus Yogyakarta">Kampus Yogyakarta</option>
                                <option value="Kampus Magelang">Kampus Magelang</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kelas, Angkatan & Status Row -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="sm:col-span-1">
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Angkatan
                        </label>
                        <input type="text" name="angkatan" value="Angkatan 35" required 
                               class="w-full px-3 py-2.5 bg-white border border-slate-300 rounded-xl text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand transition font-medium">
                    </div>

                    <div class="sm:col-span-1">
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Status Siswa
                        </label>
                        <select name="status" required 
                                class="w-full px-3 py-2.5 bg-white border border-slate-300 rounded-xl text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand transition font-medium">
                            <option value="Aktif" selected>Aktif</option>
                            <option value="Alumni">Alumni</option>
                        </select>
                    </div>

                    <div class="sm:col-span-1">
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Kelas / Kejuruan <span class="text-red-500">*</span>
                        </label>
                        <select name="kelas" required 
                                class="w-full px-3 py-2.5 bg-white border border-slate-300 rounded-xl text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand transition font-medium">
                            <option value="" disabled selected>-- Pilih --</option>
                            <option value="Teknik Komputer dan Jaringan">TKJ</option>
                            <option value="Tata Busana">Tata Busana</option>
                            <option value="Fotografi dan Videografi">Fotografi</option>
                            <option value="Desain Grafis">Desain Grafis</option>
                            <option value="Otomotif">Otomotif</option>
                            <option value="Aplikasi Perkantoran">Perkantoran</option>
                        </select>
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
        </div> <!-- /p-6 wrapper -->
    </main>
</div>

<script>
function previewSantriFoto(input) {
    var previewImg = document.getElementById('fotoPreviewImg');
    var defaultIcon = document.getElementById('fotoDefaultIcon');
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            previewImg.classList.remove('hidden');
            if (defaultIcon) defaultIcon.classList.add('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        previewImg.src = '';
        previewImg.classList.add('hidden');
        if (defaultIcon) defaultIcon.classList.remove('hidden');
    }
}
</script>
</body>
</html>
