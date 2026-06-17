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
                'body'         => 'Memasuki dunia fotografi analog bisa terasa mengintimidasi bagi pemula. Dari berbagai format, jenis film, hingga mekanisme kamera mekanik versus elektronik, pilihan yang tersedia sangat luas. Langkah pertama yang paling krusial adalah memahami perbedaan antara kamera Point-and-Shoot, SLR, dan Rangefinder. Kamera SLR mekanik seperti seri Canon AE atau Pentax K menawarkan kebebasan kontrol penuh tanpa mengorbankan kemudahan belajar, karena sebagian besar telah dilengkapi dengan pengukur cahaya terintegrasi. Penting juga untuk memperhatikan ketersediaan dan harga film 35mm di pasaran sebelum menentukan pilihan akhir Anda.',
                'published_at' => now()->subDays(2),
            ],
            [
                'title'        => 'Sejarah Walkman Sony yang Legendaris',
                'tag'          => 'SEJARAH',
                'excerpt'      => 'Bagaimana Sony mengubah cara dunia mendengarkan musik selamanya melalui kaset portabel.',
                'image'        => $copyImage('Artikel_SejarahWalkman.jpg', 'articles'),
                'body'         => 'Pada akhir tahun 1970-an, mendengarkan musik adalah pengalaman yang terikat pada ruang tamu atau sistem audio di dalam mobil. Hal ini berubah secara dramatis ketika Sony memperkenalkan Walkman pertama pada tahun 1979. Perangkat ini tidak sekadar mengubah medium fisik pemutar musik, melainkan melahirkan budaya mendengarkan musik secara privat di ruang publik. Dengan menggunakan kaset pita magnetik, Walkman menghadirkan kompromi yang brilian antara kualitas suara dan portabilitas, memicu tren yang kelak menjadi fondasi bagi era pemutar MP3 dan layanan streaming digital masa kini.',
                'published_at' => now()->subDays(5),
            ],
            [
                'title'        => 'Tips Membeli Turntable Bekas',
                'tag'          => 'AUDIO',
                'excerpt'      => 'Mengapa banyak audiophile modern masih memburu pemutar piringan hitam klasik era 70-an dan 80-an.',
                'image'        => $copyImage('Artikel_TurntableBekas.jpg', 'articles'),
                'body'         => 'Di tengah kemudahan akses audio resolusi tinggi digital, popularitas turntable atau pemutar piringan hitam klasik justru kembali memuncak. Alasan utamanya bukan sekadar nostalgia, melainkan karakter suara analog yang khas. Perangkat keras dari era keemasan audio seperti era 70-an menggunakan komponen mekanis masif—seperti motor direct drive presisi dan tonearm dengan bahan berkualitas—yang sulit disamai oleh produk masa kini pada rentang harga serupa. Resonansi suara yang dihasilkan memiliki kehangatan harmonik yang tidak dapat direplikasi sempurna secara digital.',
                'published_at' => now()->subDays(10),
            ],
            [
                'title'        => 'Mengenal Kamera Polaroid SX-70',
                'tag'          => 'OPINI',
                'excerpt'      => 'Kamera instant lipat pertama Polaroid. Karya seni teknik yang mengubah fotografi instan.',
                'image'        => $copyImage('Produk_PolaroidSX-70.jpg', 'articles'),
                'body'         => 'Polaroid SX-70 adalah kamera instan SLR lipat yang diproduksi oleh Polaroid Corporation. Kamera ini diperkenalkan pada tahun 1972 dan merupakan salah satu desain paling ikonik dalam sejarah fotografi instan. Kamera ini tidak hanya menawarkan kemampuan untuk melihat pratinjau gambar melalui lensa (SLR), tetapi juga dapat dilipat menjadi bentuk datar, sehingga sangat portabel. Ini adalah kamera pertama yang menggunakan film integral Polaroid yang mengembangkan foto di depan mata Anda.',
                'published_at' => now()->subDays(15),
            ],
            [
                'title'        => 'Restorasi Radio Tabung Antik',
                'tag'          => 'TUTORIAL',
                'excerpt'      => 'Langkah-langkah dasar merestorasi radio tabung peninggalan kakek nenek Anda.',
                'image'        => $copyImage('Artikel_RestorasiRadioTabungAntik.jpg', 'articles'),
                'body'         => 'Merestorasi radio tabung adalah hobi yang memuaskan yang menggabungkan elektronik, pertukangan, dan sejarah. Langkah pertama adalah keamanan: selalu ingat bahwa radio tabung beroperasi pada tegangan tinggi yang mematikan. Setelah memastikan keamanan, Anda dapat mulai mengganti kapasitor tua (re-capping), yang hampir selalu diperlukan untuk radio dari era 1930-an hingga 1950-an. Kemudian, bersihkan sasis, periksa tabung vakum, dan kembalikan kilau kabinet kayu aslinya.',
                'published_at' => now()->subDays(20),
            ],
            [
                'title'        => 'Koleksi Konsol Game Retro Terbaik',
                'tag'          => 'REVIEW',
                'excerpt'      => 'Rangkuman konsol retro wajib yang layak Anda mainkan kembali di era modern.',
                'image'        => $copyImage('Artikel_KonsolTerbaik.jpg', 'articles'),
                'body'         => 'Nostalgia bermain video game jadul selalu menemukan tempat khusus. Walau grafisnya hanya sebatas 8-bit atau 16-bit, kualitas *gameplay* dan musik MIDI dari perangkat retro memberikan pengalaman tak tergantikan. Konsol seperti Sega Mega Drive dan Super Nintendo adalah bukti puncak rivalitas hardware game yang memunculkan banyak inovasi desain.',
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
