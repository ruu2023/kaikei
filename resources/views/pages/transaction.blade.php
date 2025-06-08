<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between pr-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('取引登録') }}
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
                    <form method="POST" id="transactionForm" action="/transaction">
                        @csrf
                        <div class="form-group">
                            <label for="transactionDate">日付</label>
                            <input type="date" id="transactionDate" name="date" required />
                        </div>

                        <div class="form-group">
                            <label for="transactionSource">取引元</label>
                            <input type="text" id="transactionSource" name="client_name"
                                placeholder="例：○○銀行、○○クライアント" required />
                        </div>

                        <div class="form-group">
                            <label for="transactionCategory">科目</label>
                            <select id="transactionCategory" name="category_id" required>
                                <option value="" disabled @if (empty($type)) selected @endif>
                                    科目を選択してください</option>
                                <optgroup label="収入">
                                    @foreach ($category as $item)
                                        @if ($item->default_type === 'income')
                                            <option value={{ $item->id }}
                                                @if ($loop->first && $type === 'income') selected @endif>{{ $item->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </optgroup>
                                <optgroup label="支出">
                                    @foreach ($category as $item)
                                        @if ($item->default_type === 'expense')
                                            <option value={{ $item->id }}
                                                @if ($loop->first && $type === 'expense') selected @endif>{{ $item->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="transactionType">収支区分</label>
                            <div class="transaction-type-toggle">
                                <input type="radio" id="income" name="type" value="income" required
                                    @checked($type === 'income') />
                                <label for="income" class="toggle-label income">収入</label>
                                <input type="radio" id="expense" name="type" value="expense" required
                                    @checked($type === 'expense') />
                                <label for="expense" class="toggle-label expense">支出</label>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="transactionCategory">相手方</label>
                            <select id="transactionCategory" name="payment_method_id" required>
                                <option value="" class="paymentMethod" disabled selected>相手方を選択してください</option>
                                @foreach ($paymentMethod as $item)
                                    @if ($item->type === 'income')
                                        <option class="paymentMethodIncome"
                                            style="@if ($type !== 'income') display: none; @endif"
                                            value={{ $item->id }}>
                                            {{ $item->name }}</option>
                                    @endif
                                @endforeach
                                @foreach ($paymentMethod as $item)
                                    @if ($item->type === 'expense')
                                        <option class="paymentMethodExpense"
                                            style="@if ($type !== 'expense') display: none; @endif"
                                            value={{ $item->id }}>
                                            {{ $item->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="transactionAmount">金額</label>
                            <div class="amount-input-wrapper">
                                <span class="currency-symbol">¥</span>
                                <input type="number" id="transactionAmount" name="amount" placeholder="0"
                                    min="0" required />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="transactionMemo">メモ</label>
                            <textarea id="transactionMemo" name="memo" placeholder="取引に関するメモ"></textarea>
                        </div>

                        <button type="submit" class="submit-button">
                            <i class="fas fa-check"></i> 登録する
                        </button>
                    </form>
                </section>

                <!-- ナビゲーション -->
                @include('layouts.navigation-bottom')
            </div>
        </div>
    </div>

    @push('scripts')
        @vite('resources/js/transaction.js')
    @endpush
</x-app-layout>
