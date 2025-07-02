# SOLUSI LOGIN ADMIN - 3 CARA ALTERNATIF

## ❗ MASALAH: Login admin gagal setelah upload database schema

**Penyebab**: File `mysql-schema.sql` hanya berisi struktur tabel, tidak ada data admin user.

---

## 🔧 SOLUSI 1: SQL Manual (TERCEPAT)

1. **Buka phpMyAdmin** di cPanel hosting
2. **Copy-paste** semua isi file `CREATE_ADMIN_USER_FIXED.sql`
3. **Klik Go** untuk menjalankan
4. **Cek hasil**: Harus tampil "USER CREATED" dan "LOCATION CREATED"
5. **Login**:
    - URL: `https://absensi.mahabathina.or.id/admin`
    - Email: `admin@attendance.com`
    - Password: `password123`

---

## 🔧 SOLUSI 2: Upload Database Lengkap

1. **Download** file `database_with_admin.sql` (sudah berisi admin user + lokasi)
2. **Backup database lama** di phpMyAdmin (Export)
3. **Drop semua tabel** di database lama
4. **Import** file `database_with_admin.sql` yang baru
5. **Login dengan credentials yang sama**

---

## 🔧 SOLUSI 3: Manual via phpMyAdmin

Jika SQL gagal, buat manual:

1. **Buka tabel `users`** di phpMyAdmin
2. **Insert new row** dengan data:

    ```
    name: System Administrator
    email: admin@attendance.com
    password: $2y$12$.JAJjhUd4JAPTB/fLypN2.FuJHkQs0bUnBR5xFFw6ukPF1t6r9rSW
    role: admin
    is_active: 1
    phone_number: +62812345678901
    created_at: 2024-12-19 12:00:00
    updated_at: 2024-12-19 12:00:00
    ```

3. **Buka tabel `attendance_locations`**
4. **Insert new row** dengan data:
    ```
    name: Sekolah Utama
    latitude: -6.562994582429248
    longitude: 110.86059242639898
    radius_meters: 500
    is_active: 1
    is_primary: 1
    description: Lokasi sekolah utama
    created_at: 2024-12-19 12:00:00
    updated_at: 2024-12-19 12:00:00
    ```

---

## 🔍 DEBUGGING STEPS

Jika masih gagal login, cek:

### 1. Database Check

```sql
SELECT id, name, email, role, is_active FROM users WHERE email = 'admin@attendance.com';
```

**Harus ada 1 row dengan role = 'admin'**

### 2. URL Check

-   ✅ **Benar**: `https://absensi.mahabathina.or.id/admin`
-   ❌ **Salah**: `https://absensi.mahabathina.or.id/admin/login`

### 3. Browser Check

-   Clear cache (Ctrl+Shift+Delete)
-   Coba Incognito mode
-   Coba browser lain

### 4. Error Check

-   Buka Developer Tools (F12)
-   Lihat tab Console saat login
-   Screenshot error dan kirim

---

## 📋 CREDENTIALS FINAL

**Admin Login:**

-   **URL**: https://absensi.mahabathina.or.id/admin
-   **Email**: admin@attendance.com
-   **Password**: password123

**Teacher Login:**

-   **URL**: https://absensi.mahabathina.or.id/teacher
-   (Buat teacher user manual di admin panel setelah login admin berhasil)

---

## 🆘 JIKA MASIH GAGAL

Kirim screenshot dari:

1. **Error message** di browser
2. **Hasil query** `SELECT * FROM users;`
3. **Developer Console** saat login

Kita akan debug lebih lanjut!
