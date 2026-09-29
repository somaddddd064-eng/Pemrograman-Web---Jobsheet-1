// Fungsi generik untuk fetch & render data tabel
async function loadTableData(jsonPath, columns) {
  const tbody = document.querySelector(".table-responsive table tbody");
  const loading = document.getElementById("loading-indicator");

  if (!tbody) return;
  if (loading) loading.style.display = "block";
  tbody.innerHTML = "";

  try {
    // Simulasi delay jaringan diperlama menjadi 3000ms (3 detik)
    await new Promise((resolve) => setTimeout(resolve, 3000));

    const res = await fetch(jsonPath);
    if (!res.ok) throw new Error("Gagal mengambil data (status " + res.status + ")");

    const dataList = await res.json();

    dataList.forEach((item) => {
      const tr = document.createElement("tr");
      let cellsHTML = "";

      // Buat <td> dinamis berdasarkan array nama kolom/key yang dikirim
      columns.forEach((key) => {
        cellsHTML += "<td>" + (item[key] !== undefined ? item[key] : "") + "</td>";
      });

      // Tambahkan kolom tombol aksi
      cellsHTML += `
        <td>
          <button type="button">Edit</button>
          <button type="button" class="btn-delete">Delete</button>
        </td>`;

      tr.innerHTML = cellsHTML;
      tbody.appendChild(tr);
    });
  } catch (err) {
    const colCount = columns.length + 1;
    tbody.innerHTML = `<tr><td colspan="${colCount}">Gagal memuat data: ${err.message}</td></tr>`;
  } finally {
    if (loading) loading.style.display = "none";
  }
}