const CACHE_NAME = 'demakijo1-v4';
const ASSETS_TO_CACHE = [
  '/offline',
  '/manifest.json',
  '/logo-192.png',
  '/logo-512.png',
  'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap',
  'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css',
  'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css',
  'https://unpkg.com/aos@2.3.1/dist/aos.css',
  'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js',
  'https://unpkg.com/aos@2.3.1/dist/aos.js'
];

// Install Event - Pre-cache offline page & assets
self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME).then(cache => {
      return cache.addAll(ASSETS_TO_CACHE);
    })
  );
  self.skipWaiting();
});

// Activate Event - Clean up old caches immediately
self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(keys => {
      return Promise.all(
        keys.map(key => {
          if (key !== CACHE_NAME) {
            return caches.delete(key);
          }
        })
      );
    })
  );
  self.clients.claim();
});

// Fetch Event - Dynamic and Static Caching Strategy
self.addEventListener('fetch', event => {
  // Only handle GET requests
  if (event.request.method !== 'GET') return;

  const url = new URL(event.request.url);
  const isHtml = event.request.mode === 'navigate' || 
                 (event.request.headers.get('accept') && event.request.headers.get('accept').includes('text/html'));

  // 1. STRATEGI UNTUK HALAMAN WEB (HTML/NAVIGASI/ADMIN/DASHBOARD) -> Network Only / Network First
  // Kita TIDAK BOLEH meng-cache HTML sama sekali agar data database & layout selalu riil.
  if (isHtml) {
    event.respondWith(
      fetch(event.request)
        .then(networkResponse => {
          return networkResponse;
        })
        .catch(() => {
          // Jika network gagal (offline), tampilkan halaman fallback offline yang sudah di-cache
          return caches.match('/offline');
        })
    );
    return;
  }

  // 2. STRATEGI UNTUK ASET STATIS (CSS, JS, Fonts, Images) -> Cache First
  event.respondWith(
    caches.match(event.request).then(cachedResponse => {
      if (cachedResponse) {
        return cachedResponse;
      }
      return fetch(event.request).then(networkResponse => {
        // Hanya cache respon sukses dari origin yang sama
        if (networkResponse.status === 200 && url.origin === self.location.origin) {
          const responseClone = networkResponse.clone();
          caches.open(CACHE_NAME).then(cache => {
            cache.put(event.request, responseClone);
          });
        }
        return networkResponse;
      }).catch(() => {
        // Fallback jika asset gagal load offline (misal image placeholder, dll)
        return new Response('Asset not available offline', { status: 404, statusText: 'Offline' });
      });
    })
  );
});
