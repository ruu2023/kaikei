<div class="settings-content-inner">
    <div class="settings-header">
        <h2>相手方管理</h2>
    </div>
    <!-- 新しい相手方を追加 -->
    <div class="settings-section">
        <h3>新しい相手方を追加</h3>
        <form action="/payment-methods" method="POST" class="add-payment-method-form">
            @csrf
            <div class="form-group">

                <label for="newPaymentMethodName">相手方名</label>
                <input type="text" id="newPaymentMethodName" name="name" placeholder="例: 現金、クレジットカードA" required>

                <label for="newPaymentMethodType">区分</label>
                <select id="newPaymentMethodType" name="type" required>
                    <option value="expense">支出</option>
                    <option value="income">収入</option>
                </select>

                <button type="submit" class="primary-button">
                    <i class="fas fa-plus"></i> 追加
                </button>
            </div>
        </form>
    </div>

    <!-- 登録済みの支払方法 -->
    <div class="settings-section">
        <div class="payment-method-list">
            @if (isset($paymentMethods) && $paymentMethods->isEmpty())
                <p class="text-gray-500 empty-message">登録されている支払方法はありません。</p>
            @elseif (isset($paymentMethods))
                <div class="payment-method-group">
                    <h3 style="border-bottom: 1px solid #eee; padding-bottom: 0.5rem;">収入の受取方法</h3>
                    <ul class="payment-method-sub-list">
                        @php $incomeMethodsFound = false; @endphp
                        @foreach ($paymentMethods->where('type', 'income') as $pm)
                            @php $incomeMethodsFound = true; @endphp
                            <li class="form-group payment-method-item"
                                style="display: flex; align-items: center; gap: 4px;">
                                <form method="POST" id="paymentMethodForm_{{ $pm->id }}"
                                    action="{{ route('payment-methods.update', $pm->id) }}"
                                    style="display: flex; align-items: center; gap: 4px; flex: 4;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="text" name="name" value="{{ $pm->name }}" style="flex: 2;"
                                        required>
                                    <select name="type" style="flex: 1;" required>
                                        <option value="income" @if ($pm->type === 'income') selected @endif>収入
                                        </option>
                                        <option value="expense" @if ($pm->type === 'expense') selected @endif>支出
                                        </option>
                                    </select>
                                    <button type="submit" class="action-btn edit-btn">更新</button>
                                </form>
                                <form style="display: flex; align-items: center; flex: 1;" method="POST"
                                    id="paymentMethodDeleteForm_{{ $pm->id }}"
                                    action="{{ route('payment-methods.destroy', $pm->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn danger-btn">削除</button>
                                </form>
                            </li>
                        @endforeach
                        @if (!$incomeMethodsFound)
                            <li>
                                <p class="text-gray-500 empty-message-small">登録されている収入の支払方法はありません。</p>
                            </li>
                        @endif
                    </ul>
                </div>

                <div class="payment-method-group">
                    <h3 style="border-bottom: 1px solid #eee; padding-bottom: 0.5rem;">支出の支払方法</h3>
                    <ul class="payment-method-sub-list">
                        @php $expenseMethodsFound = false; @endphp
                        @foreach ($paymentMethods->where('type', 'expense') as $pm)
                            @php $expenseMethodsFound = true; @endphp
                            <li class="form-group payment-method-item"
                                style="display: flex; align-items: center; gap: 4px;">
                                <form method="POST" id="paymentMethodForm_{{ $pm->id }}"
                                    action="{{ route('payment-methods.update', $pm->id) }}"
                                    style="display: flex; align-items: center; gap: 4px; flex: 4;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="text" name="name" value="{{ $pm->name }}" style="flex: 2;"
                                        required>
                                    <select name="type" style="flex: 1;" required>
                                        <option value="expense" @if ($pm->type === 'expense') selected @endif>支出
                                        </option>
                                        <option value="income" @if ($pm->type === 'income') selected @endif>収入
                                        </option>
                                    </select>
                                    <button type="submit" class="action-btn edit-btn">更新</button>
                                </form>
                                <form style="display: flex; align-items: center; flex: 1;" method="POST"
                                    id="paymentMethodDeleteForm_{{ $pm->id }}"
                                    action="{{ route('payment-methods.destroy', $pm->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn danger-btn">削除</button>
                                </form>
                            </li>
                        @endforeach
                        @if (!$expenseMethodsFound)
                            <li>
                                <p class="text-gray-500 empty-message-small">登録されている支出の支払方法はありません。</p>
                            </li>
                        @endif
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>
