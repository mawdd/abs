# 🆘 Hosting Troubleshooting - Filament Admin Panel

## ❌ **MASALAH: "Di Local Bisa, Hosting Tidak Bisa"**

### 🔍 **DIAGNOSIS CEPAT:**

**1. Cek URL yang Benar:**

```
❌ SALAH: https://yourdomain.com/
❌ SALAH: https://yourdomain.com/login
✅ BENAR: https://yourdomain.com/admin
```

**2. Cek Error Message:**

-   500 Internal Server Error
-   404 Not Found
-   Blank white page
-   Database connection error

---

## 🛠️ **SOLUSI LANGKAH DEMI LANGKAH:**

### **🚨 STEP 1: Cek File Permissions**

**Via cPanel File Manager:**

```
storage/ → 775 atau 755
bootstrap/cache/ → 775 atau 755
.env → 644
public/ → 755
```

**Via Terminal (jika ada):**

```bash
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
chmod 644 .env
chmod 755 public/
```

### **🗄️ STEP 2: Cek Database & .env**

**Periksa .env file:**

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost          # Atau IP hosting
DB_PORT=3306
DB_DATABASE=nama_database  # Yang dibuat di hosting
DB_USERNAME=user_database  # User database hosting
DB_PASSWORD=password_db    # Password database hosting
```

**Test Database Connection:**

```bash
# Via terminal hosting (jika ada)
php artisan tinker
DB::connection()->getPdo();
```

### **📦 STEP 3: Install Dependencies**

**Pastikan Composer Dependencies Terinstall:**

```bash
# Via terminal hosting
composer install --no-dev --optimize-autoloader

# Jika tidak ada terminal, upload folder vendor/ dari lokal
```

### **🔑 STEP 4: Generate Application Key**

```bash
# Via terminal
php artisan key:generate

# Atau manual edit .env
APP_KEY=base64:RANDOM_STRING_HERE
```

### **📊 STEP 5: Run Migrations**

```bash
# Cek status migration
php artisan migrate:status

# Run migration
php artisan migrate --force

# Seed data
php artisan db:seed --class=AdminUserSeeder
```

### **🔗 STEP 6: Create Storage Link**

```bash
# Wajib untuk Filament assets
php artisan storage:link

# Atau manual buat symlink
ln -s ../storage/app/public public/storage
```

### **⚡ STEP 7: Clear & Cache**

```bash
# Clear all cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Generate cache untuk production
php artisan config:cache
php artisan route:cache
```

---

## 🎯 **SOLUSI SPESIFIK ERROR:**

### **🚨 Error 500 Internal Server Error**

**Cara Debug:**

```bash
# Aktifkan debug sementara
# Edit .env
APP_DEBUG=true

# Atau cek error log
tail -f storage/logs/laravel.log
```

**Solusi Umum:**

-   File permissions storage/ dan bootstrap/cache/
-   Missing .env file
-   Database connection error
-   Missing vendor/ folder

### **🚨 Error 404 Not Found**

**Masalah:**

-   Document root salah
-   .htaccess tidak berfungsi

**Solusi:**

```apache
# Pastikan .htaccess ada di public/
# File: public/.htaccess
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_URI} !^(/public)?
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

### **🚨 Error Database Connection**

**Debug:**

```bash
# Test koneksi
php artisan migrate:status
```

**Solusi:**

-   Cek DB_HOST (biasanya localhost)
-   Cek DB_DATABASE nama database yang benar
-   Cek user permission database
-   Test via phpMyAdmin

### **🚨 Blank White Page**

**Penyebab:**

-   PHP memory limit
-   Missing dependencies
-   Fatal error

**Solusi:**

```php
// Tambah di public/index.php (sementara)
ini_set('display_errors', 1);
error_reporting(E_ALL);
```

---

## ⚡ **QUICK FIX COMMANDS:**

**Satu Command untuk Fix Semua:**

```bash
# Copy paste command ini di terminal hosting
chmod -R 775 storage/ bootstrap/cache/ && \
php artisan storage:link && \
php artisan config:cache && \
php artisan route:cache && \
php artisan migrate --force && \
php artisan db:seed --class=AdminUserSeeder
```

---

## 📝 **CHECKLIST SETELAH DEPLOY:**

### **✅ Test URLs:**

-   [ ] `https://yourdomain.com/` → Homepage
-   [ ] `https://yourdomain.com/admin` → Filament login
-   [ ] `https://yourdomain.com/teacher` → Teacher panel

### **✅ Test Login:**

-   [ ] Admin: `admin@attendance.com` / `password123`
-   [ ] Bisa akses dashboard Filament
-   [ ] Menu navigasi tampil semua

### **✅ Test Functionality:**

-   [ ] GPS location berfungsi
-   [ ] Database CRUD operations
-   [ ] File upload (jika ada)

---

## 🔧 **HOSTING SPECIFIC FIXES:**

### **cPanel/DirectAdmin:**

```bash
# Set PHP version ke 8.1 atau 8.2
# Aktifkan extension: pdo_mysql, mbstring, xml, curl
```

### **Shared Hosting (Hostinger, Niagahoster):**

```
# Document Root: public_html/public/
# Atau move isi public/ ke public_html/
```

### **VPS/Cloud:**

```bash
# Install PHP extensions
sudo apt-get install php8.2-mysql php8.2-mbstring php8.2-xml
```

---

## 🆘 **JIKA MASIH ERROR:**

### **Log Debugging:**

```bash
# Cek Laravel log
tail -f storage/logs/laravel.log

# Cek Apache/Nginx error log
tail -f /var/log/apache2/error.log
```

### **Manual Testing:**

```bash
# Test basic Laravel
echo "<?php phpinfo();" > test.php

# Test database
php artisan tinker
User::count();
```

---

## 🎉 **HASIL AKHIR:**

Setelah semua langkah, akses:

```
https://yourdomain.com/admin
```

Login dengan:

-   **Email:** admin@attendance.com
-   **Password:** password123

**Harus tampil:** Dashboard Filament dengan sidebar menu!

---

## 📞 **EMERGENCY CONTACT:**

Jika semua langkah sudah dicoba tapi masih error, kirim:

1. **Error message** yang muncul
2. **URL** yang diakses
3. **Hosting provider** yang digunakan
4. **Screenshot** error page
5. **Laravel log** (dari storage/logs/laravel.log)

**Kami akan bantu debug lebih detail!** 🚀
