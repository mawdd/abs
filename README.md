# Teacher Attendance Management System

A comprehensive web-based attendance system designed to prevent attendance fraud (jockeying) and provide accurate records for daily teacher attendance and student attendance during teaching sessions.

## Key Features

### Anti-Jockeying (Fraud Prevention) Features

-   **GPS Location Validation**: Automatic validation of teacher location against configured school coordinates
-   **Device Registration**: Automatic device linking to prevent attendance from unauthorized devices
-   **Holiday Integration**: Automatic holiday validation to exclude non-working days

### For Teachers (Mobile Web Interface)

-   **Daily Attendance**: Simple check-in/check-out with GPS validation
-   **Teaching Session Management**: Start/end teaching sessions with student attendance tracking
-   **Personal History**: View attendance and teaching session history
-   **Multi-language Support**: Indonesian and English interface

### For Administrators (FilamentPHP Panel)

-   **Teacher Management**: CRUD operations for teachers with device management
-   **Student Management**: Complete student information management
-   **Attendance Monitoring**: Real-time attendance tracking with location validation
-   **Reports & Analytics**: Comprehensive reporting with export capabilities
-   **System Configuration**: GPS locations, holidays, and system settings

## Technology Stack

-   **Backend**: Laravel 12 (PHP 8.2+)
-   **Admin Panel**: FilamentPHP 3.3
-   **Database**: MySQL
-   **Authentication**: Laravel Sanctum
-   **Frontend**: Blade templates with Tailwind CSS
-   **GPS**: Browser Geolocation API

## Installation Instructions

### 1. System Requirements

-   PHP 8.2 or higher
-   Composer
-   MySQL 8.0 or higher
-   Node.js & npm (for frontend assets)

### 2. Installation Steps

```bash
# Clone the repository
git clone <repository-url>
cd attendance-management-system

# Install PHP dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure database in .env file
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=attendance_system
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Run migrations
php artisan migrate

# Run seeders to create initial data
php artisan db:seed

# Install and build frontend assets (if needed)
npm install
npm run build

# Start the development server
php artisan serve
```

### 3. Initial Setup

After installation, the system will be pre-configured with:

**Admin Access:**

-   URL: `http://localhost:8000/admin`
-   Email: `admin@attendance.com`
-   Password: `password123`

**Sample Teacher Access:**

-   URL: `http://localhost:8000/teacher/login`
-   Email: `ahmad.fauzi@school.com` (or any teacher from seeders)
-   Password: `teacher123`

### 4. GPS Location Configuration

⚠️ **IMPORTANT**: Update the GPS coordinates for your school location:

1. Login to admin panel
2. Navigate to **System Settings > Attendance Locations**
3. Edit the "Main School Building" location
4. Update latitude and longitude with your actual school coordinates
5. Adjust the radius as needed (default: 100 meters)

### 5. System Settings Configuration

Configure the following settings in **System Settings**:

-   **Default Language**: Set to `id` (Indonesian) or `en` (English)
-   **School Name**: Update with your school's name
-   **Location Tolerance**: Adjust GPS tolerance radius
-   **Holiday Validation**: Enable/disable holiday checking

## Usage Guide

### For Teachers

1. **Access the System**:

    - Visit `http://yoursite.com/teacher/login`
    - Login with provided credentials

2. **Daily Attendance**:

    - Allow location access when prompted
    - Click "Check In" when arriving at school
    - Click "Check Out" when leaving school
    - System validates GPS location automatically

3. **Teaching Sessions**:

    - Start a teaching session by selecting subject and class
    - Mark student attendance during the session
    - End the session when completed

4. **View History**:
    - Check personal attendance history
    - Review teaching session records

### For Administrators

1. **Access Admin Panel**:

    - Visit `http://yoursite.com/admin`
    - Login with admin credentials

2. **Teacher Management**:

    - Add/edit teacher information
    - Reset teacher passwords
    - Manage device registrations

3. **Attendance Monitoring**:

    - View real-time attendance data
    - Monitor location validation status
    - Generate reports

4. **System Configuration**:
    - Configure GPS locations
    - Manage holidays
    - Update system settings

## API Endpoints

The system provides RESTful API endpoints for mobile app integration:

### Authentication

```
POST /api/teacher/login
GET  /api/teacher/profile
POST /api/teacher/logout
```

### Daily Attendance

```
GET  /api/teacher/attendance/today
POST /api/teacher/attendance/check-in
POST /api/teacher/attendance/check-out
GET  /api/teacher/attendance/history
```

### Teaching Sessions

```
GET  /api/teacher/sessions/current
POST /api/teacher/sessions/start
POST /api/teacher/sessions/{id}/end
GET  /api/teacher/sessions/{id}/students
POST /api/teacher/sessions/{id}/attendance
```

## Security Features

### Anti-Fraud Mechanisms

1. **Device Registration**:

    - Automatic device fingerprinting using browser characteristics
    - One device per teacher policy
    - Admin can reset device registrations

2. **GPS Validation**:

    - Real-time location verification
    - Configurable tolerance radius
    - Invalid location warnings and logging

3. **Holiday Integration**:
    - Automatic holiday checking
    - Prevents unnecessary attendance on holidays
    - Configurable holiday calendar

### Data Protection

-   Secure password hashing
-   API token authentication
-   Input validation and sanitization
-   SQL injection prevention
-   XSS protection

## Database Schema

### Core Tables

-   `users` - Teacher and admin accounts
-   `attendances` - Daily attendance records
-   `teaching_sessions` - Teaching session records
-   `student_attendances` - Student attendance within sessions
-   `students` - Student information
-   `class_rooms` - Classroom data
-   `subjects` - Subject information
-   `holidays` - Holiday calendar
-   `attendance_locations` - GPS validation points
-   `device_registrations` - Device management
-   `system_settings` - Configuration settings

## Troubleshooting

### Common Issues

1. **GPS Not Working**:

    - Ensure HTTPS is enabled (required for geolocation)
    - Check browser permissions for location access
    - Verify GPS coordinates are correctly configured

2. **Device Registration Issues**:

    - Clear browser cache and cookies
    - Admin can reset device registration in admin panel
    - Check if teacher has multiple devices registered

3. **Location Validation Failing**:
    - Verify school GPS coordinates are accurate
    - Adjust tolerance radius if needed
    - Check if teacher is within the configured area

### Performance Optimization

-   Enable database indexing on frequently queried columns
-   Use Laravel caching for system settings
-   Optimize GPS calculation queries
-   Regular database maintenance

## Customization

### Adding New Languages

1. Create language files in `lang/{locale}/attendance.php`
2. Update system settings to include new language
3. Modify frontend templates to support new language

### Custom Reports

1. Create new Filament resources for custom reports
2. Use Laravel Excel for export functionality
3. Implement custom widgets for dashboard analytics

### Integration with Other Systems

-   Use provided API endpoints for mobile app integration
-   Implement webhooks for external system notifications
-   Export data using Laravel Excel or custom formats

## Support

For technical support or feature requests, please:

1. Check the troubleshooting section
2. Review the documentation
3. Contact system administrator

## License

This project is proprietary software. All rights reserved.

---

**Note**: This system is designed specifically for educational institutions to ensure accurate attendance tracking and prevent fraud. Please ensure compliance with local data protection regulations when implementing.
