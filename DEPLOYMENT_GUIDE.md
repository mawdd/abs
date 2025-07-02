# 🚀 Panduan Lengkap Deploy ke Hosting

## ✅ **READY TO DEPLOY!**

Semua fix sudah selesai, sekarang tinggal ikuti langkah berikut:

---

## 📋 **STEP-BY-STEP DEPLOYMENT:**

### **🔥 STEP 1: Download & Prepare Files**

#### **Option A: Download dari GitHub**

```bash
# Clone repository
git clone https://github.com/mawdd/abs.git
cd abs

# Atau download ZIP dari GitHub
```

#### **Option B: Siapkan Files Lokal**

```bash
# Buat ZIP tanpa file yang tidak perlu
tar -czf abs-hosting.tar.gz \
  --exclude=node_modules \
  --exclude=.git \
  --exclude=storage/logs/* \
  --exclude=storage/framework/cache/* \
  --exclude=storage/framework/sessions/* \
  --exclude=storage/framework/views/* \
  .
```

---

### **📤 STEP 2: Upload ke Hosting**

#### **Untuk cPanel/DirectAdmin:**

1. **Login** ke cPanel/DirectAdmin
2. **File Manager** → Buka folder `public_html/`
3. **Upload** file `abs-hosting.tar.gz`
4. **Extract** file ZIP/tar.gz
5. **Move semua isi folder** ke `public_html/` (bukan foldernya)

#### **Untuk FTP/SFTP:**

```bash
# Upload via FTP client (FileZilla, WinSCP, dll)
# Target: public_html/ atau www/ atau htdocs/
```

#### **⚠️ PENTING - Structure Folder:**

```
public_html/
├── app/
├── bootstrap/
├── config/
├── database/
├── resources/
├── routes/
├── storage/
├── vendor/ (akan dibuat composer)
├── public/ (isi folder ini pindah ke root)
├── .env
├── composer.json
└── artisan
```

---

### **🗄️ STEP 3: Setup Database**

#### **Buat Database MySQL:**

1. **cPanel** → **MySQL Databases**
2. **Create Database**: `abs_production`
3. **Create User**: `abs_user` dengan password kuat
4. **Assign User** ke database dengan **ALL PRIVILEGES**
5. **Catat**: Host, Database Name, Username, Password

#### **Alternative: phpMyAdmin**

```sql
CREATE DATABASE abs_production;
CREATE USER 'abs_user'@'localhost' IDENTIFIED BY 'password_kuat_123';
GRANT ALL PRIVILEGES ON abs_production.* TO 'abs_user'@'localhost';
FLUSH PRIVILEGES;
```

---

### **⚙️ STEP 4: Setup Environment (.env)**

#### **Copy & Edit .env:**

```bash
# Di File Manager atau via text editor
cp .env.example .env
```

#### **Edit .env dengan data hosting:**

```env
APP_NAME="Teacher Attendance System"
APP_ENV=production
APP_KEY=                    # Akan di-generate
APP_DEBUG=false
APP_TIMEZONE=Asia/Jakarta
APP_URL=https://yourdomain.com

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=localhost           # Atau IP dari hosting
DB_PORT=3306
DB_DATABASE=abs_production  # Nama database yang dibuat
DB_USERNAME=abs_user        # Username database
DB_PASSWORD=password_kuat_123 # Password database

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

SESSION_DRIVER=database
SESSION_LIFETIME=480        # 8 jam untuk hari sekolah
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

CACHE_STORE=database
CACHE_PREFIX=

MAIL_MAILER=log
```

---

### **🛠️ STEP 5: Install Dependencies**

#### **Via Terminal Hosting (jika ada):**

```bash
# Masuk ke folder website
cd public_html  # atau domain folder

# Install Composer dependencies
composer install --no-dev --optimize-autoloader

# Generate application key
php artisan key:generate

# Create storage link
php artisan storage:link
```

#### **⚠️ Jika TIDAK ada Terminal:**

1. **Download Composer Dependencies** di lokal:
    ```bash
    composer install --no-dev --optimize-autoloader
    ```
