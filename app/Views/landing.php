<!DOCTYPE html>
<html lang="id" class="scroll-smooth scroll-pt-6">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <title><?= esc($title ?? 'Syiar Gemilang – Satu NIS untuk semua urusan akademik'); ?></title>
  
  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico'); ?>">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,500;12..96,700;12..96,800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
  
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            blue: '#007ACE',
            deep: '#04243F',
            ink: '#0C1F31',
            muted: '#5A6D7F',
            line: '#DDE6EE',
            soft: '#EEF5FB',
            pencil: '#FFD23F',
          },
          fontFamily: {
            disp: ['"Bricolage Grotesque"', 'system-ui', 'sans-serif'],
            sans: ['"DM Sans"', 'system-ui', 'sans-serif'],
          },
          keyframes: {
            swing: {
              '0%': { transform: 'rotate(-9deg) translateY(-30px)', opacity: '0' },
              '30%': { opacity: '1' },
              '55%': { transform: 'rotate(4deg)' },
              '80%': { transform: 'rotate(-2deg)' },
              '100%': { transform: 'rotate(-1.5deg)' },
            }
          },
          animation: {
            swing: 'swing 1.6s cubic-bezier(0.2, 0.7, 0.2, 1) both',
          }
        }
      }
    }
  </script>

  <style>
    :root {
      padding-top: env(safe-area-inset-top, 0px);
      padding-bottom: env(safe-area-inset-bottom, 0px);
    }
    :focus-visible {
      outline: 3px solid #FFD23F;
      outline-offset: 3px;
      border-radius: 6px;
    }
    /* Scroll Reveal helper */
    .reveal {
      opacity: 0;
      transform: translateY(24px);
      transition: opacity 0.7s cubic-bezier(0.2, 0.8, 0.2, 1), transform 0.7s cubic-bezier(0.2, 0.8, 0.2, 1);
    }
    .reveal.in {
      opacity: 1;
      transform: none;
    }
    /* Banner Accordion expansion via grid */
    .prog-banner {
      display: grid;
      grid-template-rows: 0fr;
      transition: grid-template-rows 0.52s cubic-bezier(0.22, 1, 0.36, 1);
    }
    .prog-item.open .prog-banner {
      grid-template-rows: 1fr;
    }
    /* Banner image clip-path transition */
    .prog-item.open .banner-media {
      clip-path: inset(0 0 0% 0 round 20px) !important;
      opacity: 1 !important;
      transform: translateY(0) scale(1) !important;
    }
    .prog-item.open .banner-media img {
      transform: scale(1) !important;
    }
    .prog-item.open .banner-body {
      opacity: 1 !important;
      transform: translateY(0) !important;
    }
    .prog-item.open .prog-btn {
      background-color: #007ACE !important;
      color: #fff !important;
      padding-left: 32px !important;
    }
    .prog-item.open .prog-btn span {
      color: rgba(255, 255, 255, 0.92) !important;
    }
    .prog-item.open .prog-btn svg.chevron-icon {
      transform: rotate(90deg);
    }
    @media (prefers-reduced-motion: reduce) {
      .reveal, .banner-body, .banner-media {
        opacity: 1 !important;
        transform: none !important;
        clip-path: none !important;
        transition: none !important;
      }
      .lan { animation: none !important; transform: rotate(-1.5deg) !important; }
    }
  </style>
