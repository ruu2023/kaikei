document.addEventListener("DOMContentLoaded", function () {
  // フォーム要素の取得
  const transactionForm = document.getElementById("transactionForm");

  // 今日の日付を初期値として設定
  const dateInput = document.getElementById("transactionDate");
  const today = new Date();
  const formattedDate = today.toISOString().split("T")[0]; // YYYY-MM-DD形式
  dateInput.value = formattedDate;

  // 科目が変更されたときに収支区分を自動選択
  const categorySelect = document.getElementById("transactionCategory");
  categorySelect.addEventListener("change", function () {
    const selectedOption = this.options[this.selectedIndex];
    const optgroupLabel = selectedOption.parentNode.label;

    if (optgroupLabel === "収入") {
      document.getElementById("income").checked = true;
      document.getElementById("income").dispatchEvent(new Event("change"));
    } else if (optgroupLabel === "支出") {
      document.getElementById("expense").checked = true;
      document.getElementById("expense").dispatchEvent(new Event("change"));
    }
  });

  // 相手方を表示
  document.getElementById("income").addEventListener("change", () => {
    document.querySelectorAll(".paymentMethodIncome").forEach((item) => {
      item.style.display = "block";
    });
    document.querySelectorAll(".paymentMethodExpense").forEach((item) => {
      item.style.display = "none";
    });
  });
  document.getElementById("expense").addEventListener("change", () => {
    document.querySelectorAll(".paymentMethodIncome").forEach((item) => {
      item.style.display = "none";
    });
    document.querySelectorAll(".paymentMethodExpense").forEach((item) => {
      item.style.display = "block";
    });
  });

  /**
   * 取引データを保存する関数
   * 実際のアプリケーションではAPIやローカルストレージに保存
   */
  function saveTransaction(data) {
    // 現時点ではデモとしてコンソールに出力
    console.log("取引データを保存:", data);

    // 保存が成功したことをユーザーに通知
    const amount = formatCurrency(data.amount);
    const sign = data.type === "income" ? "+" : "-";

    // アラートで通知
    alert(`取引が登録されました。\n${sign}${amount}`);

    // フォームをリセット
    transactionForm.reset();
    dateInput.value = formattedDate; // 日付は今日の日付に戻す

    // 実際のアプリケーションでは成功メッセージを表示してホーム画面に戻るなどの処理
    // window.location.href = "index.html"; // ホーム画面に戻る場合
  }

  /**
   * 数値を通貨形式にフォーマット
   */
  function formatCurrency(amount) {
    return new Intl.NumberFormat("ja-JP", {
      style: "currency",
      currency: "JPY",
      maximumFractionDigits: 0,
    }).format(amount);
  }

  // 取引一覧画面への遷移を処理するリンク（実際のアプリケーションで実装）
  // const transactionListLink = document.getElementById("transactionListLink");
  // if (transactionListLink) {
  //   transactionListLink.addEventListener("click", function(e) {
  //     e.preventDefault();
  //     window.location.href = "transaction-list.html";
  //   });
  // }
});
