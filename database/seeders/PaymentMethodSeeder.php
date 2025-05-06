<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userId = 1;

        PaymentMethod::insert([
            ['name' => '現金', 'type' => 'expense', 'user_id' => $userId],
            ['name' => '銀行振込', 'type' => 'income', 'user_id' => $userId],
            ['name' => 'クレジットカード', 'type' => 'expense', 'user_id' => $userId]
        ]);
    }
}
