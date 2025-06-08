<x-app-layout>


    <div class="app-container">
        <!-- ヘッダー -->
        <header class="header">
            <h1>取引分析</h1>
            <div class="header-actions">
                <button class="icon-button" id="filterBtn">
                    <i class="fas fa-filter"></i>
                </button>
            </div>
        </header>

        <!-- 期間選択 -->
        <section class="period-selector">
            <div class="period-control">
                <form method="GET" action="{{ route('analytics') }}"
                    style="display: flex; flex-wrap: wrap; align-items: center; gap: 4px;">
                    <input type="date" name="start_date" value="{{ $start_date }}"
                        style="padding: 0.5rem; border: 1px solid #ddd; border-radius: 4px;">
                    <span>～</span>
                    <input type="date" name="end_date" value="{{ $end_date }}"
                        style="padding: 0.5rem; border: 1px solid #ddd; border-radius: 4px;">
                    <button type="submit"
                        style="margin: 0 0 0 auto;padding: 0.5rem 1rem; background: #3a7bd5; color: white; border: none; border-radius: 4px;">
                        適用
                    </button>
                </form>
            </div>
        </section>

        <!-- 月次サマリー -->
        <section class="summary-section">
            <div class="summary-cards">
                <div class="summary-card income">
                    <div class="summary-icon">
                        <i class="fas fa-arrow-down"></i>
                    </div>
                    <div class="summary-info">
                        <div class="summary-label">収入</div>
                        <div class="summary-amount" id="totalIncome">¥{{ number_format($periodIncome) }}</div>
                    </div>
                </div>
                <div class="summary-card expense">
                    <div class="summary-icon">
                        <i class="fas fa-arrow-up"></i>
                    </div>
                    <div class="summary-info">
                        <div class="summary-label">支出</div>
                        <div class="summary-amount" id="totalExpense">¥{{ number_format($periodExpense) }}</div>
                    </div>
                </div>
                <div class="summary-card balance">
                    <div class="summary-icon">
                        <i class="fas fa-coins"></i>
                    </div>
                    <div class="summary-info">
                        <div class="summary-label">収支</div>
                        <div class="summary-amount" id="netBalance">
                            {{ $periodBalance >= 0 ? '+' : '' }}¥{{ number_format(abs($periodBalance)) }}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 月次グラフ -->
        <section class="chart-section">
            <div id="analytics" data-monthly="{{ json_encode($monthlyData) }}"
                data-category="{{ json_encode($categoryStats) }}"></div>
            <div class="chart-container">
                <canvas id="monthlyChart"></canvas>
            </div>
            <div class="chart-tabs">
                <button class="chart-tab active" data-chart="bar">月次推移</button>
                <button class="chart-tab" data-chart="pie">科目別集計</button>
            </div>
        </section>

        <!-- 取引リスト -->
        <section class="transactions-section">
            <div class="section-header">
                <h2>取引明細</h2>
                <form method="GET" action="{{ route('analytics') }}" style="display: flex; gap: 0.5rem;">
                    <input type="hidden" name="start_date" value="{{ $start_date }}">
                    <input type="hidden" name="end_date" value="{{ $end_date }}">
                    <select name="type" class="transaction-filter" onchange="this.form.submit()">
                        <option value="all" {{ $type === 'all' ? 'selected' : '' }}>すべて</option>
                        <option value="income" {{ $type === 'income' ? 'selected' : '' }}>収入のみ</option>
                        <option value="expense" {{ $type === 'expense' ? 'selected' : '' }}>支出のみ</option>
                    </select>
                    <select name="category_id" class="transaction-filter" onchange="this.form.submit()">
                        <option value="">全科目</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
            <ul class="transaction-list" id="transactionList">
                @forelse($transactions as $transaction)
                    <li class="transaction-item" data-id="{{ $transaction->id }}" data-type="{{ $transaction->type }}"
                        data-date="{{ $transaction->date }}" data-amount="{{ $transaction->amount }}"
                        data-memo="{{ $transaction->memo }}"
                        data-client-name="{{ $transaction->client->name ?? $transaction->client_name }}"
                        data-category-id="{{ $transaction->category->id }}"
                        data-payment-method="{{ $transaction->paymentMethod->id }}">
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
                        <div class="transaction-details" style="text-align: center; color: #666; width: 100%;">
                            指定された期間に取引データがありません
                        </div>
                    </li>
                @endforelse
            </ul>

            <!-- ページネーション -->
            <div style="margin-top: 1rem;">
                {{ $transactions->appends(request()->query())->links() }}
            </div>
        </section>

        <!-- ナビゲーション -->
        @include('layouts.navigation-bottom')
    </div>

    <!-- 取引編集モーダル -->
    <div class="modal" id="editTransactionModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>取引編集</h2>
                <button class="close-modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form method="POST" id="transactionForm" action="/transaction/">
                @method('PATCH')
                @csrf
                <input type="hidden" id="editTransactionId">
                <div class="form-group">
                    <label for="transactionDate">日付</label>
                    <input type="date" id="transactionDate" name="date" required />
                </div>

                <div class="form-group">
                    <label for="transactionSource">取引元</label>
                    <input type="text" id="transactionSource" name="client_name" placeholder="例：○○銀行、○○クライアント"
                        required />
                </div>

                <div class="form-group">
                    <label for="transactionCategory">科目</label>
                    <select id="transactionCategory" name="category_id" required>
                        <option value="" disabled selected>科目を選択してください</option>
                        <optgroup label="収入">
                            @foreach ($categories as $item)
                                @if ($item->default_type === 'income')
                                    <option value={{ $item->id }}>{{ $item->name }}</option>
                                @endif
                            @endforeach
                        </optgroup>
                        <optgroup label="支出">
                            @foreach ($categories as $item)
                                @if ($item->default_type === 'expense')
                                    <option value={{ $item->id }}>{{ $item->name }}</option>
                                @endif
                            @endforeach
                        </optgroup>
                    </select>
                </div>

                <div class="form-group">
                    <label for="transactionType">収支区分</label>
                    <div class="transaction-type-toggle">
                        <input type="radio" id="income" name="type" value="income" required />
                        <label for="income" class="toggle-label income">収入</label>
                        <input type="radio" id="expense" name="type" value="expense" required />
                        <label for="expense" class="toggle-label expense">支出</label>
                    </div>
                </div>


                <div class="form-group">
                    <label for="paymentMethod">相手方</label>
                    <select id="paymentMethod" name="payment_method_id" required>
                        <option value="" class="paymentMethod" disabled selected>相手方を選択してください</option>
                        @foreach ($paymentMethod as $item)
                            @if ($item->type === 'income')
                                <option class="paymentMethodIncome" style="display:none;" value={{ $item->id }}>
                                    {{ $item->name }}</option>
                            @endif
                        @endforeach
                        @foreach ($paymentMethod as $item)
                            @if ($item->type === 'expense')
                                <option class="paymentMethodExpense" style="display:none;" value={{ $item->id }}>
                                    {{ $item->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="transactionAmount">金額</label>
                    <div class="amount-input-wrapper">
                        <span class="currency-symbol">¥</span>
                        <input type="number" id="transactionAmount" name="amount" placeholder="0" min="0"
                            required />
                    </div>
                </div>

                <div class="form-group">
                    <label for="transactionMemo">メモ</label>
                    <textarea id="transactionMemo" name="memo" placeholder="取引に関するメモ"></textarea>
                </div>

                <div class="flex space-x-2 mt-4">
                    {{-- 削除ボタン --}}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <button type="button" id="transactionDelete"
                        class="delete-button bg-red-500 text-white px-4 py-2 rounded">
                        <i class="fas fa-trash-alt mr-1"></i> 削除する
                    </button>

                    {{-- 更新ボタン --}}
                    <button type="submit" class="submit-button bg-blue-500 text-white px-4 py-2 rounded">
                        <i class="fas fa-check mr-1"></i> 更新する
                    </button>

                </div>
            </form>
        </div>
    </div>

    <!-- 削除確認モーダル -->
    <div class="modal" id="deleteTransactionModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>取引を削除</h2>
                <button class="close-modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <p>この取引を削除してもよろしいですか？</p>
            </div>
            <form class="form-actions" method="POST" id="transactionDeleteForm" action="/transaction">
                @csrf
                @method('DELETE')
                <button type="button" class="secondary-button close-modal">
                    キャンセル
                </button>
                <button class="danger-button" id="confirmDeleteTransactionBtn">
                    <i class="fas fa-trash"></i> 削除する
                </button>
            </form>
        </div>
    </div>


    <!-- フィルターモーダル -->
    <div class="modal" id="filterModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>絞り込み設定</h2>
                <button class="close-modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="filterForm">
                <div class="form-group">
                    <label>期間</label>
                    <div class="date-range">
                        <input type="date" id="startDate" name="startDate">
                        <span>～</span>
                        <input type="date" id="endDate" name="endDate">
                    </div>
                </div>

                <div class="form-group">
                    <label>収支</label>
                    <div class="checkbox-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="transactionTypes" value="income" checked>
                            収入
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" name="transactionTypes" value="expense" checked>
                            支出
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label>科目</label>
                    <div class="checkbox-group categories">
                        <div class="category-group">
                            <h3>収入</h3>
                            <label class="checkbox-label">
                                <input type="checkbox" name="categories" value="sales" checked>
                                売上
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="categories" value="consulting" checked>
                                コンサルティング
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="categories" value="interest" checked>
                                利息
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="categories" value="other_income" checked>
                                その他収入
                            </label>
                        </div>

                        <div class="category-group">
                            <h3>支出</h3>
                            <label class="checkbox-label">
                                <input type="checkbox" name="categories" value="office" checked>
                                オフィス経費
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="categories" value="salary" checked>
                                給与
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="categories" value="rent" checked>
                                賃料
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="categories" value="utilities" checked>
                                光熱費
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="categories" value="transportation" checked>
                                交通費
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="categories" value="meals" checked>
                                飲食費
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="categories" value="marketing" checked>
                                マーケティング
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="categories" value="equipment" checked>
                                機器・設備
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="categories" value="tax" checked>
                                税金
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="categories" value="other_expense" checked>
                                その他支出
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="secondary-button" id="resetFilterBtn">
                        リセット
                    </button>
                    <button type="submit" class="submit-button">
                        適用
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- 削除確認モーダル -->
    <div class="modal" id="deleteConfirmModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>取引削除</h2>
                <button class="close-modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <p>この取引を削除してもよろしいですか？</p>
                <p>この操作は取り消せません。</p>
            </div>
            <div class="form-actions">
                <button class="secondary-button close-modal">
                    キャンセル
                </button>
                <button class="danger-button" id="confirmDeleteBtn">
                    <i class="fas fa-trash"></i> 削除する
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        @vite('resources/js/analytics.js')
    @endpush
</x-app-layout>
