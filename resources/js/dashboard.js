// Dashboard specific JavaScript functionality

document.addEventListener("DOMContentLoaded", function () {
  // イベントリスナーの設定
  setupEventListeners();
});

/**
 * イベントリスナーの設定
 */
function setupEventListeners() {
  // 通知ボタン
  const notificationBtn = document.getElementById("notificationBtn");
  if (notificationBtn) {
    notificationBtn.addEventListener("click", function () {
      alert("通知機能は現在開発中です。");
    });
  }

  // プロフィールボタン
  const profileBtn = document.getElementById("profileBtn");
  if (profileBtn) {
    profileBtn.addEventListener("click", function () {
      alert("プロフィール設定は現在開発中です。");
    });
  }

  // Chart period selector
  const chartPeriodSelect = document.getElementById('chartPeriod');
  if (chartPeriodSelect) {
    chartPeriodSelect.addEventListener('change', function() {
      // Chart period change functionality can be implemented here
      console.log('Period changed to:', this.value);
    });
  }
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

// Export functions for global access
window.dashboardUtils = {
  formatCurrency
};