2. **Upload folder `vendor/`** ke hosting
3. **Generate key manual** di `.env`:
    ```
    APP_KEY=base64:RANDOM_32_CHARACTER_STRING_HERE
    ```

---

### **📊 STEP 6: Run Migration**

#### **Via Terminal:**

```bash
# Check migration status
php artisan migrate:status

# Run migration (SIAP! Sudah fix MySQL index length)
php artisan migrate

# Seed initial data
php artisan db:seed --class=AdminUserSeeder
php artisan db:seed --class=AttendanceLocationSeeder
php artisan db:seed --class=SystemSettingSeeder
```

#### **⚠️ Jika TIDAK ada Terminal:**

1. **Upload database dump** via phpMyAdmin
2. **Import** file `database/schema/mysql-schema.sql`
3. **Run seeders** via phpMyAdmin atau script

---

### **🔧 STEP 7: Set Permissions**

#### **Set Folder Permissions:**

```bash
# Storage & bootstrap cache (775 atau 755)
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/

# Jika perlu (di beberapa hosting)
chmod -R 644 .env
chmod 755 artisan
```

#### **Via File Manager:**

-   **storage/** → 775
-   **bootstrap/cache/** → 775
-   **.env** → 644
-   **public/** files → 644

---

### **🌐 STEP 8: Configure Web Server**

#### **Untuk Apache (.htaccess sudah included):**

```apache
# File public/.htaccess sudah ada, pastikan mod_rewrite aktif
```

#### **Untuk Nginx:**

```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/your/project/public;

    index index.php index.html index.htm;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

---

### **🎯 STEP 9: Final Optimization**

#### **Cache Configuration:**

```bash
# Optimize untuk production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Clear jika ada masalah
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

#### **Security Check:**

-   ✅ `.env` tidak bisa diakses dari browser
-   ✅ `storage/` tidak bisa diakses dari browser
-   ✅ `APP_DEBUG=false` di production
-   ✅ Database user hanya akses database yang diperlukan

---

### **✅ STEP 10: Testing & Verification**

#### **Test URLs:**

```
https://yourdomain.com/              → Landing page
https://yourdomain.com/login         → Login form
https://yourdomain.com/admin         → Admin panel (Filament)
https://yourdomain.com/teacher       → Teacher panel (Filament)
```

#### **Test Functionality:**

1. **Login Admin**: admin@system.com / password
2. **GPS Location**: Test GPS functionality
3. **Database**: Check tables created
4. **PWA**: Test install prompt
5. **Mobile**: Test responsive design

---

## 🆘 **TROUBLESHOOTING:**

### **Error 500:**

```bash
# Check logs
tail -f storage/logs/laravel.log

# Common fixes
php artisan config:clear
chmod -R 775 storage/
```

### **Database Connection Error:**

-   ✅ Check `.env` database settings
-   ✅ Verify database user permissions
-   ✅ Test database connection via phpMyAdmin

### **Migration Errors:**

```bash
# Our fixes should prevent MySQL 1071 errors
# If still error, check:
php artisan migrate:status
php artisan migrate --force
```

### **Assets Not Loading:**

-   ✅ CDN should work (no Node.js needed)
-   ✅ Check network connection for Tailwind CDN
-   ✅ Verify public folder structure

---

## 🎉 **SELESAI!**

### **✅ PRODUCTION READY:**

-   **Teacher Attendance System** fully deployed
-   **GPS Location Tracking** active
-   **PWA** installable
-   **Admin & Teacher** panels ready
-   **Mobile Responsive**

### **🔐 Default Login:**

-   **Admin**: admin@system.com / password
-   **Teacher**: teacher@system.com / password

### **📱 Features Active:**

-   ✅ Daily attendance check-in/out
-   ✅ GPS location validation
-   ✅ Teaching session management
-   ✅ Attendance history & reports
-   ✅ PWA offline support
-   ✅ Admin management panel

**🚀 READY TO USE!** School attendance system siap digunakan!
