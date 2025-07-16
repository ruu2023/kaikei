// Analytics page JavaScript functionality

document.addEventListener("DOMContentLoaded", function () {
  // 初期化
  if (!window._settingsInitialized) {
    window._settingsInitialized = true;
    console.log("init");
    initAnalyticsPage();
  }
});

// Global chart variable
let monthlyChart;

const dataAnalytics = document.getElementById("analytics");
// Chart data from server
const monthlyData = JSON.parse(dataAnalytics.dataset.monthly);
const categoryStats = JSON.parse(dataAnalytics.dataset.category);

// Prepare chart data
const chartData = {
  bar: {
    labels: monthlyData.map((item) => item.month),
    datasets: [
      {
        label: "収入",
        data: monthlyData.map((item) => item.income),
        backgroundColor: "rgba(40, 167, 69, 0.8)",
        borderColor: "rgba(40, 167, 69, 1)",
        borderWidth: 1,
      },
      {
        label: "支出",
        data: monthlyData.map((item) => item.expense),
        backgroundColor: "rgba(220, 53, 69, 0.8)",
        borderColor: "rgba(220, 53, 69, 1)",
        borderWidth: 1,
      },
    ],
  },
  pie: {
    labels: Object.keys(categoryStats).slice(0, 5),
    datasets: [
      {
        data: Object.values(categoryStats)
          .slice(0, 5)
          .map((stat) => {
            return stat.reduce(
              (total, item) => total + parseFloat(item.total),
              0
            );
          }),
        backgroundColor: [
          "#3a7bd5",
          "#dc3545",
          "#ffc107",
          "#28a745",
          "#6c757d",
        ],
      },
    ],
  },
};

// Initialize chart
function initChart() {
  const ctx = document.getElementById("monthlyChart").getContext("2d");
  monthlyChart = new Chart(ctx, {
    type: "bar",
    data: chartData.bar,
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            callback: function (value) {
              return "¥" + value.toLocaleString();
            },
          },
        },
      },
      plugins: {
        legend: {
          position: "top",
        },
      },
    },
  });
}

// Chart tab switching
document.querySelectorAll(".chart-tab").forEach((tab) => {
  tab.addEventListener("click", function () {
    const chartType = this.getAttribute("data-chart");

    // Update active tab
    document
      .querySelectorAll(".chart-tab")
      .forEach((t) => t.classList.remove("active"));
    this.classList.add("active");

    // Update chart
    if (chartType === "bar") {
      monthlyChart.config.type = "bar";
      monthlyChart.data = chartData.bar;
      monthlyChart.options.scales = {
        y: {
          beginAtZero: true,
          ticks: {
            callback: function (value) {
              return "¥" + value.toLocaleString();
            },
          },
        },
      };
    } else if (chartType === "pie") {
      monthlyChart.config.type = "pie";
      monthlyChart.data = chartData.pie;
      monthlyChart.options.scales = {};
      monthlyChart.options.plugins = {
        legend: {
          position: "bottom",
        },
      };
    }

    monthlyChart.update();
  });
});

// Modal functions
function openModal(modalId) {
  document.getElementById(modalId).classList.add("show");
}

function closeModal(modalId) {
  document.getElementById(modalId).classList.remove("show");
}

/**
 * Initialize analytics page
 */
function initAnalyticsPage() {
  initChart();
  // Setup event listeners
  setupAnalyticsEventListeners();
}

/**
 * 相手方の表示（収入）
 */
function showPaymentIncome() {
  document.querySelectorAll(".paymentMethodIncome").forEach((item) => {
    item.style.display = "block";
  });
  document.querySelectorAll(".paymentMethodExpense").forEach((item) => {
    item.style.display = "none";
  });
}
/**
 * 相手方の表示（支出）
 */
function showPaymentExpense() {
  document.querySelectorAll(".paymentMethodIncome").forEach((item) => {
    item.style.display = "none";
  });
  document.querySelectorAll(".paymentMethodExpense").forEach((item) => {
    item.style.display = "block";
  });
}

/**
 * フォームの科目選択、相手方の設定
 */
function changePaymentMethod(categorySelect) {
  const selectedOption = categorySelect.options[categorySelect.selectedIndex];
  const optgroupLabel = selectedOption.parentNode.label;
  if (optgroupLabel === "収入") {
    document.getElementById("income").checked = true;
    document.getElementById("income").dispatchEvent(new Event("change"));
  } else if (optgroupLabel === "支出") {
    document.getElementById("expense").checked = true;
    document.getElementById("expense").dispatchEvent(new Event("change"));
  }
}

function handleDelete(transactionId) {
  // 科目フォーム送信
  document
    .getElementById("transactionDeleteForm")
    .addEventListener("submit", function (e) {
      e.preventDefault();
      // /categories に対して、 /categories/1 のように変更
      this.action = `/transaction/${transactionId}`;
      this.submit();
    });

  return;
}

/**
 * Setup event listeners for analytics page
 */
