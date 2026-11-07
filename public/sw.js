const CACHE = 'club-v1';
const PRIVATE = ['/account', '/enter', '/logout', '/book'];
const PRECACHE = ['/offline.html', '/css/club.css', '/js/club.js', '/icons/icon-192.png'];

self.addEventListener('install', e => {
  e.waitUntil(caches.open(CACHE).then(c => c.addAll(PRECACHE)).then(() => self.skipWaiting()));
});

self.addEventListener('activate', e => {
  e.waitUntil(
    caches.keys().then(keys => Promise.all(keys.filter(k => k !== CACHE).map(k => caches.delete(k))))
      .then(() => self.clients.claim())
  );
});

self.addEventListener('fetch', e => {
  const req = e.request;
  if (req.method !== 'GET' || new URL(req.url).origin !== location.origin) return;

  // Личные страницы и форма брони не сохраняем на устройстве
  if (PRIVATE.some(p => new URL(req.url).pathname.startsWith(p))) {
    e.respondWith(fetch(req).catch(() => caches.match('/offline.html')));
    return;
  }

  // Страницы: сначала сеть, при отсутствии интернета — кэш или offline.html
  if (req.mode === 'navigate') {
    e.respondWith(
      fetch(req).then(res => {
        const copy = res.clone();
        caches.open(CACHE).then(c => c.put(req, copy));
        return res;
      }).catch(() => caches.match(req).then(r => r || caches.match('/offline.html')))
    );
    return;
  }

  // Статика: из кэша, обновляем в фоне
  e.respondWith(
    caches.match(req).then(cached => {
      const net = fetch(req).then(res => {
        const copy = res.clone();
        caches.open(CACHE).then(c => c.put(req, copy));
        return res;
      }).catch(() => cached);
      return cached || net;
    })
  );
});
