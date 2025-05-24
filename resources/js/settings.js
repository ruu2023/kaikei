document.addEventListener("DOMContentLoaded", function () {
    const categoryObj = document
        .getElementById("category-list")
        .getAttribute("data-category");
    const category = JSON.parse(categoryObj);
    const categoryData = category.reduce((acc, item) => {
        if (!acc[item.default_type]) {
            acc[item.default_type] = [];
        }
        acc[item.default_type].push(item);
        return acc;
    }, {});
    // console.log(category, categoryItems);
    // 科目データ（モック）
    // const categoryData = {
    //     income: [
    //         { id: "inc1", name: "売上", icon: "fas fa-coins" },
    //         { id: "inc2", name: "コンサルティング", icon: "fas fa-briefcase" },
    //         { id: "inc3", name: "利息", icon: "fas fa-piggy-bank" },
    //         { id: "inc4", name: "その他収入", icon: "fas fa-hand-holding-usd" },
    //     ],
    //     expense: [
    //         { id: "exp1", name: "オフィス経費", icon: "fas fa-paperclip" },
    //         { id: "exp2", name: "給与", icon: "fas fa-user-tie" },
    //         { id: "exp3", name: "賃料", icon: "fas fa-building" },
    //         { id: "exp4", name: "光熱費", icon: "fas fa-bolt" },
    //         { id: "exp5", name: "交通費", icon: "fas fa-train" },
    //         { id: "exp6", name: "飲食費", icon: "fas fa-utensils" },
    //         { id: "exp7", name: "マーケティング", icon: "fas fa-bullhorn" },
    //         { id: "exp8", name: "機器・設備", icon: "fas fa-laptop" },
    //         { id: "exp9", name: "税金", icon: "fas fa-file-invoice-dollar" },
    //         { id: "exp10", name: "その他支出", icon: "fas fa-receipt" },
    //     ],
    // };

    // グローバル変数
    let currentCategoryId = null;
    let currentCategoryType = null;
    let selectedIconValue = "fas fa-coins";

    // 初期化
    initSettings();

    /**
     * 設定画面の初期化
     */
    function initSettings() {
        // 設定メニューの設定
        setupSettingsMenu();

        // エクスポート日付の初期設定
        setupExportDates();

        // 科目データの描画
        renderCategories();

        // イベントリスナーの設定
        setupEventListeners();
    }

    /**
     * 設定メニューの設定
     */
    function setupSettingsMenu() {
        const menuItems = document.querySelectorAll(".settings-menu-item");

        menuItems.forEach((item) => {
            item.addEventListener("click", function () {
                // アクティブなメニューアイテムの更新
                document
                    .querySelector(".settings-menu-item.active")
                    .classList.remove("active");
                this.classList.add("active");

                // タブの表示切り替え
                const tabId = this.dataset.tab + "-tab";
                document
                    .querySelector(".settings-tab.active")
                    .classList.remove("active");
                document.getElementById(tabId).classList.add("active");
            });
        });
    }

    /**
     * エクスポート日付の初期設定
     */
    function setupExportDates() {
        const today = new Date();
        const firstDayOfMonth = new Date(
            today.getFullYear(),
            today.getMonth(),
            1
        );
        const lastDayOfMonth = new Date(
            today.getFullYear(),
            today.getMonth() + 1,
            0
        );

        document.getElementById("exportStartDate").value =
            formatDateForInput(firstDayOfMonth);
        document.getElementById("exportEndDate").value =
            formatDateForInput(lastDayOfMonth);
    }

    /**
     * 科目データの描画
     */
    function renderCategories() {
        // 収入科目の描画
        renderCategoryList("income", categoryData.income);

        // 支出科目の描画
        renderCategoryList("expense", categoryData.expense);
    }

    /**
     * 科目リストの描画
     */
    function renderCategoryList(type, categories) {
        const listElement = document.getElementById(`${type}Categories`);
        listElement.innerHTML = "";

        categories.forEach((category) => {
            const listItem = document.createElement("li");
            listItem.className = "category-item";
            listItem.dataset.id = category.id;
            listItem.dataset.type = type;

            listItem.innerHTML = `
        <div class="category-info">
          <div class="category-icon ${type}">
            <i class="${category.icon}"></i>
          </div>
          <div class="category-name">${category.name}</div>
        </div>
        <div class="category-actions">
          <button class="icon-button edit-category" data-id="${category.id}" data-type="${type}">
            <i class="fas fa-edit"></i>
          </button>
          <button class="icon-button delete-category" data-id="${category.id}" data-type="${type}">
            <i class="fas fa-trash"></i>
          </button>
        </div>
      `;

            listElement.appendChild(listItem);
        });

        // 編集・削除ボタンのイベントリスナーを追加
        attachCategoryActionListeners();
    }

    /**
     * 科目アクションボタンのイベントリスナー追加
     */
    function attachCategoryActionListeners() {
        // 編集ボタン
        const editButtons = document.querySelectorAll(".edit-category");
        editButtons.forEach((button) => {
            button.addEventListener("click", function () {
                const categoryId = this.dataset.id;
                const categoryType = this.dataset.type;
                openCategoryModal("edit", categoryId, categoryType);
            });
        });

        // 削除ボタン
        const deleteButtons = document.querySelectorAll(".delete-category");
        deleteButtons.forEach((button) => {
            button.addEventListener("click", function () {
                const categoryId = this.dataset.id;
                const categoryType = this.dataset.type;
                openDeleteCategoryModal(categoryId, categoryType);
            });
        });
    }

    /**
     * 科目モーダルを開く
     */
    function openCategoryModal(mode, categoryId, categoryType) {
        document.getElementById("categoryModalTitle").textContent =
            mode === "add" ? "科目を追加" : "科目を編集";

        if (mode === "edit") {
            // 既存の科目を編集する場合
            const categories = categoryData[categoryType];
            const category = categories.find((c) => c.id === categoryId);

            if (category) {
                document.getElementById("categoryId").value = category.id;
                document.getElementById("categoryType").value = categoryType;
                document.getElementById("categoryName").value = category.name;
                document.getElementById("categoryIconValue").value =
                    category.icon;

                // アイコンの表示を更新
                updateSelectedIcon(category.icon);

                // 削除ボタンを表示
                document.getElementById("deleteCategoryBtn").style.display =
                    "flex";

                // グローバル変数を更新
                currentCategoryId = category.id;
                currentCategoryType = categoryType;
                selectedIconValue = category.icon;
            }
        } else {
            // 新規追加の場合
            document.getElementById("categoryId").value = "";
            document.getElementById("categoryType").value =
                categoryType || "income";
            document.getElementById("categoryName").value = "";
            document.getElementById("categoryIconValue").value = "fas fa-coins";

            // デフォルトアイコンの表示
            updateSelectedIcon("fas fa-coins");

            // 削除ボタンを非表示
            document.getElementById("deleteCategoryBtn").style.display = "none";

            // グローバル変数を更新
            currentCategoryId = null;
            currentCategoryType = categoryType || "income";
            selectedIconValue = "fas fa-coins";
        }

        // アイコン選択肢の選択状態を更新
        updateIconOptionSelection();

        // モーダルを表示
        document.getElementById("categoryModal").classList.add("show");
    }

    /**
     * 選択中のアイコンを更新
     */
    function updateSelectedIcon(iconClass) {
        document.getElementById(
            "selectedIcon"
        ).innerHTML = `<i class="${iconClass}"></i>`;
    }

    /**
     * アイコンオプションの選択状態を更新
     */
    function updateIconOptionSelection() {
        const options = document.querySelectorAll(".icon-option");

        options.forEach((option) => {
            option.classList.remove("selected");

            if (option.dataset.icon === selectedIconValue) {
                option.classList.add("selected");
            }
        });
    }

    /**
     * 削除確認モーダルを開く
     */
    function openDeleteCategoryModal(categoryId, categoryType) {
        currentCategoryId = categoryId;
        currentCategoryType = categoryType;
        document.getElementById("deleteCategoryModal").classList.add("show");
    }

    /**
     * モーダルを閉じる
     */
    function closeModals() {
        const modals = document.querySelectorAll(".modal");
        modals.forEach((modal) => {
            modal.classList.remove("show");
        });
    }

    /**
     * 科目の追加
     */
    function addCategory(formData) {
        const type = formData.get("categoryType");
        const name = formData.get("categoryName");
        const icon = formData.get("categoryIcon");

        // 新しいIDを生成
        const newId = generateCategoryId(type);

        // 新しい科目を追加
        categoryData[type].push({
            id: newId,
            name: name,
            icon: icon,
        });

        // 科目リストを再描画
        renderCategories();

        // モーダルを閉じる
        closeModals();

        // 成功メッセージ
        alert("科目を追加しました");
    }

    /**
     * 科目の編集
     */
    function updateCategory(formData) {
        const id = formData.get("categoryId");
        const type = formData.get("categoryType");
        const name = formData.get("categoryName");
        const icon = formData.get("categoryIcon");

        // 科目データの更新
        const categoryIndex = categoryData[type].findIndex((c) => c.id === id);

        if (categoryIndex !== -1) {
            categoryData[type][categoryIndex].name = name;
            categoryData[type][categoryIndex].icon = icon;

            // 科目リストを再描画
            renderCategories();

            // モーダルを閉じる
            closeModals();

            // 成功メッセージ
            alert("科目を更新しました");
        }
    }

    /**
     * 科目の削除
     */
    function deleteCategory() {
        if (!currentCategoryId || !currentCategoryType) return;

        // 「その他」カテゴリかどうかをチェック
        const isOtherCategory =
            (currentCategoryType === "income" &&
                currentCategoryId === "inc4") ||
            (currentCategoryType === "expense" &&
                currentCategoryId === "exp10");

        if (isOtherCategory) {
            alert("「その他」カテゴリは削除できません");
            closeModals();
            return;
        }

        // カテゴリの件数をチェック
        if (categoryData[currentCategoryType].length <= 1) {
            alert("最低1つの科目が必要です");
            closeModals();
            return;
        }

        // 科目の削除
        categoryData[currentCategoryType] = categoryData[
            currentCategoryType
        ].filter((c) => c.id !== currentCategoryId);

        // 科目リストを再描画
        renderCategories();

        // モーダルを閉じる
        closeModals();

        // 成功メッセージ
        alert("科目を削除しました");
    }

    /**
     * 新しい科目IDの生成
     */
    function generateCategoryId(type) {
        const existingIds = categoryData[type].map((c) => c.id);
        let counter = 1;
        let newId = "";

        // 接頭辞を設定
        const prefix = type === "income" ? "inc" : "exp";

        // 既存のIDと重複しないIDを生成
        do {
            newId = `${prefix}${counter}`;
            counter++;
        } while (existingIds.includes(newId));

        return newId;
    }

    /**
     * CSVエクスポート機能
     */
    function exportData() {
        const startDate = document.getElementById("exportStartDate").value;
        const endDate = document.getElementById("exportEndDate").value;
        const format = document.querySelector(
            'input[name="exportFormat"]:checked'
        ).value;

        // 選択されたエクスポート項目の取得
        const selectedFields = [];
        document
            .querySelectorAll('input[name="exportFields"]:checked')
            .forEach((field) => {
                selectedFields.push(field.value);
            });

        // 実際のアプリではAPIやローカルストレージからデータを取得してCSV生成
        // ここではデモとして疑似的なCSVをダウンロード

        // CSVヘッダーとサンプルデータの作成
        let csvContent = "取引日,科目,取引元,収支区分,金額,メモ\n";
        csvContent +=
            "2025-04-05,売上,クライアントA,収入,480000,4月分サービス利用料\n";
        csvContent +=
            "2025-04-12,コンサルティング,クライアントB,収入,250000,コンサルティング料金\n";
        csvContent += "2025-04-20,利息,銀行,収入,5000,普通預金利息\n";
        csvContent +=
            "2025-04-25,売上,クライアントC,収入,215000,プロジェクト完了報酬\n";
        csvContent +=
            "2025-04-02,オフィス経費,オフィスデポ,支出,12500,事務用品\n";
        csvContent += "2025-04-03,給与,スタッフA,支出,350000,給与\n";
        csvContent += "2025-04-05,賃料,オフィスビル,支出,85000,オフィス賃料\n";
        csvContent += "2025-04-12,光熱費,電力会社,支出,23500,電気代\n";
        csvContent += "2025-04-15,交通費,交通系,支出,15800,交通費精算\n";
        csvContent += "2025-04-18,飲食費,レストラン,支出,8600,取引先ランチ\n";

        // CSVファイルのダウンロード
        const encodedUri = encodeURI(
            "data:text/csv;charset=utf-8," + csvContent
        );
        const link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", `取引データ_${startDate}_${endDate}.csv`);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);

        // 成功メッセージ
        alert("データをエクスポートしました");
    }

    /**
     * イベントリスナーの設定
     */
    function setupEventListeners() {
        // 科目追加ボタン
        document
            .getElementById("addCategoryBtn")
            .addEventListener("click", function () {
                openCategoryModal("add", null, "income");
            });

        // 科目フォーム送信
        document
            .getElementById("categoryForm")
            .addEventListener("submit", function (e) {
                // e.preventDefault();
                // const formData = new FormData(this);
                // if (formData.get("categoryId")) {
                //     // 既存の科目を更新
                //     updateCategory(formData);
                // } else {
                //     // 新しい科目を追加
                //     addCategory(formData);
                // }
            });

        // 科目削除ボタン
        document
            .getElementById("deleteCategoryBtn")
            .addEventListener("click", function () {
                openDeleteCategoryModal(currentCategoryId, currentCategoryType);
            });

        // 削除確認ボタン
        document
            .getElementById("confirmDeleteCategoryBtn")
            .addEventListener("click", deleteCategory);

        // アイコンオプション選択
        document.querySelectorAll(".icon-option").forEach((option) => {
            option.addEventListener("click", function () {
                const iconClass = this.dataset.icon;
                selectedIconValue = iconClass;

                // document.getElementById();

                // 選択中のアイコンを更新
                updateSelectedIcon(iconClass);

                // 入力値を更新
                document.getElementById("categoryIconValue").value = iconClass;

                // 選択状態を更新
                updateIconOptionSelection();
            });
        });

        // エクスポートボタン
        document
            .getElementById("exportButton")
            .addEventListener("click", exportData);

        // ヘルプボタン
        document
            .getElementById("helpBtn")
            .addEventListener("click", function () {
                alert("設定画面のヘルプ機能は現在開発中です。");
            });

        // モーダルを閉じるボタン
        document.querySelectorAll(".close-modal").forEach((button) => {
            button.addEventListener("click", closeModals);
        });

        // モーダル外クリックで閉じる
        document.querySelectorAll(".modal").forEach((modal) => {
            modal.addEventListener("click", function (e) {
                if (e.target === this) {
                    closeModals();
                }
            });
        });
    }

    /**
     * 日付をinput[type="date"]用にフォーマット
     */
    function formatDateForInput(date) {
        const d = new Date(date);
        const year = d.getFullYear();
        const month = String(d.getMonth() + 1).padStart(2, "0");
        const day = String(d.getDate()).padStart(2, "0");
        return `${year}-${month}-${day}`;
    }
});
