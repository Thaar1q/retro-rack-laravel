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
                'body'         => '',
                'published_at' => now()->subDays(5),
            ],
            [
                'title'        => 'Tips Membeli Turntable Bekas',
                'tag'          => 'AUDIO',
                'excerpt'      => 'Mengapa banyak audiophile modern masih memburu pemutar piringan hitam klasik era 70-an dan 80-an.',
                'image'        => $copyImage('Artikel_TurntableBekas.jpg', 'articles'),
                'body'         => 'Di era ketika jutaan lagu dapat diakses hanya dengan satu ketukan jari, pemutar piringan hitam atau turntable klasik justru kembali meraih popularitas yang luar biasa. Fenomena ini bukan sekadar tren sesaat, melainkan sebuah bentuk apresiasi terhadap kualitas audio analog yang hangat, kaya, dan memiliki karakter unik. Bagi para penikmat musik, ritual meletakkan jarum di atas piringan hitam menawarkan pengalaman mendengarkan yang jauh lebih intim dan fokus.


Membeli turntable bekas dari era keemasan audio, khususnya periode 1970-an hingga awal 1980-an, sering kali menjadi pilihan terbaik dibandingkan membeli unit baru di kelas harga menengah ke bawah. Pabrikan pada era tersebut, seperti Technics, Pioneer, dan Sansui, merancang perangkat mereka dengan material kelas berat dan ketepatan mekanis (over-engineered) yang sangat mengagumkan dan dirancang untuk bertahan lintas generasi.


Namun, terjun ke pasar perangkat audio vintage tentu membutuhkan kejelian ekstra. Tidak semua turntable tua layak untuk direstorasi, dan beberapa kerusakan mekanis bisa memakan biaya perbaikan yang melebihi harga beli unit itu sendiri. Oleh karena itu, ada beberapa komponen krusial yang wajib diperiksa sebelum Anda memutuskan untuk membawa pulang sebuah turntable klasik.



    - **Kestabilan Motor:** Pastikan putaran piringan stabil di angka 33 1/3 dan 45 RPM tanpa adanya fluktuasi suara (wow and flutter).

    - **Kondisi Tonearm:** Periksa pergerakan tonearm yang harus sangat mulus tanpa hambatan fisik saat digerakkan dari pinggir ke tengah.

    - **Ketersediaan Sparepart:** Pilih merek populer yang komponen penggantinya seperti jarum (stylus) dan sabuk pemutar (belt) masih mudah ditemukan di pasaran.

    - **Sistem Kabel:** Pastikan kabel RCA dan kabel ground bawaan masih utuh dan tidak menyebabkan dengung (humming) saat disambungkan ke amplifier.



Dengan panduan yang tepat dan sedikit kesabaran, menemukan turntable vintage yang sempurna dapat menjadi awal dari perjalanan panjang menikmati musik dalam bentuk fisiknya yang paling memukau dan artistik.

---',
                'published_at' => now()->subDays(10),
            ],
            [
                'title'        => 'Mengenal Kamera Polaroid SX-70',
                'tag'          => 'OPINI',
                'excerpt'      => 'Kamera instant lipat pertama Polaroid. Karya seni teknik yang mengubah fotografi instan.',
                'image'        => $copyImage('Produk_PolaroidSX-70.jpg', 'articles'),
                'body'         => 'Di antara berbagai inovasi teknologi abad ke-20, kamera Polaroid SX-70 berdiri sebagai salah satu mahakarya desain industri yang paling ikonis. Diluncurkan pertama kali pada tahun 1972, SX-70 bukan sekadar kamera instan biasa; ia adalah kamera Single-Lens Reflex (SLR) instan pertama yang memungkinkan fotografer melihat tepat apa yang akan ditangkap oleh lensa. Desain lipatnya yang futuristik menjadikannya perangkat ajaib yang mampu bertransformasi dari benda seukuran buku tipis menjadi sebuah kamera profesional yang kokoh.


Keajaiban sejati SX-70 terletak pada teknologi film integral yang diperkenalkannya. Berbeda dengan generasi Polaroid sebelumnya yang mengharuskan penggunanya mengelupas lapisan kimia dengan tangan, film SX-70 keluar dari kamera dalam keadaan kering dan perlahan memunculkan gambar di hadapan mata penggunanya. Proses pengembangan gambar yang terjadi di bawah sinar matahari ini memberikan sensasi magis yang belum pernah ada sebelumnya.


Sistem optik dan mekanis yang dijejalkan ke dalam bodi ramping SX-70 sangatlah kompleks dan revolusioner. Dengan memanfaatkan serangkaian cermin dan lensa fresnel yang presisi, kamera ini memadukan kemampuan pemfokusan manual yang tajam dengan portabilitas ekstrem. Tidak heran jika SX-70 segera menjadi perangkat favorit para seniman, arsitek, dan desainer, termasuk nama-nama besar seperti Andy Warhol dan Ansel Adams.



    - **Material Premium:** Bodi kamera dilapisi kulit asli dan baja tahan karat, memberikan kesan mewah yang tak lekang oleh waktu.

    - **Fokus Jarak Dekat:** SX-70 mampu mengambil gambar fokus dengan jarak sangat dekat hingga 10.4 inci, sempurna untuk fotografi makro instan.

    - **Eksposur Otomatis:** Dilengkapi dengan sensor cahaya pintar yang mampu mengatur kecepatan rana dari hitungan milidetik hingga beberapa detik secara otomatis.

    - **Baterai pada Kartrid:** Setiap bungkus film SX-70 klasik dilengkapi baterai tipis di dalamnya, memastikan kamera selalu mendapat daya baru setiap kali film diganti.



Hari ini, berkat komunitas pencinta film analog dan perusahaan modern yang kembali memproduksi film format aslinya, Polaroid SX-70 kembali menemukan napasnya. Menggunakan SX-70 di era modern bukan hanya tentang menangkap momen, melainkan merayakan harmoni antara teknik rekayasa yang brilian dan estetika desain yang murni.

---',
                'published_at' => now()->subDays(15),
            ],
            [
                'title'        => 'Restorasi Radio Tabung Antik',
                'tag'          => 'TUTORIAL',
                'excerpt'      => 'Langkah-langkah dasar merestorasi radio tabung peninggalan kakek nenek Anda.',
                'image'        => $copyImage('Artikel_RestorasiRadioTabungAntik.jpg', 'articles'),
                'body'         => 'Bagi mereka yang memiliki ketertarikan mendalam pada elektronika dan sejarah, merestorasi radio tabung antik menawarkan kepuasan hobi yang tiada duanya. Proyek ini menggabungkan berbagai keahlian—mulai dari pemahaman kelistrikan, seni pertukangan kayu untuk memperbaiki kabinet, hingga kesabaran dalam mencari komponen pengganti yang langka. Sebuah radio kayu besar yang mungkin tampak kusam di sudut garasi kakek Anda sebenarnya menyimpan potensi besar untuk dihidupkan kembali sebagai pusat perhatian di ruang keluarga.


Langkah paling krusial sebelum memulai proyek restorasi radio tabung adalah menyadari dan mematuhi protokol keselamatan. Berbeda dengan perangkat elektronik modern yang menggunakan tegangan rendah berkat transistor, radio tabung vakum beroperasi dengan tegangan arus searah (DC) yang sangat tinggi, sering kali melebihi 300 volt. Listrik bertegangan tinggi ini dapat tersimpan di dalam kapasitor elektrolit bahkan setelah kabel listrik dicabut berhari-hari lamanya, menjadikannya sangat berbahaya jika disentuh tanpa kehati-hatian.


Proses perbaikan sirkuit biasanya dimulai dengan apa yang disebut oleh para penghobi sebagai "re-capping", yakni penggantian semua kapasitor kertas dan kapasitor elektrolit lama. Kapasitor berbahan kertas dari era 1930-an hingga 1950-an memiliki tingkat kegagalan nyaris 100 persen di masa sekarang karena bahan penyekatnya (dielektrik) yang menyerap kelembaban seiring berjalannya waktu. Memaksa menghidupkan radio tua dengan kapasitor asli dapat menyebabkan kerusakan fatal pada transformator daya yang sangat sulit dicari penggantinya.


Setelah urusan kelistrikan selesai dan radio kembali dapat menangkap siaran dengan jernih, perhatian biasanya beralih pada perbaikan estetika kabinet kayu. Kebanyakan radio antik dibalut dengan pelapis kayu tipis (veneer) mewah seperti walnut atau mahoni yang sering kali sudah terkelupas atau tergores. Mengembalikan kilau orisinalnya menuntut ketelatenan dalam proses pengelupasan pernis lama, pengamplasan halus, hingga penerapan lapisan pelindung akhir seperti lacquer atau shellac.


Selain kabinet kayu, detail estetika lain seperti kain penutup speaker (grill cloth) dan kenop putar (knob) juga memainkan peran besar dalam tampilan akhir. Kain penutup asli yang robek sering kali harus diganti dengan kain reproduksi modern yang meniru pola tenunan akustik era tersebut. Proses mencari suku cadang dan material semacam ini justru menjadi petualangan tersendiri bagi para penggiat restorasi.


Untuk memastikan proyek restorasi Anda berjalan aman dan sukses, perhatikan tahapan-tahapan penting berikut ini:



    - **Jangan Pernah Langsung Dicolok:** Hindari godaan untuk mencolokkan radio tua langsung ke stopkontak; gunakan alat bernama "dim bulb tester" atau Variac untuk menaikkan tegangan secara perlahan dan aman.

    - **Dokumentasi Menyeluruh:** Ambil foto beresolusi tinggi dari setiap sudut sasis dan jalur perkabelan sebelum Anda memotong atau mencabut komponen apa pun sebagai panduan perakitan kembali.

    - **Ganti Kabel Daya:** Kabel listrik bawaan yang sudah getas dan mengelupas wajib segera diganti dengan kabel berinsulasi ganda modern untuk mencegah risiko korsleting atau sengatan listrik.

    - **Skema Sirkuit:** Selalu berusahalah mendapatkan skema (schematic diagram) asli dari model radio tersebut, seperti yang sering ditemukan pada literatur klasik Rider\'s Perpetual Troubleshooter\'s Manuals.



Mendengarkan siaran langsung dari radio tabung yang bersinar hangat memberikan nuansa nostalgia akustik yang mustahil disamai oleh pengeras suara pintar modern. Resonansi suara yang dipancarkan melalui kabinet kayu tua tersebut tidak hanya menggetarkan udara, tetapi juga menjadi saksi bisu kebangkitan kembali mahakarya rekayasa masa lalu di tangan Anda yang terampil.

---',
                'published_at' => now()->subDays(20),
            ],
            [
                'title'        => 'Tren Koleksi Konsol Game Retro',
                'tag'          => 'REVIEW',
                'excerpt'      => 'Rangkuman konsol retro wajib yang layak Anda mainkan kembali di era modern.',
                'image'        => $copyImage('Artikel_KonsolTerbaik.jpg', 'articles'),
                'body'         => 'Evolusi industri video game modern dengan grafis fotorealistis dan realitas virtual yang menakjubkan nyatanya tidak serta-merta mengubur pesona konsol klasik. Di tengah gempuran teknologi mutakhir, banyak gamer yang justru merindukan kesederhanaan dan tantangan murni yang ditawarkan oleh mesin-mesin game 8-bit dan 16-bit dari era 80-an serta 90-an. Nostalgia ini telah memicu kebangkitan kembali minat terhadap konsol retro di seluruh dunia.


Perangkat legendaris seperti Nintendo Entertainment System (NES) dan Sega Mega Drive memiliki tempat istimewa karena mereka meletakkan fondasi bagi hampir seluruh genre game modern. Keterbatasan perangkat keras pada masa itu memaksa para pengembang untuk fokus secara maksimal pada kualitas gameplay, desain level yang cerdik, dan musik chiptune yang sangat ikonik hingga mudah melekat di ingatan.


Mengoleksi konsol retro bukan sekadar tentang menyimpan barang antik, melainkan upaya melestarikan potongan sejarah interaktif. Setiap kaset atau kartrid yang ditiup sebelum dimasukkan ke dalam slot memberikan sensasi fisik yang sepenuhnya hilang pada era distribusi game digital saat ini. Sensasi taktil ini menjadi daya tarik tersendiri bagi generasi yang tumbuh bersamanya maupun generasi baru yang penasaran.


Bagi para kolektor pemula, membangun koleksi retro yang ideal membutuhkan dedikasi dan ketelitian. Memilih antara menggunakan televisi CRT asli untuk akurasi visual yang maksimal atau menggunakan upscaler modern untuk kenyamanan layar datar adalah salah satu dari sekian banyak keputusan menarik yang akan dihadapi dalam perjalanan menghidupkan kembali masa keemasan video game.

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
