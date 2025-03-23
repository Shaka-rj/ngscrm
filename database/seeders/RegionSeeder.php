<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Region;


class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regions = [
            'Toshkent',
            'Andijon',
            'Buxoro',
            'Farg‘ona',
            'Jizzax', 
            'Xorazm',
            'Namangan',
            'Navoiy',
            'Qashqadaryo', 
            'Qoraqalpog‘iston',
            'Samarqand',
            'Sirdaryo',
            'Surxondaryo',
            'Toshkent viloyati'
        ];

        foreach ($regions as $region) {
            Region::create(['name' => $region]);
        }
    }
}
