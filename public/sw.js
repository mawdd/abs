const CACHE_NAME = "absensi-guru-v1.0";
const urlsToCache = [
    "/",
    "/teacher/attendance",
    "/teacher/attendance/history",
    "/css/app.css",
    "/js/app.js",
    "https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css",
    "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css",
];

// Install event
self.addEventListener("install", (event) => {
    console.log("Service Worker: Install");
    event.waitUntil(
        caches
            .open(CACHE_NAME)
            .then((cache) => {
                console.log("Service Worker: Caching files");
                return cache.addAll(urlsToCache);
            })
            .then(() => self.skipWaiting())
    );
});

// Activate event
self.addEventListener("activate", (event) => {
    console.log("Service Worker: Activate");
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cache) => {
                    if (cache !== CACHE_NAME) {
                        console.log("Service Worker: Clearing old cache");
                        return caches.delete(cache);
                    }
                })
            );
        })
    );
});

// Fetch event
self.addEventListener("fetch", (event) => {
    console.log("Service Worker: Fetching");

    // Skip cross-origin requests
    if (!event.request.url.startsWith(self.location.origin)) {
        return;
    }

    event.respondWith(
        fetch(event.request)
            .then((response) => {
                // Make sure we have a valid response
                if (
                    !response ||
                    response.status !== 200 ||
                    response.type !== "basic"
                ) {
                    return response;
                }

                // Clone the response
                const responseToCache = response.clone();

                caches.open(CACHE_NAME).then((cache) => {
                    cache.put(event.request, responseToCache);
                });

                return response;
            })
            .catch(() => {
                // If online fetch fails, try to get it from cache
                return caches.match(event.request).then((response) => {
                    if (response) {
                        return response;
                    }

                    // For attendance pages, return a basic offline page
                    if (event.request.url.includes("/teacher/attendance")) {
                        return new Response(
                            `
                <!DOCTYPE html>
                <html>
                <head>
                  <title>Offline - Sistem Absensi</title>
                  <meta name="viewport" content="width=device-width, initial-scale=1">
                  <style>
                    body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
                    .offline { color: #dc2626; }
                  </style>
                </head>
                <body>
                  <h1 class="offline">📱 Mode Offline</h1>
                  <p>Koneksi internet tidak tersedia.</p>
                  <p>Pastikan Anda terhubung ke internet untuk menggunakan sistem absensi.</p>
                  <button onclick="window.location.reload()">Coba Lagi</button>
                </body>
                </html>
              `,
                            {
                                headers: { "Content-Type": "text/html" },
                            }
                        );
                    }

                    return new Response(
                        "Offline - No cached version available",
                        {
                            status: 404,
                            headers: { "Content-Type": "text/plain" },
                        }
                    );
                });
            })
    );
});

// Background sync for attendance data
self.addEventListener("sync", (event) => {
    if (event.tag === "attendance-sync") {
        console.log("Service Worker: Background sync for attendance");
        event.waitUntil(syncAttendanceData());
    }
});

// Function to sync attendance data when back online
async function syncAttendanceData() {
    try {
        // This would sync any pending attendance data stored locally
        console.log("Syncing attendance data...");
        // Implementation would depend on your offline storage strategy
    } catch (error) {
        console.error("Error syncing attendance data:", error);
    }
}

// Push notification support
self.addEventListener("push", (event) => {
    const options = {
        body: event.data
            ? event.data.text()
            : "Reminder: Jangan lupa check-in hari ini!",
        icon: "/icons/icon-192x192.png",
        badge: "/icons/icon-72x72.png",
        vibrate: [100, 50, 100],
        data: {
            dateOfArrival: Date.now(),
            primaryKey: 1,
        },
    };

    event.waitUntil(
        self.registration.showNotification("Sistem Absensi Guru", options)
    );
});

// Handle notification clicks
self.addEventListener("notificationclick", (event) => {
    event.notification.close();

    event.waitUntil(clients.openWindow("/teacher/attendance"));
});