function setupAnalyticsEventListeners() {
  // Filter button
  // document.getElementById("filterBtn").addEventListener("click", function () {
  //   openModal("filterModal");
  // });

  // 相手方を変更
  document.getElementById("income").addEventListener("change", () => {
    showPaymentIncome();
  });
  document.getElementById("expense").addEventListener("change", () => {
    showPaymentExpense();
  });

  // Delete button
  document
    .getElementById("transactionDelete")
    .addEventListener("click", function () {
      openModal("deleteTransactionModal");
    });

  // Transaction item click
  document.querySelectorAll(".transaction-item").forEach((item) => {
    item.addEventListener("click", function () {
      const transactionId = this.getAttribute("data-id");
      document.getElementById("transactionDate").value =
        this.getAttribute("data-date");
      document.getElementById("transactionCategory").value =
        this.getAttribute("data-category-id");
      document.getElementById("transactionSource").value =
        this.getAttribute("data-client-name");
      document.getElementById("transactionAmount").value =
        this.getAttribute("data-amount");
      document.getElementById("paymentMethod").value = this.getAttribute(
        "data-payment-method"
      );
      document.getElementById("transactionMemo").value =
        this.getAttribute("data-memo");
      document.getElementById(this.getAttribute("data-type")).checked = true;
      if (this.getAttribute("data-type") === "income") {
        showPaymentIncome();
      } else {
        showPaymentExpense();
      }
      const form = document.getElementById("transactionForm");
      form.action = `/transaction/${transactionId}`;
      document.getElementById("editTransactionId").value = transactionId;
      openModal("editTransactionModal");
    });
  });

  // 科目が変更されたときに収支区分を自動選択
  const categorySelect = document.getElementById("transactionCategory");
  categorySelect.addEventListener("change", function () {
    console.log("ここ");
    changePaymentMethod(categorySelect);
  });

  // Modal close buttons
  document.querySelectorAll(".close-modal").forEach((button) => {
    button.addEventListener("click", function () {
      const modal = this.closest(".modal");
      modal.classList.remove("show");
    });
  });

  // Modal background click
  document.querySelectorAll(".modal").forEach((modal) => {
    modal.addEventListener("click", function (e) {
      if (e.target === this) {
        this.classList.remove("show");
      }
    });
  });

  // Delete transaction button
  // Confirm delete
  document
    .getElementById("confirmDeleteTransactionBtn")
    .addEventListener("click", function () {
      const transactionId = document.getElementById("editTransactionId").value;
      handleDelete(transactionId);
      closeModal("deleteConfirmModal");
    });

  // Filter reset
  document
    .getElementById("resetFilterBtn")
    .addEventListener("click", function () {
      document.getElementById("filterForm").reset();
    });

  // Chart tab switching
  const chartTabs = document.querySelectorAll(".chart-tab");
  chartTabs.forEach((tab) => {
    tab.addEventListener("click", function () {
      // Update active tab
      document
        .querySelectorAll(".chart-tab")
        .forEach((t) => t.classList.remove("active"));
      this.classList.add("active");

      // Update chart based on selection
      const chartType = this.getAttribute("data-chart");
      updateChart(chartType);
    });
  });

  // Modal close buttons
  const closeButtons = document.querySelectorAll(".close-modal");
  closeButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const modal = this.closest(".modal");
      if (modal) {
        modal.classList.remove("show");
      }
    });
  });

  // Modal background click to close
  const modals = document.querySelectorAll(".modal");
  modals.forEach((modal) => {
    modal.addEventListener("click", function (e) {
      if (e.target === this) {
        this.classList.remove("show");
      }
    });
  });

  // Transaction item clicks for editing
  const transactionItems = document.querySelectorAll(
    ".transaction-item[data-id]"
  );
  transactionItems.forEach((item) => {
    item.addEventListener("click", function () {
      const transactionId = this.getAttribute("data-id");
      if (transactionId) {
        openEditModal(transactionId);
      }
    });
  });
}

/**
 * Update chart based on type
 */
function updateChart(chartType) {
  // This function would update the chart based on the selected type
  // Implementation depends on the chart library and data structure
  console.log("Updating chart to type:", chartType);
}

/**
 * Open edit modal for transaction
 */
function openEditModal(transactionId) {
  const modal = document.getElementById("editTransactionModal");
  if (modal) {
    // Populate modal with transaction data
    // This would typically fetch data and populate form fields
    modal.classList.add("show");
  }
}

/**
 * Open filter modal
 */
function openFilterModal() {
  const modal = document.getElementById("filterModal");
  if (modal) {
    modal.classList.add("show");
  }
}

/**
 * Format currency for display
 */
function formatCurrency(amount, showSign = false) {
  const formatted = new Intl.NumberFormat("ja-JP", {
    style: "currency",
    currency: "JPY",
    maximumFractionDigits: 0,
  }).format(Math.abs(amount));

  if (!showSign) return formatted;

  return amount >= 0 ? `+${formatted}` : `-${formatted}`;
}

// Export functions for global access
window.analyticsUtils = {
  formatCurrency,
  openFilterModal,
  openEditModal,
};
