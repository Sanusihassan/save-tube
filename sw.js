const staticCache = "static-cache-v2";
const assets = [
    "/",
    "https://fonts.googleapis.com/icon?family=Material+Icons",
    "https://fonts.gstatic.com/s/materialicons/v50/flUhRq6tzZclQEJ-Vdg-IuiaDsNc.woff2",
    "https://fonts.googleapis.com/css?family=Maven+Pro|Montserrat|Public+Sans&display=swap",
    "/manifest.json",
    "/css/app.css",
    "/img/icon-512x512.png",
    "/img/icon-192x192.png",
    "/img/logo.png",
    "/js/app.js"
];
caches.delete("static-cache-v1");
this.addEventListener("install", (evt) => {
    this.skipWaiting();
    evt.waitUntil(
        caches.open(staticCache).then(cache => {
            cache.addAll(assets);
        })
    )
});
this.addEventListener("fetch", (evt) => {
    evt.respondWith(
        caches.match(evt.request).then(casheRes => {
            return casheRes || fetch(evt.request)
        })
    )
});
this.addEventListener("beforeinstallprompt", (evt) => {
    evt.prompt();
});


