<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Transaction::create([
            'date' => now()->toDateString(),
            'amount' => 10000,
            'type' => 'income',
            'memo' => '売上の入金',
            'category_id' => 1,
            'user_id' => 1,
            'payment_method_id' => 2,
            'client_id' => 1,
        ]);

        Transaction::create([
            'date' => now()->subDays(1)->toDateString(),
            'amount' => 2000,
            'type' => 'expense',
            'memo' => '交通費の精算',
            'category_id' => 2,
            'user_id' => 1,
            'payment_method_id' => 1,
            'client_id' => 2,
        ]);
    }
}
