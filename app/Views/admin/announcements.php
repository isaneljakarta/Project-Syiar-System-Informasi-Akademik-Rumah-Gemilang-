<?php require_once 'navbar.php'; ?>

<div class="flex-1 min-w-0 flex flex-col overflow-hidden bg-[#F8FAFC]">

    <!-- Top Navbar -->
    <?php 
    $page_title = $title ?? 'Papan Pengumuman Diklat';
    require_once __DIR__ . '/components/topbar.php'; 
    ?>

    <!-- Main Scrollable Area -->
    <main class="flex-1 overflow-y-auto pb-16">

        <!-- ===================== HERO WAVE BANNER ===================== -->
        <?php
        $hero = [
            'breadcrumb' => [
                ['label' => 'Portal Admin', 'url' => base_url('admin')],
                ['label' => 'Papan Pengumuman']
            ],
            'badge' => 'Papan Informasi & Agenda Diklat E-RGI',
            'title' => 'Papan Pengumuman Diklat & Kegiatan Pekanan',
            'subtitle' => 'Kelola seluruh informasi, pengumuman acara resmi kedinasan, agenda pekanan, hingga kegiatan tidak resmi santri yang tampil di landing page.',
            'stats' => [
                ['icon' => 'fa-solid fa-bullhorn', 'bg' => 'bg-sky-400/20 text-sky-200', 'value' => $stats['total'] ?? count($announcements), 'label' => 'Total Pengumuman'],
                ['icon' => 'fa-solid fa-certificate', 'bg' => 'bg-blue-400/20 text-blue-200', 'value' => $stats['resmi'] ?? 0, 'label' => 'Acara Resmi'],
                ['icon' => 'fa-solid fa-users', 'bg' => 'bg-amber-400/20 text-amber-200', 'value' => $stats['tidak_resmi'] ?? 0, 'label' => 'Kegiatan Santri'],
                ['icon' => 'fa-solid fa-calendar-days', 'bg' => 'bg-emerald-400/20 text-emerald-200', 'value' => $stats['aktif'] ?? 0, 'label' => 'Sedang Aktif'],
            ]
        ];
        require_once __DIR__ . '/components/hero_header.php';
        ?>

        <div class="p-6 space-y-6">

            <!-- Flash Notification -->
            <?php if (session()->getFlashdata('notif_msg')) : ?>
                <?php
                    $type = session()->getFlashdata('notif_type') ?? 'add';
                    $bgClass = $type === 'add' ? 'bg-[#DCFCE7] border-[#86EFAC] text-[#166534]'
                             : ($type === 'edit' ? 'bg-amber-50 border-amber-200 text-amber-900'
                             : 'bg-[#FEE2E2] border-[#FCA5A5] text-[#991B1B]');
                    $iconBg  = $type === 'add' ? 'bg-emerald-600'
                             : ($type === 'edit' ? 'bg-amber-500' : 'bg-rose-600');
                    $iconFa  = $type === 'add' ? 'fa-circle-check'
                             : ($type === 'edit' ? 'fa-pen-to-square' : 'fa-trash-can');
                ?>
                <div id="flashNoticeAlert" class="rounded-xl border p-4 shadow-sm flex items-start justify-between gap-3 <?= $bgClass; ?>">
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-lg <?= $iconBg; ?> text-white flex items-center justify-center text-base shrink-0 mt-0.5">
                            <i class="fa-solid <?= $iconFa; ?>"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold"><?= esc(session()->getFlashdata('notif_title') ?? 'Notifikasi Sistem'); ?></h4>
                            <p class="text-xs mt-0.5"><?= esc(session()->getFlashdata('notif_msg')); ?></p>
                        </div>
                    </div>
                    <button type="button" onclick="document.getElementById('flashNoticeAlert').remove()" class="text-slate-400 hover:text-slate-600 p-1 cursor-pointer">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs flex items-center gap-2.5">
                    <i class="fa-solid fa-circle-exclamation text-rose-600 text-base shrink-0"></i>
                    <span><?= esc(session()->getFlashdata('error')); ?></span>
                </div>
            <?php endif; ?>

            <!-- Table Card -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 space-y-4">
                
                <!-- Controls Bar -->
                <div class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3">
                    
                    <!-- Search Input -->
                    <div class="relative flex-1 max-w-md">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-magnifying-glass text-xs"></i>
                        </div>
                        <input type="text" id="searchInput" onkeyup="filterAnnouncements()" 
                               placeholder="Cari judul, kategori, pekan, lokasi..." 
                               class="w-full pl-9 pr-4 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0066CC]/30 focus:border-[#0066CC] transition">
                    </div>

                    <!-- Category Filter & Action Button -->
                    <div class="flex items-center gap-2.5">
                        <select id="kategoriFilter" onchange="filterAnnouncements()" 
                                class="text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#0066CC]/30 focus:border-[#0066CC]">
                            <option value="">Semua Kategori</option>
                            <option value="resmi">Acara Resmi</option>
                            <option value="tidak_resmi">Kegiatan Santri (Tidak Resmi)</option>
                            <option value="agenda">Agenda Diklat</option>
                        </select>

                        <button type="button" onclick="openAddModal()" 
                                class="px-4 py-2 bg-[#0066CC] hover:bg-[#0052A3] text-white rounded-xl text-xs font-semibold shadow-sm shadow-[#0066CC]/25 flex items-center gap-2 transition cursor-pointer shrink-0">
                            <i class="fa-solid fa-plus"></i>
                            <span>Buat Pengumuman Baru</span>
                        </button>
                    </div>
                </div>

                <!-- Announcement List Table -->
                <div class="overflow-x-auto rounded-xl border border-slate-100">
                    <table class="w-full text-left text-xs text-slate-600" id="announcementTable">
                        <thead class="bg-slate-50/80 text-slate-500 font-bold uppercase tracking-wider text-3xs border-b border-slate-200">
                            <tr>
                                <th class="py-3 px-4 w-12 text-center">No</th>
                                <th class="py-3 px-4 min-w-[260px]">Pengumuman / Acara</th>
                                <th class="py-3 px-4 w-36">Kategori & Pekan</th>
                                <th class="py-3 px-4 w-44">Jadwal & Lokasi</th>
                                <th class="py-3 px-4 w-28 text-center">Status</th>
                                <th class="py-3 px-4 w-32 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php if (empty($announcements)) : ?>
                                <tr>
                                    <td colspan="6" class="text-center py-12 text-slate-400">
                                        <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-2 text-xl">
                                            <i class="fa-solid fa-bullhorn"></i>
                                        </div>
                                        <p class="font-semibold text-slate-600">Belum ada pengumuman tersimpan.</p>
                                        <p class="text-3xs mt-1">Klik tombol "Buat Pengumuman Baru" di atas untuk menambahkan pengumuman pekan ini.</p>
                                    </td>
                                </tr>
                            <?php else : ?>
                                <?php foreach ($announcements as $index => $item) : ?>
                                    <?php 
                                        $catColor = [
                                            'resmi'       => ['badge' => 'bg-blue-50 text-blue-700 border-blue-200', 'label' => 'Acara Resmi', 'icon' => 'fa-certificate'],
                                            'tidak_resmi' => ['badge' => 'bg-amber-50 text-amber-800 border-amber-300', 'label' => 'Kegiatan Santri', 'icon' => 'fa-users'],
                                            'agenda'      => ['badge' => 'bg-emerald-50 text-emerald-800 border-emerald-200', 'label' => 'Agenda Diklat', 'icon' => 'fa-calendar-check'],
                                        ][$item['kategori']] ?? ['badge' => 'bg-slate-50 text-slate-700 border-slate-200', 'label' => 'Umum', 'icon' => 'fa-bullhorn'];
                                    ?>
                                    <tr class="hover:bg-slate-50/60 transition announcement-row" 
                                        data-kategori="<?= esc($item['kategori']); ?>"
                                        data-search="<?= strtolower(esc($item['judul'] . ' ' . $item['isi'] . ' ' . ($item['lokasi'] ?? '') . ' ' . ($item['pekan_ke'] ?? ''))); ?>">
                                        <td class="py-3.5 px-4 text-center font-bold text-slate-400">
                                            <?= $index + 1; ?>
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <div class="flex items-start gap-2.5">
                                                <?php if (!empty($item['is_pinned'])) : ?>
                                                    <span class="mt-0.5 text-amber-500 shrink-0" title="Disematkan (Pinned)">
                                                        <i class="fa-solid fa-thumbtack"></i>
                                                    </span>
                                                <?php endif; ?>
                                                <div>
                                                    <h4 class="font-bold text-slate-800 text-xs hover:text-[#0066CC] transition leading-snug">
                                                        <?= esc($item['judul']); ?>
                                                    </h4>
                                                    <p class="text-3xs text-slate-500 line-clamp-2 mt-1 leading-relaxed">
                                                        <?= esc($item['isi']); ?>
                                                    </p>
                                                    <div class="mt-1 flex items-center gap-2 text-3xs text-slate-400">
                                                        <span><i class="fa-solid fa-building text-slate-400 mr-1"></i><?= esc($item['penyelenggara'] ?: 'Diklat RGI'); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <div class="space-y-1">
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-3xs font-bold border <?= $catColor['badge']; ?>">
                                                    <i class="fa-solid <?= $catColor['icon']; ?> text-3xs"></i>
                                                    <?= $catColor['label']; ?>
                                                </span>
                                                <div class="text-3xs text-slate-500 font-medium">
                                                    <i class="fa-solid fa-clock-rotate-left mr-1 text-slate-400"></i><?= esc($item['pekan_ke'] ?: 'Pekan Ini'); ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <div class="space-y-0.5">
                                                <div class="font-medium text-slate-700 flex items-center gap-1.5">
                                                    <i class="fa-regular fa-calendar text-[#0066CC]"></i>
                                                    <span><?= !empty($item['tanggal_kegiatan']) ? date('d M Y', strtotime($item['tanggal_kegiatan'])) : 'Fleksibel'; ?></span>
                                                    <?php if (!empty($item['waktu_kegiatan'])) : ?>
                                                        <span class="text-slate-400">• <?= esc($item['waktu_kegiatan']); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="text-3xs text-slate-500 flex items-center gap-1">
                                                    <i class="fa-solid fa-location-dot text-rose-500"></i>
                                                    <span class="truncate"><?= esc($item['lokasi'] ?: 'Kampus Diklat RGI'); ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4 text-center">
                                            <?php if (!empty($item['is_active'])) : ?>
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-3xs font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Tampil
                                                </span>
                                            <?php else : ?>
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-3xs font-extrabold bg-slate-100 text-slate-500 border border-slate-200">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Arsip
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="py-3.5 px-4 text-center">
                                            <div class="inline-flex items-center justify-center gap-1.5">
                                                <!-- Edit Button -->
                                                <button type="button" 
                                                        onclick='openEditModal(<?= json_encode($item, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>)' 
                                                        title="Edit Pengumuman"
                                                        class="w-7 h-7 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 flex items-center justify-center text-xs transition cursor-pointer">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button>

                                                <!-- Toggle Active Button -->
                                                <form action="<?= base_url('admin/announcements/toggle/' . $item['id']); ?>" method="POST" class="inline">
                                                    <?= csrf_field(); ?>
                                                    <button type="submit" 
                                                            title="<?= !empty($item['is_active']) ? 'Sembunyikan dari Landing Page' : 'Tampilkan di Landing Page'; ?>"
                                                            class="w-7 h-7 rounded-lg <?= !empty($item['is_active']) ? 'bg-slate-100 hover:bg-slate-200 text-slate-600' : 'bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200'; ?> flex items-center justify-center text-xs transition cursor-pointer">
                                                        <i class="fa-solid <?= !empty($item['is_active']) ? 'fa-eye-slash' : 'fa-eye'; ?>"></i>
                                                    </button>
                                                </form>

                                                <!-- Delete Button -->
                                                <button type="button" 
                                                        onclick="openDeleteModal(<?= $item['id']; ?>, '<?= esc(addslashes($item['judul'])); ?>')" 
                                                        title="Hapus Pengumuman"
                                                        class="w-7 h-7 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 flex items-center justify-center text-xs transition cursor-pointer">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="text-3xs text-slate-400 flex items-center justify-between pt-2">
                    <span>* Pengumuman dengan status <strong>Tampil</strong> akan langsung terlihat di section <strong>Papan Pengumuman</strong> pada Landing Page utama.</span>
                    <span>Admin dapat memperbarui papan ini secara berkala setiap pekan.</span>
                </div>

            </div>

        </div>
    </main>
