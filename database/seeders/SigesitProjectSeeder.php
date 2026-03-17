<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;

class SigesitProjectSeeder extends Seeder
{
    public function run(): void
    {
        $project = Project::create([
            'title' => 'SIGESIT JUARA — Enterprise Education Data Platform',
            'description' => 'Merancang dan membangun arsitektur data end-to-end untuk sistem manajemen kepegawaian guru, tenaga kependidikan, dan siswa di Provinsi Jawa Barat. Platform ini mengintegrasikan data dari 5 sumber eksternal (Dapodik, SIMPEG, Disdukcapil, SIAP, Tikomdik) ke dalam satu data warehouse terpusat dengan 238 model database, melayani 62.000+ pegawai di 5.090 sekolah.',
            'datastack' => 'PostgreSQL · Laravel Queue · Redis · MinIO · Dapodik API',
            'icon' => 'account_tree',
            'tools' => [
                'PostgreSQL',
                'Laravel Octane',
                'Redis Queue',
                'Python (Django)',
                'Docker',
                'MinIO (S3)',
                'Supervisor',
                'NGINX',
            ],
            'repo_link' => null,
            'demo_link' => 'https://sigesitjuara.jabarprov.go.id',
            'highlights' => [
                'etl' => [
                    'text' => 'Pipeline data end-to-end yang memproses jutaan record dari sumber eksternal ke data warehouse setiap harinya.',
                    'items' => [
                        [
                            'step' => 'EXTRACT',
                            'icon' => 'cloud_download',
                            'label' => 'Multi-Source Extraction',
                            'desc' => 'Tarik data secara terjadwal dari 5 sumber: SIMPEG (PNS/PPPK), Dapodik API (sekolah & rombel), Disdukcapil (validasi NIK), SIAP Jabar, dan Tikomdik.',
                            'detail' => 'Menggunakan Laravel Queue Jobs dengan Supervisor untuk orchestrasi. Total 41 ETL jobs aktif berjalan secara cron maupun on-demand.',
                        ],
                        [
                            'step' => 'TRANSFORM',
                            'icon' => 'transform',
                            'label' => 'Data Cleansing & Mapping',
                            'desc' => 'Normalisasi data dari berbagai format: deduplikasi NIP, klasifikasi jenis PTK (Guru/Tendik/Kepala Sekolah), konversi field kosong ke NULL, mapping unit kerja ke ID sekolah.',
                            'detail' => 'SyncLocalPegawai.php memproses 200 record per-chunk menggunakan Eloquent chunk() untuk efisiensi memori. Business logic: klasifikasi jabatan via string matching ("kepala sekolah sman/smkn/slbn").',
                        ],
                        [
                            'step' => 'VALIDATE',
                            'icon' => 'verified_user',
                            'label' => 'Data Validation & Enrichment',
                            'desc' => 'Validasi NIK ke API Disdukcapil, generate DGM (Daftar Gaji Mingguan) dan DSO (Daftar Standar Output) dari data rombel + mapel, serta analisis kebutuhan guru per-sekolah.',
                            'detail' => 'GenerateDgmV2Job.php mengkalkulasi jam mengajar aktual vs standar. GenerateSemesterJob.php melakukan snapshot data per-semester sebagai audit trail.',
                        ],
                        [
                            'step' => 'LOAD',
                            'icon' => 'storage',
                            'label' => 'Warehouse Load & Versioning',
                            'desc' => 'Data bersih dimuat ke PostgreSQL multi-schema. File dokumen (SPTJM, SK, Ijazah) disimpan ke MinIO S3-compatible storage.',
                            'detail' => 'Upsert pattern: cek existing record via NIP, lalu update atau create. Riwayat (pendidikan, SK, sertifikasi) disimpan sebagai tabel historis terpisah.',
                        ],
                        [
                            'step' => 'SERVE',
                            'icon' => 'api',
                            'label' => 'API & Export Engine',
                            'desc' => 'Data disajikan ke frontend Nuxt via Laravel REST API (Octane/Swoole, 4 workers) dan diekspor ke 173 template Excel/PDF untuk laporan dinas.',
                            'detail' => 'Export diproses sebagai background jobs (GenerateMutasiZip) untuk menghindari timeout. Notifikasi via WhatsApp Engine (ExpressJS) saat export selesai.',
                        ],
                    ],
                ],
                'stats' => [
                    'text' => 'Skala data dan metrik utama platform yang menggambarkan kompleksitas sistem secara keseluruhan.',
                    'items' => [
                        [
                            'value' => '62.000+',
                            'label' => 'Data Pegawai',
                            'icon' => 'people',
                            'color' => 'blue',
                        ],
                        [
                            'value' => '5.090',
                            'label' => 'Sekolah Tercakup',
                            'icon' => 'school',
                            'color' => 'green',
                        ],
                        [
                            'value' => '238',
                            'label' => 'Database Models',
                            'icon' => 'table_chart',
                            'color' => 'purple',
                        ],
                        [
                            'value' => '41',
                            'label' => 'ETL Pipeline Jobs',
                            'icon' => 'sync',
                            'color' => 'orange',
                        ],
                        [
                            'value' => '173',
                            'label' => 'Export Templates',
                            'icon' => 'description',
                            'color' => 'teal',
                        ],
                        [
                            'value' => '5',
                            'label' => 'Source API Integrations',
                            'icon' => 'hub',
                            'color' => 'red',
                        ],
                        [
                            'value' => '4',
                            'label' => 'Database Connections',
                            'icon' => 'dns',
                            'color' => 'indigo',
                        ],
                        [
                            'value' => '12',
                            'label' => 'User Roles',
                            'icon' => 'manage_accounts',
                            'color' => 'yellow',
                        ],
                    ],
                ],
                'entities' => [
                    'text' => 'Domain data utama yang dikelola, mencakup seluruh entitas kepegawaian, sekolah, dan pelaporan di Jawa Barat.',
                    'items' => [
                        [
                            'name' => 'm_guru / m_tendik',
                            'source' => 'SIMPEG + Dapodik',
                            'desc' => 'Master data kepegawaian dengan 80+ atribut: identitas, riwayat pendidikan, sertifikasi, jabatan, pangkat golongan, SK, dan informasi penggajian.',
                        ],
                        [
                            'name' => 'm_sekolah',
                            'source' => 'Dapodik API',
                            'desc' => 'Data identitas sekolah SMA/SMK/SLB se-Jawa Barat dengan relasi ke KCD (Kantor Cabang Dinas), kabupaten/kota, sarpras, dan koordinat geospasial.',
                        ],
                        [
                            'name' => 'Penjadwalan & Rombel',
                            'source' => 'Dapodik + Manual',
                            'desc' => 'Jadwal mengajar per-guru per-semester, rombongan belajar, mata pelajaran, dan kurikulum. Menjadi basis kalkulasi DSO dan DGM.',
                        ],
                        [
                            'name' => 'Mutasi & Pengajuan',
                            'source' => 'Internal Workflow',
                            'desc' => 'Workflow mutasi pegawai antar sekolah dengan approval multi-level, dokumen digital (SPTJM), dan notifikasi WhatsApp otomatis.',
                        ],
                        [
                            'name' => 'SIMTUN (Tunjangan Profesi)',
                            'source' => 'Internal + Keuangan',
                            'desc' => 'Sistem informasi manajemen tunjangan profesi guru: verifikasi sertifikasi, perhitungan nominal, dan ekspor laporan pembayaran.',
                        ],
                        [
                            'name' => 'Relokasi PPPK',
                            'source' => 'Internal HR',
                            'desc' => 'Manajemen relokasi guru PPPK antar formasi sekolah dengan tracking status, dokumen persyaratan, dan riwayat perubahan posisi.',
                        ],
                    ],
                ],
            ],
        ]);

        $this->command->info("✅ Project Sigesit created with ID: {$project->id}");
    }
}

