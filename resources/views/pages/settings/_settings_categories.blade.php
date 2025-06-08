<div class="settings-tab" id="categories-tab">
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

            </ul>
        </div>

        <!-- 支出科目 -->
        <div class="category-group">
            <h3>支出科目</h3>
            <ul class="category-list" id="expenseCategories">

            </ul>
        </div>
    </div>
</div>
