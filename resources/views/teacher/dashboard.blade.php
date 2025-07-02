<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('attendance.daily_attendance') }} - Teacher Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .btn-primary {
            @apply bg-blue-600 text-white px-6 py-3 rounded-lg text-lg font-semibold hover:bg-blue-700 transition-colors;
        }
        .btn-success {
            @apply bg-green-600 text-white px-6 py-3 rounded-lg text-lg font-semibold hover:bg-green-700 transition-colors;
        }
        .btn-danger {
            @apply bg-red-600 text-white px-6 py-3 rounded-lg text-lg font-semibold hover:bg-red-700 transition-colors;
        }
        .btn-disabled {
            @apply bg-gray-400 text-white px-6 py-3 rounded-lg text-lg font-semibold cursor-not-allowed;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="max-w-md mx-auto bg-white min-h-screen">
        <!-- Header -->
        <div class="bg-blue-600 text-white p-4">
            <div class="flex justify-between items-center">
                <h1 class="text-xl font-bold">{{ __('attendance.daily_attendance') }}</h1>
                <div class="flex items-center space-x-2">
                    <span class="text-sm">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm text-white underline hover:text-blue-200 transition-colors">
                            {{ __('attendance.logout') }}
                        </button>
                    </form>
                </div>
            </div>
            <div class="text-sm mt-2">
                {{ now()->format('l, d F Y') }}
            </div>
        </div>

        <!-- Navigation -->
        <div class="flex border-b">
            <button onclick="showTab('attendance')" class="flex-1 py-3 px-4 text-center border-b-2 border-blue-600 text-blue-600 font-semibold" id="attendance-tab">
                {{ __('attendance.attendance') }}
            </button>
            <button onclick="showTab('teaching')" class="flex-1 py-3 px-4 text-center text-gray-600" id="teaching-tab">
                {{ __('attendance.teaching_session') }}
            </button>
            <button onclick="showTab('history')" class="flex-1 py-3 px-4 text-center text-gray-600" id="history-tab">
                {{ __('attendance.attendance_history') }}
            </button>
        </div>

        <!-- Content -->
        <div id="content" class="p-4">
            <!-- Attendance Tab -->
            <div id="attendance-content">
                <div id="holiday-notice" class="hidden bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
                </div>
                
                <div id="location-warning" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ __('attendance.location_warning') }}
                </div>

                <div class="space-y-4">
                    <div class="bg-gray-50 p-4 rounded">
                        <h3 class="font-semibold mb-2">{{ __('attendance.today') }}</h3>
                        <div id="attendance-status">
                            <div class="flex justify-between items-center mb-2">
                                <span>{{ __('attendance.check_in_time') }}:</span>
                                <span id="check-in-time" class="font-mono">--:--</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span>{{ __('attendance.check_out_time') }}:</span>
                                <span id="check-out-time" class="font-mono">--:--</span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <button id="check-in-btn" onclick="checkIn()" class="w-full btn-primary" disabled>
                            {{ __('attendance.check_in') }}
                        </button>
                        <button id="check-out-btn" onclick="checkOut()" class="w-full btn-danger" disabled>
                            {{ __('attendance.check_out') }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Teaching Session Tab -->
            <div id="teaching-content" class="hidden">
                <div id="current-session" class="hidden">
                    <div class="bg-green-50 border border-green-200 p-4 rounded mb-4">
                        <h3 class="font-semibold text-green-800 mb-2">{{ __('attendance.session_active') }}</h3>
                        <div id="session-info" class="text-sm text-green-700">
                        </div>
                        <button onclick="endSession()" class="mt-3 btn-danger">
                            {{ __('attendance.end_teaching') }}
                        </button>
                    </div>
                </div>

                <div id="start-session-form">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-2">{{ __('Subject') }}</label>
                            <select id="subject-select" class="w-full p-3 border rounded">
                                <option value="">{{ __('Select Subject') }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">{{ __('Class') }}</label>
                            <select id="class-select" class="w-full p-3 border rounded">
                                <option value="">{{ __('Select Class') }}</option>
                            </select>
                        </div>
                        <button onclick="startSession()" class="w-full btn-success">
                            {{ __('attendance.start_teaching') }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- History Tab -->
            <div id="history-content" class="hidden">
                <div class="space-y-4">
                    <h3 class="font-semibold">{{ __('attendance.attendance_history') }}</h3>
                    <div id="history-list">
                        <!-- History items will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentLocation = null;
        let activeSessionId = null;

        // Get user location
        function getCurrentLocation() {
            return new Promise((resolve, reject) => {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        position => {
                            resolve({
                                latitude: position.coords.latitude,
                                longitude: position.coords.longitude
                            });
                        },
                        error => reject(error),
                        { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
                    );
                } else {
                    reject(new Error('Geolocation is not supported'));
                }
            });
        }

        // API helper
        async function apiCall(url, method = 'GET', data = null) {
            const options = {
                method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Authorization': `Bearer ${localStorage.getItem('teacher_token')}`
                }
            };
            
            if (data) {
                options.body = JSON.stringify(data);
            }
            
            const response = await fetch(`/api/teacher${url}`, options);
            return response.json();
        }

        // Tab switching
        function showTab(tab) {
            // Hide all content
            document.getElementById('attendance-content').classList.add('hidden');
            document.getElementById('teaching-content').classList.add('hidden');
            document.getElementById('history-content').classList.add('hidden');
            
            // Remove active state from all tabs
            document.getElementById('attendance-tab').classList.remove('border-blue-600', 'text-blue-600', 'font-semibold');
            document.getElementById('teaching-tab').classList.remove('border-blue-600', 'text-blue-600', 'font-semibold');
            document.getElementById('history-tab').classList.remove('border-blue-600', 'text-blue-600', 'font-semibold');
            
            // Show selected content and activate tab
            document.getElementById(`${tab}-content`).classList.remove('hidden');
            const activeTab = document.getElementById(`${tab}-tab`);
            activeTab.classList.add('border-blue-600', 'text-blue-600', 'font-semibold');
            
            // Load content based on tab
            if (tab === 'teaching') {
                loadTeachingOptions();
                checkCurrentSession();
            } else if (tab === 'history') {
                loadHistory();
            }
        }

        // Check in
        async function checkIn() {
            try {
                currentLocation = await getCurrentLocation();
                const result = await apiCall('/attendance/check-in', 'POST', {
                    location: currentLocation
                });
                
                if (result.success) {
                    alert(result.message);
                    loadAttendanceStatus();
                } else {
                    alert(result.message);
                }
                
                if (result.location_validation && !result.location_validation.valid) {
                    document.getElementById('location-warning').classList.remove('hidden');
                }
            } catch (error) {
                alert('Error: ' + error.message);
            }
        }

        // Check out
        async function checkOut() {
            try {
                currentLocation = await getCurrentLocation();
                const result = await apiCall('/attendance/check-out', 'POST', {
                    location: currentLocation
                });
                
                if (result.success) {
                    alert(result.message);
                    loadAttendanceStatus();
                } else {
                    alert(result.message);
                }
                
                if (result.location_validation && !result.location_validation.valid) {
                    document.getElementById('location-warning').classList.remove('hidden');
                }
            } catch (error) {
                alert('Error: ' + error.message);
            }
        }

        // Load attendance status
        async function loadAttendanceStatus() {
            try {
                const result = await apiCall('/attendance/today');
                
                if (result.success) {
                    const attendance = result.attendance;
                    
                    if (attendance) {
                        if (attendance.check_in_time) {
                            document.getElementById('check-in-time').textContent = 
                                new Date(attendance.check_in_time).toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'});
                        }
                        if (attendance.check_out_time) {
                            document.getElementById('check-out-time').textContent = 
                                new Date(attendance.check_out_time).toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'});
                        }
                    }
                    
                    // Update button states
                    const checkInBtn = document.getElementById('check-in-btn');
                    const checkOutBtn = document.getElementById('check-out-btn');
                    
                    checkInBtn.disabled = !result.can_check_in;
                    checkOutBtn.disabled = !result.can_check_out;
                    
                    if (!result.can_check_in) {
                        checkInBtn.className = 'w-full btn-disabled';
                    } else {
                        checkInBtn.className = 'w-full btn-primary';
                    }
                    
                    if (!result.can_check_out) {
                        checkOutBtn.className = 'w-full btn-disabled';
                    } else {
                        checkOutBtn.className = 'w-full btn-danger';
                    }
                    
                    // Show holiday notice
                    if (result.holiday && result.holiday.is_holiday) {
                        const holidayNotice = document.getElementById('holiday-notice');
                        holidayNotice.textContent = result.holiday.message;
                        holidayNotice.classList.remove('hidden');
                    }
                }
            } catch (error) {
                console.error('Error loading attendance status:', error);
            }
        }

        // Start teaching session
        async function startSession() {
            try {
                currentLocation = await getCurrentLocation();
                const subjectId = document.getElementById('subject-select').value;
                const classId = document.getElementById('class-select').value;
                
                if (!subjectId || !classId) {
                    alert('Please select subject and class');
                    return;
                }
                
                const result = await apiCall('/sessions/start', 'POST', {
                    subject_id: subjectId,
                    class_room_id: classId,
                    location: currentLocation
                });
                
                if (result.success) {
                    alert(result.message);
                    checkCurrentSession();
                } else {
                    alert(result.message);
                }
            } catch (error) {
                alert('Error: ' + error.message);
            }
        }

        // End teaching session
        async function endSession() {
            try {
                currentLocation = await getCurrentLocation();
                const result = await apiCall(`/sessions/${activeSessionId}/end`, 'POST', {
                    location: currentLocation
                });
                
                if (result.success) {
                    alert(result.message);
                    checkCurrentSession();
                } else {
                    alert(result.message);
                }
            } catch (error) {
                alert('Error: ' + error.message);
            }
        }

        // Check current session
        async function checkCurrentSession() {
            try {
                const result = await apiCall('/sessions/current');
                
                if (result.success && result.has_active_session) {
                    activeSessionId = result.session.id;
                    document.getElementById('current-session').classList.remove('hidden');
                    document.getElementById('start-session-form').classList.add('hidden');
                    
                    document.getElementById('session-info').innerHTML = `
                        <div><strong>Subject:</strong> ${result.session.subject.name}</div>
                        <div><strong>Class:</strong> ${result.session.class_room.name}</div>
                        <div><strong>Started:</strong> ${new Date(result.session.start_time).toLocaleTimeString('id-ID')}</div>
                    `;
                } else {
                    activeSessionId = null;
                    document.getElementById('current-session').classList.add('hidden');
                    document.getElementById('start-session-form').classList.remove('hidden');
                }
            } catch (error) {
                console.error('Error checking current session:', error);
            }
        }

        // Load teaching options
        async function loadTeachingOptions() {
            try {
                const result = await apiCall('/sessions/options');
                
                if (result.success) {
                    const subjectSelect = document.getElementById('subject-select');
                    const classSelect = document.getElementById('class-select');
                    
                    // Clear existing options
                    subjectSelect.innerHTML = '<option value="">Select Subject</option>';
                    classSelect.innerHTML = '<option value="">Select Class</option>';
                    
                    // Add subjects
                    result.subjects.forEach(subject => {
                        const option = document.createElement('option');
                        option.value = subject.id;
                        option.textContent = subject.name;
                        subjectSelect.appendChild(option);
                    });
                    
                    // Add classes
                    result.class_rooms.forEach(classRoom => {
                        const option = document.createElement('option');
                        option.value = classRoom.id;
                        option.textContent = classRoom.name;
                        classSelect.appendChild(option);
                    });
                }
            } catch (error) {
                console.error('Error loading teaching options:', error);
            }
        }

        // Load history
        async function loadHistory() {
            try {
                const result = await apiCall('/attendance/history');
                
                if (result.success) {
                    const historyList = document.getElementById('history-list');
                    historyList.innerHTML = '';
                    
                    if (result.attendances.data.length === 0) {
                        historyList.innerHTML = '<p class="text-gray-500">{{ __("attendance.no_records") }}</p>';
                        return;
                    }
                    
                    result.attendances.data.forEach(attendance => {
                        const item = document.createElement('div');
                        item.className = 'border rounded p-3 mb-2';
                        
                        const checkInTime = attendance.check_in_time ? 
                            new Date(attendance.check_in_time).toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'}) : '--:--';
                        const checkOutTime = attendance.check_out_time ? 
                            new Date(attendance.check_out_time).toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'}) : '--:--';
                        
                        item.innerHTML = `
                            <div class="flex justify-between items-center">
                                <div>
                                    <div class="font-semibold">${new Date(attendance.date).toLocaleDateString('id-ID')}</div>
                                    <div class="text-sm text-gray-600">${checkInTime} - ${checkOutTime}</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-xs ${attendance.check_in_location_valid ? 'text-green-600' : 'text-red-600'}">
                                        ${attendance.check_in_location_valid ? '✓' : '✗'} In
                                    </div>
                                    <div class="text-xs ${attendance.check_out_location_valid ? 'text-green-600' : 'text-red-600'}">
                                        ${attendance.check_out_location_valid ? '✓' : '✗'} Out
                                    </div>
                                </div>
                            </div>
                        `;
                        
                        historyList.appendChild(item);
                    });
                }
            } catch (error) {
                console.error('Error loading history:', error);
            }
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            loadAttendanceStatus();
        });
    </script>
</body>
</html> 