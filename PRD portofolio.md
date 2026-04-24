# PRD: Website Portofolio Data Engineer (Aldri Hardiansyah)

## 1. Visi & Tujuan Produk
Membangun platform digital yang memvalidasi keahlian Aldri Hardiansyah sebagai **Data Engineer** yang mampu merancang arsitektur data kompleks, mengelola sistem database skala besar (200+ tabel), dan menjembatani kebutuhan bisnis dengan solusi teknis.

---

## 2. Profil Pengguna (Target Audience)
* **Recruiter & Hiring Manager**: Mencari bukti kemampuan teknis dalam pengelolaan database dan pipeline data skala besar (melibatkan 62.000+ data pegawai).
* **Technical Lead**: Menilai pemahaman arsitektur sistem (seperti sinkronisasi data Dapodik), efisiensi query, dan cara penyelesaian masalah server kritis.

---

## 3. Fitur Utama & Struktur Konten

### A. Hero Section: The "Forestry to Data" Story
* **Headline**: Data Engineer dengan latar belakang Teknik Kehutanan yang membawa ketelitian sistematis dalam pengolahan data.
* **Sub-headline**: Spesialisasi dalam pembangunan Data Warehouse, optimalisasi PostgreSQL, dan analisis data pendidikan skala provinsi.

### B. Project Case Studies (Fokus Utama)
Setiap proyek akan ditampilkan dengan diagram alir data yang jelas untuk menunjukkan kemampuan perancangan arsitektur.

1.  **Sigesit Juara - Enterprise Data Architecture**:
    * **Deskripsi**: Merancang arsitektur database relasional dengan 200+ tabel untuk manajemen data dari 5.090 sekolah dan 62.000 pegawai.
    * **Highlight**: Desain logika *ingestion* data dari API Dapodik serta penerapan **SCD Type 2** pada tabel riwayat untuk pelacakan data historis.
    * **Peran**: Arsitek Data & Desainer Logika Sistem (merancang alur kerja yang diimplementasikan melalui Laravel Jobs).

2.  **DSO & DGM - Business Logic Engineering**:
    * **Deskripsi**: Membangun mesin penghitung otomatis untuk analisis kebutuhan guru (DSO) dan laporan pemenuhan jam mengajar (DGM).
    * **Impact**: Hasil perhitungan ini menjadi fondasi utama kebijakan strategis kepegawaian di lingkungan Dinas Pendidikan Jawa Barat.

3.  **Spatial Analysis - Forestry Roots**:
    * **Deskripsi**: Analisis kesesuaian habitat primata menggunakan citra satelit dan ArcGIS Pro.
    * **Unique Selling Point**: Menunjukkan kemampuan menangani data non-tradisional (geospasial) dengan pendekatan analitis yang mendalam.

### C. Technical Toolbox (Skills)
* **Database**: PostgreSQL (Multi-schema), MySQL.
* **Languages**: Python (Pandas), SQL, R Studio.
* **Tools**: Docker, Redis (Queue logic), ArcGIS Pro, QGIS.

---

## 4. Persyaratan Non-Fungsional (Tech Stack)

Arsitektur ini menggabungkan teknologi utama dari **Sigesit Juara** dengan infrastruktur yang dapat di-deploy secara gratis.

### A. Development Stack (Sesuai Sigesit Juara)
* **Frontend**: **Vue.js / Nuxt** (Untuk antarmuka reaktif dan ramah SEO).
* **Backend**: **Laravel (REST API)** untuk pengelolaan metadata proyek dan konten.
* **Security**: Autentikasi API menggunakan **Laravel Sanctum**.

### B. Deployment & Infrastructure (Free Tier Strategy)
* **Frontend Hosting**: **Vercel** (Gratis untuk aplikasi Nuxt/Vue).
* **Backend Hosting**: **Render** (Free Tier untuk hosting Laravel API).
* **Database**: **Supabase**.
* **File Storage**: **Supabase Storage** (Untuk menyimpan aset gambar diagram arsitektur secara gratis).

---

## 5. Matriks Keberhasilan (Success Metrics)
* Website memiliki skor performa (Lighthouse) di atas 90%.
* Arsitektur data Sigesit Juara divisualisasikan secara jelas melalui diagram alir yang dapat dipahami dalam waktu kurang dari 1 menit.
* Integritas data tetap terjaga menggunakan standar ACID (*Database Transactions*) pada setiap fitur CRUD di backend.