</div>

<!-- ===================== MODAL TAMBAH PENGUMUMAN ===================== -->
<div id="addAnnouncementModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" onclick="closeAddModal()"></div>
    <div class="relative bg-white w-full max-w-lg rounded-2xl shadow-2xl border border-slate-100 overflow-hidden z-10 animate-in fade-in zoom-in-95 duration-150">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50">
            <div class="flex items-center gap-2.5">
                <span class="w-8 h-8 rounded-lg bg-[#0066CC] text-white flex items-center justify-center text-sm font-bold shadow-xs">
                    <i class="fa-solid fa-bullhorn"></i>
                </span>
                <div>
                    <h3 class="text-sm font-bold text-slate-800">Buat Pengumuman Baru</h3>
                    <p class="text-3xs text-slate-500">Pasang informasi resmi atau kegiatan santri pekan ini</p>
                </div>
            </div>
            <button type="button" onclick="closeAddModal()" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-lg hover:bg-slate-200 transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form action="<?= base_url('admin/announcements/save'); ?>" method="POST" class="p-5 space-y-3.5 text-xs">
            <?= csrf_field(); ?>

            <div>
                <label for="judul" class="block font-semibold text-slate-700 mb-1">Judul Pengumuman <span class="text-rose-500">*</span></label>
                <input type="text" name="judul" id="judul" required placeholder="Contoh: Upacara Pembukaan Ujian Praktik Kejuruan" 
                       class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0066CC]/30 focus:border-[#0066CC]">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label for="kategori" class="block font-semibold text-slate-700 mb-1">Kategori Acara <span class="text-rose-500">*</span></label>
                    <select name="kategori" id="kategori" required 
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0066CC]/30 focus:border-[#0066CC]">
                        <option value="resmi">Acara Resmi Kedinasan</option>
                        <option value="tidak_resmi">Kegiatan Santri (Tidak Resmi)</option>
                        <option value="agenda">Agenda Diklat & Pembinaan</option>
                    </select>
                </div>
                <div>
                    <label for="pekan_ke" class="block font-semibold text-slate-700 mb-1">Periode Pekan</label>
                    <input type="text" name="pekan_ke" id="pekan_ke" value="Pekan Ini" placeholder="Contoh: Pekan 2 November 2026" 
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0066CC]/30 focus:border-[#0066CC]">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label for="tanggal_kegiatan" class="block font-semibold text-slate-700 mb-1">Tanggal Pelaksanaan</label>
                    <input type="date" name="tanggal_kegiatan" id="tanggal_kegiatan" 
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0066CC]/30 focus:border-[#0066CC]">
                </div>
                <div>
                    <label for="waktu_kegiatan" class="block font-semibold text-slate-700 mb-1">Waktu / Jam</label>
                    <input type="text" name="waktu_kegiatan" id="waktu_kegiatan" placeholder="Contoh: 08:00 - 12:00 WIB" 
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0066CC]/30 focus:border-[#0066CC]">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label for="lokasi" class="block font-semibold text-slate-700 mb-1">Lokasi Tempat</label>
                    <input type="text" name="lokasi" id="lokasi" value="Kampus Diklat RGI Depok" placeholder="Contoh: Aula Serbaguna / Lapangan" 
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0066CC]/30 focus:border-[#0066CC]">
                </div>
                <div>
                    <label for="penyelenggara" class="block font-semibold text-slate-700 mb-1">Penyelenggara</label>
                    <input type="text" name="penyelenggara" id="penyelenggara" value="Diklat RGI" placeholder="Contoh: Divisi Pembinaan / BEM Santri" 
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0066CC]/30 focus:border-[#0066CC]">
                </div>
            </div>

            <div>
                <label for="isi" class="block font-semibold text-slate-700 mb-1">Isi & Deskripsi Pengumuman <span class="text-rose-500">*</span></label>
                <textarea name="isi" id="isi" rows="3" required placeholder="Tuliskan detail pengumuman, instruksi pakaian, atau agenda..." 
                          class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0066CC]/30 focus:border-[#0066CC] leading-relaxed"></textarea>
            </div>

            <div class="flex items-center gap-6 pt-1">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_pinned" value="1" class="rounded text-[#0066CC] focus:ring-[#0066CC]">
                    <span class="text-slate-700 font-medium">Sematkan di Atas (Pin Notice)</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" checked class="rounded text-[#0066CC] focus:ring-[#0066CC]">
                    <span class="text-slate-700 font-medium">Langsung Tampilkan di Landing Page</span>
                </label>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2.5">
                <button type="button" onclick="closeAddModal()" class="px-4 py-2 border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-100 transition font-medium">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 bg-[#0066CC] hover:bg-[#0052A3] text-white rounded-xl font-bold shadow-sm shadow-[#0066CC]/25 transition flex items-center gap-2">
                    <i class="fa-solid fa-paper-plane text-xs"></i>
                    <span>Terbitkan Pengumuman</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ===================== MODAL EDIT PENGUMUMAN ===================== -->
<div id="editAnnouncementModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" onclick="closeEditModal()"></div>
    <div class="relative bg-white w-full max-w-lg rounded-2xl shadow-2xl border border-slate-100 overflow-hidden z-10 animate-in fade-in zoom-in-95 duration-150">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50">
            <div class="flex items-center gap-2.5">
                <span class="w-8 h-8 rounded-lg bg-amber-500 text-white flex items-center justify-center text-sm font-bold shadow-xs">
                    <i class="fa-solid fa-pen-to-square"></i>
                </span>
                <div>
                    <h3 class="text-sm font-bold text-slate-800">Edit Pengumuman Diklat</h3>
                    <p class="text-3xs text-slate-500">Perbarui rincian pengumuman yang sudah terpasang</p>
                </div>
            </div>
            <button type="button" onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-lg hover:bg-slate-200 transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form action="<?= base_url('admin/announcements/update'); ?>" method="POST" class="p-5 space-y-3.5 text-xs">
            <?= csrf_field(); ?>
            <input type="hidden" name="id" id="edit_id">

            <div>
                <label for="edit_judul" class="block font-semibold text-slate-700 mb-1">Judul Pengumuman <span class="text-rose-500">*</span></label>
                <input type="text" name="judul" id="edit_judul" required 
                       class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label for="edit_kategori" class="block font-semibold text-slate-700 mb-1">Kategori Acara <span class="text-rose-500">*</span></label>
                    <select name="kategori" id="edit_kategori" required 
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500">
                        <option value="resmi">Acara Resmi Kedinasan</option>
                        <option value="tidak_resmi">Kegiatan Santri (Tidak Resmi)</option>
                        <option value="agenda">Agenda Diklat & Pembinaan</option>
                    </select>
                </div>
                <div>
                    <label for="edit_pekan_ke" class="block font-semibold text-slate-700 mb-1">Periode Pekan</label>
                    <input type="text" name="pekan_ke" id="edit_pekan_ke" 
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label for="edit_tanggal_kegiatan" class="block font-semibold text-slate-700 mb-1">Tanggal Pelaksanaan</label>
                    <input type="date" name="tanggal_kegiatan" id="edit_tanggal_kegiatan" 
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500">
                </div>
                <div>
                    <label for="edit_waktu_kegiatan" class="block font-semibold text-slate-700 mb-1">Waktu / Jam</label>
                    <input type="text" name="waktu_kegiatan" id="edit_waktu_kegiatan" 
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label for="edit_lokasi" class="block font-semibold text-slate-700 mb-1">Lokasi Tempat</label>
                    <input type="text" name="lokasi" id="edit_lokasi" 
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500">
                </div>
                <div>
                    <label for="edit_penyelenggara" class="block font-semibold text-slate-700 mb-1">Penyelenggara</label>
                    <input type="text" name="penyelenggara" id="edit_penyelenggara" 
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500">
                </div>
            </div>

            <div>
                <label for="edit_isi" class="block font-semibold text-slate-700 mb-1">Isi & Deskripsi Pengumuman <span class="text-rose-500">*</span></label>
                <textarea name="isi" id="edit_isi" rows="3" required 
                          class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500 leading-relaxed"></textarea>
            </div>

            <div class="flex items-center gap-6 pt-1">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_pinned" id="edit_is_pinned" value="1" class="rounded text-amber-500 focus:ring-amber-500">
                    <span class="text-slate-700 font-medium">Sematkan di Atas (Pin Notice)</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" id="edit_is_active" value="1" class="rounded text-amber-500 focus:ring-amber-500">
                    <span class="text-slate-700 font-medium">Status Tampil di Landing Page</span>
                </label>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2.5">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-100 transition font-medium">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-xl font-bold shadow-sm shadow-amber-500/25 transition flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk text-xs"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ===================== MODAL KONFIRMASI HAPUS ===================== -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" onclick="closeDeleteModal()"></div>
    <div class="relative bg-white w-full max-w-sm rounded-2xl shadow-2xl border border-slate-100 overflow-hidden z-10 animate-in fade-in zoom-in-95 duration-150 p-6 text-center">
        <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center mx-auto mb-3.5 text-xl border border-rose-100">
            <i class="fa-solid fa-trash-can"></i>
        </div>
        <h3 class="text-base font-bold text-slate-800">Hapus Pengumuman?</h3>
        <p class="text-xs text-slate-500 mt-1" id="deleteTargetText">Pengumuman ini akan dihapus permanen dari papan pengumuman.</p>

        <form id="deleteForm" method="POST" class="mt-5 flex items-center justify-center gap-2">
            <?= csrf_field(); ?>
            <button type="button" onclick="closeDeleteModal()" class="flex-1 py-2 px-3 border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-100 transition text-xs font-semibold">
                Batal
            </button>
            <button type="submit" class="flex-1 py-2 px-3 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold shadow-md shadow-rose-600/20 transition">
                Ya, Hapus
            </button>
        </form>
    </div>
</div>

<script>
    function filterAnnouncements() {
        const query = document.getElementById('searchInput').value.toLowerCase();
        const kat = document.getElementById('kategoriFilter').value;
        const rows = document.querySelectorAll('.announcement-row');

        rows.forEach(row => {
            const rowKat = row.getAttribute('data-kategori');
            const rowSearch = row.getAttribute('data-search');

            const matchKat = !kat || rowKat === kat;
            const matchSearch = !query || rowSearch.includes(query);

            if (matchKat && matchSearch) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    function openAddModal() {
        document.getElementById('addAnnouncementModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeAddModal() {
        document.getElementById('addAnnouncementModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    function openEditModal(item) {
        document.getElementById('edit_id').value = item.id;
        document.getElementById('edit_judul').value = item.judul || '';
        document.getElementById('edit_kategori').value = item.kategori || 'resmi';
        document.getElementById('edit_pekan_ke').value = item.pekan_ke || 'Pekan Ini';
        document.getElementById('edit_tanggal_kegiatan').value = item.tanggal_kegiatan || '';
        document.getElementById('edit_waktu_kegiatan').value = item.waktu_kegiatan || '';
        document.getElementById('edit_lokasi').value = item.lokasi || '';
        document.getElementById('edit_penyelenggara').value = item.penyelenggara || '';
        document.getElementById('edit_isi').value = item.isi || '';
        document.getElementById('edit_is_pinned').checked = parseInt(item.is_pinned, 10) === 1;
        document.getElementById('edit_is_active').checked = parseInt(item.is_active, 10) === 1;

        document.getElementById('editAnnouncementModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeEditModal() {
        document.getElementById('editAnnouncementModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    function openDeleteModal(id, title) {
        const form = document.getElementById('deleteForm');
        form.action = '<?= base_url('admin/announcements/delete/'); ?>' + id;
        document.getElementById('deleteTargetText').textContent = `Pengumuman "${title}" akan dihapus permanen.`;
        document.getElementById('deleteModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
</script>
