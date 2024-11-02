<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Cek Jika Aplikasi Sedang Dalam Mode Pemeliharaan
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Daftarkan Auto Loader
require __DIR__.'/../vendor/autoload.php';

// Jalankan Aplikasi
$app = require_once __DIR__.'/../bootstrap/app.php';

// Tangani permintaan yang masuk dan kirim respons kembali
try {
    $kernel = $app->make(Kernel::class);
    $request = Request::capture();
    $response = $kernel->handle($request);
    
    // Kirim respons ke browser
    $response->send();
    
    // Akhiri aplikasi dan lakukan pembersihan
    $kernel->terminate($request, $response);
} catch (Exception $e) {
    // Tangani pengecualian dan tampilkan pesan kesalahan
    // Anda dapat mencatat pengecualian atau menampilkan pesan yang ramah pengguna
    http_response_code(500);
    echo 'Terjadi kesalahan: ' . $e->getMessage();
}
