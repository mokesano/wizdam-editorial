## Panduan Membersihkan Repositori (lumera-edge) – Storage Cache (PS)

### ⚠️ Catatan Penting
- Folder kode sumber **`Cache`** (SimplePie, `core/Library/.../Cache/`) dan **`core/Modules/cache`** tidak boleh tersentuh.
- Folder dependensi seperti `vendor/`, `core/Library/`, `node_modules/` juga tidak boleh diubah isinya.
- Semua file di `storage/cache/` akan dihapus dari indeks Git, kecuali nanti kita tambahkan kembali tiga folder inti dengan `.gitkeep`.

---

### 1. Pulihkan Jika Sebelumnya Ada Kesalahan

Jika Anda sebelumnya menjalankan perintah yang salah dan file kode sumber ikut ter-`rm --cached`, pulihkan dulu:

```powershell
git restore --staged .
```

---

### 2. Masuk ke Direktori Repositori

```powershell
Set-Location -Path "C:\xampp\htdocs\lumera-edge"
```

Pastikan status bersih:

```powershell
git status
```

---

### 3. Hentikan Pelacakan Semua File di `storage/cache/`

Hapus seluruh file di dalam `storage/cache/` dari indeks Git (tanpa menyentuh file asli di disk).

```powershell
git rm --cached -r storage/cache/* 2>$null
```

Perintah ini akan menghapus dari indeks semua file yang terlacak di bawah `storage/cache/`. Error `fatal: pathspec '...' did not match any files` akan diabaikan (`2>$null`).

---

### 4. Hentikan Pelacakan File `*.json.gz` di Plugin & Luar Dependensi

Kita hapus dari indeks semua file `.json.gz` yang **tidak** berada di `vendor/`, `core/Library/`, atau `node_modules/`.

```powershell
git ls-files '*.json.gz' | ForEach-Object {
    if ($_ -notmatch "(vendor/|core/Library/|node_modules/)") {
        git rm --cached $_
    }
}
```

Ini akan mencakup file `*.json.gz` di `plugins/` (seperti yang banyak muncul di `plugins/themes/sangiapub/php/.../cache/`).

---

### 5. Perbarui File `.gitignore`

Buka `.gitignore` dengan Notepad:

```powershell
notepad .gitignore
```

**Tambahkan** aturan berikut (jangan hapus aturan lain yang sudah ada):

```gitignore
# Abaikan seluruh isi storage/cache/ kecuali .gitkeep di folder inti
storage/cache/*
!storage/cache/t_cache/.gitkeep
!storage/cache/t_compile/.gitkeep
!storage/cache/t_config/.gitkeep

# Abaikan semua file .json.gz di seluruh repositori
*.json.gz
```

**Penjelasan singkat:**
- `storage/cache/*` akan mengabaikan semua file di dalam `storage/cache/`.
- `!storage/cache/t_cache/.gitkeep` mengecualikan file `.gitkeep` di folder inti, sehingga folder tersebut tetap bisa disimpan.
- `*.json.gz` akan membuat Git mengabaikan semua file `.json.gz` di mana pun, termasuk di plugin.

Simpan dan tutup Notepad.

---

### 6. Buat File `.gitkeep` di Tiga Folder Cache Inti

```powershell
$folderInti = @(
    "storage/cache/t_cache",
    "storage/cache/t_compile",
    "storage/cache/t_config"
)

foreach ($folder in $folderInti) {
    New-Item -ItemType Directory -Force -Path $folder | Out-Null
    $gitkeepPath = Join-Path $folder ".gitkeep"
    if (-not (Test-Path $gitkeepPath)) {
        New-Item -ItemType File -Path $gitkeepPath -Force | Out-Null
        Write-Host "Membuat $gitkeepPath"
    }
}
```

---

### 7. Tambahkan `.gitkeep` dan `.gitignore` ke Staging

```powershell
# Tambahkan .gitkeep secara paksa
Get-ChildItem -Recurse -Filter ".gitkeep" | ForEach-Object { git add --force $_.FullName }
# Tambahkan .gitignore
git add .gitignore
```

---

### 8. Periksa Staging Area

```powershell
git status
```

Pastikan hanya file `.gitkeep` (tiga buah) dan perubahan `.gitignore` yang muncul di **"Changes to be committed"**. Jika masih ada file cache lain, batalkan dengan `git reset HEAD <file>`.

---

### 9. Commit

```powershell
git commit -m "Bersihkan file cache, hanya pertahankan folder cache inti di storage/cache"
```

---

### 10. Push ke GitHub

```powershell
git push
```

---

### 11. Verifikasi Akhir

```powershell
git status
git status --ignored
git ls-files '*.json.gz'
git ls-files 'storage/cache/'
git ls-files '*.gitkeep'
```

- `git status` → *nothing to commit, working tree clean*.
- `git status --ignored` → file `.json.gz` di plugin akan muncul sebagai *Ignored files*.
- `git ls-files '*.json.gz'` → **kosong** (atau hanya file di dalam `vendor/`/`core/Library/` jika masih dilacak, yang seharusnya sudah tidak ada).
- `git ls-files 'storage/cache/'` → hanya tiga file `.gitkeep` di dalam `t_cache`, `t_compile`, `t_config`.
- `git ls-files '*.gitkeep'` → menampilkan tiga file tersebut.

---

**Selesai.** Repositori kini bersih dari file cache. Folder `storage/cache/t_cache`, `storage/cache/t_compile`, dan `storage/cache/t_config` tetap ada dengan placeholder `.gitkeep`; file cache lainnya (termasuk `.json.gz` di plugin) tidak akan pernah tercommit lagi.