# Aplikasi Kuesioner STMIK Bandung
Aplikasi kuesioner untuk tugas akhir STMIK Bandung.

## Instalasi
 1. Pastikan XAMPP (7.4.11) telah terinstall.
 2. Download dan install *Composer* di: `getcomposer.org`
 3. Install *Laravel*: `composer global require laravel/installer`
 4. Clone repository: `git clone https://github.com/rizkyirmawan/kuesioner.git`
 5. `cd` kedalam repository.
 6. Install dependency: `composer install`
 7. Copy file .env: `copy .env .env.example` dan sesuaikan konfigurasi.
 8. Generate app key: `php artisan key:generate`
 9. Migrate dan seed database: `php artisan migrate --seed`
 10. Jalankan aplikasi: `php artisan serve`