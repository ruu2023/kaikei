import "./bootstrap"; // bootstrap.js の中で axios を window に登録済み

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

  // グローバル変数
  let currentCategoryId = null;
  let currentCategoryType = null;
  let selectedIconValue = "fas fa-coins";

  // 初期化
  if (!window._settingsInitialized) {
    window._settingsInitialized = true;
    console.log("init");
    initSettings();
  }

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

    // 予算データの読み込み
    loadBudgetData();

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

        // 予算タブが選択された場合、データを再読み込み
        if (this.dataset.tab === "budgets") {
          loadBudgetData();
        }
      });
    });
  }

  /**
   * エクスポート日付の初期設定
   */
  function setupExportDates() {
    const today = new Date();
    const firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
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
    if (categoryData.income) {
      // 収入科目の描画
      renderCategoryList("income", categoryData.income);
    }

    if (categoryData.expense) {
      // 支出科目の描画
      renderCategoryList("expense", categoryData.expense);
    }
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
      const category = categories.find((c) => c.id === Number(categoryId));

      if (category) {
        document.getElementById("categoryId").value = category.id;
        document.getElementById("categoryType").value = categoryType;
        document.getElementById("categoryName").value = category.name;
        document.getElementById("categoryIconValue").value = category.icon;
        document.getElementById(categoryType).checked = true;

        // アイコンの表示を更新
        updateSelectedIcon(category.icon);

        // 削除ボタンを表示
        document.getElementById("deleteCategoryBtn").style.display = "flex";

        // グローバル変数を更新
        currentCategoryId = category.id;
        currentCategoryType = categoryType;
        selectedIconValue = category.icon;
      }
    } else {
      // 新規追加の場合
      document.getElementById("categoryId").value = "";
      document.getElementById("categoryType").value = categoryType || "income";
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
   * 科目の削除
   */
  function deleteCategory() {
    // 科目フォーム送信
    document
      .getElementById("categoryDeleteForm")
      .addEventListener("submit", function (e) {
        e.preventDefault();
        // /categories に対して、 /categories/1 のように変更
        this.action = `/categories/${currentCategoryId}`;
        this.submit();
      });

    return;
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
   * 予算データの読み込み
   */
  function loadBudgetData() {
    const currentBudgetsDiv = document.getElementById("current-budgets");

    // APIから現在の予算データを取得
    fetch("/budgets/data")
      .then((response) => response.json())
      .then((data) => {
        renderBudgetList(data);
      })
      .catch((error) => {
        console.error("Error loading budget data:", error);
        currentBudgetsDiv.innerHTML =
          '<div class="error">予算データの読み込みに失敗しました。</div>';
      });
  }

  /**
   * 予算リストの描画
   */
  function renderBudgetList(budgets) {
    const currentBudgetsDiv = document.getElementById("current-budgets");

    if (budgets.length === 0) {
      currentBudgetsDiv.innerHTML =
        '<div class="no-budgets">設定された予算がありません。</div>';
      return;
    }

    let html = "";
    budgets.forEach((budget) => {
      const progressPercentage = Math.min(budget.progress_percentage, 100);
      const warningClass = budget.warning_level;

      html += `
        <div class="budget-item ${warningClass}">
          <div class="budget-info">
            <div class="budget-category">${budget.category.name}</div>
            <div class="budget-numbers">
              ¥${budget.actual_spent.toLocaleString()} / ¥${budget.amount.toLocaleString()}
            </div>
            <div class="budget-actions">
              <button class="icon-button edit-budget" data-id="${budget.id}">
                <i class="fas fa-edit"></i>
              </button>
              <button class="icon-button delete-budget" data-id="${budget.id}">
                <i class="fas fa-trash"></i>
              </button>
            </div>
          </div>
          <div class="progress-bar">
            <div class="progress" style="width: ${progressPercentage}%"></div>
          </div>
          ${
            budget.is_over_budget
              ? `
            <div class="budget-warning">
              <small style="color: #dc3545;">
                予算オーバー: ¥${(
                  budget.actual_spent - budget.amount
                ).toLocaleString()}
              </small>
            </div>
          `
              : ""
          }
        </div>
      `;
    });

    currentBudgetsDiv.innerHTML = html;
    attachBudgetActionListeners();
  }

  /**
   * 予算アクションボタンのイベントリスナー追加
   */
  function attachBudgetActionListeners() {
    // 編集ボタン
    document.querySelectorAll(".edit-budget").forEach((button) => {
      button.addEventListener("click", function () {
        const budgetId = this.dataset.id;
        editBudget(budgetId);
      });
    });

    // 削除ボタン
    document.querySelectorAll(".delete-budget").forEach((button) => {
      button.addEventListener("click", function () {
        const budgetId = this.dataset.id;
        deleteBudget(budgetId);
      });
    });
  }

  /**
   * 予算の編集
   */
  function editBudget(budgetId) {
    // 実装は省略（モーダル表示など）
    console.log("Edit budget:", budgetId);
  }

  /**
   * 予算の削除
   */
  function deleteBudget(budgetId) {
    if (confirm("この予算を削除してもよろしいですか？")) {
      fetch(`/budgets/${budgetId}`, {
        method: "DELETE",
        headers: {
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
            .content,
          "Content-Type": "application/json",
        },
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            loadBudgetData(); // 予算データを再読み込み
          } else {
            alert("予算の削除に失敗しました。");
          }
        })
        .catch((error) => {
          console.error("Error deleting budget:", error);
          alert("予算の削除に失敗しました。");
        });
    }
  }

  /**
   * CSVエクスポート機能
   */
  async function exportData() {
    const startDate = document.getElementById("exportStartDate").value;
    const endDate = document.getElementById("exportEndDate").value;
    const format = document.querySelector(
      'input[name="exportFormat"]:checked'
    ).value;

    // データベースから取引情報を取得する
    let transactionArray = [];
    try {
      const response = await axios.post("/data-export", {
        startDate,
        endDate,
      });
      transactionArray = response.data;
    } catch (error) {
      console.log(error, "だめっぽい");
      transactionArray = [];
    }

    // CSVヘッダーとサンプルデータの作成
    let csvContent = "取引日,科目,相手方,取引元,収支区分,金額,メモ\n";

    // csv形式にデーターベースのレコードを加工する
    transactionArray.forEach((item) => {
      const type = item.type == "expense" ? "支出" : "収入";
      csvContent += `${item.date},${item.category.name},${item.payment_method.name},${item.client_name},${type},${item.amount},${item.memo}\n`;
    });

    // {
    //     "id": 1,
    //     "date": "2025-06-08",
    //     "amount": 500,
    //     "type": "expense",
    //     "memo": null,
    //     "category_id": 17,
    //     "user_id": 7,
    //     "payment_method_id": 12,
    //     "client_id": null,
    //     "created_at": "2025-06-08T02:54:59.000000Z",
    //     "updated_at": "2025-06-08T02:54:59.000000Z",
    //     "client_name": "あああ"
    // }

    console.log(csvContent);

    // 選択されたエクスポート項目の取得
    const selectedFields = [];
    document
      .querySelectorAll('input[name="exportFields"]:checked')
      .forEach((field) => {
        selectedFields.push(field.value);
      });

    // CSVファイルのダウンロード
    const encodedUri = encodeURI("data:text/csv;charset=utf-8," + csvContent);
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
        e.preventDefault();
        const formData = new FormData(this);
        const id = formData.get("categoryId");
        const methodInput = document.getElementById("methodInput");
        if (id) {
          // 既存の科目を更新
          methodInput.value = "PATCH";
        } else {
          // 新しい科目を追加
          methodInput.value = "POST";
        }

        // actionにidを埋め込む
        this.action = `/categories/${id}`;
        this.submit();
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

    // 予算フォーム送信
    document
      .querySelector(".budget-form")
      .addEventListener("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch("/budgets", {
          method: "POST",
          headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
              .content,
          },
          body: formData,
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.success) {
              this.reset(); // フォームをリセット
              loadBudgetData(); // 予算データを再読み込み
              alert("予算を設定しました。");
            } else {
              alert(data.message || "予算の設定に失敗しました。");
            }
          })
          .catch((error) => {
            console.error("Error creating budget:", error);
            alert("予算の設定に失敗しました。");
          });
      });

    // アイコンオプション選択
    document.querySelectorAll(".icon-option").forEach((option) => {
      option.addEventListener("click", function () {
        const iconClass = this.dataset.icon;
        selectedIconValue = iconClass;

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
    document.getElementById("helpBtn").addEventListener("click", function () {
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
