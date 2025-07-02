# MySQL Index Length Fix for Hosting

## Problem

When deploying to shared hosting, MySQL migration fails with error:

```
SQLSTATE[42000]: Syntax error or access violation: 1071 Specified key was too long; max key length is 1000 bytes
```

## Root Cause

-   MySQL using `utf8mb4` charset (4 bytes per character)
-   Default VARCHAR(255) = 255 × 4 = 1020 bytes > 1000 bytes limit
-   Affects columns: `users.email`, `password_reset_tokens.email`, `sessions.id`

## Solution Applied

### 1. Updated Migration Files

Changed string column lengths in migration:

```php
// Before
$table->string('email')->unique();
$table->string('id')->primary();

// After
$table->string('email', 191)->unique();  // 191 × 4 = 764 bytes ✓
$table->string('id', 191)->primary();    // 191 × 4 = 764 bytes ✓
```

### 2. AppServiceProvider Global Fix

Added in `app/Providers/AppServiceProvider.php`:

```php
use Illuminate\Support\Facades\Schema;

public function boot(): void
{
    // Fix for MySQL index length limit on older versions/shared hosting
    Schema::defaultStringLength(191);

    // ... other code
}
```

## Files Modified

-   ✅ `database/migrations/0001_01_01_000000_create_users_table.php`
-   ✅ `database/migrations/0001_01_01_000001_create_cache_table.php`
-   ✅ `database/migrations/0001_01_01_000002_create_jobs_table.php`
-   ✅ `database/migrations/2025_05_18_060809_create_device_registrations_table.php`
-   ✅ `database/migrations/2025_05_18_100000_create_students_table.php`
-   ✅ `database/migrations/2025_05_18_100004_create_system_settings_table.php`
-   ✅ `app/Providers/AppServiceProvider.php`

## Deployment Steps

1. Upload all files to hosting
2. Run migration: `php artisan migrate`
3. Should work without index length errors

## Notes

-   191 characters is sufficient for email addresses (RFC standard max ~320 chars)
-   This fix ensures compatibility with all MySQL versions and hosting providers
-   No data loss - only affects maximum allowed length
