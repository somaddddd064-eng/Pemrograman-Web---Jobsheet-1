document.addEventListener("DOMContentLoaded", function () {
    initHapusConfirm();
    initUpdateConfirm();
});

// Konfirmasi Hapus via Event Delegation "submit"
function initHapusConfirm() {
    document.addEventListener("submit", function (e) {
        const form = e.target;
        if (!form.classList.contains("form-hapus")) return;

        const row = form.closest("tr");
        const nama = row ? row.querySelector("td")?.textContent : "data ini";

        const yakin = confirm("Yakin ingin menghapus \"" + nama.trim() + "\"?");
        if (!yakin) {
            e.preventDefault();
        }
    });
}

// Exercise 7.4 Item 1: Additional Confirmation Before Update
function initUpdateConfirm() {
    document.addEventListener("submit", function (e) {
        const form = e.target;
        if (form.getAttribute("action") === "process_edit.php") {
            const yakin = confirm("Apakah Anda yakin ingin menyimpan perubahan data ini?");
            if (!yakin) {
                e.preventDefault();
            }
        }
    });
}