# DEBUG LOGIN GAGAL - INSTRUKSI LENGKAP

## LANGKAH 1: Jalankan SQL yang Baru (dengan Hash Password Fresh)

1. Buka **phpMyAdmin** di cPanel
2. Pilih database kamu
3. Copy-paste **SEMUA ISI** file `CREATE_ADMIN_USER_FIXED.sql`
4. Klik **Go/Jalankan**
5. Pastikan ada pesan sukses dan hasil SELECT menampilkan user & lokasi

## LANGKAH 2: Test Login dengan 2 Opsi Password

**Opsi 1 - Password: password123**

-   Email: `admin@attendance.com`
-   Password: `password123`

**Opsi 2 - Password: admin** (jika opsi 1 gagal, uncomment baris alternatif di SQL)

-   Email: `admin@attendance.com`
-   Password: `admin`

## LANGKAH 3: Cek Database Manual

Jalankan query ini di phpMyAdmin untuk memastikan data benar:

```sql
SELECT id, name, email, role, is_active, created_at FROM users WHERE email = 'admin@attendance.com';
```

Harus menampilkan:

-   **role**: admin
-   **is_active**: 1
-   **created_at**: tanggal hari ini

## LANGKAH 4: Cek URL Login

Pastikan kamu akses URL yang benar:

-   **Admin Panel**: https://absensi.mahabathina.or.id/admin
-   **Bukan**: https://absensi.mahabathina.or.id/admin/login

## LANGKAH 5: Clear Browser Cache

1. Clear cache browser (Ctrl+Shift+Delete)
2. Atau coba **Incognito/Private Mode**
3. Atau coba browser lain

## LANGKAH 6: Jika Masih Gagal - Check Error

1. Buka **Developer Tools** (F12)
2. Klik tab **Console**
3. Coba login lagi
4. Screenshot error yang muncul dan kirim ke saya

## LANGKAH 7: Alternatif - Upload Database Baru

Jika semua gagal, kita bisa:

1. Download database backup yang sudah ada data admin
2. Import ulang ke hosting
3. Atau buat user manual lewat Laravel command

## LANGKAH 8: Manual Check di Database

Jika perlu, jalankan query ini untuk debug:

```sql
-- Cek semua users
SELECT * FROM users;

-- Cek struktur tabel users
DESCRIBE users;

-- Test manual password verification (hanya untuk debug)
SELECT email, password FROM users WHERE email = 'admin@attendance.com';
```

---

**KIRIM SCREENSHOT jika ada error atau hasil SELECT yang tidak sesuai!**
