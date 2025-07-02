-- SQL untuk membuat admin user
INSERT INTO users (name, email, password, role, is_active, phone_number, created_at, updated_at) 
VALUES (
    'System Administrator',
    'admin@attendance.com',
    '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', -- password123
    'admin',
    1,
    '+62812345678901',
    NOW(),
    NOW()
);

-- SQL untuk membuat lokasi sekolah dengan koordinat yang sudah kamu berikan
INSERT INTO attendance_locations (name, latitude, longitude, radius_meters, is_active, is_primary, description, created_at, updated_at)
VALUES (
    'Sekolah Utama',
    -6.562994582429248,
    110.86059242639898,
    500,
    1,
    1,
    'Lokasi sekolah utama untuk absensi guru',
    NOW(),
    NOW()
);

-- Atau kalau mau password yang lebih sederhana (password123):
-- UPDATE users SET password = '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' WHERE email = 'admin@attendance.com'; 