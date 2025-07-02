# 🚨 MISSING INDEX.PHP - URGENT FIX

## ❌ **MASALAH:** File `index.php` tidak ada di hosting!

**Root cause:** Upload tidak lengkap atau folder `public/` terlewat.

---

## 🔍 **DIAGNOSIS:**

### **File yang HARUS ada di hosting:**

```
public_html/
├── index.php        ❌ MISSING! (harus dari public/index.php)
├── .htaccess        ❓ Check juga
├── app/             ✅ Folder Laravel app
├── bootstrap/       ✅ Folder Laravel bootstrap
├── config/          ✅ Folder Laravel config
├── database/        ✅ Folder Laravel database
├── storage/         ✅ Folder Laravel storage
├── vendor/          ❓ Composer dependencies
├── .env             ❓ Environment file
└── composer.json    ✅ Composer config
```

---

## 🚀 **SOLUSI CEPAT:**

### **Option 1: Re-Upload Folder Public/ (RECOMMENDED)**

#### **Step 1: Download/Siapkan Files Lokal**

```bash
# Dari repository GitHub atau lokal project
# Pastikan folder public/ ada dengan isi:
public/
├── index.php        ← CRITICAL FILE!
├── .htaccess        ← CRITICAL FILE!
├── favicon.ico
├── css/
├── js/
├── icons/           ← PWA icons
├── manifest.json    ← PWA manifest
└── sw.js           ← Service worker
```

#### **Step 2: Upload Manual via cPanel**

1. **Login** ke cPanel File Manager
2. **Upload** folder `public/` ke hosting
3. **Extract** jika dalam ZIP
4. **Copy** semua isi folder `public/` ke `public_html/` (root)
5. **Delete** folder `public/` yang kosong

### **Option 2: Buat File index.php Manual**

**Jika tidak bisa upload ulang, buat file `index.php` manual:**

#### **File: `public_html/index.php`**

```php
<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Check If The Application Is Under Maintenance
|--------------------------------------------------------------------------
|
| If the application is in maintenance / demo mode via the "down" command
| we will load this file so that any pre-rendered content can be shown
| instead of starting the framework, which could cause an exception.
|
*/

if (file_exists($maintenance = __DIR__.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| this application. We just need to utilize it! We'll simply require it
| into the script here so we don't need to manually load our classes.
|
*/

require __DIR__.'/vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request using
| the application's HTTP kernel. Then, we will send the response back
| to this client's browser, allowing them to enjoy our application.
|
*/

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
```

#### **File: `public_html/.htaccess`**

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

---

## 🔄 **Option 3: Complete Re-Upload**

### **Fresh Upload Steps:**

#### **Step 1: Prepare Complete Package**

```bash
# Download fresh dari GitHub
git clone https://github.com/mawdd/abs.git
cd abs

# Atau buat ZIP lengkap
tar -czf abs-complete.tar.gz \
  --exclude=.git \
  --exclude=node_modules \
  --exclude=storage/framework/cache/* \
  --exclude=storage/framework/sessions/* \
  --exclude=storage/framework/views/* \
  --exclude=storage/logs/* \
  .
```

#### **Step 2: Upload & Extract**

1. **Upload** `abs-complete.tar.gz` ke hosting
2. **Extract** di `public_html/`
3. **Move** isi folder `public/` ke root
4. **Delete** folder `public/` kosong

#### **Step 3: Verify Critical Files**

**Check these files exist in `public_html/`:**

-   ✅ `index.php` (from public/)
-   ✅ `.htaccess` (from public/)
-   ✅ `app/` folder
-   ✅ `bootstrap/` folder
-   ✅ `vendor/` folder (or install with composer)
-   ✅ `.env` file (copy from .env.example)

---

## 🎯 **VERIFICATION:**

### **Test 1: Check Files**

**Via cPanel File Manager, pastikan ada:**

```
public_html/
├── index.php        ✅ Size ~2KB
├── .htaccess        ✅ Size ~1KB
├── app/
├── bootstrap/
├── config/
├── database/
├── storage/
├── vendor/          (or run composer install)
└── .env             (copy from .env.example)
```

### **Test 2: Website Access**

1. **Visit:** `https://absensi.mahabathina.or.id/`
2. **Expect:** Laravel page atau error 500 (better than 403!)
3. **If 500:** Check `.env` dan database connection

---

## 🆘 **QUICK DIAGNOSIS:**

### **Check Upload Status:**

**Via File Manager, verify:**

-   [ ] `index.php` exists in root ✅ **CRITICAL**
-   [ ] `.htaccess` exists in root ✅ **CRITICAL**
-   [ ] `app/` folder exists ✅
-   [ ] `vendor/` folder exists (or install composer)
-   [ ] `.env` file exists and configured

### **File Sizes Reference:**

-   `index.php` ≈ 2KB
-   `.htaccess` ≈ 1KB
-   `app/` folder ≈ 1-2MB
-   `vendor/` folder ≈ 50-100MB (after composer install)

---

## 📱 **AFTER FIX:**

**Expected Result:**

-   ✅ No more 403 Forbidden
-   ✅ Website loads (maybe error 500, which is progress!)
-   ✅ Ready for database configuration

**Next Steps:**

1. Configure `.env` file
2. Run `composer install`
3. Run `php artisan migrate`
4. Test login functionality

---

**🚨 PRIORITY: Upload atau buat file `index.php` DULU!**  
**Tanpa `index.php`, Laravel tidak akan pernah jalan!**
