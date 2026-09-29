// ===== 1. Hamburger Menu (JS-Driven) =====
function initNavToggle() {
  const toggleBtn = document.getElementById("nav-toggle-btn");
  const nav = document.querySelector("header nav");

  if (!toggleBtn || !nav) return;

  toggleBtn.addEventListener("click", function () {
    nav.classList.toggle("nav-open");
  });
}

// ===== 2. Delete Confirmation (Event Delegation) =====
function initDeleteConfirm() {
  document.addEventListener("click", function (e) {
    const btn = e.target.closest(".btn-delete");
    if (!btn) return;

    const row = btn.closest("tr");
    const name = row ? row.querySelector("td")?.textContent : "this item";
    const confirmed = confirm('Are you sure you want to delete "' + name + '"?');

    if (confirmed && row) {
      row.remove();
    }
  });
}

// ===== 3. Real-Time Table Filter =====
function initTableFilter() {
  const input = document.getElementById("search-input");
  const table = document.querySelector(".table-responsive table");

  if (!input || !table) return;

  input.addEventListener("keyup", function () {
    const keyword = input.value.toLowerCase();
    const rows = table.querySelectorAll("tbody tr");

    rows.forEach(function (row) {
      const text = row.textContent.toLowerCase();
      row.style.display = text.includes(keyword) ? "" : "none";
    });
  });
}

// ===== 4. Form Validation (Client-Side) =====
function showError(input, message) {
  clearError(input);
  const span = document.createElement("span");
  span.className = "error";
  span.textContent = message;
  input.insertAdjacentElement("afterend", span);
}

function clearError(input) {
  const next = input.nextElementSibling;
  if (next && next.classList.contains("error")) {
    next.remove();
  }
}

function initFormValidation() {
  const form = document.getElementById("form-add");
  if (!form) return;

  form.addEventListener("submit", function (e) {
    let valid = true;

    // Validasi Judul / Nama
    const title = form.querySelector("[name='title'], [name='name']");
    if (title && title.value.trim() === "") {
      showError(title, "This field is required.");
      valid = false;
    } else if (title) {
      clearError(title);
    }

    // Validasi Penulis / Alamat
    const author = form.querySelector("[name='author'], [name='address']");
    if (author && author.value.trim() === "") {
      showError(author, "This field is required.");
      valid = false;
    } else if (author) {
      clearError(author);
    }

    // Validasi Tahun
    const year = form.querySelector("[name='year']");
    if (year) {
      const value = parseInt(year.value, 10);
      if (isNaN(value) || value < 1900 || value > 2026) {
        showError(year, "Year must be between 1900 and 2026.");
        valid = false;
      } else {
        clearError(year);
      }
    }

    // Validasi Stok
    const stock = form.querySelector("[name='stock']");
    if (stock) {
      const value = parseInt(stock.value, 10);
      if (isNaN(value) || value < 0) {
        showError(stock, "Stock cannot be negative.");
        valid = false;
      } else {
        clearError(stock);
      }
    }

    if (!valid) {
      e.preventDefault();
    }
  });
}

// ===== Entry Point Utama =====
document.addEventListener("DOMContentLoaded", function () {
  initNavToggle();
  initDeleteConfirm();
  initTableFilter();
  initFormValidation();
});