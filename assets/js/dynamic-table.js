// Tabel dynamic
// Menangani klik pada dokumen (event delegation)
document.addEventListener("click", function (event) {
  // Memeriksa apakah elemen yang diklik memiliki kelas "addRow"
  if (event.target.classList.contains("addRow")) {
    // Mengambil baris saat ini dimana tombol "Add" diklik
    var currentRow = event.target.closest(".data-row");
    // Menduplikasi baris saat ini untuk membuat baris baru
    var newRow = currentRow.cloneNode(true);

    // Tombol delete ditampilkan di baris sebelumnya
    currentRow.querySelector(".deleteRow").style.display = "inline-block";
    // Tombol add disembunyikan di baris sebelumnya
    currentRow.querySelector(".addRow").style.display = "none";

    // Tombol "Delete" ditampilkan di baris baru
    newRow.querySelector(".deleteRow").style.display = "inline-block";
    // Tombol add ditampilkan di baris baru
    newRow.querySelector(".addRow").style.display = "inline-block";

    // Reset nilai input pada baris baru
    newRow.querySelectorAll("input").forEach(function (input) {
      input.value = "";
    });

    // Reset nilai total harga pada baris baru
    newRow.querySelector(".total-harga").textContent = "";

    // Increment nomor baris
    var lastRowNumber = parseInt(
      document
        .querySelector("#dataTable tbody")
        .lastElementChild.querySelector(".row-number").textContent
    );
    newRow.querySelector(".row-number").textContent = lastRowNumber + 1;

    // Baris baru ditambahkan ke dalam tabel
    currentRow.parentNode.insertBefore(newRow, currentRow.nextSibling);

    // Update nomor baris setelah penambahan baris baru
    updateRowNumbers();
  } else if (event.target.classList.contains("deleteRow")) {
    // Hapus baris ketika tombol delete ditekan
    event.target.closest(".data-row").remove();

    // Update tombol "Delete" dan "Add" sesuai dengan jumlah total baris setelah penghapusan
    updateButtons();

    // Update nomor baris setelah penghapusan baris
    updateRowNumbers();
  }
});

document.addEventListener("input", function (event) {
  // Mengambil baris yang sedang diubah
  var currentRow = event.target.closest(".data-row");

  // Mengambil nilai kuantitas dan harga satuan dari input
  var kuantitasInput = currentRow.querySelector("input[name='kuantitas[]']");
  var hargaSatuanInput = currentRow.querySelector(
    "input[name='harga_satuan[]']"
  );

  // Mengambil nilai kuantitas dan harga satuan jika diisi, atau 0 jika tidak
  var kuantitas = parseInt(kuantitasInput.value) || 0;
  var hargaSatuan = parseInt(hargaSatuanInput.value) || 0;

  // Mengambil elemen total harga di baris yang sedang diubah
  var totalHargaElement = currentRow.querySelector(".total-harga");

  // Jika kuantitas dan harga satuan diisi, maka hitung total harga
  if (kuantitas && hargaSatuan) {
    // Menghitung total harga
    var totalHarga = kuantitas * hargaSatuan;
    // Menampilkan total harga pada elemen yang sesuai
    totalHargaElement.textContent = totalHarga;
  } else {
    // Jika kuantitas atau harga satuan kosong, kosongkan juga total harga
    totalHargaElement.textContent = "";
  }

  // Jika ini adalah baris baru yang ditambahkan, reset nilai total harga
  if (event.target.classList.contains("addRow")) {
    var newRowTotalHargaElement =
      currentRow.nextElementSibling.querySelector(".total-harga");
    newRowTotalHargaElement.textContent = "";
  }
});

function updateButtons() {
  var rows = document.querySelectorAll(".data-row");
  var lastRow = rows[rows.length - 1];

  if (rows.length === 1) {
    // Jika hanya ada satu baris, sembunyikan tombol "Delete" dan tampilkan tombol "Add"
    rows[0].querySelector(".deleteRow").style.display = "none";
    rows[0].querySelector(".addRow").style.display = "inline-block";
  } else {
    // Tampilkan tombol "Delete" di semua baris kecuali baris terakhir
    rows.forEach(function (row) {
      row.querySelector(".deleteRow").style.display = "inline-block";
    });

    // tampilkan tombol "Add" di baris terakhir
    lastRow.querySelector(".addRow").style.display = "inline-block";
  }
}

// Function untuk memperbarui nomor baris
function updateRowNumbers() {
  var rowNumbers = document.querySelectorAll(".row-number");
  rowNumbers.forEach(function (row, index) {
    row.textContent = index + 1;
  });
}
