// Mengambil & menampilkan Daftar Anggota secara asinkron dari data/members.json
async function loadMemberList() {
  const tbody = document.querySelector(".table-responsive table tbody");
  const loading = document.getElementById("loading-indicator");

  if (!tbody) return;

  if (loading) loading.style.display = "block";
  tbody.innerHTML = "";

  try {
    // Simulasi delay jaringan diperlama menjadi 3000ms (3 detik)
    await new Promise((resolve) => setTimeout(resolve, 3000));

    const res = await fetch("../data/members.json");
    if (!res.ok) {
      throw new Error("Gagal mengambil data (status " + res.status + ")");
    }

    const memberList = await res.json();

    memberList.forEach(function (member) {
      const tr = document.createElement("tr");
      tr.innerHTML =
        "<td>" + member.member_no + "</td>" +
        "<td>" + member.name + "</td>" +
        "<td>" + member.address + "</td>" +
        "<td>" + member.phone_no + "</td>" +
        "<td>" +
        '<button type="button">Edit</button> ' +
        '<button type="button" class="btn-delete">Delete</button>' +
        "</td>";
      tbody.appendChild(tr);
    });
  } catch (err) {
    tbody.innerHTML =
      '<tr><td colspan="5">Gagal memuat data: ' + err.message + "</td></tr>";
  } finally {
    if (loading) loading.style.display = "none";
  }
}

document.addEventListener("DOMContentLoaded", loadMemberList);