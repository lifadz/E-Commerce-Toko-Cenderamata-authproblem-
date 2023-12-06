<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $provinces = array(
			array('code' => 'NAD', 'name' => 'Nanggroe Aceh Darussalam'),
			array('code' => 'SMU', 'name' => 'Sumatera Utara'),
			array('code' => 'SSL', 'name' => 'Sumatera Selatan'),
			array('code' => 'SSB', 'name' => 'Sumatera Barat'),
			array('code' => 'BKL', 'name' => 'Bengkulu'),
			array('code' => 'RAU', 'name' => 'Riau'),
			array('code' => 'KRU', 'name' => 'Kepulauan Riau'),
			array('code' => 'JMI', 'name' => 'Jambi'),
			array('code' => 'LMP', 'name' => 'Lampung'),
			array('code' => 'BBL', 'name' => 'Bangka Belitung'),
			array('code' => 'KBR', 'name' => 'Kalimantan Barat'),
			array('code' => 'KTM', 'name' => 'Kalimantan Timur'),
			array('code' => 'KSN', 'name' => 'Kalimantan Selatan'),
			array('code' => 'KTG', 'name' => 'Kalimantan Tengah'),
			array('code' => 'KUT', 'name' => 'Kalimantan Utara'),
			array('code' => 'BTN', 'name' => 'Banten'),
			array('code' => 'JKT', 'name' => 'DKI Jakarta'),
			array('code' => 'JBR', 'name' => 'Jawa Barat'),
			array('code' => 'JTG', 'name' => 'Jawa Tengah'),
			array('code' => 'DIY', 'name' => 'Daerah Istimewa Yogyakarta'),
			array('code' => 'JTM', 'name' => 'Jawa Timur'),
			array('code' => 'BLI', 'name' => 'Bali'),
			array('code' => 'NTT', 'name' => 'Nusa Tenggara Timur'),
			array('code' => 'NTB', 'name' => 'Nusa Tenggara Barat'),
			array('code' => 'GRO', 'name' => 'Gorontalo'),
			array('code' => 'SLB', 'name' => 'Sulawesi Barat'),
			array('code' => 'SLTG', 'name' => 'Sulawesi Tengah'),
			array('code' => 'SLU', 'name' => 'Sulawesi Utara'),
			array('code' => 'SLTGR', 'name' => 'Sulawesi Tenggara'),
			array('code' => 'SLS', 'name' => 'Sulawesi Selatan'),
			array('code' => 'MKU', 'name' => 'Maluku Utara'),
			array('code' => 'MLU', 'name' => 'Maluku'),
			array('code' => 'PBR', 'name' => 'Papua Barat'),
			array('code' => 'PPA', 'name' => 'Papua'),
			array('code' => 'PTG', 'name' => 'Papua Tengah'),
			array('code' => 'PPG', 'name' => 'Papua Pegunungan'),
			array('code' => 'PPS', 'name' => 'Papua Selatan'),
			array('code' => 'PBD', 'name' => 'Papua Barat Daya'),
        );

        DB::table('provinces')->insert($provinces);
    }
}