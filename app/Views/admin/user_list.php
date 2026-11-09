<?php require_once 'navbar.php'; ?>

<div class="flex-1 min-w-0 flex flex-col overflow-hidden bg-[#F8FAFC]">

    <!-- Top Navbar -->
    <?php 
    $page_title = $title ?? 'Manajemen Pengguna';
    require_once __DIR__ . '/components/topbar.php'; 
    ?>

    <!-- Main Scrollable Area -->
    <main class="flex-1 overflow-y-auto pb-16">

        <!-- ===================== HERO WAVE BANNER ===================== -->
        <?php
        $hero = [
            'breadcrumb' => [
                ['label' => 'Portal Admin', 'url' => base_url('/')],
                ['label' => 'Manajemen Pengguna']
            ],
            'badge' => 'Otoritas & Hak Akses Multi-Peran E-RGI',
            'title' => 'Direktori & Manajemen User Login',
            'subtitle' => 'Kelola seluruh akun pengguna terdaftar (Admin, Instruktur, Siswa, dan Wali Santri), pantau status aktif, dan tambahkan pengguna baru.',
            'stats' => [
                ['icon' => 'fa-solid fa-users', 'bg' => 'bg-sky-400/20 text-sky-200', 'value' => $stats['total'] ?? count($users), 'label' => 'Total Akun'],
                ['icon' => 'fa-solid fa-user-shield', 'bg' => 'bg-blue-400/20 text-blue-200', 'value' => $stats['admin'] ?? 0, 'label' => 'Admin'],
                ['icon' => 'fa-solid fa-chalkboard-user', 'bg' => 'bg-purple-400/20 text-purple-200', 'value' => $stats['instruktur'] ?? 0, 'label' => 'Instruktur'],
                ['icon' => 'fa-solid fa-user-graduate', 'bg' => 'bg-emerald-400/20 text-emerald-200', 'value' => ($stats['siswa'] ?? 0) + ($stats['wali_santri'] ?? 0), 'label' => 'Siswa & Wali'],
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
                <div id="flashUserAlert" class="rounded-xl border p-4 shadow-sm flex items-start justify-between gap-3 <?= $bgClass; ?>">
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-lg <?= $iconBg; ?> text-white flex items-center justify-center text-base shrink-0 mt-0.5">
                            <i class="fa-solid <?= $iconFa; ?>"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold"><?= esc(session()->getFlashdata('notif_title') ?? 'Notifikasi Sistem'); ?></h4>
                            <p class="text-xs mt-0.5"><?= esc(session()->getFlashdata('notif_msg')); ?></p>
                        </div>
                    </div>
                    <button type="button" onclick="document.getElementById('flashUserAlert').remove()" class="text-slate-400 hover:text-slate-600 p-1 cursor-pointer">
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
                
                <!-- Table Controls Bar -->
                <div class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3">
                    
                    <!-- Search Input -->
                    <div class="relative flex-1 max-w-md">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-magnifying-glass text-xs"></i>
                        </div>
                        <input type="text" id="userSearchInput" onkeyup="filterUserTable()"
                               placeholder="Cari user (nama, username, role)..." 
                               class="w-full pl-9 pr-8 py-2 text-xs border border-slate-300 rounded-xl bg-white text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand transition">
                    </div>

                    <!-- Filter Role Dropdown -->
                    <div class="flex items-center gap-2.5 shrink-0">
                        <select id="userFilterRole" onchange="filterUserTable()" 
                                class="px-3 py-2 text-xs border border-slate-300 rounded-xl bg-white text-slate-700 font-medium focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand transition">
                            <option value="">Semua Role</option>
                            <option value="admin">Administrator</option>
                            <option value="instruktur">Instruktur</option>
                            <option value="siswa">Siswa / Santri</option>
                            <option value="wali_santri">Wali Santri</option>
                        </select>

                        <!-- Add User Button -->
                        <a href="<?= base_url('admin/users/add'); ?>" 
                           class="bg-brand hover:bg-brand-dark text-white text-xs font-semibold px-4 py-2 rounded-xl shadow-sm shadow-brand/20 flex items-center gap-2 transition shrink-0 cursor-pointer">
                            <i class="fa-solid fa-user-plus"></i> Tambah User Baru
                        </a>
                    </div>
                </div>

                <!-- Users Table -->
                <div class="overflow-x-auto rounded-xl border border-slate-200">
                    <table class="w-full text-left border-collapse" id="userMainTable">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold text-slate-700 uppercase tracking-wider">
                                <th class="py-3 px-3 border-r border-slate-200 w-12 text-center">ID</th>
                                <th class="py-3 px-3 border-r border-slate-200">Pengguna</th>
                                <th class="py-3 px-3 border-r border-slate-200">Username</th>
                                <th class="py-3 px-3 border-r border-slate-200 text-center">Role</th>
                                <th class="py-3 px-3 border-r border-slate-200">Tautan Santri</th>
                                <th class="py-3 px-3 border-r border-slate-200 text-center w-24">Status</th>
                                <th class="py-3 px-3 text-center w-36">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-slate-200" id="userTableBody">
                            <?php foreach ($users as $index => $u): ?>
                            <?php
                                $isSelf = ((int)$u['id'] === (int)session()->get('user_id'));
                                $roleBadge = [
                                    'admin'       => 'bg-blue-50 text-[#0066CC] border-blue-200',
                                    'instruktur'  => 'bg-purple-50 text-purple-700 border-purple-200',
                                    'siswa'       => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'wali_santri' => 'bg-amber-50 text-amber-800 border-amber-200',
                                ][$u['role']] ?? 'bg-slate-50 text-slate-700 border-slate-200';

                                $roleLabel = [
                                    'admin'       => 'Administrator',
                                    'instruktur'  => 'Instruktur',
                                    'siswa'       => 'Siswa / Santri',
                                    'wali_santri' => 'Wali Santri',
                                ][$u['role']] ?? ucfirst($u['role']);

                                $roleIcon = [
                                    'admin'       => 'fa-solid fa-user-shield',
                                    'instruktur'  => 'fa-solid fa-chalkboard-user',
                                    'siswa'       => 'fa-solid fa-user-graduate',
                                    'wali_santri' => 'fa-solid fa-hands-holding-child',
                                ][$u['role']] ?? 'fa-solid fa-user';
                            ?>
                            <tr class="user-row <?= $index % 2 === 1 ? 'bg-slate-50/60' : 'bg-white'; ?> hover:bg-brand-light/30 transition">
                                <td class="py-3 px-3 border-r border-slate-200 font-mono text-xs font-semibold text-slate-500 text-center col-user-id">
                                    <?= esc($u['id']); ?>
                                </td>
                                
                                <td class="py-3 px-3 border-r border-slate-200 col-user-name">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-full bg-slate-100 border border-slate-200 text-brand font-bold text-xs flex items-center justify-center shrink-0">
                                            <?= strtoupper(mb_substr($u['nama'] ?? 'U', 0, 1)); ?>
                                        </div>
                                        <div class="leading-tight">
                                            <p class="font-bold text-slate-800 text-xs sm:text-sm">
                                                <?= esc($u['nama']); ?>
                                                <?php if ($isSelf): ?>
                                                    <span class="ml-1 text-3xs font-extrabold px-1.5 py-0.5 rounded bg-blue-100 text-blue-800 border border-blue-200">Anda</span>
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="py-3 px-3 border-r border-slate-200 font-mono text-xs text-slate-700 font-semibold col-user-username">
                                    <span class="text-slate-400">@</span><?= esc($u['username']); ?>
                                </td>

                                <td class="py-3 px-3 border-r border-slate-200 text-center col-user-role" data-role="<?= esc($u['role']); ?>">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-3xs font-bold border <?= $roleBadge; ?>">
                                        <i class="<?= $roleIcon; ?> text-2xs"></i> <?= $roleLabel; ?>
                                    </span>
                                </td>

                                <td class="py-3 px-3 border-r border-slate-200 text-xs">
                                    <?php if (!empty($u['santri_nama'])): ?>
                                        <div class="leading-tight">
                                            <span class="font-semibold text-slate-800 block truncate"><?= esc($u['santri_nama']); ?></span>
                                            <span class="text-3xs text-slate-500 font-mono">NIS: <?= esc($u['santri_nis'] ?? '-'); ?> • <?= esc($u['santri_kelas'] ?? '-'); ?></span>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-3xs text-slate-400 italic">Tidak ditautkan</span>
                                    <?php endif; ?>
                                </td>

                                <td class="py-3 px-3 border-r border-slate-200 text-center">
                                    <?php if (!empty($u['is_active'])): ?>
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-3xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-3xs font-bold bg-slate-100 text-slate-600 border border-slate-300">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Nonaktif
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td class="py-3 px-3 text-center whitespace-nowrap">
                                    <!-- Toggle Status Button -->
                                    <?php if (!$isSelf): ?>
                                        <form action="<?= base_url('admin/users/toggle/' . urlencode($u['id'])); ?>" method="post" class="inline">
                                            <?= csrf_field(); ?>
                                            <button type="submit" 
                                                    title="<?= $u['is_active'] ? 'Nonaktifkan Akun' : 'Aktifkan Akun'; ?>"
                                                    class="p-1.5 rounded-lg border text-xs font-semibold mr-1 transition cursor-pointer <?= $u['is_active'] ? 'border-amber-200 text-amber-700 hover:bg-amber-50' : 'border-emerald-200 text-emerald-700 hover:bg-emerald-50'; ?>">
                                                <i class="fa-solid <?= $u['is_active'] ? 'fa-user-slash' : 'fa-user-check'; ?>"></i>
                                            </button>
                                        </form>

                                        <!-- Delete Button -->
                                        <form action="<?= base_url('admin/users/delete/' . urlencode($u['id'])); ?>" method="post" class="inline">
                                            <?= csrf_field(); ?>
                                            <button type="submit" onclick="return confirm('Hapus permanen akun user <?= esc($u['nama']); ?> (@<?= esc($u['username']); ?>)?')"
                                                    title="Hapus Akun Pengguna"
                                                    class="p-1.5 rounded-lg border border-rose-200 text-rose-700 hover:bg-rose-50 text-xs font-semibold transition cursor-pointer">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <span class="text-3xs text-slate-400 italic">Akun aktif Anda</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </main>
</div>

<script>
function filterUserTable() {
    const searchVal = document.getElementById('userSearchInput').value.trim().toLowerCase();
    const roleVal = document.getElementById('userFilterRole').value.trim().toLowerCase();
    const rows = document.querySelectorAll('.user-row');

    rows.forEach(row => {
        const nameText = row.querySelector('.col-user-name')?.textContent.toLowerCase() || '';
        const userText = row.querySelector('.col-user-username')?.textContent.toLowerCase() || '';
        const roleData = row.querySelector('.col-user-role')?.getAttribute('data-role')?.toLowerCase() || '';

        const matchSearch = searchVal === '' || nameText.includes(searchVal) || userText.includes(searchVal);
        const matchRole = roleVal === '' || roleData === roleVal;

        if (matchSearch && matchRole) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script>
</body>
</html>
