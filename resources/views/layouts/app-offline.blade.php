<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Teacher Attendance System')</title>
    
    <!-- Offline CSS - No CDN needed -->
    <style>
        /* Reset & Base */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            background-color: #f5f5f5;
            color: #333;
        }
        
        /* Layout */
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        .card { background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 20px; margin: 20px 0; }
        
        /* Typography */
        h1 { font-size: 2rem; font-weight: bold; margin-bottom: 1rem; }
        h2 { font-size: 1.5rem; font-weight: bold; margin-bottom: 0.75rem; }
        h3 { font-size: 1.25rem; font-weight: bold; margin-bottom: 0.5rem; }
        
        /* Buttons */
        .btn {
            display: inline-block;
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            cursor: pointer;
            font-weight: 500;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .btn-primary { background: #3B82F6; color: white; }
        .btn-primary:hover { background: #2563EB; }
        
        .btn-success { background: #10B981; color: white; }
        .btn-success:hover { background: #059669; }
        
        .btn-danger { background: #EF4444; color: white; }
        .btn-danger:hover { background: #DC2626; }
        
        .btn-disabled { background: #9CA3AF; color: white; cursor: not-allowed; }
        
        .btn-full { width: 100%; margin: 10px 0; }
        
        /* Forms */
        .form-group { margin-bottom: 1rem; }
        .form-label { display: block; margin-bottom: 0.5rem; font-weight: 500; }
        .form-input {
            width: 100%;
            padding: 12px;
            border: 1px solid #D1D5DB;
            border-radius: 6px;
            font-size: 1rem;
        }
        .form-input:focus {
            outline: none;
            border-color: #3B82F6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .form-select {
            width: 100%;
            padding: 12px;
            border: 1px solid #D1D5DB;
            border-radius: 6px;
            background: white;
        }
        
        /* Alerts */
        .alert {
            padding: 12px 16px;
            border-radius: 6px;
            margin: 1rem 0;
        }
        .alert-success { background: #D1FAE5; color: #065F46; border: 1px solid #A7F3D0; }
        .alert-error { background: #FEE2E2; color: #991B1B; border: 1px solid #FECACA; }
        .alert-warning { background: #FEF3C7; color: #92400E; border: 1px solid #FDE68A; }
        .alert-info { background: #DBEAFE; color: #1E40AF; border: 1px solid #93C5FD; }
        
        /* Header */
        .header {
            background: #1E40AF;
            color: white;
            padding: 1rem 0;
            margin-bottom: 2rem;
        }
        
        .header h1 { color: white; margin: 0; }
        .header .user-info { float: right; }
        .header .logout { color: #93C5FD; text-decoration: underline; }
        
        /* Navigation */
        .nav-tabs {
            display: flex;
            border-bottom: 2px solid #E5E7EB;
            margin-bottom: 2rem;
        }
        
        .nav-tab {
            flex: 1;
            padding: 1rem;
            text-align: center;
            border: none;
            background: none;
            cursor: pointer;
            border-bottom: 2px solid transparent;
        }
        
        .nav-tab.active {
            border-bottom-color: #3B82F6;
            color: #3B82F6;
            font-weight: 600;
        }
        
        /* Utilities */
        .hidden { display: none !important; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-small { font-size: 0.875rem; }
        .text-bold { font-weight: bold; }
        
        .mt-1 { margin-top: 0.25rem; }
        .mt-2 { margin-top: 0.5rem; }
        .mt-4 { margin-top: 1rem; }
        .mb-2 { margin-bottom: 0.5rem; }
        .mb-4 { margin-bottom: 1rem; }
        
        .p-2 { padding: 0.5rem; }
        .p-4 { padding: 1rem; }
        
        .bg-gray { background-color: #F3F4F6; }
        .bg-blue { background-color: #EBF8FF; }
        .bg-green { background-color: #F0FDF4; }
        .bg-red { background-color: #FEF2F2; }
        
        .border { border: 1px solid #E5E7EB; }
        .rounded { border-radius: 0.375rem; }
        
        .space-y > * + * { margin-top: 1rem; }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .container { padding: 0 10px; }
            .card { margin: 10px 0; padding: 15px; }
            h1 { font-size: 1.5rem; }
            .header .user-info { float: none; margin-top: 10px; }
        }
        
        /* Loading States */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid #3B82F6;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
    
    @yield('styles')
</head>
<body>
    @yield('content')
    
    @yield('scripts')
</body>
</html> 