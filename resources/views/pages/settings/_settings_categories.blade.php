<div class="settings-tab active" id="categories-tab">
    <div class="settings-header">
        <h2>科目管理</h2>
        <button class="action-btn" id="addCategoryBtn">
            <i class="fas fa-plus"></i> 新規追加
        </button>
    </div>


    <div class="category-groups">
        <!-- 収入科目 -->
        <div id="category-list" data-category='@json($category->toArray())'></div>
        <div class="category-group">
            <h3>収入科目</h3>
            <ul class="category-list" id="incomeCategories">
                <li class="category-item">
                    <div class="category-info">
                        <div class="category-icon income">
                            <i class="fas fa-coins"></i>
                        </div>
                        <div class="category-name">売上</div>
                    </div>
                    <div class="category-actions">
                        <button class="icon-button edit-category">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="icon-button delete-category">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </li>
                <li class="category-item">
                    <div class="category-info">
                        <div class="category-icon income">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <div class="category-name">コンサルティング</div>
                    </div>
                    <div class="category-actions">
                        <button class="icon-button edit-category">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="icon-button delete-category">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </li>
                <li class="category-item">
                    <div class="category-info">
                        <div class="category-icon income">
                            <i class="fas fa-piggy-bank"></i>
                        </div>
                        <div class="category-name">利息</div>
                    </div>
                    <div class="category-actions">
                        <button class="icon-button edit-category">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="icon-button delete-category">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </li>
                <li class="category-item">
                    <div class="category-info">
                        <div class="category-icon income">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                        <div class="category-name">その他収入</div>
                    </div>
                    <div class="category-actions">
                        <button class="icon-button edit-category">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="icon-button delete-category">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </li>
            </ul>
        </div>

        <!-- 支出科目 -->
        <div class="category-group">
            <h3>支出科目</h3>
            <ul class="category-list" id="expenseCategories">
                <li class="category-item">
                    <div class="category-info">
                        <div class="category-icon expense">
                            <i class="fas fa-paperclip"></i>
                        </div>
                        <div class="category-name">オフィス経費</div>
                    </div>
                    <div class="category-actions">
                        <button class="icon-button edit-category">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="icon-button delete-category">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </li>
                <li class="category-item">
                    <div class="category-info">
                        <div class="category-icon expense">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="category-name">給与</div>
                    </div>
                    <div class="category-actions">
                        <button class="icon-button edit-category">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="icon-button delete-category">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </li>
                <li class="category-item">
                    <div class="category-info">
                        <div class="category-icon expense">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="category-name">賃料</div>
                    </div>
                    <div class="category-actions">
                        <button class="icon-button edit-category">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="icon-button delete-category">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </li>
                <li class="category-item">
                    <div class="category-info">
                        <div class="category-icon expense">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <div class="category-name">光熱費</div>
                    </div>
                    <div class="category-actions">
                        <button class="icon-button edit-category">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="icon-button delete-category">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </li>
                <li class="category-item">
                    <div class="category-info">
                        <div class="category-icon expense">
                            <i class="fas fa-train"></i>
                        </div>
                        <div class="category-name">交通費</div>
                    </div>
                    <div class="category-actions">
                        <button class="icon-button edit-category">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="icon-button delete-category">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </li>
                <li class="category-item">
                    <div class="category-info">
                        <div class="category-icon expense">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <div class="category-name">飲食費</div>
                    </div>
                    <div class="category-actions">
                        <button class="icon-button edit-category">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="icon-button delete-category">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </li>
                <li class="category-item">
                    <div class="category-info">
                        <div class="category-icon expense">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                        <div class="category-name">マーケティング</div>
                    </div>
                    <div class="category-actions">
                        <button class="icon-button edit-category">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="icon-button delete-category">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </li>
                <li class="category-item">
                    <div class="category-info">
                        <div class="category-icon expense">
                            <i class="fas fa-laptop"></i>
                        </div>
                        <div class="category-name">機器・設備</div>
                    </div>
                    <div class="category-actions">
                        <button class="icon-button edit-category">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="icon-button delete-category">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </li>
                <li class="category-item">
                    <div class="category-info">
                        <div class="category-icon expense">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                        <div class="category-name">税金</div>
                    </div>
                    <div class="category-actions">
                        <button class="icon-button edit-category">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="icon-button delete-category">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </li>
                <li class="category-item">
                    <div class="category-info">
                        <div class="category-icon expense">
                            <i class="fas fa-receipt"></i>
                        </div>
                        <div class="category-name">その他支出</div>
                    </div>
                    <div class="category-actions">
                        <button class="icon-button edit-category">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="icon-button delete-category">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
