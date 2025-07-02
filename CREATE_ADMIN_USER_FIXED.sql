-- SQL untuk membuat admin user (VERSI BARU DENGAN HASH YANG BENAR)

-- Hapus user admin lama jika ada
DELETE FROM users WHERE email = 'admin@attendance.com';

-- Buat admin user baru dengan password hash yang fresh
INSERT INTO users (name, email, password, role, is_active, phone_number, created_at, updated_at) 
VALUES (
    'System Administrator',
    'admin@attendance.com',
    '$2y$12$.JAJjhUd4JAPTB/fLypN2.FuJHkQs0bUnBR5xFFw6ukPF1t6r9rSW',
    'admin',
    1,
    '+62812345678901',
    NOW(),
    NOW()
);

-- Alternatif dengan password "admin" (lebih sederhana)
-- INSERT INTO users (name, email, password, role, is_active, phone_number, created_at, updated_at) 
-- VALUES (
--     'System Administrator',
--     'admin@attendance.com',
--     '$2y$12$zru.yw9VWcR21hyjBJTK..Eo5reb.L..zj7PajqCMa2OZzkWoAFAq',
--     'admin',
--     1,
--     '+62812345678901',
--     NOW(),
--     NOW()
-- );

-- Hapus lokasi lama jika ada
DELETE FROM attendance_locations WHERE name = 'Sekolah Utama';

-- Buat lokasi sekolah dengan koordinat yang sudah kamu berikan
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

-- Cek hasil
SELECT 'USER CREATED:' as info, id, name, email, role FROM users WHERE email = 'admin@attendance.com';
SELECT 'LOCATION CREATED:' as info, id, name, latitude, longitude, radius_meters FROM attendance_locations WHERE name = 'Sekolah Utama'; 