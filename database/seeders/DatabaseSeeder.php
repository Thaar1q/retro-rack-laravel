<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // --- Admin & Demo User ---
        $admin = User::create([
            'name'     => 'Admin RetroRack',
            'email'    => 'admin@mail.com',
            'password' => bcrypt('12345678'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'Budi Santoso',
            'email'    => 'user@mail.com',
            'password' => bcrypt('12345678'),
            'role'     => 'user',
        ]);

        // --- Categories ---
        $categories = [
            ['name' => 'Kamera',   'slug' => 'kamera',   'icon' => 'camera'],
            ['name' => 'Audio',    'slug' => 'audio',    'icon' => 'sliders'],
            ['name' => 'Video',    'slug' => 'video',    'icon' => 'video'],
            ['name' => 'Komputer', 'slug' => 'komputer', 'icon' => 'cpu'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        $kamera   = Category::where('slug', 'kamera')->first();
        $audio    = Category::where('slug', 'audio')->first();
        $video    = Category::where('slug', 'video')->first();
        $komputer = Category::where('slug', 'komputer')->first();

        // Copy images to public disk
        $fs = new \Illuminate\Filesystem\Filesystem;
        $imageDir = database_path('seeders/images');
        $publicDir = storage_path('app/public');
        
        if (!\Storage::disk('public')->exists('products')) {
            \Storage::disk('public')->makeDirectory('products');
        }
        if (!\Storage::disk('public')->exists('articles')) {
            \Storage::disk('public')->makeDirectory('articles');
        }

        $copyImage = function($filename, $type) use ($imageDir) {
            $source = $imageDir . '/' . $filename;
            if (\File::exists($source)) {
                $target = $type . '/' . $filename;
                \Storage::disk('public')->put($target, \File::get($source));
                return $target;
            }
            return null;
        };

        // --- Products ---
        $products = [
            ['category_id' => $kamera->id,   'name' => 'Canon AE-1 Program',              'year' => 1981, 'price' => 2500000, 'condition' => 'baik',       'stock' => 3, 'image' => $copyImage('Produk_CanonAE1Program.jpg', 'products'), 'description' => 'Kamera SLR 35mm ikonik. Mudah digunakan dan populer di kalangan fotografer film.'],
            ['category_id' => $audio->id,    'name' => 'Sony Walkman WM-D6C',             'year' => 1984, 'price' => 3800000, 'condition' => 'sangat_baik', 'stock' => 2, 'image' => $copyImage('Produk_SonyWalkmanWM-D6C.jpg', 'products'), 'description' => 'Walkman profesional dengan kemampuan recording. Kondisi sangat baik, semua tombol berfungsi.'],
            ['category_id' => $audio->id,    'name' => 'Technics SL-1200MK2',             'year' => 1979, 'price' => 5200000, 'condition' => 'baik',        'stock' => 1, 'image' => $copyImage('Produk_TechnicsSL-1200MK2.jpg', 'products'), 'description' => 'Turntable legendaris pilihan para DJ dan audiophile. Motor direct drive, stabil dan handal.'],
            ['category_id' => $kamera->id,   'name' => 'Polaroid SX-70',                  'year' => 1972, 'price' => 1800000, 'condition' => 'cukup',       'stock' => 4, 'image' => $copyImage('Produk_PolaroidSX-70.jpg', 'products'), 'description' => 'Kamera instant lipat pertama Polaroid. Karya seni teknik yang mengubah fotografi instan.'],
            ['category_id' => $audio->id,    'name' => 'Sony Microcassette-Corder M-470', 'year' => 1975, 'price' => 950000,  'condition' => 'baik',        'stock' => 5, 'image' => $copyImage('Produk_SonyMicrocassette-CorderM-470.jpg', 'products'), 'description' => 'Recorder microcassette ringkas, ideal untuk jurnalis dan meeting.'],
            ['category_id' => $komputer->id, 'name' => 'Commodore 64',                    'year' => 1982, 'price' => 4500000, 'condition' => 'sangat_baik', 'stock' => 1, 'image' => $copyImage('Produk_Commodore64.jpg', 'products'), 'description' => 'Komputer rumahan terlaris sepanjang masa. Lengkap dengan power supply dan kabel.'],
            ['category_id' => $kamera->id,   'name' => 'Nikon FM2',                       'year' => 1982, 'price' => 3200000, 'condition' => 'sangat_baik', 'stock' => 2, 'image' => $copyImage('Produk_NikonFM2.jpg', 'products'), 'description' => 'Kamera SLR full mekanik legendaris yang tangguh.'],
            ['category_id' => $video->id,    'name' => 'Sony Trinitron KV-1311CR',        'year' => 1985, 'price' => 2100000, 'condition' => 'baik',        'stock' => 1, 'image' => $copyImage('Produk_SonyTrinitronKV-1311CR.jpg', 'products'), 'description' => 'TV CRT klasik dengan warna Trinitron yang tajam, sangat cocok untuk retro gaming.'],
            ['category_id' => $kamera->id,   'name' => 'Pentax K1000',                    'year' => 1976, 'price' => 1500000, 'condition' => 'cukup',       'stock' => 4, 'image' => $copyImage('Produk_PentaxK1000.jpg', 'products'), 'description' => 'Kamera pelajar sepanjang masa. Full mekanik dan sangat andal.'],
            ['category_id' => $audio->id,    'name' => 'Akai GX-77',                      'year' => 1981, 'price' => 8500000, 'condition' => 'mint',        'stock' => 1, 'image' => $copyImage('Produk_AkaiGX-77.jpg', 'products'), 'description' => 'Reel to reel tape deck yang legendaris, kondisi mint like new.'],
            ['category_id' => $komputer->id, 'name' => 'Sega Mega Drive',                 'year' => 1988, 'price' => 1200000, 'condition' => 'baik',        'stock' => 3, 'image' => $copyImage('Produk-SegaMegaDrive.jpg', 'products'), 'description' => 'Konsol 16-bit legendaris Sega. Lengkap 2 controller.'],
            ['category_id' => $kamera->id,   'name' => 'Olympus OM-1',                    'year' => 1972, 'price' => 2400000, 'condition' => 'sangat_baik', 'stock' => 2, 'image' => $copyImage('Produk_OlympusOM-1.jpg', 'products'), 'description' => 'Kamera SLR full mekanik yang ringkas dan cantik dari Olympus.'],
            ['category_id' => $kamera->id,   'name' => 'Minolta X-700',                   'year' => 1981, 'price' => 1900000, 'condition' => 'baik',        'stock' => 2, 'image' => $copyImage('Produk_MinoltaX-700.jpg', 'products'), 'description' => 'Kamera SLR canggih dengan mode program unggulan pada zamannya.']
        ];

        foreach ($products as $data) {
            Product::create(array_merge($data, [
                'slug'      => Str::slug($data['name']),
                'is_active' => true,
            ]));
        }

        // --- Articles ---
        $articles = [
            [
                'title'        => 'Panduan Merawat Kamera Film Vintage',
                'tag'          => 'TUTORIAL',
                'excerpt'      => 'Memulai hobi fotografi film tidak harus mahal dan rumit. Berikut panduan langkah demi langkah.',
                'image'        => $copyImage('Artikel_KameraFilmVintage.jpg', 'articles'),
                'body'         => '> *"Memasuki dunia fotografi analog bisa terasa mengintimidasi bagi pemula. Dari berbagai format, jenis film, hingga mekanisme kamera."*

Langkah pertama yang paling krusial adalah memahami perbedaan antara kamera *Point-and-Shoot*, SLR, dan *Rangefinder*. Kamera SLR mekanik seperti seri **Canon AE** atau **Pentax K** menawarkan kebebasan kontrol penuh tanpa mengorbankan kemudahan belajar, karena sebagian besar telah dilengkapi dengan pengukur cahaya terintegrasi. Penting juga untuk memperhatikan ketersediaan dan harga film 35mm di pasaran sebelum menentukan pilihan akhir.

Setelah memiliki kamera, perawatannya sangatlah vital agar lensa dan bodi tidak berjamur. Anda harus selalu membersihkan kamera setelah digunakan, terutama setelah dari tempat yang lembab atau berdebu. Gunakan *blower* atau kuas khusus lensa untuk membersihkan debu tanpa menggores elemen optik yang rapuh.

Penyimpanan yang tepat akan memperpanjang umur kamera Anda hingga puluhan tahun. Hindari menyimpan kamera di dalam tas dalam jangka waktu yang lama, karena serat kain dapat menyerap kelembaban dan memicu tumbuhnya jamur lensa.

Berikut adalah beberapa langkah penting dalam merawat kamera film kesayangan Anda:
- **Gunakan Dry Box:** Simpan kamera di dalam *dry box* atau wadah kedap udara yang dilengkapi dengan *silica gel* untuk menjaga tingkat kelembaban.
- **Lepas Baterai:** Jika kamera tidak akan digunakan dalam waktu lama, selalu lepaskan baterai untuk menghindari kebocoran kimiawi.
- **Service Berkala:** Lakukan servis atau *Clean, Lubricate, Adjust* (CLA) pada teknisi terpercaya setiap beberapa tahun sekali.

---',
                'published_at' => now()->subDays(2),
            ],
            [
                'title'        => 'Sejarah Walkman Sony yang Legendaris',
                'tag'          => 'SEJARAH',
                'excerpt'      => 'Bagaimana Sony mengubah cara dunia mendengarkan musik selamanya melalui kaset portabel.',
                'image'        => $copyImage('Artikel_SejarahWalkman.jpg', 'articles'),
                'body'         => '> *"Inovasi ini tidak hanya menghadirkan portabilitas, tetapi juga mendefinisikan ulang cara manusia berinteraksi dengan lagu favorit."*

Sebelum kehadiran era digital dan layanan *streaming*, mendengarkan musik saat bepergian adalah sebuah kemewahan. Semua itu berubah drastis ketika **Sony** memperkenalkan Walkman pertama ke hadapan publik, membebaskan musik dari batasan ruang keluarga.

Dengan ukuran yang cukup ringkas dan ditenagai baterai standar, Walkman menghadirkan kompromi brilian antara kualitas suara kaset pita dan mobilitas. Pengguna kini dapat menciptakan *soundtrack* untuk kehidupan sehari-hari mereka.

Dampak budaya yang ditimbulkan sangat masif. Fenomena mendengarkan musik dengan *headphone* di tempat umum mulai dinormalisasi. Walkman menjelma menjadi ikon mode dan simbol kebebasan berekspresi bagi generasi muda era 80-an.

Alasan Walkman tetap diminati:
- **Sensasi Otentik:** Merasakan kembali putaran roda gigi analog yang tak tergantikan.
- **Koleksi Fisik:** Apresiasi terhadap seni *cover* kaset dan *liner notes*.
- **Kualitas Mekanis:** Unit klasik seperti *Sony WM-D6C* menawarkan *build quality* premium.

Kini, warisan Walkman tetap abadi di kalangan kolektor dan penikmat audio puritan.

---',
                'published_at' => now()->subDays(5),
            ],
            [
                'title'        => 'Tips Membeli Turntable Bekas',
                'tag'          => 'AUDIO',
                'excerpt'      => 'Mengapa banyak audiophile modern masih memburu pemutar piringan hitam klasik era 70-an dan 80-an.',
                'image'        => $copyImage('Artikel_TurntableBekas.jpg', 'articles'),
                'body'         => '> *"Fenomena ini bukan sekadar tren sesaat, melainkan bentuk apresiasi terhadap kualitas audio analog yang hangat."*

Di era ketika jutaan lagu dapat diakses dengan satu ketukan jari, pemutar piringan hitam (*turntable*) klasik justru kembali meraih popularitas. Bagi para penikmat musik, ritual meletakkan jarum di atas piringan hitam menawarkan pengalaman yang jauh lebih intim.

Membeli *turntable* bekas dari era keemasan audio (1970-an hingga 1980-an) sering kali menjadi pilihan terbaik. Pabrikan seperti **Technics, Pioneer, dan Sansui** merancang perangkat mereka dengan material kelas berat (*over-engineered*) yang dirancang untuk bertahan lintas generasi.

Namun, tidak semua *turntable* tua layak direstorasi. Ada beberapa komponen krusial yang wajib diperiksa:
- **Kestabilan Motor:** Pastikan putaran piringan stabil (33 1/3 dan 45 RPM) tanpa fluktuasi (*wow and flutter*).
- **Kondisi Tonearm:** Pergerakan harus sangat mulus tanpa hambatan fisik.
- **Ketersediaan Sparepart:** Pilih merek populer yang komponennya (seperti *stylus* dan *belt*) mudah ditemukan.
- **Sistem Kabel:** Pastikan kabel RCA dan *ground* bawaan tidak menyebabkan dengung (*humming*).

Dengan panduan yang tepat, menemukan *turntable* *vintage* sempurna dapat menjadi awal perjalanan artistik Anda.

---',
                'published_at' => now()->subDays(10),
            ],
            [
                'title'        => 'Mengenal Kamera Polaroid SX-70',
                'tag'          => 'OPINI',
                'excerpt'      => 'Kamera instant lipat pertama Polaroid. Karya seni teknik yang mengubah fotografi instan.',
                'image'        => $copyImage('Produk_PolaroidSX-70.jpg', 'articles'),
                'body'         => '> *"SX-70 bukan sekadar kamera instan biasa; ia adalah kamera Single-Lens Reflex (SLR) instan pertama."*

Di antara berbagai inovasi teknologi abad ke-20, kamera **Polaroid SX-70** berdiri sebagai salah satu mahakarya desain industri yang paling ikonis. Diluncurkan pertama kali pada tahun 1972, desain lipatnya yang futuristik menjadikannya perangkat ajaib yang mampu bertransformasi dari benda seukuran buku tipis menjadi sebuah kamera profesional yang kokoh.

Keajaiban sejati SX-70 terletak pada **teknologi film integral** yang diperkenalkannya. Berbeda dengan generasi Polaroid sebelumnya, film SX-70 keluar dari kamera dalam keadaan kering dan perlahan memunculkan gambar. Proses pengembangan gambar di bawah sinar matahari ini memberikan sensasi magis tersendiri.

Sistem optik dan mekanis yang dijejalkan ke dalam bodi ramping SX-70 sangatlah kompleks dan revolusioner. Tidak heran jika SX-70 segera menjadi perangkat favorit para seniman, termasuk nama-nama besar seperti *Andy Warhol* dan *Ansel Adams*.

Keunggulan utama Polaroid SX-70 meliputi:
- **Material Premium:** Bodi kamera dilapisi kulit asli dan baja tahan karat.
- **Fokus Jarak Dekat:** Mampu mengambil gambar fokus hingga 10.4 inci (fotografi makro instan).
- **Eksposur Otomatis:** Sensor cahaya pintar mengatur kecepatan rana secara otomatis.
- **Baterai pada Kartrid:** Film SX-70 klasik dilengkapi baterai tipis di dalamnya.

Hari ini, Polaroid SX-70 kembali menemukan napasnya, merayakan harmoni antara teknik rekayasa yang brilian dan estetika desain yang murni.

---',
                'published_at' => now()->subDays(15),
            ],
            [
                'title'        => 'Restorasi Radio Tabung Antik',
                'tag'          => 'TUTORIAL',
                'excerpt'      => 'Langkah-langkah dasar merestorasi radio tabung peninggalan kakek nenek Anda.',
                'image'        => $copyImage('Artikel_RestorasiRadioTabungAntik.jpg', 'articles'),
                'body'         => '> *"Sebuah radio kayu besar yang tampak kusam di sudut garasi menyimpan potensi besar untuk dihidupkan kembali."*

Bagi mereka yang memiliki ketertarikan mendalam pada elektronika dan sejarah, merestorasi radio tabung antik menawarkan kepuasan hobi yang tiada duanya. Proyek ini menggabungkan pemahaman kelistrikan, seni pertukangan kayu, hingga kesabaran dalam mencari komponen langka.

Langkah paling krusial sebelum memulai proyek restorasi radio tabung adalah mematuhi **protokol keselamatan**. Radio tabung vakum beroperasi dengan tegangan arus searah (DC) yang sangat tinggi (melebihi 300 volt). Listrik bertegangan tinggi ini dapat tersimpan di dalam kapasitor berhari-hari lamanya.

Proses perbaikan sirkuit biasanya dimulai dengan *"re-capping"*, yakni penggantian semua kapasitor kertas dan kapasitor elektrolit lama. Setelah urusan kelistrikan selesai, perhatian biasanya beralih pada perbaikan estetika kabinet kayu, seperti veneer walnut atau mahoni.

Untuk memastikan proyek restorasi berjalan aman dan sukses:
- **Jangan Pernah Langsung Dicolok:** Gunakan alat bernama *"dim bulb tester"* atau Variac.
- **Dokumentasi Menyeluruh:** Ambil foto beresolusi tinggi sebelum memotong komponen.
- **Ganti Kabel Daya:** Kabel bawaan yang getas wajib diganti dengan kabel modern.
- **Skema Sirkuit:** Selalu dapatkan skema (*schematic diagram*) asli dari model radio tersebut.

---',
                'published_at' => now()->subDays(20),
            ],
            [
                'title'        => 'Tren Koleksi Konsol Game Retro',
                'tag'          => 'REVIEW',
                'excerpt'      => 'Rangkuman konsol retro wajib yang layak Anda mainkan kembali di era modern.',
                'image'        => $copyImage('Artikel_KonsolTerbaik.jpg', 'articles'),
                'body'         => '> *"Evolusi industri video game modern dengan grafis fotorealistis nyatanya tidak mengubur pesona konsol klasik."*

Di tengah gempuran teknologi mutakhir, banyak gamer yang justru merindukan kesederhanaan dan tantangan murni yang ditawarkan oleh mesin-mesin game **8-bit** dan **16-bit** dari era 80-an serta 90-an. Nostalgia ini telah memicu kebangkitan kembali minat terhadap konsol retro di seluruh dunia.

Perangkat legendaris seperti *Nintendo Entertainment System (NES)* dan *Sega Mega Drive* memiliki tempat istimewa karena mereka meletakkan fondasi bagi hampir seluruh genre game modern. Keterbatasan perangkat keras pada masa itu memaksa para pengembang untuk fokus secara maksimal pada kualitas *gameplay*, desain level yang cerdik, dan musik *chiptune* yang sangat ikonik.

Mengoleksi konsol retro bukan sekadar tentang menyimpan barang antik, melainkan upaya melestarikan potongan sejarah interaktif. Setiap kaset atau kartrid yang ditiup sebelum dimasukkan ke dalam slot memberikan sensasi fisik yang sepenuhnya hilang pada era distribusi game digital saat ini. 

Bagi para kolektor pemula, membangun koleksi retro yang ideal membutuhkan dedikasi dan ketelitian:
- **Visual Asli:** Menggunakan televisi CRT asli untuk akurasi visual yang maksimal.
- **Kenyamanan Modern:** Menggunakan *upscaler* modern untuk kenyamanan layar datar.
- **Perawatan Rutin:** Membersihkan pin konektor kartrid secara berkala agar tidak berkarat.

---',
                'published_at' => now()->subDays(25),
            ],
        ];

        foreach ($articles as $data) {
            Article::create(array_merge($data, [
                'user_id'      => $admin->id,
                'slug'         => Str::slug($data['title']),
                'is_published' => true,
            ]));
        }
    }
}
