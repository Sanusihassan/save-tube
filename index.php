<?php 
error_reporting(0);
$path = __DIR__ . '/visitors.txt';
$ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
$data = file_get_contents($path) . $ip . ',';
file_put_contents($path, $data);

?><!DOCTYPE html><html lang=en><head><meta charset=utf-8><meta http-equiv=X-UA-Compatible content="IE=edge"><meta name=viewport content="width=device-width,initial-scale=1,user-scalable=no"><meta name=description content="SaveTube - download youtube videos on your device easily and for free"><meta name=google content=notranslate><link rel=icon href=img/favicon.png><link rel=stylesheet href=https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css integrity="sha256-+N4/V/SbAFiW1MPBCXnfnP9QSN3+Keu+NlB+0ev/YKQ=" crossorigin=anonymous><link rel=stylesheet href="https://fonts.googleapis.com/css?family=Maven+Pro|Montserrat|Public+Sans&display=swap"><link rel=apple-touch-icon href=img/icon-512x512.png><meta name=apple-mobile-web-app-status-bar content=#16a085><title>SaveTube</title><link rel=manifest href=/manifest.json><link href=/css/app.css rel=stylesheet></head><body><noscript><strong>We're sorry but SaveTube.com doesn't work properly without JavaScript enabled. Please enable it to continue.</strong></noscript><div id=app></div><script>if(window.navigator.serviceWorker) {
      window.navigator.serviceWorker.register("./sw.js");
    }</script><script src=js/app.js></script></body></html>