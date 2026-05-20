<?php

namespace Database\Seeders;

use App\Models\Fasilitas;
use Illuminate\Database\Seeder;

class FasilitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fasilitasList = Fasilitas::defaultList();

        foreach ($fasilitasList as $nama) {
            Fasilitas::firstOrCreate([
                'nama_fasilitas' => $nama,
            ]);
        }
    }
}
