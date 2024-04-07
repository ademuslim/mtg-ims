// Menangani fungsi toggleAccordion()
function toggleAccordion(element) {
  element.classList.toggle("active"); // Menambah atau menghapus kelas 'active' pada elemen yang diklik
  let subMenu = element.nextElementSibling;

  if (subMenu.style.maxHeight) {
    subMenu.style.maxHeight = null; // Jika sudah terbuka, tutup
  } else {
    subMenu.style.maxHeight = subMenu.scrollHeight + "px"; // Jika belum terbuka, buka
  }
}
