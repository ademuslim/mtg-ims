# Dokumentasi Fungsi tambahData

## Deskripsi

Fungsi `tambahData` digunakan untuk menambahkan data ke dalam tabel database MySQL.

## Parameter

1. `$tableName` (string): Nama tabel yang akan ditambahkan datanya.
2. `$columnNames` (array): Array yang berisi nama kolom pada tabel yang akan diisi.
3. `$columnValues` (array): Array yang berisi nilai-nilai yang akan dimasukkan ke dalam kolom yang sesuai.
4. `$customMessage` (string): Pesan kustom yang akan digunakan dalam pesan kesuksesan atau kegagalan.

## Pengembalian Nilai

Tidak ada.

## Cara Penggunaan

Fungsi ini dapat dipanggil dengan menggunakan sintaks berikut:

```
tambahData($tableName, $columnNames, $columnValues, $customMessage);
```

## Contoh Penggunaan

Berikut adalah contoh penggunaan fungsi `tambahData`:

```
// Menambahkan data ke dalam tabel "data_harga"
$tabel = "data_harga";
$kolom = ["tanggal", "id_produk", "harga"];
$nilai = [$tanggal, $idProduk, $harga];
pesan_kustom = "harga";
tambahData($tabel, $kolom, $nilai, $pesan_kustom);
```

---

# Dokumentasi Fungsi hapusData

## Deskripsi

Fungsi `hapusData` digunakan untuk menghapus data dari tabel di database MySQL berdasarkan kondisi tertentu.

## Parameter

1. `$tableName` (string): Nama tabel dari mana data akan dihapus.
2. `$conditions` (string): Kondisi untuk mengidentifikasi data yang akan dihapus.
3. `$customMessage` (string): Pesan kustom yang akan digunakan dalam pesan kesuksesan atau kegagalan.

## Pengembalian Nilai

Tidak ada.

## Cara Penggunaan

Fungsi ini dapat dipanggil dengan menggunakan sintaks berikut:

```
hapusData($tableName, $conditions, $customMessage);
```

## Contoh Penggunaan

Berikut adalah contoh penggunaan fungsi `hapusData`:

```
// Menghapus data produk dari tabel "produk" berdasarkan kondisi tertentu
$tabel = "produk";
$kondisi = "id_produk = 5";
pesan_kustom = "produk";
hapusData($tabel, $kondisi, $pesan_kustom);
```

---

# Dokumentasi Fungsi `updateData`

## Deskripsi

Fungsi `updateData` digunakan untuk mengupdate data di dalam tabel database MySQL berdasarkan kondisi tertentu.

## Parameter

1. `$tableName` (string): Nama tabel yang akan diupdate.
2. `$updateValues` (array): Array asosiatif yang berisi pasangan nama kolom dan nilai baru yang akan diupdate.
3. `$conditions` (string): Kondisi untuk mengidentifikasi record yang akan diupdate.
4. `$customMessage` (string): Pesan kustom yang akan digunakan dalam pesan kesuksesan atau kegagalan.

## Pengembalian Nilai

Tidak ada.

## Cara Penggunaan

Fungsi ini dapat dipanggil dengan menggunakan sintaks berikut:

```php
updateData($tableName, $updateValues, $conditions, $customMessage);
```

## Contoh Penggunaan

Berikut adalah contoh penggunaan fungsi `updateData`:

```php
// Update data produk di dalam tabel "data_produk"
$tableName = "data_produk";
$updateValues = [
    "no_produk" => "ABC123",
    "deskripsi" => "Deskripsi baru",
    "satuan" => "Kilogram"
];
$conditions = "id_produk='123'";
$customMessage = "produk";
updateData($tableName, $updateValues, $conditions, $customMessage);
```

---
