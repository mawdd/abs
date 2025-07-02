# ⚡ Quick Deploy Checklist

## 🚀 **HOSTING DEPLOYMENT - CHECKLIST**

### **📥 1. PERSIAPAN (5 menit)**

-   [ ] Download/clone repository dari GitHub
-   [ ] Zip files (exclude: node_modules, .git, storage cache)
-   [ ] Siapkan akses hosting (cPanel/FTP)

### **🗄️ 2. DATABASE SETUP (5 menit)**

-   [ ] Buat database MySQL di hosting
-   [ ] Catat: Host, Database, Username, Password
-   [ ] Test koneksi database

### **📤 3. UPLOAD FILES (10 menit)**

-   [ ] Upload & extract files ke public_html/
-   [ ] Move isi folder public/ ke root directory
-   [ ] Set permissions: storage/ (775), .env (644)

### **⚙️ 4. CONFIGURATION (5 menit)**

-   [ ] Copy .env.example → .env
-   [ ] Edit .env dengan data database hosting
-   [ ] Set APP_ENV=production, APP_DEBUG=false

### **🛠️ 5. INSTALL & MIGRATE (10 menit)**

-   [ ] Run: `composer install --no-dev --optimize-autoloader`
-   [ ] Run: `php artisan key:generate`
-   [ ] Run: `php artisan migrate` ✅ **No MySQL errors!**
-   [ ] Run: `php artisan db:seed`

### **🎯 6. FINAL OPTIMIZATION (3 menit)**

-   [ ] Run: `php artisan config:cache`
-   [ ] Run: `php artisan route:cache`
-   [ ] Run: `php artisan storage:link`

### **✅ 7. TESTING (2 menit)**

-   [ ] Visit homepage - should load ✅
-   [ ] Login admin: admin@system.com / password
-   [ ] Test GPS location (allow browser location)
-   [ ] Check PWA install prompt

---

## 🆘 **JIKA ERROR:**

### **Error 500:**

```bash
chmod -R 775 storage/
php artisan config:clear
```

### **Database Error:**

-   Check .env database settings
-   Verify user permissions di hosting

### **Migration Error 1071:**

**SUDAH FIXED!** ✅ Tidak akan terjadi lagi

---

## ⏱️ **TOTAL TIME: ~40 MENIT**

**🎉 RESULT:** Fully functional Teacher Attendance System!

**Default Login:**

-   Admin: admin@system.com / password
-   Teacher: teacher@system.com / password
