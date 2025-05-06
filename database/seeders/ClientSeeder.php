<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userId = 1;

        Client::insert([
            ['name' => '株式会社テスト', 'user_id' => $userId],
            ['name' => '合同会社サンプル', 'user_id' => $userId],
        ]);
    }
}
