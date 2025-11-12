<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\User;
use App\Models\Komentar;
use App\Models\Wartawan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        // TODO 
        // 1. BUAT WARTAWAN
        $wartawans = Wartawan::factory(2)->create();
        // 2. BUAT 4 BERITA (MASING-MASING BERITA DIMILIKI OLEH WARTAWAN)
        $berita1 = News::factory()->create([
            'wartawan_id' => $wartawans->first()->id
        ]);

        $berita2 = News::factory()->create([
            'wartawan_id' => $wartawans->first()->id
        ]);

        $berita3 = News::factory()->create([
            'wartawan_id' => $wartawans->last()->id
        ]);

        $berita4 = News::factory()->create([
            'wartawan_id' => $wartawans->last()->id
        ]);
        // 3. BUAT 20 KOMENTAR TOTAL DARI MASING-MASIGN BERITA 5 KOMENTAR
        $all_berita = collect([$berita1, $berita2, $berita3, $berita4]);
        foreach($all_berita as $berita) {
            Komentar::factory(5)->create([
                'news_id' => $berita->id
            ]);
        }

        $this->call(AdminSeeder::class);
    }
}
