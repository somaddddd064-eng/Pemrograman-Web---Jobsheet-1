// Mengambil & menampilkan Daftar Buku secara asinkron dari data/books.json
async function loadBookList() {
  const tbody = document.querySelector(".table-responsive table tbody");
  const loading = document.getElementById("loading-indicator");

  if (!tbody) return;

  if (loading) loading.style.display = "block";
  tbody.innerHTML = "";

  try {
    // Simulasi delay jaringan diperlama menjadi 3000ms (3 detik)
    await new Promise((resolve) => setTimeout(resolve, 3000));

    const res = await fetch("../data/books.json");
    if (!res.ok) {
      throw new Error("Gagal mengambil data (status " + res.status + ")");
    }

    const bookList = await res.json();

    bookList.forEach(function (book) {
      const tr = document.createElement("tr");
      tr.innerHTML =
        "<td>" + book.title + "</td>" +
        "<td>" + book.author + "</td>" +
        "<td>" + book.year + "</td>" +
        "<td>" + book.stock + "</td>" +
        "<td>" + (book.category || "-") + "</td>" +
        "<td>" +
        '<button type="button">Edit</button> ' +
        '<button type="button" class="btn-delete">Delete</button>' +
        "</td>";
      tbody.appendChild(tr);
    });
  } catch (err) {
    tbody.innerHTML =
      '<tr><td colspan="6">Gagal memuat data: ' + err.message + "</td></tr>";
  } finally {
    if (loading) loading.style.display = "none";
  }
}

document.addEventListener("DOMContentLoaded", loadBookList);