<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'amount',
        'year',
        'month',
    ];

    protected $casts = [
        'amount' => 'integer',
        'year' => 'integer',
        'month' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * 予算の進捗率を計算
     */
    public function getProgressPercentageAttribute()
    {
        $spent = \App\Models\Transaction::where('user_id', $this->user_id)
            ->where('category_id', $this->category_id)
            ->where('type', 'expense')
            ->whereYear('date', $this->year)
            ->whereMonth('date', $this->month)
            ->sum('amount');

        return $this->amount > 0 ? min(($spent / $this->amount) * 100, 100) : 0;
    }

    /**
     * 実際の支出額を取得
     */
    public function getActualSpentAttribute()
    {
        return \App\Models\Transaction::where('user_id', $this->user_id)
            ->where('category_id', $this->category_id)
            ->where('type', 'expense')
            ->whereYear('date', $this->year)
            ->whereMonth('date', $this->month)
            ->sum('amount');
    }

    /**
     * 予算の残り金額を取得
     */
    public function getRemainingAmountAttribute()
    {
        return max($this->amount - $this->actual_spent, 0);
    }

    /**
     * 予算オーバーかどうか
     */
    public function getIsOverBudgetAttribute()
    {
        return $this->actual_spent > $this->amount;
    }

    /**
     * 警告レベル（進捗率80%以上で警告）
     */
    public function getWarningLevelAttribute()
    {
        $progress = $this->progress_percentage;
        
        if ($progress >= 100) {
            return 'danger';
        } elseif ($progress >= 80) {
            return 'warning';
        } else {
            return 'normal';
        }
    }
}
