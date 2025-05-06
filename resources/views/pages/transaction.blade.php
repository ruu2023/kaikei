<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between pr-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('取引登録 - 会計管理ダッシュボード') }}
            </h2>
            <a href="{{ route('dashboard') }}" class="icon-button" id="closeBtn">
                <i class="fas fa-times"></i>
            </a>
        </div>
    </x-slot>
    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    @endpush
    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <!-- 取引フォーム -->
                <section class="transaction-form-section">
                    <form id="transactionForm">
                        <div class="form-group">
                            <label for="transactionDate">日付</label>
                            <input type="date" id="transactionDate" name="transactionDate" required />
                        </div>

                        <div class="form-group">
                            <label for="transactionSource">取引元</label>
                            <input type="text" id="transactionSource" name="transactionSource"
                                placeholder="例：○○銀行、○○クライアント" required />
                        </div>

                        <div class="form-group">
                            <label for="transactionCategory">科目</label>
                            <select id="transactionCategory" name="transactionCategory" required>
                                <option value="" disabled selected>科目を選択してください</option>
                                <optgroup label="収入">
                                    <option value="sales">売上</option>
                                    <option value="consulting">コンサルティング</option>
                                    <option value="interest">利息</option>
                                    <option value="other_income">その他収入</option>
                                </optgroup>
                                <optgroup label="支出">
                                    <option value="office">オフィス経費</option>
                                    <option value="salary">給与</option>
                                    <option value="rent">賃料</option>
                                    <option value="utilities">光熱費</option>
                                    <option value="transportation">交通費</option>
                                    <option value="meals">飲食費</option>
                                    <option value="marketing">マーケティング</option>
                                    <option value="equipment">機器・設備</option>
                                    <option value="tax">税金</option>
                                    <option value="other_expense">その他支出</option>
                                </optgroup>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="transactionType">収支区分</label>
                            <div class="transaction-type-toggle">
                                <input type="radio" id="income" name="transactionType" value="income" required />
                                <label for="income" class="toggle-label income">収入</label>
                                <input type="radio" id="expense" name="transactionType" value="expense" required />
                                <label for="expense" class="toggle-label expense">支出</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="transactionAmount">金額</label>
                            <div class="amount-input-wrapper">
                                <span class="currency-symbol">¥</span>
                                <input type="number" id="transactionAmount" name="transactionAmount" placeholder="0"
                                    min="0" required />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="transactionMemo">メモ</label>
                            <textarea id="transactionMemo" name="transactionMemo" placeholder="取引に関するメモ"></textarea>
                        </div>

                        <button type="submit" class="submit-button">
                            <i class="fas fa-check"></i> 登録する
                        </button>
                    </form>
                </section>

                <!-- ナビゲーション -->
                <nav class="bottom-nav">
                    <a href="index.html" class="nav-item">
                        <i class="fas fa-home"></i>
                        <span>ホーム</span>
                    </a>
                    <a href="#" class="nav-item active">
                        <i class="fas fa-exchange-alt"></i>
                        <span>取引</span>
                    </a>
                    <a href="analytics.html" class="nav-item">
                        <i class="fas fa-chart-line"></i>
                        <span>分析</span>
                    </a>
                    <a href="settings.html" class="nav-item">
                        <i class="fas fa-cog"></i>
                        <span>設定</span>
                    </a>
                </nav>
            </div>
        </div>
    </div>

    @push('scripts')
        @vite('resources/js/transaction.js')
    @endpush
</x-app-layout>
