<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between pr-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('設定') }}
            </h2>
            <button class="icon-button" id="helpBtn">
                <i class="fas fa-question-circle"></i>
            </button>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <!-- 設定メニュー -->
                <section class="settings-menu-section">
                    <div class="settings-menu">
                        <button class="settings-menu-item active" data-tab="categories">
                            <i class="fas fa-tags"></i>
                            <span>科目管理</span>
                        </button>
                        <button class="settings-menu-item" data-tab="export">
                            <i class="fas fa-file-export"></i>
                            <span>データエクスポート</span>
                        </button>
                        <button class="settings-menu-item" data-tab="profile">
                            <i class="fas fa-user"></i>
                            <span>プロフィール</span>
                        </button>
                        <button class="settings-menu-item" data-tab="notifications">
                            <i class="fas fa-bell"></i>
                            <span>通知設定</span>
                        </button>
                        <button class="settings-menu-item" data-tab="appearance">
                            <i class="fas fa-palette"></i>
                            <span>外観設定</span>
                        </button>
                        <button class="settings-menu-item" data-tab="about">
                            <i class="fas fa-info-circle"></i>
                            <span>このアプリについて</span>
                        </button>
                    </div>
                </section>

                <!-- タブコンテンツ -->
                <section class="settings-content">
                    <!-- 科目管理タブ -->
                    @include('pages/settings/_settings_categories')

                    <!-- データエクスポートタブ -->
                    <div class="settings-tab" id="export-tab">
                        <div class="settings-header">
                            <h2>データエクスポート</h2>
                        </div>

                        <div class="export-options">
                            <div class="export-section">
                                <h3>期間を選択</h3>
                                <div class="date-range">
                                    <div class="form-group">
                                        <label for="exportStartDate">開始日</label>
                                        <input type="date" id="exportStartDate" name="exportStartDate">
                                    </div>
                                    <div class="form-group">
                                        <label for="exportEndDate">終了日</label>
                                        <input type="date" id="exportEndDate" name="exportEndDate">
                                    </div>
                                </div>
                            </div>

                            <div class="export-section">
                                <h3>エクスポート形式</h3>
                                <div class="export-formats">
                                    <div class="format-option">
                                        <input type="radio" id="formatCSV" name="exportFormat" value="csv" checked>
                                        <label for="formatCSV">
                                            <i class="fas fa-file-csv"></i>
                                            <span>CSV形式</span>
                                        </label>
                                    </div>
                                    <div class="format-option">
                                        <input type="radio" id="formatExcel" name="exportFormat" value="excel">
                                        <label for="formatExcel">
                                            <i class="fas fa-file-excel"></i>
                                            <span>Excel形式</span>
                                        </label>
                                    </div>
                                    <div class="format-option">
                                        <input type="radio" id="formatPDF" name="exportFormat" value="pdf">
                                        <label for="formatPDF">
                                            <i class="fas fa-file-pdf"></i>
                                            <span>PDF形式</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="export-section">
                                <h3>エクスポート項目</h3>
                                <div class="export-fields">
                                    <div class="field-option">
                                        <input type="checkbox" id="fieldTransaction" name="exportFields"
                                            value="transactions" checked>
                                        <label for="fieldTransaction">取引データ</label>
                                    </div>
                                    <div class="field-option">
                                        <input type="checkbox" id="fieldSummary" name="exportFields" value="summary"
                                            checked>
                                        <label for="fieldSummary">月次サマリー</label>
                                    </div>
                                    <div class="field-option">
                                        <input type="checkbox" id="fieldCategories" name="exportFields"
                                            value="categories">
                                        <label for="fieldCategories">科目設定</label>
                                    </div>
                                </div>
                            </div>

                            <button id="exportButton" class="primary-button">
                                <i class="fas fa-download"></i> データをエクスポート
                            </button>
                        </div>
                    </div>

                    <!-- その他のタブ (実装しない) -->
                    <div class="settings-tab" id="profile-tab">
                        <div class="settings-header">
                            <h2>プロフィール設定</h2>
                        </div>
                        <div class="settings-placeholder">
                            <i class="fas fa-user"></i>
                            <p>この機能は現在開発中です。</p>
                        </div>
                    </div>

                    <div class="settings-tab" id="notifications-tab">
                        <div class="settings-header">
                            <h2>通知設定</h2>
                        </div>
                        <div class="settings-placeholder">
                            <i class="fas fa-bell"></i>
                            <p>この機能は現在開発中です。</p>
                        </div>
                    </div>

                    <div class="settings-tab" id="appearance-tab">
                        <div class="settings-header">
                            <h2>外観設定</h2>
                        </div>
                        <div class="settings-placeholder">
                            <i class="fas fa-palette"></i>
                            <p>この機能は現在開発中です。</p>
                        </div>
                    </div>

                    <div class="settings-tab" id="about-tab">
                        <div class="settings-header">
                            <h2>このアプリについて</h2>
                        </div>
                        <div class="about-content">
                            <div class="app-logo">
                                <i class="fas fa-chart-pie"></i>
                                <h3>会計管理ダッシュボード</h3>
                            </div>
                            <p class="app-version">バージョン 1.0.0</p>
                            <p class="app-description">
                                このアプリケーションは、個人事業主や小規模事業者向けの会計管理ツールです。
                                収支の記録、分析、レポート作成などの機能を提供します。
                            </p>
                            <div class="app-credits">
                                <p>© 2025 会計管理ダッシュボード</p>
                            </div>
                        </div>
                    </div>
                </section>


                <!-- 科目編集モーダル -->
                <div class="modal" id="categoryModal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 id="categoryModalTitle">科目を編集</h2>
                            <button class="close-modal">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <form method="POST" id="categoryForm" action="/categories">
                            @csrf
                            <input type="hidden" id="categoryId" name="categoryId">
                            <input type="hidden" id="categoryType" name="categoryType">

                            <div class="form-group">
                                <label for="categoryName">科目名</label>
                                <input type="text" id="categoryName" name="name" required>
                            </div>

                            <div class="form-group">
                                <label for="transactionType">収支区分</label>
                                <div class="transaction-type-toggle">
                                    <input type="radio" id="income" name="default_type" value="income"
                                        required />
                                    <label for="income" class="toggle-label income">収入</label>
                                    <input type="radio" id="expense" name="default_type" value="expense"
                                        required />
                                    <label for="expense" class="toggle-label expense">支出</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="categoryIcon">アイコン</label>
                                <div class="icon-selector">
                                    <div class="selected-icon" id="selectedIcon">
                                        <i class="fas fa-coins"></i>
                                    </div>
                                    <div class="icon-grid">
                                        <button type="button" class="icon-option" data-icon="fas fa-coins">
                                            <i class="fas fa-coins"></i>
                                        </button>
                                        <button type="button" class="icon-option" data-icon="fas fa-briefcase">
                                            <i class="fas fa-briefcase"></i>
                                        </button>
                                        <button type="button" class="icon-option" data-icon="fas fa-piggy-bank">
                                            <i class="fas fa-piggy-bank"></i>
                                        </button>
                                        <button type="button" class="icon-option"
                                            data-icon="fas fa-hand-holding-usd">
                                            <i class="fas fa-hand-holding-usd"></i>
                                        </button>
                                        <button type="button" class="icon-option" data-icon="fas fa-paperclip">
                                            <i class="fas fa-paperclip"></i>
                                        </button>
                                        <button type="button" class="icon-option" data-icon="fas fa-user-tie">
                                            <i class="fas fa-user-tie"></i>
                                        </button>
                                        <button type="button" class="icon-option" data-icon="fas fa-building">
                                            <i class="fas fa-building"></i>
                                        </button>
                                        <button type="button" class="icon-option" data-icon="fas fa-bolt">
                                            <i class="fas fa-bolt"></i>
                                        </button>
                                        <button type="button" class="icon-option" data-icon="fas fa-train">
                                            <i class="fas fa-train"></i>
                                        </button>
                                        <button type="button" class="icon-option" data-icon="fas fa-utensils">
                                            <i class="fas fa-utensils"></i>
                                        </button>
                                        <button type="button" class="icon-option" data-icon="fas fa-bullhorn">
                                            <i class="fas fa-bullhorn"></i>
                                        </button>
                                        <button type="button" class="icon-option" data-icon="fas fa-laptop">
                                            <i class="fas fa-laptop"></i>
                                        </button>
                                        <button type="button" class="icon-option"
                                            data-icon="fas fa-file-invoice-dollar">
                                            <i class="fas fa-file-invoice-dollar"></i>
                                        </button>
                                        <button type="button" class="icon-option" data-icon="fas fa-receipt">
                                            <i class="fas fa-receipt"></i>
                                        </button>
                                        <button type="button" class="icon-option" data-icon="fas fa-shopping-cart">
                                            <i class="fas fa-shopping-cart"></i>
                                        </button>
                                        <button type="button" class="icon-option" data-icon="fas fa-store">
                                            <i class="fas fa-store"></i>
                                        </button>
                                        <button type="button" class="icon-option" data-icon="fas fa-car">
                                            <i class="fas fa-car"></i>
                                        </button>
                                        <button type="button" class="icon-option" data-icon="fas fa-plane">
                                            <i class="fas fa-plane"></i>
                                        </button>
                                        <button type="button" class="icon-option" data-icon="fas fa-home">
                                            <i class="fas fa-home"></i>
                                        </button>
                                        <button type="button" class="icon-option" data-icon="fas fa-graduation-cap">
                                            <i class="fas fa-graduation-cap"></i>
                                        </button>
                                        <button type="button" class="icon-option" data-icon="fas fa-hospital">
                                            <i class="fas fa-hospital"></i>
                                        </button>
                                        <button type="button" class="icon-option" data-icon="fas fa-gifts">
                                            <i class="fas fa-gifts"></i>
                                        </button>
                                        <button type="button" class="icon-option" data-icon="fas fa-phone">
                                            <i class="fas fa-phone"></i>
                                        </button>
                                        <button type="button" class="icon-option" data-icon="fas fa-wifi">
                                            <i class="fas fa-wifi"></i>
                                        </button>
                                    </div>
                                    <input type="hidden" id="categoryIconValue" name="icon" required>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="button" class="danger-button" id="deleteCategoryBtn">
                                    <i class="fas fa-trash"></i> 削除
                                </button>
                                <button type="submit" class="submit-button">
                                    <i class="fas fa-check"></i> 保存
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- 削除確認モーダル -->
                <div class="modal" id="deleteCategoryModal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2>科目を削除</h2>
                            <button class="close-modal">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>この科目を削除してもよろしいですか？</p>
                            <p class="warning-text">
                                <i class="fas fa-exclamation-triangle"></i>
                                この科目に関連付けられた取引はすべて「その他」に再分類されます。
                            </p>
                        </div>
                        <div class="form-actions">
                            <button class="secondary-button close-modal">
                                キャンセル
                            </button>
                            <button class="danger-button" id="confirmDeleteCategoryBtn">
                                <i class="fas fa-trash"></i> 削除する
                            </button>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    @push('scripts')
        @vite('resources/js/settings.js')
    @endpush
</x-app-layout>