</head>
<body class="bg-white text-ink font-sans leading-[1.65] antialiased m-0 selection:bg-pencil selection:text-deep">

  <!-- SVG Symbols Definition -->
  <svg width="0" height="0" class="absolute hidden" aria-hidden="true">
    <symbol id="cap" viewBox="0 0 24 24"><path d="M2 9l10-5 10 5-10 5z"/><path d="M6 11v5c0 1.5 3 3 6 3s6-1.5 6-3v-5"/></symbol>
    <symbol id="clip" viewBox="0 0 24 24"><path d="M9 4h6v3H9z"/><path d="M7 5H5v15h14V5h-2"/><path d="M9 13l2 2 4-4"/></symbol>
    <symbol id="chart" viewBox="0 0 24 24"><path d="M4 19V5M4 19h16"/><path d="M8 15l3-4 3 2 5-6"/></symbol>
    <symbol id="cal" viewBox="0 0 24 24"><path d="M4 6h16v14H4zM4 10h16M8 3v4M16 3v4"/></symbol>
    <symbol id="users" viewBox="0 0 24 24"><path d="M9 11a3 3 0 100-6 3 3 0 000 6z"/><path d="M3 20c0-3 3-5 6-5s6 2 6 5"/><path d="M17 11a2.5 2.5 0 100-5M17 15c2.5 0 4 1.5 4 4"/></symbol>
    <symbol id="arr" viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></symbol>
    <symbol id="pin" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></symbol>
    <symbol id="eye" viewBox="0 0 24 24"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></symbol>
    <symbol id="eye-off" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24M1 1l22 22"/></symbol>
  </svg>

  <!-- Hero Section -->
  <div class="relative bg-blue text-white overflow-hidden pt-[env(safe-area-inset-top,0px)] after:content-[''] after:absolute after:inset-x-0 after:bottom-0 after:h-[180px] after:bg-gradient-to-t after:from-deep/35 after:to-transparent after:pointer-events-none after:z-[1]" id="beranda">
    <canvas id="gridCanvas" class="absolute inset-0 w-full h-full pointer-events-none z-0"></canvas>
    
    <div class="max-w-[1180px] mx-auto px-6">
      <!-- Navbar -->
      <div class="flex justify-between items-center h-[84px] relative z-[3]">
        <a class="group flex items-center gap-3 font-disp font-bold text-[20px] tracking-[-0.01em]" href="<?= base_url('/'); ?>">
          <span class="w-10 h-10 rounded-full bg-white text-blue grid place-items-center transition-transform duration-300 ease-[cubic-bezier(0.2,0.8,0.2,1)] group-hover:-rotate-12 group-hover:scale-110 shadow-sm">
            <svg class="w-[22px] h-[22px] fill-none stroke-current stroke-[1.7] [stroke-linecap:round] [stroke-linejoin:round] flex-none"><use href="#cap"/></svg>
          </span>
          Syiar Gemilang
        </a>
        <nav class="hidden md:flex items-center gap-7 text-[15px] font-medium" aria-label="Utama">
          <a href="#fitur" class="opacity-85 hover:opacity-100 hover:underline hover:underline-offset-[6px] transition-opacity duration-200">Fitur portal</a>
          <a href="#pengumuman" class="opacity-85 hover:opacity-100 hover:underline hover:underline-offset-[6px] transition-opacity duration-200">Papan pengumuman</a>
          <a href="#program" class="opacity-85 hover:opacity-100 hover:underline hover:underline-offset-[6px] transition-opacity duration-200">Program keahlian</a>
          <a href="#kontak" class="opacity-85 hover:opacity-100 hover:underline hover:underline-offset-[6px] transition-opacity duration-200">Kontak</a>
          <a href="<?= base_url('login'); ?>" class="inline-flex items-center gap-1.5 py-2 px-4 rounded-xl bg-white/15 hover:bg-white/25 text-white transition-all duration-200 text-sm font-semibold border border-white/20">
            Halaman Login
            <svg class="w-4 h-4 fill-none stroke-current stroke-[1.7] [stroke-linecap:round] [stroke-linejoin:round]"><use href="#arr"/></svg>
          </a>
        </nav>
      </div>

      <!-- Hero Grid -->
      <div class="relative z-[2] grid grid-cols-1 lg:grid-cols-[1.15fr_0.85fr] gap-12 items-center pt-8 md:pt-14 pb-20 md:pb-[120px]">
        <div>
          <h1 class="font-disp font-extrabold text-[clamp(46px,7.2vw,98px)] leading-[1.06] tracking-[-0.025em]">
            Satu NIS untuk <span class="inline bg-gradient-to-b from-transparent from-[62%] via-pencil via-[62%] to-transparent to-[92%] text-deep [box-decoration-break:clone] [-webkit-box-decoration-break:clone]">semua urusan</span> akademik.
          </h1>
          <p class="max-w-[46ch] text-[19px] mt-7 text-white/90">Nilai, absensi, jadwal kelas, dan materi belajar santri Rumah Gemilang Indonesia, dalam satu portal yang bisa dibuka kapan saja.</p>
        </div>

        <!-- 3D Interactive Card Container -->
        <div class="lan flex justify-center [perspective:1000px] [transform-origin:50%_-40px] animate-swing mt-2 lg:mt-0" id="cardWrap">
          <div class="w-full max-w-[380px] bg-white text-ink rounded-[24px] shadow-[0_40px_70px_-25px_rgba(0,20,40,0.55)] overflow-hidden relative [transform-style:preserve-3d] transition-[transform] duration-[0.12s] ease-out shadow-2xl before:content-[''] before:absolute before:top-3 before:left-1/2 before:w-16 before:h-2.5 before:-ml-8 before:rounded-[9px] before:bg-soft before:shadow-[inset_0_1px_2px_rgba(0,0,0,0.18)] before:z-[2]" id="idCard">
            
            <div class="id-glare absolute inset-0 pointer-events-none opacity-0 transition-opacity duration-200 z-[3] mix-blend-overlay" id="idGlare"></div>

            <div class="bg-deep text-white pt-[38px] px-6 pb-[18px] flex items-center gap-3">
              <span class="w-[34px] h-[34px] rounded-full bg-white text-blue grid place-items-center">
                <svg class="w-[18px] h-[18px] fill-none stroke-current stroke-[1.7] [stroke-linecap:round] [stroke-linejoin:round] flex-none"><use href="#cap"/></svg>
              </span>
              <div>
                <b class="font-disp font-bold text-base leading-tight">Kartu Santri</b>
                <small class="block text-xs opacity-70">Rumah Gemilang Indonesia</small>
              </div>
            </div>

            <div class="pt-5 px-6 pb-0 flex gap-4 items-center">
              <div class="w-[68px] h-[80px] rounded-[14px] bg-soft text-blue grid place-items-center font-disp font-extrabold text-2xl transition-[background-color,color] duration-200" id="cardAvatar" aria-hidden="true">SG</div>
              <dl class="m-0 text-[13.5px]">
                <dt class="text-muted text-xs">Nama</dt>
                <dd class="m-0 mb-1.5 font-semibold transition-colors duration-200" id="cardName">Santri Gemilang</dd>
                <dt class="text-muted text-xs">Nomor Induk Santri</dt>
                <dd class="m-0 mb-1.5 font-semibold transition-colors duration-200" id="cardNis">Masukkan NIS di bawah</dd>
              </dl>
            </div>

            <!-- Login Form (POST ke /login, jika salah atau tidak lengkap dilempar ke /login) -->
            <form id="f" action="<?= base_url('login'); ?>" method="POST" novalidate class="pt-[18px] px-6 pb-6">
              <?= csrf_field(); ?>

              <label for="nis" class="block text-[13px] font-semibold mt-3 mb-1.5">NIS atau username</label>
              <input id="nis" name="username" type="text" autocomplete="username" value="<?= esc(old('username')); ?>" placeholder="Contoh: 2024001 atau username" class="w-full h-[46px] border-[1.5px] border-line rounded-xl px-3.5 font-sans font-medium text-[15px] text-ink bg-white transition-[border-color,box-shadow] duration-200 focus:outline-none focus:border-blue focus:ring-4 focus:ring-blue/15">
              
              <label for="pw" class="block text-[13px] font-semibold mt-3 mb-1.5">Kata sandi</label>
              <div class="relative flex items-center">
                <input id="pw" name="password" type="password" autocomplete="current-password" placeholder="Kata sandi" class="w-full h-[46px] border-[1.5px] border-line rounded-xl pl-3.5 pr-11 font-sans font-medium text-[15px] text-ink bg-white transition-[border-color,box-shadow] duration-200 focus:outline-none focus:border-blue focus:ring-4 focus:ring-blue/15">
                <button type="button" class="absolute right-2.5 bg-transparent border-0 text-muted cursor-pointer p-1.5 grid place-items-center rounded-lg hover:text-blue hover:bg-soft transition-[color,background-color] duration-200" id="togglePw" aria-label="Tampilkan kata sandi">
                  <svg class="w-[18px] h-[18px] fill-none stroke-current stroke-[1.7] [stroke-linecap:round] [stroke-linejoin:round] flex-none"><use href="#eye"/></svg>
                </button>
              </div>

              <button id="submitBtn" class="mt-[18px] w-full h-[50px] border-0 rounded-xl bg-blue text-white font-sans font-semibold text-base cursor-pointer flex items-center justify-center gap-2.5 transition-[background-color,transform] duration-200 hover:bg-[#0067AE] hover:-translate-y-px active:translate-y-0 disabled:opacity-75 disabled:cursor-wait" type="submit">
                <span id="submitLabel">Masuk</span> 
                <svg id="submitIcon" class="w-[22px] h-[22px] fill-none stroke-current stroke-[1.7] [stroke-linecap:round] [stroke-linejoin:round] flex-none"><use href="#arr"/></svg>
              </button>
              <p id="msg" role="status" class="min-h-[20px] mt-2.5 mb-0 text-[12.5px] text-muted"></p>
            </form>

          </div>
        </div>
      </div>

      <!-- Quick Facts -->
      <div class="relative z-[2] flex flex-wrap gap-x-12 gap-y-3 pb-8 text-[15px] text-white/90">
        <span><b class="count font-disp font-bold text-[22px] text-white mr-2" data-target="2500" data-suffix="+">2.500+</b>santri dan alumni</span>
        <span><b class="count font-disp font-bold text-[22px] text-white mr-2" data-target="8" data-suffix="">8</b>program keahlian</span>
        <span><b class="font-disp font-bold text-[22px] text-white mr-2">24/7</b>akses portal</span>
      </div>
    </div>
  </div>

  <main>
    <!-- Feature Section -->
    <section id="fitur" class="py-[72px] md:py-[112px]">
      <div class="max-w-[1180px] mx-auto px-6 grid grid-cols-1 md:grid-cols-[0.8fr_1.2fr] gap-7 md:gap-16 items-start">
        <h2 class="reveal font-disp font-bold text-[clamp(34px,4.4vw,56px)] leading-[1.06] tracking-[-0.025em] static md:sticky md:top-8">Yang bisa Anda lakukan di portal</h2>
        
        <div>
          <div class="fr reveal group flex gap-5 md:gap-5.5 py-7 px-4 -mx-4 border-t border-line rounded-2xl transition-[background-color,transform] duration-250 hover:bg-soft hover:translate-x-1.5">
            <span class="w-[54px] h-[54px] rounded-2xl bg-soft text-blue grid place-items-center transition-[background-color,color,transform] duration-250 group-hover:bg-blue group-hover:text-white group-hover:scale-105 flex-none">
              <svg class="w-[22px] h-[22px] fill-none stroke-current stroke-[1.7] [stroke-linecap:round] [stroke-linejoin:round]"><use href="#clip"/></svg>
            </span>
            <div>
              <h3 class="font-disp font-bold text-2xl tracking-[-0.015em] mb-1.5 leading-tight">Cek absensi</h3>
              <p class="m-0 text-muted max-w-[46ch]">Kehadiran harian tercatat langsung di setiap sesi kelas dan kegiatan pembinaan.</p>
            </div>
          </div>

          <div class="fr reveal group flex gap-5 md:gap-5.5 py-7 px-4 -mx-4 border-t border-line rounded-2xl transition-[background-color,transform] duration-250 hover:bg-soft hover:translate-x-1.5">
            <span class="w-[54px] h-[54px] rounded-2xl bg-soft text-blue grid place-items-center transition-[background-color,color,transform] duration-250 group-hover:bg-blue group-hover:text-white group-hover:scale-105 flex-none">
              <svg class="w-[22px] h-[22px] fill-none stroke-current stroke-[1.7] [stroke-linecap:round] [stroke-linejoin:round]"><use href="#chart"/></svg>
            </span>
            <div>
              <h3 class="font-disp font-bold text-2xl tracking-[-0.015em] mb-1.5 leading-tight">Pantau nilai</h3>
              <p class="m-0 text-muted max-w-[46ch]">Nilai tugas, ujian praktik, dan rapor akhir bisa dilihat kapan saja.</p>
            </div>
          </div>

          <div class="fr reveal group flex gap-5 md:gap-5.5 py-7 px-4 -mx-4 border-t border-line rounded-2xl transition-[background-color,transform] duration-250 hover:bg-soft hover:translate-x-1.5">
            <span class="w-[54px] h-[54px] rounded-2xl bg-soft text-blue grid place-items-center transition-[background-color,color,transform] duration-250 group-hover:bg-blue group-hover:text-white group-hover:scale-105 flex-none">
              <svg class="w-[22px] h-[22px] fill-none stroke-current stroke-[1.7] [stroke-linecap:round] [stroke-linejoin:round]"><use href="#cal"/></svg>
            </span>
            <div>
              <h3 class="font-disp font-bold text-2xl tracking-[-0.015em] mb-1.5 leading-tight">Lihat jadwal dan unduh materi</h3>
              <p class="m-0 text-muted max-w-[46ch]">Jadwal, ruangan, instruktur pengampu, dan modul belajar ada di satu tempat.</p>
            </div>
          </div>

          <div class="fr reveal group flex gap-5 md:gap-5.5 py-7 px-4 -mx-4 border-t border-b border-line rounded-2xl transition-[background-color,transform] duration-250 hover:bg-soft hover:translate-x-1.5">
            <span class="w-[54px] h-[54px] rounded-2xl bg-soft text-blue grid place-items-center transition-[background-color,color,transform] duration-250 group-hover:bg-blue group-hover:text-white group-hover:scale-105 flex-none">
              <svg class="w-[22px] h-[22px] fill-none stroke-current stroke-[1.7] [stroke-linecap:round] [stroke-linejoin:round]"><use href="#users"/></svg>
            </span>
            <div>
              <h3 class="font-disp font-bold text-2xl tracking-[-0.015em] mb-1.5 leading-tight">Kelola data santri</h3>
              <p class="m-0 text-muted max-w-[46ch]">Nomor Induk Santri, profil angkatan, hingga riwayat kelulusan tersimpan rapi.</p>
            </div>
          </div>
        </div>

      </div>
    </section>

    <!-- Papan Pengumuman Diklat Section -->
    <section class="py-[72px] md:py-[104px] bg-[#F8FAFC] border-t border-line relative overflow-hidden" id="pengumuman">
      <div class="max-w-[1180px] mx-auto px-6 relative z-10">
        
        <!-- Header Section -->
        <div class="reveal flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10 pb-6 border-b border-line">
          <div>
            <div class="inline-flex items-center gap-2 py-1.5 px-3.5 rounded-full bg-pencil/20 text-deep border border-pencil/50 text-[12.5px] font-bold tracking-wide uppercase mb-3">
              <svg class="w-4 h-4 fill-none stroke-current stroke-[1.8]"><use href="#pin"/></svg>
              Papan Pengumuman Diklat RGI
            </div>
            <h2 class="font-disp font-bold text-[clamp(32px,4vw,52px)] leading-[1.08] tracking-[-0.025em] text-deep">
              Informasi & Agenda Pekan Ini
            </h2>
            <p class="m-0 mt-3 text-muted max-w-[56ch] text-[15.5px] leading-relaxed">
              Pengumuman resmi kedinasan, agenda pembinaan karakter, hingga kegiatan santri Rumah Gemilang Indonesia. Diperbarui secara berkala oleh manajemen diklat setiap pekan.
            </p>
          </div>

          <!-- Category Filter Tabs (Interactive) -->
          <div class="flex flex-wrap items-center gap-2 bg-white p-1.5 rounded-2xl border border-line shadow-xs">
            <button type="button" class="ann-filter-btn active py-2 px-3.5 rounded-xl text-[13px] font-semibold transition-all duration-200 bg-blue text-white shadow-xs cursor-pointer" data-filter="all">
              Semua (<?= count($announcements ?? []); ?>)
            </button>
            <button type="button" class="ann-filter-btn py-2 px-3.5 rounded-xl text-[13px] font-semibold text-muted hover:text-ink hover:bg-soft transition-all duration-200 cursor-pointer" data-filter="resmi">
              Acara Resmi
            </button>
            <button type="button" class="ann-filter-btn py-2 px-3.5 rounded-xl text-[13px] font-semibold text-muted hover:text-ink hover:bg-soft transition-all duration-200 cursor-pointer" data-filter="tidak_resmi">
              Kegiatan Santri
            </button>
            <button type="button" class="ann-filter-btn py-2 px-3.5 rounded-xl text-[13px] font-semibold text-muted hover:text-ink hover:bg-soft transition-all duration-200 cursor-pointer" data-filter="agenda">
              Agenda Diklat
            </button>
          </div>
        </div>

        <!-- Announcement Grid -->
        <?php if (empty($announcements)) : ?>
          <div class="reveal bg-white rounded-3xl p-12 text-center border border-line shadow-sm max-w-xl mx-auto">
            <span class="w-16 h-16 rounded-2xl bg-soft text-blue grid place-items-center mx-auto mb-4 text-2xl">
              <svg class="w-7 h-7 fill-none stroke-current stroke-[1.7]"><use href="#clip"/></svg>
            </span>
            <h3 class="font-disp font-bold text-xl text-deep mb-2">Belum Ada Pengumuman Baru Pekan Ini</h3>
            <p class="text-muted text-[14.5px] leading-relaxed">Agenda dan pengumuman kegiatan diklat akan diperbarui oleh admin secara berkala.</p>
          </div>
        <?php else : ?>
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="announcementGrid">
            <?php foreach ($announcements as $ann) : ?>
              <?php 
                $kategoriMap = [
                  'resmi'       => ['badge' => 'bg-deep text-white border-deep', 'label' => 'Acara Resmi', 'dot' => 'bg-pencil'],
                  'tidak_resmi' => ['badge' => 'bg-pencil text-deep border-pencil font-bold', 'label' => 'Kegiatan Santri', 'dot' => 'bg-deep'],
                  'agenda'      => ['badge' => 'bg-[#007ACE] text-white border-blue', 'label' => 'Agenda Diklat', 'dot' => 'bg-white'],
                ][$ann['kategori']] ?? ['badge' => 'bg-soft text-blue border-line', 'label' => 'Pengumuman', 'dot' => 'bg-blue'];
              ?>
              <div class="ann-card reveal flex flex-col justify-between bg-white rounded-[22px] p-6 border border-line shadow-[0_10px_30px_-15px_rgba(4,36,63,0.07)] hover:shadow-[0_20px_40px_-15px_rgba(4,36,63,0.14)] hover:-translate-y-1 transition-all duration-300 relative group"
                   data-cat="<?= esc($ann['kategori']); ?>">
                
                <div>
                  <!-- Card Header: Badges & Pinned Icon -->
                  <div class="flex items-center justify-between gap-3 mb-4">
                    <div class="flex items-center gap-2 flex-wrap">
                      <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-[11.5px] font-semibold border <?= $kategoriMap['badge']; ?>">
                        <span class="w-1.5 h-1.5 rounded-full <?= $kategoriMap['dot']; ?>"></span>
                        <?= $kategoriMap['label']; ?>
                      </span>
                      <span class="inline-flex items-center py-1 px-2.5 rounded-full text-[11px] font-medium bg-soft text-muted">
                        <?= esc($ann['pekan_ke'] ?: 'Pekan Ini'); ?>
                      </span>
                    </div>

                    <?php if (!empty($ann['is_pinned'])) : ?>
                      <span class="w-7 h-7 rounded-full bg-pencil/30 text-deep grid place-items-center shrink-0" title="Pengumuman Penting Disematkan">
                        <svg class="w-3.5 h-3.5 fill-none stroke-current stroke-2"><use href="#pin"/></svg>
                      </span>
                    <?php endif; ?>
                  </div>

                  <!-- Judul -->
                  <h3 class="font-disp font-bold text-xl text-deep group-hover:text-blue transition-colors duration-200 leading-snug mb-3">
                    <?= esc($ann['judul']); ?>
                  </h3>

                  <!-- Metadata: Tanggal & Lokasi -->
                  <div class="space-y-1.5 mb-4 text-[13px] text-muted">
                    <?php if (!empty($ann['tanggal_kegiatan'])) : ?>
                      <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 fill-none stroke-current stroke-[1.7] text-blue flex-none"><use href="#cal"/></svg>
                        <span><?= date('d M Y', strtotime($ann['tanggal_kegiatan'])); ?><?= !empty($ann['waktu_kegiatan']) ? ' &bull; ' . esc($ann['waktu_kegiatan']) : ''; ?></span>
                      </div>
                    <?php endif; ?>

                    <div class="flex items-center gap-2">
                      <svg class="w-4 h-4 fill-none stroke-current stroke-[1.7] text-pencil flex-none"><use href="#pin"/></svg>
                      <span class="truncate"><?= esc($ann['lokasi'] ?: 'Kampus Diklat RGI Depok'); ?></span>
                    </div>
                  </div>

                  <!-- Isi / Deskripsi -->
                  <p class="text-[14px] text-muted leading-relaxed m-0 border-t border-line/70 pt-3">
                    <?= nl2br(esc($ann['isi'])); ?>
                  </p>
                </div>

                <!-- Footer Card: Penyelenggara -->
                <div class="mt-5 pt-3 border-t border-line flex items-center justify-between text-[12px] text-muted">
                  <span class="inline-flex items-center gap-1.5 font-medium">
                    <svg class="w-3.5 h-3.5 fill-none stroke-current stroke-[1.7]"><use href="#users"/></svg>
                    <?= esc($ann['penyelenggara'] ?: 'Diklat RGI'); ?>
                  </span>
                  <a href="#kontak" class="text-blue font-semibold group-hover:translate-x-0.5 transition-transform duration-200 inline-flex items-center gap-1">
                    Informasi <svg class="w-3.5 h-3.5 fill-none stroke-current stroke-2"><use href="#arr"/></svg>
                  </a>
                </div>

              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

      </div>
    </section>

    <!-- Program Keahlian Section -->
    <section class="prog bg-soft py-[72px] md:py-[112px]" id="program">
      <div class="max-w-[1180px] mx-auto px-6">
        <div class="ph2 reveal flex justify-between items-end gap-6 flex-wrap mb-10">
          <h2 class="font-disp font-bold text-[clamp(34px,4.4vw,56px)] leading-[1.06] tracking-[-0.025em]">Program keahlian</h2>
          <p class="m-0 text-muted max-w-[36ch]">Delapan jurusan, tersedia di beberapa kota. Klik jurusan untuk membuka banner informasi.</p>
        </div>

        <div class="list reveal" id="progList">

          <!-- Item 1: Tata Busana -->
          <div class="prog-item border-t border-[#C9DAE8]">
            <button class="prog-btn w-full bg-transparent border-0 text-left font-inherit text-inherit flex flex-col md:flex-row md:items-center justify-between gap-1.5 md:gap-5 py-5 md:py-[22px] px-5 cursor-pointer transition-[background-color,color,padding-left] duration-300 ease-[cubic-bezier(0.22,1,0.36,1)] hover:bg-blue hover:text-white hover:pl-8 group" type="button" aria-expanded="false">
              <h3 class="font-disp font-bold text-[clamp(24px,3.4vw,40px)] leading-[1.1] tracking-[-0.02em]">Tata Busana</h3>
              <span class="text-[14.5px] text-muted flex items-center gap-3.5 whitespace-nowrap transition-colors duration-250 group-hover:text-white/90">
                Depok, Surabaya 
                <svg class="chevron-icon w-[22px] h-[22px] fill-none stroke-current stroke-[1.7] [stroke-linecap:round] [stroke-linejoin:round] hidden md:block transition-transform duration-400 ease-[cubic-bezier(0.22,1,0.36,1)]"><use href="#arr"/></svg>
              </span>
            </button>
            <div class="prog-banner bg-white shadow-[inset_0_8px_24px_-12px_rgba(4,36,63,0.16)]" role="region" aria-label="Detail jurusan Tata Busana">
              <div class="prog-inner overflow-hidden">
                <div class="banner-card grid grid-cols-1 lg:grid-cols-[1.15fr_0.85fr] gap-6 md:gap-9 items-center p-6 md:p-9 border-t border-line bg-gradient-to-br from-white to-[#F7FBFF]">
                  <div class="banner-body opacity-0 -translate-y-3.5 transition-[opacity,transform] duration-450 ease-[cubic-bezier(0.22,1,0.36,1)]">
                    <div class="banner-meta flex flex-wrap items-center gap-2.5 mb-3.5">
                      <span class="loc-badge inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full bg-pencil text-deep font-sans font-bold text-[12.5px] tracking-wide">
                        <svg class="w-[15px] h-[15px] fill-none stroke-current stroke-[1.7] [stroke-linecap:round] [stroke-linejoin:round]"><use href="#pin"/></svg> Depok, Surabaya
                      </span>
                      <span class="tag-pill inline-flex items-center py-1.5 px-3 rounded-full bg-soft text-blue font-sans font-semibold text-[12.5px]">6 Bulan Intensif • Praktik Studio Jahit</span>
                    </div>
                    <h4 class="font-disp font-extrabold text-[clamp(26px,3vw,36px)] text-deep mb-3 leading-tight">Tata Busana</h4>
                    <p class="m-0 mb-6 text-muted text-[15.5px] leading-[1.65] max-w-[54ch]">Pelatihan menjahit profesional, pembuatan pola busana muslim dan kasual, pemilihan karakter tekstil, hingga manajemen produksi dan usaha butik mandiri.</p>
                    <div class="banner-actions flex flex-wrap items-center gap-3">
                      <a href="#beranda" class="prog-cta inline-flex items-center gap-2 py-3 px-5 rounded-xl bg-blue text-white font-sans font-semibold text-[14.5px] transition-[background-color,transform] duration-200 hover:bg-[#0067AE] hover:-translate-y-0.5" data-jurusan="Tata Busana">
                        Login santri jurusan ini <svg class="w-4 h-4 fill-none stroke-current stroke-[1.7] [stroke-linecap:round] [stroke-linejoin:round]"><use href="#arr"/></svg>
                      </a>
                      <!-- <button type="button" class="banner-close bg-transparent border-[1.5px] border-line text-muted py-2.5 px-4 rounded-xl font-sans font-semibold text-sm cursor-pointer transition-[border-color,color,background-color] duration-200 hover:border-ink hover:text-ink hover:bg-white">Tutup banner</button> -->
                    </div>
                  </div>
                  <div class="banner-media order-first lg:order-none relative rounded-[20px] overflow-hidden aspect-[16/10] bg-deep shadow-[0_24px_48px_-18px_rgba(4,36,63,0.35)] opacity-0 -translate-y-3 scale-95 [clip-path:inset(0_0_100%_0_round_20px)] transition-[clip-path,opacity,transform] duration-500 ease-[cubic-bezier(0.22,1,0.36,1)]">
                    <img src="<?= base_url('assets/img/tatabusana.jpg'); ?>" alt="Suasana praktik jurusan Tata Busana di Depok, Surabaya" loading="lazy" class="w-full h-full object-cover block scale-110 transition-transform duration-700 ease-[cubic-bezier(0.22,1,0.36,1)] hover:scale-105">
                    <div class="media-caption absolute inset-x-3 bottom-3 py-2.5 px-3.5 rounded-xl bg-deep/80 backdrop-blur-md text-white flex justify-between items-center text-[12.5px]">
                      <span class="opacity-80">Program Keahlian RGI</span>
                      <b class="text-pencil font-semibold">Depok, Surabaya</b>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Item 2: Teknik Komputer dan Jaringan -->
          <div class="prog-item border-t border-[#C9DAE8]">
            <button class="prog-btn w-full bg-transparent border-0 text-left font-inherit text-inherit flex flex-col md:flex-row md:items-center justify-between gap-1.5 md:gap-5 py-5 md:py-[22px] px-5 cursor-pointer transition-[background-color,color,padding-left] duration-300 ease-[cubic-bezier(0.22,1,0.36,1)] hover:bg-blue hover:text-white hover:pl-8 group" type="button" aria-expanded="false">
              <h3 class="font-disp font-bold text-[clamp(24px,3.4vw,40px)] leading-[1.1] tracking-[-0.02em]">Teknik Komputer dan Jaringan</h3>
              <span class="text-[14.5px] text-muted flex items-center gap-3.5 whitespace-nowrap transition-colors duration-250 group-hover:text-white/90">
                Depok 
                <svg class="chevron-icon w-[22px] h-[22px] fill-none stroke-current stroke-[1.7] [stroke-linecap:round] [stroke-linejoin:round] hidden md:block transition-transform duration-400 ease-[cubic-bezier(0.22,1,0.36,1)]"><use href="#arr"/></svg>
              </span>
            </button>
            <div class="prog-banner bg-white shadow-[inset_0_8px_24px_-12px_rgba(4,36,63,0.16)]" role="region" aria-label="Detail jurusan Teknik Komputer dan Jaringan">
              <div class="prog-inner overflow-hidden">
                <div class="banner-card grid grid-cols-1 lg:grid-cols-[1.15fr_0.85fr] gap-6 md:gap-9 items-center p-6 md:p-9 border-t border-line bg-gradient-to-br from-white to-[#F7FBFF]">
                  <div class="banner-body opacity-0 -translate-y-3.5 transition-[opacity,transform] duration-450 ease-[cubic-bezier(0.22,1,0.36,1)]">
                    <div class="banner-meta flex flex-wrap items-center gap-2.5 mb-3.5">
                      <span class="loc-badge inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full bg-pencil text-deep font-sans font-bold text-[12.5px] tracking-wide">
                        <svg class="w-[15px] h-[15px] fill-none stroke-current stroke-[1.7] [stroke-linecap:round] [stroke-linejoin:round]"><use href="#pin"/></svg> Depok
                      </span>
                      <span class="tag-pill inline-flex items-center py-1.5 px-3 rounded-full bg-soft text-blue font-sans font-semibold text-[12.5px]">6 Bulan Intensif • Lab Jaringan & Server</span>
                    </div>
                    <h4 class="font-disp font-extrabold text-[clamp(26px,3vw,36px)] text-deep mb-3 leading-tight">Teknik Komputer dan Jaringan</h4>
                    <p class="m-0 mb-6 text-muted text-[15.5px] leading-[1.65] max-w-[54ch]">Perakitan perangkat keras PC, administrasi server Linux, konfigurasi routing jaringan MikroTik, instalasi fiber optik, dan dasar keamanan siber.</p>
                    <div class="banner-actions flex flex-wrap items-center gap-3">
                      <a href="#beranda" class="prog-cta inline-flex items-center gap-2 py-3 px-5 rounded-xl bg-blue text-white font-sans font-semibold text-[14.5px] transition-[background-color,transform] duration-200 hover:bg-[#0067AE] hover:-translate-y-0.5" data-jurusan="Teknik Komputer dan Jaringan">
                        Login santri jurusan ini <svg class="w-4 h-4 fill-none stroke-current stroke-[1.7] [stroke-linecap:round] [stroke-linejoin:round]"><use href="#arr"/></svg>
                      </a>
                      <!-- <button type="button" class="banner-close bg-transparent border-[1.5px] border-line text-muted py-2.5 px-4 rounded-xl font-sans font-semibold text-sm cursor-pointer transition-[border-color,color,background-color] duration-200 hover:border-ink hover:text-ink hover:bg-white">Tutup banner</button> -->
                    </div>
                  </div>
                  <div class="banner-media order-first lg:order-none relative rounded-[20px] overflow-hidden aspect-[16/10] bg-deep shadow-[0_24px_48px_-18px_rgba(4,36,63,0.35)] opacity-0 -translate-y-3 scale-95 [clip-path:inset(0_0_100%_0_round_20px)] transition-[clip-path,opacity,transform] duration-500 ease-[cubic-bezier(0.22,1,0.36,1)]">
                    <img src="<?= base_url('assets/img/tkj.jpg'); ?>" alt="Suasana praktik jurusan Teknik Komputer dan Jaringan di Depok" loading="lazy" class="w-full h-full object-cover block scale-110 transition-transform duration-700 ease-[cubic-bezier(0.22,1,0.36,1)] hover:scale-105">
                    <div class="media-caption absolute inset-x-3 bottom-3 py-2.5 px-3.5 rounded-xl bg-deep/80 backdrop-blur-md text-white flex justify-between items-center text-[12.5px]">
                      <span class="opacity-80">Program Keahlian RGI</span>
                      <b class="text-pencil font-semibold">Depok</b>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Item 3: Fotografi dan Videografi -->
          <div class="prog-item border-t border-[#C9DAE8]">
            <button class="prog-btn w-full bg-transparent border-0 text-left font-inherit text-inherit flex flex-col md:flex-row md:items-center justify-between gap-1.5 md:gap-5 py-5 md:py-[22px] px-5 cursor-pointer transition-[background-color,color,padding-left] duration-300 ease-[cubic-bezier(0.22,1,0.36,1)] hover:bg-blue hover:text-white hover:pl-8 group" type="button" aria-expanded="false">
              <h3 class="font-disp font-bold text-[clamp(24px,3.4vw,40px)] leading-[1.1] tracking-[-0.02em]">Fotografi dan Videografi</h3>
              <span class="text-[14.5px] text-muted flex items-center gap-3.5 whitespace-nowrap transition-colors duration-250 group-hover:text-white/90">
                Depok 
                <svg class="chevron-icon w-[22px] h-[22px] fill-none stroke-current stroke-[1.7] [stroke-linecap:round] [stroke-linejoin:round] hidden md:block transition-transform duration-400 ease-[cubic-bezier(0.22,1,0.36,1)]"><use href="#arr"/></svg>
              </span>
            </button>
            <div class="prog-banner bg-white shadow-[inset_0_8px_24px_-12px_rgba(4,36,63,0.16)]" role="region" aria-label="Detail jurusan Fotografi dan Videografi">
              <div class="prog-inner overflow-hidden">
                <div class="banner-card grid grid-cols-1 lg:grid-cols-[1.15fr_0.85fr] gap-6 md:gap-9 items-center p-6 md:p-9 border-t border-line bg-gradient-to-br from-white to-[#F7FBFF]">
                  <div class="banner-body opacity-0 -translate-y-3.5 transition-[opacity,transform] duration-450 ease-[cubic-bezier(0.22,1,0.36,1)]">
                    <div class="banner-meta flex flex-wrap items-center gap-2.5 mb-3.5">
                      <span class="loc-badge inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full bg-pencil text-deep font-sans font-bold text-[12.5px] tracking-wide">
                        <svg class="w-[15px] h-[15px] fill-none stroke-current stroke-[1.7] [stroke-linecap:round] [stroke-linejoin:round]"><use href="#pin"/></svg> Depok
                      </span>
                      <span class="tag-pill inline-flex items-center py-1.5 px-3 rounded-full bg-soft text-blue font-sans font-semibold text-[12.5px]">6 Bulan Intensif • Studio & Produksi Lapangan</span>
                    </div>
                    <h4 class="font-disp font-extrabold text-[clamp(26px,3vw,36px)] text-deep mb-3 leading-tight">Fotografi dan Videografi</h4>
                    <p class="m-0 mb-6 text-muted text-[15.5px] leading-[1.65] max-w-[54ch]">Teknik tata cahaya studio, pengambilan gambar komersial, sinematografi, penyuntingan video, color grading, serta produksi konten kreatif digital.</p>
                    <div class="banner-actions flex flex-wrap items-center gap-3">
                      <a href="#beranda" class="prog-cta inline-flex items-center gap-2 py-3 px-5 rounded-xl bg-blue text-white font-sans font-semibold text-[14.5px] transition-[background-color,transform] duration-200 hover:bg-[#0067AE] hover:-translate-y-0.5" data-jurusan="Fotografi dan Videografi">
                        Login santri jurusan ini <svg class="w-4 h-4 fill-none stroke-current stroke-[1.7] [stroke-linecap:round] [stroke-linejoin:round]"><use href="#arr"/></svg>
                      </a>
                      <!-- <button type="button" class="banner-close bg-transparent border-[1.5px] border-line text-muted py-2.5 px-4 rounded-xl font-sans font-semibold text-sm cursor-pointer transition-[border-color,color,background-color] duration-200 hover:border-ink hover:text-ink hover:bg-white">Tutup banner</button> -->
                    </div>
                  </div>
                  <div class="banner-media order-first lg:order-none relative rounded-[20px] overflow-hidden aspect-[16/10] bg-deep shadow-[0_24px_48px_-18px_rgba(4,36,63,0.35)] opacity-0 -translate-y-3 scale-95 [clip-path:inset(0_0_100%_0_round_20px)] transition-[clip-path,opacity,transform] duration-500 ease-[cubic-bezier(0.22,1,0.36,1)]">
                    <img src="<?= base_url('assets/img/potpid.jpg'); ?>" alt="Suasana praktik jurusan Fotografi dan Videografi di Depok" loading="lazy" class="w-full h-full object-cover block scale-110 transition-transform duration-700 ease-[cubic-bezier(0.22,1,0.36,1)] hover:scale-105">
                    <div class="media-caption absolute inset-x-3 bottom-3 py-2.5 px-3.5 rounded-xl bg-deep/80 backdrop-blur-md text-white flex justify-between items-center text-[12.5px]">
                      <span class="opacity-80">Program Keahlian RGI</span>
                      <b class="text-pencil font-semibold">Depok</b>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Item 4: Desain Grafis -->
          <div class="prog-item border-t border-[#C9DAE8]">
            <button class="prog-btn w-full bg-transparent border-0 text-left font-inherit text-inherit flex flex-col md:flex-row md:items-center justify-between gap-1.5 md:gap-5 py-5 md:py-[22px] px-5 cursor-pointer transition-[background-color,color,padding-left] duration-300 ease-[cubic-bezier(0.22,1,0.36,1)] hover:bg-blue hover:text-white hover:pl-8 group" type="button" aria-expanded="false">
              <h3 class="font-disp font-bold text-[clamp(24px,3.4vw,40px)] leading-[1.1] tracking-[-0.02em]">Desain Grafis</h3>
              <span class="text-[14.5px] text-muted flex items-center gap-3.5 whitespace-nowrap transition-colors duration-250 group-hover:text-white/90">
                Depok, Magelang 
                <svg class="chevron-icon w-[22px] h-[22px] fill-none stroke-current stroke-[1.7] [stroke-linecap:round] [stroke-linejoin:round] hidden md:block transition-transform duration-400 ease-[cubic-bezier(0.22,1,0.36,1)]"><use href="#arr"/></svg>
              </span>
            </button>
            <div class="prog-banner bg-white shadow-[inset_0_8px_24px_-12px_rgba(4,36,63,0.16)]" role="region" aria-label="Detail jurusan Desain Grafis">
              <div class="prog-inner overflow-hidden">
                <div class="banner-card grid grid-cols-1 lg:grid-cols-[1.15fr_0.85fr] gap-6 md:gap-9 items-center p-6 md:p-9 border-t border-line bg-gradient-to-br from-white to-[#F7FBFF]">
                  <div class="banner-body opacity-0 -translate-y-3.5 transition-[opacity,transform] duration-450 ease-[cubic-bezier(0.22,1,0.36,1)]">
                    <div class="banner-meta flex flex-wrap items-center gap-2.5 mb-3.5">
                      <span class="loc-badge inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full bg-pencil text-deep font-sans font-bold text-[12.5px] tracking-wide">
                        <svg class="w-[15px] h-[15px] fill-none stroke-current stroke-[1.7] [stroke-linecap:round] [stroke-linejoin:round]"><use href="#pin"/></svg> Depok, Magelang
                      </span>
                      <span class="tag-pill inline-flex items-center py-1.5 px-3 rounded-full bg-soft text-blue font-sans font-semibold text-[12.5px]">6 Bulan Intensif • Studio Komunikasi Visual</span>
                    </div>
                    <h4 class="font-disp font-extrabold text-[clamp(26px,3vw,36px)] text-deep mb-3 leading-tight">Desain Grafis</h4>
                    <p class="m-0 mb-6 text-muted text-[15.5px] leading-[1.65] max-w-[54ch]">Perancangan identitas visual merek, tipografi, ilustrasi vektor, desain kemasan produk UMKM, dan tata letak media promosi digital maupun cetak.</p>
                    <div class="banner-actions flex flex-wrap items-center gap-3">
                      <a href="#beranda" class="prog-cta inline-flex items-center gap-2 py-3 px-5 rounded-xl bg-blue text-white font-sans font-semibold text-[14.5px] transition-[background-color,transform] duration-200 hover:bg-[#0067AE] hover:-translate-y-0.5" data-jurusan="Desain Grafis">
                        Login santri jurusan ini <svg class="w-4 h-4 fill-none stroke-current stroke-[1.7] [stroke-linecap:round] [stroke-linejoin:round]"><use href="#arr"/></svg>
                      </a>
                      <!-- <button type="button" class="banner-close bg-transparent border-[1.5px] border-line text-muted py-2.5 px-4 rounded-xl font-sans font-semibold text-sm cursor-pointer transition-[border-color,color,background-color] duration-200 hover:border-ink hover:text-ink hover:bg-white">Tutup banner</button> -->
                    </div>
                  </div>
                  <div class="banner-media order-first lg:order-none relative rounded-[20px] overflow-hidden aspect-[16/10] bg-deep shadow-[0_24px_48px_-18px_rgba(4,36,63,0.35)] opacity-0 -translate-y-3 scale-95 [clip-path:inset(0_0_100%_0_round_20px)] transition-[clip-path,opacity,transform] duration-500 ease-[cubic-bezier(0.22,1,0.36,1)]">
                    <img src="<?= base_url('assets/img/dg.jpg'); ?>" alt="Suasana praktik jurusan Desain Grafis di Depok, Magelang" loading="lazy" class="w-full h-full object-cover block scale-110 transition-transform duration-700 ease-[cubic-bezier(0.22,1,0.36,1)] hover:scale-105">
                    <div class="media-caption absolute inset-x-3 bottom-3 py-2.5 px-3.5 rounded-xl bg-deep/80 backdrop-blur-md text-white flex justify-between items-center text-[12.5px]">
                      <span class="opacity-80">Program Keahlian RGI</span>
                      <b class="text-pencil font-semibold">Depok, Magelang</b>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Item 5: Aplikasi Perkantoran -->
          <div class="prog-item border-t border-[#C9DAE8]">
            <button class="prog-btn w-full bg-transparent border-0 text-left font-inherit text-inherit flex flex-col md:flex-row md:items-center justify-between gap-1.5 md:gap-5 py-5 md:py-[22px] px-5 cursor-pointer transition-[background-color,color,padding-left] duration-300 ease-[cubic-bezier(0.22,1,0.36,1)] hover:bg-blue hover:text-white hover:pl-8 group" type="button" aria-expanded="false">
              <h3 class="font-disp font-bold text-[clamp(24px,3.4vw,40px)] leading-[1.1] tracking-[-0.02em]">Aplikasi Perkantoran</h3>
              <span class="text-[14.5px] text-muted flex items-center gap-3.5 whitespace-nowrap transition-colors duration-250 group-hover:text-white/90">
                Depok, Jakarta Timur 
                <svg class="chevron-icon w-[22px] h-[22px] fill-none stroke-current stroke-[1.7] [stroke-linecap:round] [stroke-linejoin:round] hidden md:block transition-transform duration-400 ease-[cubic-bezier(0.22,1,0.36,1)]"><use href="#arr"/></svg>
              </span>
            </button>
            <div class="prog-banner bg-white shadow-[inset_0_8px_24px_-12px_rgba(4,36,63,0.16)]" role="region" aria-label="Detail jurusan Aplikasi Perkantoran">
              <div class="prog-inner overflow-hidden">
                <div class="banner-card grid grid-cols-1 lg:grid-cols-[1.15fr_0.85fr] gap-6 md:gap-9 items-center p-6 md:p-9 border-t border-line bg-gradient-to-br from-white to-[#F7FBFF]">
                  <div class="banner-body opacity-0 -translate-y-3.5 transition-[opacity,transform] duration-450 ease-[cubic-bezier(0.22,1,0.36,1)]">
                    <div class="banner-meta flex flex-wrap items-center gap-2.5 mb-3.5">
                      <span class="loc-badge inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full bg-pencil text-deep font-sans font-bold text-[12.5px] tracking-wide">
                        <svg class="w-[15px] h-[15px] fill-none stroke-current stroke-[1.7] [stroke-linecap:round] [stroke-linejoin:round]"><use href="#pin"/></svg> Depok, Jakarta Timur
                      </span>
                      <span class="tag-pill inline-flex items-center py-1.5 px-3 rounded-full bg-soft text-blue font-sans font-semibold text-[12.5px]">6 Bulan Intensif • Manajemen & Administrasi</span>
                    </div>
                    <h4 class="font-disp font-extrabold text-[clamp(26px,3vw,36px)] text-deep mb-3 leading-tight">Aplikasi Perkantoran</h4>
                    <p class="m-0 mb-6 text-muted text-[15.5px] leading-[1.65] max-w-[54ch]">Penguasaan pengolah dokumen korporat, spreadsheet analisis keuangan, presentasi bisnis eksekutif, serta tata kelola administrasi perkantoran modern.</p>
                    <div class="banner-actions flex flex-wrap items-center gap-3">
                      <a href="#beranda" class="prog-cta inline-flex items-center gap-2 py-3 px-5 rounded-xl bg-blue text-white font-sans font-semibold text-[14.5px] transition-[background-color,transform] duration-200 hover:bg-[#0067AE] hover:-translate-y-0.5" data-jurusan="Aplikasi Perkantoran">
                        Login santri jurusan ini <svg class="w-4 h-4 fill-none stroke-current stroke-[1.7] [stroke-linecap:round] [stroke-linejoin:round]"><use href="#arr"/></svg>
                      </a>
                      <!-- <button type="button" class="banner-close bg-transparent border-[1.5px] border-line text-muted py-2.5 px-4 rounded-xl font-sans font-semibold text-sm cursor-pointer transition-[border-color,color,background-color] duration-200 hover:border-ink hover:text-ink hover:bg-white">Tutup banner</button> -->
                    </div>
                  </div>
                  <div class="banner-media order-first lg:order-none relative rounded-[20px] overflow-hidden aspect-[16/10] bg-deep shadow-[0_24px_48px_-18px_rgba(4,36,63,0.35)] opacity-0 -translate-y-3 scale-95 [clip-path:inset(0_0_100%_0_round_20px)] transition-[clip-path,opacity,transform] duration-500 ease-[cubic-bezier(0.22,1,0.36,1)]">
                    <img src="<?= base_url('assets/img/ap.jpg'); ?>" alt="Suasana praktik jurusan Aplikasi Perkantoran di Depok, Jakarta Timur" loading="lazy" class="w-full h-full object-cover block scale-110 transition-transform duration-700 ease-[cubic-bezier(0.22,1,0.36,1)] hover:scale-105">
                    <div class="media-caption absolute inset-x-3 bottom-3 py-2.5 px-3.5 rounded-xl bg-deep/80 backdrop-blur-md text-white flex justify-between items-center text-[12.5px]">
                      <span class="opacity-80">Program Keahlian RGI</span>
                      <b class="text-pencil font-semibold">Depok, Jakarta Timur</b>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Item 6: Teknik Sepeda Motor -->
          <div class="prog-item border-t border-[#C9DAE8]">
            <button class="prog-btn w-full bg-transparent border-0 text-left font-inherit text-inherit flex flex-col md:flex-row md:items-center justify-between gap-1.5 md:gap-5 py-5 md:py-[22px] px-5 cursor-pointer transition-[background-color,color,padding-left] duration-300 ease-[cubic-bezier(0.22,1,0.36,1)] hover:bg-blue hover:text-white hover:pl-8 group" type="button" aria-expanded="false">
              <h3 class="font-disp font-bold text-[clamp(24px,3.4vw,40px)] leading-[1.1] tracking-[-0.02em]">Teknik Sepeda Motor</h3>
              <span class="text-[14.5px] text-muted flex items-center gap-3.5 whitespace-nowrap transition-colors duration-250 group-hover:text-white/90">
                Depok 
                <svg class="chevron-icon w-[22px] h-[22px] fill-none stroke-current stroke-[1.7] [stroke-linecap:round] [stroke-linejoin:round] hidden md:block transition-transform duration-400 ease-[cubic-bezier(0.22,1,0.36,1)]"><use href="#arr"/></svg>
              </span>
            </button>
            <div class="prog-banner bg-white shadow-[inset_0_8px_24px_-12px_rgba(4,36,63,0.16)]" role="region" aria-label="Detail jurusan Teknik Sepeda Motor">
              <div class="prog-inner overflow-hidden">
                <div class="banner-card grid grid-cols-1 lg:grid-cols-[1.15fr_0.85fr] gap-6 md:gap-9 items-center p-6 md:p-9 border-t border-line bg-gradient-to-br from-white to-[#F7FBFF]">
                  <div class="banner-body opacity-0 -translate-y-3.5 transition-[opacity,transform] duration-450 ease-[cubic-bezier(0.22,1,0.36,1)]">
                    <div class="banner-meta flex flex-wrap items-center gap-2.5 mb-3.5">
                      <span class="loc-badge inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full bg-pencil text-deep font-sans font-bold text-[12.5px] tracking-wide">
                        <svg class="w-[15px] h-[15px] fill-none stroke-current stroke-[1.7] [stroke-linecap:round] [stroke-linejoin:round]"><use href="#pin"/></svg> Depok
                      </span>
                      <span class="tag-pill inline-flex items-center py-1.5 px-3 rounded-full bg-soft text-blue font-sans font-semibold text-[12.5px]">6 Bulan Intensif • Bengkel Praktik Otomotif</span>
                    </div>
                    <h4 class="font-disp font-extrabold text-[clamp(26px,3vw,36px)] text-deep mb-3 leading-tight">Teknik Sepeda Motor</h4>
                    <p class="m-0 mb-6 text-muted text-[15.5px] leading-[1.65] max-w-[54ch]">Perawatan berkala mesin konvensional dan sistem injeksi (FI), kelistrikan kendaraan roda dua, diagnostik scanner, hingga manajemen bengkel mandiri.</p>
                    <div class="banner-actions flex flex-wrap items-center gap-3">
                      <a href="#beranda" class="prog-cta inline-flex items-center gap-2 py-3 px-5 rounded-xl bg-blue text-white font-sans font-semibold text-[14.5px] transition-[background-color,transform] duration-200 hover:bg-[#0067AE] hover:-translate-y-0.5" data-jurusan="Teknik Sepeda Motor">
                        Login santri jurusan ini <svg class="w-4 h-4 fill-none stroke-current stroke-[1.7] [stroke-linecap:round] [stroke-linejoin:round]"><use href="#arr"/></svg>
                      </a>
                      <!-- <button type="button" class="banner-close bg-transparent border-[1.5px] border-line text-muted py-2.5 px-4 rounded-xl font-sans font-semibold text-sm cursor-pointer transition-[border-color,color,background-color] duration-200 hover:border-ink hover:text-ink hover:bg-white">Tutup banner</button> -->
                    </div>
                  </div>
                  <div class="banner-media order-first lg:order-none relative rounded-[20px] overflow-hidden aspect-[16/10] bg-deep shadow-[0_24px_48px_-18px_rgba(4,36,63,0.35)] opacity-0 -translate-y-3 scale-95 [clip-path:inset(0_0_100%_0_round_20px)] transition-[clip-path,opacity,transform] duration-500 ease-[cubic-bezier(0.22,1,0.36,1)]">
                    <img src="<?= base_url('assets/img/tsm.jpg'); ?>" alt="Suasana praktik jurusan Teknik Sepeda Motor di Depok" loading="lazy" class="w-full h-full object-cover block scale-110 transition-transform duration-700 ease-[cubic-bezier(0.22,1,0.36,1)] hover:scale-105">
                    <div class="media-caption absolute inset-x-3 bottom-3 py-2.5 px-3.5 rounded-xl bg-deep/80 backdrop-blur-md text-white flex justify-between items-center text-[12.5px]">
                      <span class="opacity-80">Program Keahlian RGI</span>
                      <b class="text-pencil font-semibold">Depok</b>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Item 7: Rekayasa Perangkat Lunak -->
          <div class="prog-item border-t border-[#C9DAE8]">
            <button class="prog-btn w-full bg-transparent border-0 text-left font-inherit text-inherit flex flex-col md:flex-row md:items-center justify-between gap-1.5 md:gap-5 py-5 md:py-[22px] px-5 cursor-pointer transition-[background-color,color,padding-left] duration-300 ease-[cubic-bezier(0.22,1,0.36,1)] hover:bg-blue hover:text-white hover:pl-8 group" type="button" aria-expanded="false">
              <h3 class="font-disp font-bold text-[clamp(24px,3.4vw,40px)] leading-[1.1] tracking-[-0.02em]">Rekayasa Perangkat Lunak</h3>
              <span class="text-[14.5px] text-muted flex items-center gap-3.5 whitespace-nowrap transition-colors duration-250 group-hover:text-white/90">
                Surabaya 
                <svg class="chevron-icon w-[22px] h-[22px] fill-none stroke-current stroke-[1.7] [stroke-linecap:round] [stroke-linejoin:round] hidden md:block transition-transform duration-400 ease-[cubic-bezier(0.22,1,0.36,1)]"><use href="#arr"/></svg>
              </span>
            </button>
            <div class="prog-banner bg-white shadow-[inset_0_8px_24px_-12px_rgba(4,36,63,0.16)]" role="region" aria-label="Detail jurusan Rekayasa Perangkat Lunak">
              <div class="prog-inner overflow-hidden">
                <div class="banner-card grid grid-cols-1 lg:grid-cols-[1.15fr_0.85fr] gap-6 md:gap-9 items-center p-6 md:p-9 border-t border-line bg-gradient-to-br from-white to-[#F7FBFF]">
                  <div class="banner-body opacity-0 -translate-y-3.5 transition-[opacity,transform] duration-450 ease-[cubic-bezier(0.22,1,0.36,1)]">
                    <div class="banner-meta flex flex-wrap items-center gap-2.5 mb-3.5">
                      <span class="loc-badge inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full bg-pencil text-deep font-sans font-bold text-[12.5px] tracking-wide">
                        <svg class="w-[15px] h-[15px] fill-none stroke-current stroke-[1.7] [stroke-linecap:round] [stroke-linejoin:round]"><use href="#pin"/></svg> Surabaya
                      </span>
                      <span class="tag-pill inline-flex items-center py-1.5 px-3 rounded-full bg-soft text-blue font-sans font-semibold text-[12.5px]">6 Bulan Intensif • Lab Pemrograman Web</span>
                    </div>
                    <h4 class="font-disp font-extrabold text-[clamp(26px,3vw,36px)] text-deep mb-3 leading-tight">Rekayasa Perangkat Lunak</h4>
                    <p class="m-0 mb-6 text-muted text-[15.5px] leading-[1.65] max-w-[54ch]">Pengembangan aplikasi web full-stack, perancangan basis data relasional, integrasi REST API, dan pemrograman berorientasi objek siap kerja.</p>
                    <div class="banner-actions flex flex-wrap items-center gap-3">
                      <a href="#beranda" class="prog-cta inline-flex items-center gap-2 py-3 px-5 rounded-xl bg-blue text-white font-sans font-semibold text-[14.5px] transition-[background-color,transform] duration-200 hover:bg-[#0067AE] hover:-translate-y-0.5" data-jurusan="Rekayasa Perangkat Lunak">
                        Login santri jurusan ini <svg class="w-4 h-4 fill-none stroke-current stroke-[1.7] [stroke-linecap:round] [stroke-linejoin:round]"><use href="#arr"/></svg>
                      </a>
                      <!-- <button type="button" class="banner-close bg-transparent border-[1.5px] border-line text-muted py-2.5 px-4 rounded-xl font-sans font-semibold text-sm cursor-pointer transition-[border-color,color,background-color] duration-200 hover:border-ink hover:text-ink hover:bg-white">Tutup banner</button> -->
                    </div>
                  </div>
                  <div class="banner-media order-first lg:order-none relative rounded-[20px] overflow-hidden aspect-[16/10] bg-deep shadow-[0_24px_48px_-18px_rgba(4,36,63,0.35)] opacity-0 -translate-y-3 scale-95 [clip-path:inset(0_0_100%_0_round_20px)] transition-[clip-path,opacity,transform] duration-500 ease-[cubic-bezier(0.22,1,0.36,1)]">
                    <img src="<?= base_url('assets/img/rpl.jpg'); ?>" alt="Suasana praktik jurusan Rekayasa Perangkat Lunak di Surabaya" loading="lazy" class="w-full h-full object-cover block scale-110 transition-transform duration-700 ease-[cubic-bezier(0.22,1,0.36,1)] hover:scale-105">
                    <div class="media-caption absolute inset-x-3 bottom-3 py-2.5 px-3.5 rounded-xl bg-deep/80 backdrop-blur-md text-white flex justify-between items-center text-[12.5px]">
                      <span class="opacity-80">Program Keahlian RGI</span>
                      <b class="text-pencil font-semibold">Surabaya</b>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Item 8: Kuliner Halal -->
          <div class="prog-item border-t border-b border-[#C9DAE8]">
            <button class="prog-btn w-full bg-transparent border-0 text-left font-inherit text-inherit flex flex-col md:flex-row md:items-center justify-between gap-1.5 md:gap-5 py-5 md:py-[22px] px-5 cursor-pointer transition-[background-color,color,padding-left] duration-300 ease-[cubic-bezier(0.22,1,0.36,1)] hover:bg-blue hover:text-white hover:pl-8 group" type="button" aria-expanded="false">
              <h3 class="font-disp font-bold text-[clamp(24px,3.4vw,40px)] leading-[1.1] tracking-[-0.02em]">Kuliner Halal</h3>
              <span class="text-[14.5px] text-muted flex items-center gap-3.5 whitespace-nowrap transition-colors duration-250 group-hover:text-white/90">
                Yogyakarta 
                <svg class="chevron-icon w-[22px] h-[22px] fill-none stroke-current stroke-[1.7] [stroke-linecap:round] [stroke-linejoin:round] hidden md:block transition-transform duration-400 ease-[cubic-bezier(0.22,1,0.36,1)]"><use href="#arr"/></svg>
              </span>
            </button>
            <div class="prog-banner bg-white shadow-[inset_0_8px_24px_-12px_rgba(4,36,63,0.16)]" role="region" aria-label="Detail jurusan Kuliner Halal">
              <div class="prog-inner overflow-hidden">
                <div class="banner-card grid grid-cols-1 lg:grid-cols-[1.15fr_0.85fr] gap-6 md:gap-9 items-center p-6 md:p-9 border-t border-line bg-gradient-to-br from-white to-[#F7FBFF]">
                  <div class="banner-body opacity-0 -translate-y-3.5 transition-[opacity,transform] duration-450 ease-[cubic-bezier(0.22,1,0.36,1)]">
                    <div class="banner-meta flex flex-wrap items-center gap-2.5 mb-3.5">
                      <span class="loc-badge inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full bg-pencil text-deep font-sans font-bold text-[12.5px] tracking-wide">
                        <svg class="w-[15px] h-[15px] fill-none stroke-current stroke-[1.7] [stroke-linecap:round] [stroke-linejoin:round]"><use href="#pin"/></svg> Yogyakarta
                      </span>
                      <span class="tag-pill inline-flex items-center py-1.5 px-3 rounded-full bg-soft text-blue font-sans font-semibold text-[12.5px]">6 Bulan Intensif • Dapur Praktik Kuliner</span>
                    </div>
                    <h4 class="font-disp font-extrabold text-[clamp(26px,3vw,36px)] text-deep mb-3 leading-tight">Kuliner Halal</h4>
                    <p class="m-0 mb-6 text-muted text-[15.5px] leading-[1.65] max-w-[54ch]">Pengolahan hidangan nusantara dan kontinental berstandar halal, higienitas keamanan pangan, pastry & bakery, serta perhitungan HPP usaha kuliner.</p>
                    <div class="banner-actions flex flex-wrap items-center gap-3">
                      <a href="#beranda" class="prog-cta inline-flex items-center gap-2 py-3 px-5 rounded-xl bg-blue text-white font-sans font-semibold text-[14.5px] transition-[background-color,transform] duration-200 hover:bg-[#0067AE] hover:-translate-y-0.5" data-jurusan="Kuliner Halal">
                        Login santri jurusan ini <svg class="w-4 h-4 fill-none stroke-current stroke-[1.7] [stroke-linecap:round] [stroke-linejoin:round]"><use href="#arr"/></svg>
                      </a>
                      <!-- <button type="button" class="banner-close bg-transparent border-[1.5px] border-line text-muted py-2.5 px-4 rounded-xl font-sans font-semibold text-sm cursor-pointer transition-[border-color,color,background-color] duration-200 hover:border-ink hover:text-ink hover:bg-white">Tutup banner</button> -->
                    </div>
                  </div>
                  <div class="banner-media order-first lg:order-none relative rounded-[20px] overflow-hidden aspect-[16/10] bg-deep shadow-[0_24px_48px_-18px_rgba(4,36,63,0.35)] opacity-0 -translate-y-3 scale-95 [clip-path:inset(0_0_100%_0_round_20px)] transition-[clip-path,opacity,transform] duration-500 ease-[cubic-bezier(0.22,1,0.36,1)]">
                    <img src="<?= base_url('assets/img/kuliner.jpg'); ?>" alt="Suasana praktik jurusan Kuliner Halal di Yogyakarta" loading="lazy" class="w-full h-full object-cover block scale-110 transition-transform duration-700 ease-[cubic-bezier(0.22,1,0.36,1)] hover:scale-105">
                    <div class="media-caption absolute inset-x-3 bottom-3 py-2.5 px-3.5 rounded-xl bg-deep/80 backdrop-blur-md text-white flex justify-between items-center text-[12.5px]">
                      <span class="opacity-80">Program Keahlian RGI</span>
                      <b class="text-pencil font-semibold">Yogyakarta</b>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>
  </main>

  <!-- Footer -->
  <footer id="kontak" class="bg-deep text-white pt-[72px] pb-7 overflow-hidden">
    <div class="max-w-[1180px] mx-auto px-6">
      <p class="mark font-disp font-extrabold text-[clamp(52px,13vw,190px)] leading-[0.9] tracking-[-0.05em] text-blue m-0 mb-12 whitespace-nowrap transition-transform duration-100 ease-out select-none" id="footerMark" aria-hidden="true">Syiar Gemilang</p>
      
      <div class="flex flex-wrap gap-5 justify-between items-center text-sm text-white/70 border-t border-white/15 pt-6">
        <span>© 2026 Syiar Gemilang. Sistem Informasi Akademik Rumah Gemilang Indonesia.</span>
        
        <nav class="flex gap-6" aria-label="Footer">
          <a href="#fitur" class="hover:text-white transition-colors duration-200">Fitur portal</a>
          <a href="#pengumuman" class="hover:text-white transition-colors duration-200">Papan pengumuman</a>
          <a href="#program" class="hover:text-white transition-colors duration-200">Program keahlian</a>
          <a href="<?= base_url('login'); ?>" class="hover:text-white transition-colors duration-200 font-medium">Halaman login</a>
        </nav>

        <span class="inline-flex" id="langSwitch">
          <button type="button" class="bg-transparent border-0 text-white font-semibold cursor-pointer py-0 px-2.5 transition-colors duration-200" data-lang="id">Indonesia</button>
          <button type="button" class="bg-transparent border-0 text-white/70 hover:text-white cursor-pointer py-0 px-2.5 border-l border-white/20 transition-colors duration-200" data-lang="en">English</button>
          <button type="button" class="bg-transparent border-0 text-white/70 hover:text-white cursor-pointer py-0 px-2.5 border-l border-white/20 transition-colors duration-200" data-lang="ar" lang="ar">العربية</button>
        </span>
      </div>
    </div>
  </footer>

  <!-- Interactive JavaScript Engine -->
  <script>
  (function(){
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    // 1. Interactive Blueprint Grid Canvas in Hero
    const hero = document.getElementById('beranda');
    const canvas = document.getElementById('gridCanvas');
    const ctx = canvas.getContext('2d');
    let width, height, mouse = { x: -1000, y: -1000 }, ripples = [];
    const gridSize = 56;

    function resizeCanvas() {
      const rect = hero.getBoundingClientRect();
      const dpr = window.devicePixelRatio || 1;
      width = rect.width;
      height = rect.height;
      canvas.width = width * dpr;
      canvas.height = height * dpr;
      ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
    }
    resizeCanvas();
    window.addEventListener('resize', resizeCanvas);

    hero.addEventListener('pointermove', (e) => {
      const rect = hero.getBoundingClientRect();
      mouse.x = e.clientX - rect.left;
      mouse.y = e.clientY - rect.top;
    });

    hero.addEventListener('pointerleave', () => {
      mouse.x = -1000;
      mouse.y = -1000;
    });

    hero.addEventListener('pointerdown', (e) => {
      if (e.target.closest('input, button, a')) return;
      const rect = hero.getBoundingClientRect();
      ripples.push({ x: e.clientX - rect.left, y: e.clientY - rect.top, r: 0, alpha: 0.45 });
    });

    function drawGrid() {
      ctx.clearRect(0, 0, width, height);

      ctx.strokeStyle = 'rgba(255, 255, 255, 0.1)';
      ctx.lineWidth = 1;
      ctx.beginPath();
      for (let x = 0; x <= width; x += gridSize) {
        ctx.moveTo(x, 0);
        ctx.lineTo(x, height);
      }
      for (let y = 0; y <= height; y += gridSize) {
        ctx.moveTo(0, y);
        ctx.lineTo(width, y);
      }
      ctx.stroke();

      if (!reducedMotion) {
        const startCol = Math.floor((mouse.x - 180) / gridSize);
        const endCol = Math.ceil((mouse.x + 180) / gridSize);
        const startRow = Math.floor((mouse.y - 180) / gridSize);
        const endRow = Math.ceil((mouse.y + 180) / gridSize);

        for (let c = startCol; c <= endCol; c++) {
          for (let r = startRow; r <= endRow; r++) {
            const cx = c * gridSize;
            const cy = r * gridSize;
            const centerX = cx + gridSize / 2;
            const centerY = cy + gridSize / 2;
            const dist = Math.hypot(mouse.x - centerX, mouse.y - centerY);

            if (dist < 170) {
              const intensity = 1 - dist / 170;
              ctx.fillStyle = `rgba(255, 210, 63, ${intensity * 0.12})`;
              ctx.fillRect(cx + 1, cy + 1, gridSize - 2, gridSize - 2);

              ctx.strokeStyle = `rgba(255, 255, 255, ${intensity * 0.35})`;
              ctx.strokeRect(cx, cy, gridSize, gridSize);

              ctx.fillStyle = `rgba(255, 210, 63, ${intensity * 0.85})`;
              ctx.beginPath();
              ctx.arc(cx, cy, 2.2 * intensity + 0.5, 0, Math.PI * 2);
              ctx.fill();
            }
          }
        }

        for (let i = ripples.length - 1; i >= 0; i--) {
          const rp = ripples[i];
          rp.r += 7;
          rp.alpha -= 0.012;
          if (rp.alpha <= 0) {
            ripples.splice(i, 1);
            continue;
          }
          ctx.strokeStyle = `rgba(255, 210, 63, ${rp.alpha})`;
          ctx.lineWidth = 2;
          ctx.beginPath();
          ctx.arc(rp.x, rp.y, rp.r, 0, Math.PI * 2);
          ctx.stroke();
        }
      }
      requestAnimationFrame(drawGrid);
    }
    drawGrid();

    // 2. Interactive 3D Tilt & Glare on Kartu Santri
    const cardWrap = document.getElementById('cardWrap');
    const idCard = document.getElementById('idCard');
    const idGlare = document.getElementById('idGlare');

    if (!reducedMotion && cardWrap && idCard) {
      cardWrap.addEventListener('pointermove', (e) => {
        const rect = idCard.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        const centerX = rect.width / 2;
        const centerY = rect.height / 2;
        const rotateX = ((y - centerY) / centerY) * -6;
        const rotateY = ((x - centerX) / centerX) * 6;

        idCard.style.transform = `rotateX(${rotateX.toFixed(2)}deg) rotateY(${rotateY.toFixed(2)}deg)`;
        idGlare.style.opacity = '1';
        idGlare.style.background = `radial-gradient(circle at ${x}px ${y}px, rgba(255,255,255,0.45), transparent 65%)`;
      });

      cardWrap.addEventListener('pointerleave', () => {
        idCard.style.transform = '';
        idGlare.style.opacity = '0';
      });
    }

    // 3. Live Kartu Santri Preview & Password Visibility Toggle
    const nisInput = document.getElementById('nis');
    const pwInput = document.getElementById('pw');
    const cardNis = document.getElementById('cardNis');
    const cardName = document.getElementById('cardName');
    const cardAvatar = document.getElementById('cardAvatar');
    const togglePw = document.getElementById('togglePw');
    const loginForm = document.getElementById('f');
    const submitBtn = document.getElementById('submitBtn');
    const submitLabel = document.getElementById('submitLabel');

    function updateCardPreview() {
      const val = nisInput.value.trim();
      if (!val) {
        cardNis.textContent = 'Masukkan NIS di bawah';
        cardName.textContent = 'Santri Gemilang';
        cardAvatar.textContent = 'SG';
        cardAvatar.style.backgroundColor = '';
        cardAvatar.style.color = '';
      } else {
        cardNis.textContent = val;
        if (/^\d+$/.test(val)) {
          cardName.textContent = 'Santri Aktif RGI';
          cardAvatar.textContent = val.length >= 2 ? val.slice(-2) : val;
        } else {
          cardName.textContent = val;
          cardAvatar.textContent = val.slice(0, 2).toUpperCase();
        }
        cardAvatar.style.backgroundColor = '#FFD23F';
        cardAvatar.style.color = '#04243F';
      }
    }

    nisInput.addEventListener('input', updateCardPreview);
    // Inisialisasi awal jika ada value tersimpan (misal dari old input)
    if (nisInput.value.trim()) {
      updateCardPreview();
    }

    togglePw.addEventListener('click', () => {
      const isPw = pwInput.type === 'password';
      pwInput.type = isPw ? 'text' : 'password';
      togglePw.setAttribute('aria-label', isPw ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
      togglePw.innerHTML = `<svg class="w-[18px] h-[18px] fill-none stroke-current stroke-[1.7] [stroke-linecap:round] [stroke-linejoin:round] flex-none"><use href="#${isPw ? 'eye-off' : 'eye'}"/></svg>`;
    });

    // Form submission:
    // Kirim request ke backend /login. Jika tidak lengkap atau salah kredensial, backend akan
    // mengarahkan (melempar) user ke page login yang ada (/login) dengan membawa pesan error.
    loginForm.addEventListener('submit', function() {
      if (submitBtn) {
        submitBtn.disabled = true;
        if (submitLabel) submitLabel.textContent = 'Memverifikasi...';
      }
    });

    // Reset tombol jika halaman dimuat dari cache browser
    window.addEventListener('pageshow', function (e) {
      if (submitBtn) {
        submitBtn.disabled = false;
        if (submitLabel) submitLabel.textContent = 'Masuk';
      }
    });

    // 4. Interactive Program Keahlian Dropdown Banner + Auto-Fill Jurusan
    const progItems = document.querySelectorAll('.prog-item');
    progItems.forEach((item) => {
      const btn = item.querySelector('.prog-btn');
      const closeBtn = item.querySelector('.banner-close');

      btn.addEventListener('click', () => {
        const isOpen = item.classList.contains('open');
        progItems.forEach((el) => {
          el.classList.remove('open');
          el.querySelector('.prog-btn').setAttribute('aria-expanded', 'false');
        });
        if (!isOpen) {
          item.classList.add('open');
          btn.setAttribute('aria-expanded', 'true');
          if (!reducedMotion) {
            setTimeout(() => {
              item.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }, 220);
          }
        }
      });

      if (closeBtn) {
        closeBtn.addEventListener('click', () => {
          item.classList.remove('open');
          btn.setAttribute('aria-expanded', 'false');
          btn.focus();
        });
      }
    });

    document.querySelectorAll('.prog-cta').forEach((link) => {
      link.addEventListener('click', () => {
        const jurusan = link.getAttribute('data-jurusan');
        setTimeout(() => {
          nisInput.focus();
          const m = document.getElementById('msg');
          m.style.color = '#5A6D7F';
          m.textContent = `Silakan masuk untuk akses portal jurusan ${jurusan}.`;
        }, 450);
      });
    });

    // 5. Scroll Reveal & Animated Counters & Footer Parallax
    const reveals = document.querySelectorAll('.reveal');
    const counters = document.querySelectorAll('.count');
    let counted = false;

    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add('in');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12 });

    reveals.forEach((el) => observer.observe(el));

    function animateCounters() {
      if (counted || reducedMotion) return;
      counted = true;
      counters.forEach((el) => {
        const target = parseInt(el.dataset.target, 10);
        const suffix = el.dataset.suffix || '';
        const duration = 1200;
        const start = performance.now();

        function tick(now) {
          const progress = Math.min((now - start) / duration, 1);
          const ease = 1 - Math.pow(1 - progress, 3);
          const current = Math.floor(ease * target);
          el.textContent = current.toLocaleString('id-ID') + suffix;
          if (progress < 1) requestAnimationFrame(tick);
        }
        requestAnimationFrame(tick);
      });
    }
    animateCounters();

    const footer = document.getElementById('kontak');
    const footerMark = document.getElementById('footerMark');
    if (!reducedMotion && footer && footerMark) {
      window.addEventListener('scroll', () => {
        const rect = footer.getBoundingClientRect();
        if (rect.top < window.innerHeight && rect.bottom > 0) {
          const progress = 1 - rect.top / window.innerHeight;
          footerMark.style.transform = `translateX(${(progress - 0.5) * -40}px)`;
        }
      }, { passive: true });
    }

    // 6. Interactive Language Switcher Feedback
    const langBtns = document.querySelectorAll('#langSwitch button');
    langBtns.forEach((btn) => {
      btn.addEventListener('click', () => {
        langBtns.forEach((b) => {
          b.classList.remove('text-white', 'font-semibold');
          b.classList.add('text-white/70');
        });
        btn.classList.add('text-white', 'font-semibold');
        btn.classList.remove('text-white/70');
      });
    });

    // 7. Interactive Filter Papan Pengumuman Diklat
    const annFilterBtns = document.querySelectorAll('.ann-filter-btn');
    const annCards = document.querySelectorAll('.ann-card');
    annFilterBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        annFilterBtns.forEach(b => {
          b.classList.remove('bg-blue', 'text-white', 'shadow-xs', 'active');
          b.classList.add('text-muted');
        });
        btn.classList.add('bg-blue', 'text-white', 'shadow-xs', 'active');
        btn.classList.remove('text-muted');

        const filter = btn.getAttribute('data-filter');
        annCards.forEach(card => {
          const cat = card.getAttribute('data-cat');
          if (filter === 'all' || cat === filter) {
            card.style.display = 'flex';
          } else {
            card.style.display = 'none';
          }
        });
      });
    });
  })();
  </script>
</body>
</html>