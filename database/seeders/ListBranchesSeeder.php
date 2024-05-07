<?php

namespace Database\Seeders;

use App\Models\ListBranch;
use App\Models\ListBranches;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ListBranchesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Head Office
        ListBranches::create([
            'category' => '',
            'domicile' => 'Jakarta | HEAD OFFICE',
            'address' => 'The City Center Batavia Tower One, Lt.17, Jl. KH Mas Mansyur Kav. 126, Jakarta 10220',
            'telp' => '+62 21 2700 590, 2700 600',
            'fax' => '',
            'email' => 'magline@mag.co.id',
            'lat' => '-6.217362',
            'long' => '106.904841',

        ]);

        // Health Insurance Department
        ListBranches::create([
            'category' => '',
            'domicile' => 'Jakarta | Health Insurance Department',
            'address' => 'Komp. Permata Senayan, Rukan E / 59 – 60, Lt. 1, Jl. Tentara Pelajar, Kebayoran Lama, Jakarta 12210',
            'telp' => '150180',
            'fax' => '+62 21 5794 4226',
            'email' => 'health@mag.co.id',
            'lat' => '-6.221070',
            'long' => '106.791960',

        ]);

        // Motor Claim Center
        // ListBranches::create([
        //     'category' => 'Head Office',
        //     'domicile' => 'Jakarta',
        //     'address' => 'Komp. Permata Senayan, Rukan E / 59 – 60, Lt. 2, Jl. Tentara Pelajar, Kebayoran Lama, Jakarta 12210',
        //     'telp' => '150180',
        //     'fax' => '',
        //     'email' => 'csclaim@mag.co.id',
        //     'lat' => '',
        //     'long' => '',

        // ]);

        // Branch Offices
        $branchOffices = [
            // Bandung
            [
                'category' => 'Branch Office',
                'domicile' => 'Bandung',
                'address' => 'Gedung Bank Panin, Lt. 4, Jl. Asia Afrika No. 166 – 170',
                'telp' => '+62 22 420 0751, 420 0752',
                'fax' => '+62 22 423 0105',
                'email' => 'bdg@mag.co.id',
                'lat' => '-6.512090',
                'long' => '108.214250',

            ],
            // Bandar Lampung
            [
                'category' => 'Branch Office',
                'domicile' => 'Bandar Lampung',
                'address' => 'Gedung Bank Panin, Lt. 3, Jl. R. A. Kartini No. 97 – 99, Tanjung Karang',
                'telp' => '+62 721 241 858 / 256 855 / 259 323',
                'fax' => '+62 721 241 859',
                'email' => 'lmp@mag.co.id',
                'lat' => '-5.41477',
                'long' => '105.25470',

            ],
            // Banjarmasin
            [
                'category' => 'Branch Office',
                'domicile' => 'Banjarmasin',
                'address' => 'Gedung Bank Panin, Lt. 3, Jl. A. Yani Km. 4,5 No. 31',
                'telp' => '+62 511 327 4770',
                'fax' => '+62 511 327 4946',
                'email' => 'bjm@mag.co.id',
                'lat' => '-6.563270',
                'long' => '106.781260',

            ],
            // Batam
            [
                'category' => 'Branch Office',
                'domicile' => 'Batam',
                'address' => 'Gedung Bank Panin, Lt. 3, Komp. Palm Spring Blok B 2 No. 9',
                'telp' => '+62 778 467 744',
                'fax' => '',
                'email' => 'btm@mag.co.id',
                'lat' => '1.188986',
                'long' => '104.082352',

            ],
            // Bogor
            [
                'category' => 'Branch Office',
                'domicile' => 'Bogor',
                'address' => 'Gedung Bank Panin, Lt. 2, Jl. Pakuan No. 14, Baranangsiang',
                'telp' => '+62 251 838 6918',
                'fax' => '+62 251 832 4721',
                'email' => 'bgr@mag.co.id',
                'lat' => '-6.604930',
                'long' => '106.813350',

            ],
            // Bekasi
            [
                'category' => 'Branch Office',
                'domicile' => 'Bekasi',
                'address' => 'Ruko Summarecon Bekasi, Cluster Emerald Commercial, Blok UB/008, Jl. Bulevar Selatan, Kota Bekasi',
                'telp' => '+62 21 455 508 / 2928 587',
                'fax' => '',
                'email' => 'bekasi@mag.co.id',
                'lat' => '-6.22775',
                'long' => '107.00423',

            ],
            // Denpasar
            [
                'category' => 'Branch Office',
                'domicile' => 'Denpasar',
                'address' => 'Jl. Mahendradata No. 5X, Denpasar',
                'telp' => '+62 361 907 1711',
                'fax' => '+62 361 907 1710',
                'email' => 'ktb2@mag.co.id',
                'lat' => '-8.659460',
                'long' => '115.197850',

            ],
            // Jakarta Palmerah
            [
                'category' => 'Branch Office',
                'domicile' => 'Jakarta Palmerah',
                'address' => 'Gedung Panin Bank Plaza, Lt. 5, Jl. Palmerah Utara No. 52',
                'telp' => '+62 21 8062 6888',
                'fax' => '+62 21 548 5379, 5365 4223',
                'email' => 'pal@mag.co.id',
                'lat' => '-6.20247',
                'long' => '106.79666',

            ],
            // Jakarta Senayan
            [
                'category' => 'Branch Office',
                'domicile' => 'Jakarta Senayan',
                'address' => 'Gedung Bank Panin Pusat, Lt. 8, Jl. Jend. Sudirman Kav. 1, Glora Tanah Abang, Senayan, Jakarta Pusat 10270',
                'telp' => '+62 21 270 0599',
                'fax' => '',
                'email' => 'marketing.corporate@mag.co.id',
                'lat' => '-6.22784',
                'long' => '106.79999',

            ],
            // Jakarta Permata Hijau
            [
                'category' => 'Branch Office',
                'domicile' => 'Jakarta Permata Hijau',
                'address' => 'Komp. Permata Senayan, Rukan E / 59 – 60, Lt 3, Jl. Tentara Pelajar, Kebayoran Lama, Jakarta 12210',
                'telp' => '+62 21 2929 9929',
                'fax' => '',
                'email' => 'sun@mag.co.id',
                'lat' => '-6.221070',
                'long' => '106.791960',

            ],
            // Makassar
            [
                'category' => 'Branch Office',
                'domicile' => 'Makassar',
                'address' => 'Gedung Bank Panin Dubai Syariah Lt. 2, Jl. Dr. Ratulangi No. 15A',
                'telp' => '+62 411 858 860',
                'fax' => '',
                'email' => 'mks@mag.co.id',
                'lat' => '-5.162444',
                'long' => '119.418370',

            ],
            // Manado
            [
                'category' => 'Branch Office',
                'domicile' => 'Manado',
                'address' => 'Gedung Bank Panin, Lt. 3, Komp. ITC Marina Plaza, Blok B No. 24-26',
                'telp' => '+62 431 888 0468',
                'fax' => '',
                'email' => 'mnd@mag.co.id',
                'lat' => '1.490481',
                'long' => '124.837155',

            ],
            // Medan
            [
                'category' => 'Branch Office',
                'domicile' => 'Medan',
                'address' => 'Gedung Bank Panin, Lt. 5, Jl. Pemuda No. 16 – 22',
                'telp' => '+62 61 452 4419, 451 0881',
                'fax' => '+62 61 415 8659',
                'email' => 'mdn@mag.co.id',
                'lat' => '3.58287',
                'long' => '98.68151',

            ],
            // Palembang
            [
                'category' => 'Branch Office',
                'domicile' => 'Palembang',
                'address' => 'Komp Ruko Rajawali Blok B1, Jl. Rajawali, Ilir Timur II',
                'telp' => '+62 711 357 104, 357 735',
                'fax' => '+62 711 352 135',
                'email' => 'plb@mag.co.id',
                'lat' => '-2.972190',
                'long' => '104.764320',

            ],
            // Pekanbaru
            [
                'category' => 'Branch Office',
                'domicile' => 'Pekanbaru',
                'address' => 'Gedung Bank Panin, Lt. 5, Komp. Pertokoan Bima Sakti, Jl. Jend. Sudirman No. 145',
                'telp' => '+62 761 860 869',
                'fax' => '',
                'email' => 'pkb@mag.co.id',
                'lat' => '-6.210905',
                'long' => '106.818121',

            ],
            // Semarang
            [
                'category' => 'Branch Office',
                'domicile' => 'Semarang',
                'address' => 'Gedung Bank Panin, Lt.2, Jl. Pandanaran No. 6-8',
                'telp' => '+62 24 841 9219, 841 3424',
                'fax' => '+62 24 845 0061',
                'email' => 'smg@mag.co.id',
                'lat' => '-6.999660',
                'long' => '110.385620',

            ],
            // Serpong
            [
                'category' => 'Branch Office',
                'domicile' => 'Serpong',
                'address' => 'Rukan Alam Sutera, Jl. Jalur Sutera 29 A No. 06, Alam Sutera, Tangerang',
                'telp' => '+62 21 5312 5438',
                'fax' => '+62 21 5312 5439',
                'email' => 'serpong@mag.co.id',
                'lat' => '-6.23469',
                'long' => '106.66021',

            ],
            // Surabaya Darmo
            [
                'category' => 'Branch Office',
                'domicile' => 'Surabaya Darmo',
                'address' => 'Gedung Bank Panin, Lt. 3, Jl. Raya Darmo No. 139.',
                'telp' => '+62 31 567 8434, 567 8436',
                'fax' => '+62 31 567 8458',
                'email' => 'sby@mag.co.id',
                'lat' => '-7.278650',
                'long' => '112.695180',

            ],
            // Surabaya Gubeng
            [
                'category' => 'Branch Office',
                'domicile' => 'Surabaya Gubeng',
                'address' => 'Jl. Raya Gubeng No. 32 F',
                'telp' => '+62 31 9944 3449',
                'fax' => '+62 31 9944 3450',
                'email' => 'sby2@mag.co.id',
                'lat' => '-7.27091',
                'long' => '112.74963',

            ],
            // Yogyakarta
            [
                'category' => 'Branch Office',
                'domicile' => 'Yogyakarta',
                'address' => 'Gedung Bank Panin, Lt. 2, Jl. Affandi CT X / 10, Depok, Sleman',
                'telp' => '+62 274 557 538',
                'fax' => '',
                'email' => 'yog@mag.co.id',
                'lat' => '-7.76453',
                'long' => '110.39324',

            ],
            // Data kantor cabang lainnya...
        ];

        foreach ($branchOffices as $office) {
            ListBranches::create($office);
        }

        // Representative Offices
        $representativeOffices = [
            // Ambon
            [
                'category' => 'Representative Office',
                'domicile' => 'Ambon',
                'address' => 'Gedung Bank Panin, Jl. Diponegoro No. 20',
                'telp' => '+62 911 351 294',
                'fax' => '+62 911 321 518',
                'email' => 'ambon@mag.co.id',
                'lat' => '-3.700390',
                'long' => '128.182140',

            ],
            // Balikpapan
            [
                'category' => 'Representative Office',
                'domicile' => 'Balikpapan',
                'address' => 'Gedung Bank Panin, Lt. 3, Jl. A. Yani No. 3',
                'telp' => '+62 542 444 681, 444 683',
                'fax' => '',
                'email' => 'bpn@mag.co.id',
                'lat' => '-3.437450',
                'long' => '114.857810',

            ],
            // Bengkulu
            [
                'category' => 'Representative Office',
                'domicile' => 'Bengkulu',
                'address' => 'Gedung Bank Panin, Lt. 3, Jl. Letjend. Suprapto No.30',
                'telp' => '+62 736 245 29',
                'fax' => '+62 736 245 26',
                'email' => 'bengkulu@mag.co.id',
                'lat' => '-0.473660',
                'long' => '117.142320',

            ],
            // Cirebon
            [
                'category' => 'Representative Office',
                'domicile' => 'Cirebon',
                'address' => 'Gedung Bank Panin Lt. 4, Cherbon Grand Center, Jl.Karanggetas No.64',
                'telp' => '+62 231 246 995',
                'fax' => '+62 231 880 4349',
                'email' => 'cirebon@mag.co.id',
                'lat' => '-7.817679',
                'long' => '112.013322',

            ],
            // Jakarta Kelapa Gading
            [
                'category' => 'Representative Office',
                'domicile' => 'Jakarta',
                'address' => 'Ruko Ray White Lt. 3, Jl. Raya Kelapa Hibrida Nok PE10 No. 32C, Pegangsaan Dua',
                'telp' => '+62 221 2455 5508',
                'fax' => '',
                'email' => 'kelapa gading@mag.co.id',
                'lat' => '',
                'long' => '',

            ],
            // Jambi
            [
                'category' => 'Representative Office',
                'domicile' => 'Jambi',
                'address' => 'Gedung Bank Panin, Lt. 2, Komp. Ruko WTC, Jl. Sultan Thaha Blok A No. 32-33',
                'telp' => '+62 741 783 7227',
                'fax' => '+62 741 783 7227',
                'email' => 'jmb@mag.co.id',
                'lat' => '-7.266732',
                'long' => '112.796385',

            ],
            // Jayapura
            [
                'category' => 'Representative Office',
                'domicile' => 'Jayapura',
                'address' => 'Gedung Panin Bank Abepura Lt. 3, Jl. Kali Acai Abepura',
                'telp' => '+62 967 589 171',
                'fax' => '+62 967 581 612',
                'email' => 'jyp@mag.co.id',
                'lat' => '-2.633330',
                'long' => '140.583330',

            ],
            // Kendari
            [
                'category' => 'Representative Office',
                'domicile' => 'Kendari',
                'address' => 'Gedung Bank Panin, Lt. 3, Jl. Ahmad Yani No. 30E',
                'telp' => '+62 401 312 4523',
                'fax' => '',
                'email' => 'kdi@mag.co.id',
                'lat' => '-4.005340',
                'long' => '122.498920',

            ],
            // Malang
            [
                'category' => 'Representative Office',
                'domicile' => 'Malang',
                'address' => 'Gedung Bank Panin, Lt. 2, Jl. Sultan Agung No. 14',
                'telp' => '+62 341 335 015',
                'fax' => '+62 341 361 187',
                'email' => 'mlg@mag.co.id',
                'lat' => '-7.978720',
                'long' => '112.635790',

            ],
            // Muara Bungo
            [
                'category' => 'Representative Office',
                'domicile' => 'Muara Bungo',
                'address' => 'Gedung Bank Panin, Lt. 3, Jl. Moh. Yamin Komplek Wiltop Blok B No. 36 - 37',
                'telp' => '+62 747 732 4164',
                'fax' => '+62 747 732 4164',
                'email' => 'muara.bungo@mag.co.id',
                'lat' => '-1.48158',
                'long' => '102.11740',

            ],
            // Padang
            [
                'category' => 'Representative Office',
                'domicile' => 'Padang',
                'address' => 'Gedung Bank Panin, Lt. 2, Jl. Pondok No. 92',
                'telp' => '+62 751 841 502',
                'fax' => '+62 751 841 546',
                'email' => 'pad@mag.co.id',
                'lat' => '-0.95655',
                'long' => '100.36109',

            ],
            // Palu
            [
                'category' => 'Representative Office',
                'domicile' => 'Palu',
                'address' => 'Gedung Bank Panin, Lt. 2, Komp. Palu Plaza Blok A1/B1, Jl. Danau Poso',
                'telp' => '+62 451 426 998',
                'fax' => '+62 451 425 810',
                'email' => 'plu@mag.co.id',
                'lat' => '-0.89930',
                'long' => '119.86076',

            ],
            // Pangkal Pinang
            [
                'category' => 'Representative Office',
                'domicile' => 'Pangkal Pinang',
                'address' => 'Gedung PT Clipan Finance Lt. 3, Ruko Bangka Square No. 4, Jl. Soekarno Hatta KM 5',
                'telp' => '+62 717 432 200',
                'fax' => '',
                'email' => 'pangkal.pinang@mag.co.id',
                'lat' => '-2.12886',
                'long' => '106.11778',

            ],
            // Pematang Siantar
            [
                'category' => 'Representative Office',
                'domicile' => 'Pematang Siantar',
                'address' => 'Gedung Bank Panin, Lt. 3, Jl. Soa Sio No. 22 A-B',
                'telp' => '+62 622 434 145',
                'fax' => '+62 622 434 145',
                'email' => 'siantar@mag.co.id',
                'lat' => '2.96065',
                'long' => '99.07197',

            ],
            // Pontianak
            [
                'category' => 'Representative Office',
                'domicile' => 'Pontianak',
                'address' => 'Gedung Bank Panin Lt. 3, Jl. Sultan Abdurrahman No. 4-5',
                'telp' => '+62 561 740 427',
                'fax' => '+62 561 766 721',
                'email' => 'ptk@mag.co.id',
                'lat' => '-0.03938',
                'long' => '109.32850',

            ],
            // Samarinda
            [
                'category' => 'Representative Office',
                'domicile' => 'Samarinda',
                'address' => 'Gedung Bank Panin, Lt. 3, Komp. Mall Lembuswana, Blok D1-D2, Jl. S. Parman',
                'telp' => '+62 541 739 277',
                'fax' => '',
                'email' => 'sam@mag.co.id',
                'lat' => '-0.47507',
                'long' => '117.14725',

            ],
            // Solo
            [
                'category' => 'Representative Office',
                'domicile' => 'Solo',
                'address' => 'Gedung Bank Panin, Lt. 1, Jl. Mayor Kusmanto No. 7',
                'telp' => '+62 271 660 910',
                'fax' => '+62 271 660 911',
                'email' => 'ska@mag.co.id',
                'lat' => '-7.57316',
                'long' => '110.82413',

            ],
        ];

        foreach ($representativeOffices as $office) {
            ListBranches::create($office);
        }
    }
}