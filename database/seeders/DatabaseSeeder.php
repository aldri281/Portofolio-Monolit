<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call(UserSeeder::class);

        \App\Models\Profile::create([
            'resume_url' => 'https://example.com/resume.pdf',
            'tagline' => 'Architecting Complex Data Systems',
            'bio' => 'Data Engineer with a Forestry Engineering background, bringing systematic precision to data processing. Specializing in Data Warehouse construction, PostgreSQL optimization, and provincial-scale education data analysis.',
        ]);

        $project1 = \App\Models\Project::create([
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
                'badge_label' => 'Architecture Deep Dive',
                'databases' => [
                    ['name' => 'Main DB', 'desc' => 'Core warehouse'],
                    ['name' => 'SIMPEG', 'desc' => 'Kepegawaian PNS'],
                    ['name' => 'Dapodik', 'desc' => 'Data sekolah'],
                    ['name' => 'EOTM', 'desc' => 'Peer Review'],
                ],
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
                    'text' => 'Skala platform yang mencerminkan kompleksitas sistem data kepegawaian provinsi Jawa Barat.',
                    'items' => [
                        ['value' => '62.000+', 'label' => 'Data Pegawai', 'icon' => 'people', 'color' => 'blue'],
                        ['value' => '5.090', 'label' => 'Sekolah Tercakup', 'icon' => 'school', 'color' => 'green'],
                        ['value' => '238', 'label' => 'Database Models', 'icon' => 'table_chart', 'color' => 'purple'],
                        ['value' => '41', 'label' => 'ETL Pipeline Jobs', 'icon' => 'sync', 'color' => 'orange'],
                    ],
                ],
                'entities' => [
                    'text' => 'Domain data utama yang dikelola, mencakup seluruh entitas kepegawaian, sekolah, dan pelaporan di Jawa Barat.',
                    'items' => [
                        ['name' => 'm_guru / m_tendik', 'source' => 'SIMPEG + Dapodik', 'desc' => 'Master data kepegawaian dengan 80+ atribut: identitas, riwayat pendidikan, sertifikasi, jabatan, pangkat golongan, SK, dan informasi penggajian.'],
                        ['name' => 'm_sekolah', 'source' => 'Dapodik API', 'desc' => 'Data identitas sekolah SMA/SMK/SLB se-Jawa Barat dengan relasi ke KCD (Kantor Cabang Dinas), kabupaten/kota, sarpras, dan koordinat geospasial.'],
                    ],
                ],
            ],
        ]);

        \App\Models\ProjectImage::create([
            'project_id' => $project1->id,
            'image_url' => 'https://drive.google.com/file/d/1od1kq0ezox5-WFYIjSrjV1pdwU8pM0KB/view?usp=sharing',
            'is_primary' => true,
            'order' => 1,
        ]);

        \App\Models\Skill::create([
            'name' => 'PostgreSQL (Admin & Opt)',
            'category' => 'Database',
            'icon' => 'database',
        ]);

        \App\Models\Skill::create([
            'name' => 'Laravel Eco-system',
            'category' => 'Backend',
            'icon' => 'code',
        ]);

        \App\Models\Skill::create([
            'name' => 'Data Orchestration',
            'category' => 'Engineering',
            'icon' => 'build',
        ]);

        \App\Models\Certificate::create([
            'name' => 'Google Cloud Professional Data Engineer',
            'organizer' => 'Google',
            'duration' => 'Dec 2023 - Present',
            'link' => null,
        ]);

        $defaultSettings = [
            'hero_badge' => 'Forestry to Data Engineering',
            'hero_title' => 'Architecting <br/> <span class="text-transparent bg-clip-text bg-gradient-to-r from-[var(--accent-primary)] via-[var(--accent-tertiary)] to-[var(--accent-secondary)]">Complex Data</span> <br/> Systems',
            'hero_icon_1' => 'park',
            'hero_icon_2' => 'schema',
            'section_projects_title' => 'Featured Architecture',
            'section_projects_subtitle' => 'Deep dives into enterprise-scale data infrastructure and business logic engineering.',
            'section_skills_title' => 'Technical Toolbox',
            'section_skills_subtitle' => 'The technologies powering the infrastructure.',
            'section_certificates_title' => 'Certificates & Training',
            'section_certificates_subtitle' => 'Continuous learning and professional development achievements.',
            'site_logo_text' => 'Aldri<span class="text-[var(--accent-primary)]">.</span>',
            'site_footer_name' => 'Aldri Hardiansyah',
            'site_footer_copyright' => 'Data Engineer Portfolio.',
            'social_email' => '#',
            'social_link' => '#',
        ];

        foreach ($defaultSettings as $key => $value) {
            \App\Models\SiteSetting::create([
                'key' => $key,
                'value' => $value,
                'type' => 'text',
            ]);
        }
    }
}
