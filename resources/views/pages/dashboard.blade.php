<x-app-layout>
    <style>
        /* Base Styles and Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            font-family: "Helvetica Neue", Arial, sans-serif;
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .app-container {
            max-width: 100%;
            margin: 0 auto;
            padding-bottom: 70px;
        }

        h1 {
            font-size: 1.5rem;
            font-weight: 600;
        }

        h2 {
            font-size: 1.2rem;
            font-weight: 600;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-actions {
            display: flex;
            gap: 0.75rem;
        }

        .icon-button {
            background: none;
            border: none;
            font-size: 1.25rem;
            color: #555;
            cursor: pointer;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon-button:active {
            background-color: #f0f0f0;
        }

        .balance-card {
            background: linear-gradient(135deg, #3a7bd5, #3a6073);
            color: white;
            padding: 1.5rem;
            border-radius: 12px;
            margin: 1rem;
            box-shadow: 0 4px 12px rgba(58, 123, 213, 0.2);
        }

        .balance-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
        }

        .date {
            font-size: 0.85rem;
            opacity: 0.8;
        }

        .balance-summary {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 0.5rem;
        }

        .balance-column {
            flex: 1;
            text-align: center;
        }

        .balance-divider {
            width: 1px;
            height: 40px;
            background-color: rgba(255, 255, 255, 0.2);
            margin: 0 1rem;
        }

        .balance-label {
            font-size: 0.85rem;
            opacity: 0.8;
            margin-bottom: 0.5rem;
        }

        .balance-value {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .balance-value.trend {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.25rem;
        }

        .balance-value.trend i {
            font-size: 1rem;
        }

        .positive {
            color: #a5f3c9;
            font-weight: 600;
        }

        .negative {
            color: #ffb3b3;
            font-weight: 600;
        }

        .quick-actions {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.5rem;
            padding: 0.5rem 1rem 1.5rem;
            background-color: #fff;
            margin-bottom: 1rem;
        }

        .action-button {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: none;
            border: none;
            padding: 0.75rem 0;
            cursor: pointer;
            border-radius: 8px;
            text-decoration: none;
        }

        .action-button i {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: #3a7bd5;
        }

        .action-button span {
            font-size: 0.75rem;
            color: #555;
        }

        .action-button:active {
            background-color: #f0f0f0;
        }

        section {
            background-color: #fff;
            border-radius: 12px;
            margin: 0 1rem 1rem;
            padding: 1.25rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .view-all {
            color: #3a7bd5;
            text-decoration: none;
            font-size: 0.85rem;
        }

        .chart-section {
            padding-bottom: 1.5rem;
        }

        .chart-container {
            height: 200px;
            width: 100%;
        }

        #chartPeriod {
            border: 1px solid #ddd;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.85rem;
            background-color: #f9f9f9;
        }

        .transaction-list {
            list-style: none;
        }

        .transaction-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .transaction-item:last-child {
            border-bottom: none;
        }

        .transaction-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.75rem;
            flex-shrink: 0;
        }

        .transaction-icon.income {
            background-color: rgba(165, 243, 201, 0.2);
            color: #28a745;
        }

        .transaction-icon.expense {
            background-color: rgba(255, 179, 179, 0.2);
            color: #dc3545;
        }

        .transaction-details {
            flex-grow: 1;
        }

        .transaction-title {
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .transaction-date {
            font-size: 0.75rem;
            color: #888;
        }

        .transaction-amount {
            font-weight: 600;
            text-align: right;
        }

        .transaction-amount.income {
            color: #28a745;
        }

        .transaction-amount.expense {
            color: #dc3545;
        }

        .budget-items {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .budget-item {
            width: 100%;
        }

        .budget-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .budget-category {
            font-weight: 500;
        }

        .budget-numbers {
            font-size: 0.85rem;
            color: #666;
        }

        .progress-bar {
            height: 8px;
            background-color: #eee;
            border-radius: 4px;
            overflow: hidden;
        }

        .progress {
            height: 100%;
            background-color: #3a7bd5;
            border-radius: 4px;
        }

        .budget-item.warning .progress {
            background-color: #ffc107;
        }

        .budget-item.danger .progress {
            background-color: #dc3545;
        }

        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: #fff;
            display: flex;
            justify-content: space-around;
            padding: 0.75rem 0;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.05);
            z-index: 100;
        }

        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: #888;
            font-size: 0.75rem;
        }

        .nav-item i {
            font-size: 1.25rem;
            margin-bottom: 0.25rem;
        }

        .nav-item.active {
            color: #3a7bd5;
        }

        @media (min-width: 768px) {
            .app-container {
                max-width: 480px;
            }

            .quick-actions {
                gap: 1rem;
            }

            .chart-container {
                height: 250px;
            }
        }
    </style>

    <div class="app-container">
        <!-- ヘッダー -->
        <header class="header">
            <h1>会計管理</h1>
            <div class="header-actions">
                <button class="icon-button" id="notificationBtn">
                    <i class="fas fa-bell"></i>
                </button>
                <button class="icon-button" id="profileBtn">
                    <i class="fas fa-user-circle"></i>
                </button>
            </div>
        </header>

        <!-- メイン収支表示 -->
        <section class="balance-card">
            <div class="balance-header">
                <h2>今月の収支</h2>
                <span class="date">{{ now()->format('Y年n月') }}</span>
            </div>
            <div class="balance-summary">
                <div class="balance-column">
                    <div class="balance-label">今月</div>
                    <div class="balance-value {{ $currentMonthBalance >= 0 ? 'positive' : 'negative' }}">
                        {{ $currentMonthBalance >= 0 ? '+' : '' }}¥{{ number_format(abs($currentMonthBalance)) }}
                    </div>
                </div>
                <div class="balance-divider"></div>
                <div class="balance-column">
                    <div class="balance-label">前月比</div>
                    <div class="balance-value trend {{ $balanceChange >= 0 ? 'positive' : 'negative' }}">
                        <i class="fas fa-arrow-{{ $balanceChange >= 0 ? 'up' : 'down' }}"></i>
                        <span>{{ $balanceChange >= 0 ? '+' : '' }}{{ number_format($balanceChange, 1) }}%</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- クイックアクション -->
        <section class="quick-actions">
            <a href="{{ route('transaction', ['type' => 'income']) }}" class="action-button">
                <i class="fas fa-plus"></i>
                <span>収入登録</span>
            </a>
            <a href="{{ route('transaction', ['type' => 'expense']) }}" class="action-button">
                <i class="fas fa-minus"></i>
                <span>支出登録</span>
            </a>
            <a href="{{ route('settings') }}" class="action-button">
                <i class="fas fa-file-invoice"></i>
                <span>CSV出力</span>
            </a>
            <a href="{{ route('analytics') }}" class="action-button">
                <i class="fas fa-chart-pie"></i>
                <span>レポート</span>
            </a>
        </section>

        <!-- 収支グラフ -->
        <section class="chart-section">
            <div class="section-header">
                <h2>収支概要</h2>
                <select id="chartPeriod">
                    <option value="week">週間</option>
                    <option value="month" selected>月間</option>
                    <option value="year">年間</option>
                </select>
            </div>
            <div class="chart-container">
                <canvas id="incomeExpenseChart"></canvas>
            </div>
        </section>

        <!-- 最近の取引 -->
        <section class="transactions-section">
            <div class="section-header">
                <h2>最近の取引</h2>
                <a href="{{ route('analytics') }}" class="view-all">すべて表示</a>
            </div>
            <ul class="transaction-list">
                @forelse($recentTransactions as $transaction)
                    <li class="transaction-item">
                        <div class="transaction-icon {{ $transaction->type }}">
                            <i class="{{ $transaction->category->icon }}"></i>
                        </div>
                        <div class="transaction-details">
                            <div class="transaction-title">
                                {{ $transaction->memo ?: ($transaction->client ? $transaction->client->name : $transaction->client_name) ?: $transaction->category->name }}
                            </div>
                            <div class="transaction-date">
                                {{ \Carbon\Carbon::parse($transaction->date)->format('n月j日') }}</div>
                        </div>
                        <div class="transaction-amount {{ $transaction->type }}">
                            {{ $transaction->type === 'income' ? '+' : '-' }}¥{{ number_format($transaction->amount) }}
                        </div>
                    </li>
                @empty
                    <li class="transaction-item">
                        表示するアイテムがありません。
                    </li>
                @endforelse
            </ul>
        </section>

        <!-- 予算進捗 -->
        <section class="budget-section">
            <div class="section-header">
                <h2>予算進捗</h2>
                <span class="period">{{ now()->format('n月') }}</span>
            </div>
            <div class="budget-items">
                @forelse($budgets as $budget)
                    <div class="budget-item {{ $budget->warning_level }}">
                        <div class="budget-info">
                            <div class="budget-category">{{ $budget->category->name }}</div>
                            <div class="budget-numbers">¥{{ number_format($budget->actual_spent) }} /
                                ¥{{ number_format($budget->amount) }}</div>
                        </div>
                        <div class="progress-bar">
                            <div class="progress" style="width: {{ min($budget->progress_percentage, 100) }}%"></div>
                        </div>
                        @if ($budget->is_over_budget)
                            <div class="budget-warning">
                                <small style="color: #dc3545;">予算オーバー:
                                    ¥{{ number_format($budget->actual_spent - $budget->amount) }}</small>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="budget-item">
                        <div class="budget-info">
                            <div class="budget-category">予算が設定されていません</div>
                            <div class="budget-numbers">
                                <a href="{{ route('settings') }}" style="color: #3a7bd5; text-decoration: none;">
                                    予算を設定する
                                </a>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </section>

        <!-- ナビゲーション -->
        @include('layouts.navigation-bottom')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Chart.js setup for income/expense chart
        const ctx = document.getElementById('incomeExpenseChart').getContext('2d');
        const chartData = @json($chartData);

        const incomeExpenseChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartData.map(item => item.month),
                datasets: [{
                    label: '収入',
                    data: chartData.map(item => item.income),
                    backgroundColor: 'rgba(40, 167, 69, 0.8)',
                    borderColor: 'rgba(40, 167, 69, 1)',
                    borderWidth: 1
                }, {
                    label: '支出',
                    data: chartData.map(item => item.expense),
                    backgroundColor: 'rgba(220, 53, 69, 0.8)',
                    borderColor: 'rgba(220, 53, 69, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '¥' + value.toLocaleString();
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });

        // Chart period selector
        document.getElementById('chartPeriod').addEventListener('change', function() {
            // Update chart data based on selected period
            console.log('Period changed to:', this.value);
        });
    </script>
</x-app-layout>
