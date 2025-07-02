# 🚨 Fix Error 403 Forbidden - Laravel Hosting

## ❌ **MASALAH:** "Forbidden - Access to this resource on the server is denied!"

Error ini terjadi karena **structure folder Laravel belum benar** di hosting.

---

## 🔧 **SOLUSI CEPAT:**

### **🎯 MASALAH UTAMA: Public Folder Structure**

Laravel membutuhkan **isi folder `public/` sebagai document root**, bukan folder `public/` itu sendiri.

#### **❌ STRUKTUR SALAH:**

```
public_html/
├── app/
├── database/
├── public/          ← Folder ini tidak boleh ada di root
│   ├── index.php    ← File ini harus di root
│   └── .htaccess    ← File ini harus di root
└── composer.json
```

#### **✅ STRUKTUR BENAR:**

```
public_html/
├── index.php        ← Harus di root (dari folder public/)
├── .htaccess        ← Harus di root (dari folder public/)
├── css/             ← Dari public/css/
├── js/              ← Dari public/js/
├── favicon.ico      ← Dari public/favicon.ico
├── app/             ← Laravel app folder
├── database/        ← Laravel database folder
├── config/          ← Laravel config folder
└── composer.json    ← Laravel composer file
```

---

## 🛠️ **FIX STEPS:**

### **STEP 1: Pindahkan Files dari Public/**

**Via File Manager cPanel:**

1. **Masuk** ke File Manager
2. **Buka** folder `public/`
3. **Select All** files di dalam folder `public/`:
    - `index.php`
    - `.htaccess`
    - folder `css/`
    - folder `js/`
    - `favicon.ico`
    - dll.
4. **Move** atau **Copy** semua files tersebut ke `public_html/` (root)
5. **Delete** folder `public/` yang kosong

### **STEP 2: Edit index.php Path**

Edit file `index.php` di root, ubah path:

**❌ Before:**

```php
require_once __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
```

**✅ After:**

```php
require_once __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
```

### **STEP 3: Check .htaccess**

Pastikan file `.htaccess` ada di root dengan content:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

### **STEP 4: Set Permissions**

```bash
# Set permissions yang benar
chmod 644 index.php
chmod 644 .htaccess
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
```

---

## 🔍 **ALTERNATIVE SOLUTIONS:**

### **Option 1: Subdomain/Subdirectory Setup**

Jika hosting tidak mengizinkan perubahan document root:

1. **Buat subdomain** (misal: `app.yourdomain.com`)
2. **Point document root** subdomain ke folder `public/`
3. **Laravel files** tetap di folder utama

### **Option 2: Symbolic Link**

```bash
# Buat symlink dari public_html ke public folder
ln -s /path/to/laravel/public /path/to/public_html
```

### **Option 3: Custom Document Root**

**Via cPanel → Subdomains → Document Root:**

-   Set document root ke `public_html/public`

---

## ✅ **VERIFICATION STEPS:**

### **Check File Structure:**

```
public_html/
├── index.php        ✅ Harus ada
├── .htaccess        ✅ Harus ada
├── css/            ✅ Dari public/css/
├── js/             ✅ Dari public/js/
├── app/            ✅ Laravel files
├── bootstrap/      ✅ Laravel files
├── config/         ✅ Laravel files
├── database/       ✅ Laravel files
├── storage/        ✅ Laravel files (permissions 755)
├── vendor/         ✅ Laravel files
├── .env            ✅ Environment config
└── composer.json   ✅ Laravel composer
```

### **Test Access:**

1. **Visit**: `https://absensi.mahabathina.or.id/`
2. **Should show**: Laravel welcome page atau login page
3. **If still error**: Check error logs

---

## 📱 **QUICK FIX COMMANDS:**

**Via Terminal (jika ada):**

```bash
# Pindah ke directory hosting
cd public_html/

# Move public files to root
mv public/* .
mv public/.htaccess .

# Remove empty public folder
rmdir public

# Fix index.php paths
sed -i 's/__DIR__\/\.\.\//__DIR__\//' index.php

# Set permissions
chmod 644 index.php .htaccess
chmod -R 755 storage bootstrap/cache
```

---

## 🎯 **EXPECTED RESULT:**

**✅ After Fix:**

-   Website accessible: `https://absensi.mahabathina.or.id/`
-   Login page loads properly
-   No more 403 Forbidden error
-   Laravel application working

**Default Login:**

-   Admin: admin@system.com / password
-   Teacher: teacher@system.com / password

---

## 🆘 **IF STILL ERROR:**

### **Check Error Logs:**

-   cPanel → Error Logs
-   Look for specific error messages

### **Contact Hosting Support:**

-   Ask them to enable `mod_rewrite`
-   Request PHP version check (need PHP 8.1+)
-   Verify file permissions

### **Alternative Domain Test:**

Test dengan subdomain atau IP langsung untuk isolasi masalah.
