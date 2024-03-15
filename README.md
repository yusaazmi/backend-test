# Panduan Penggunaan

Ini adalah aplikasi [nama aplikasi] yang bertujuan untuk [tujuan aplikasi].

## Instalasi

1. Pastikan Anda memiliki PHP, Composer, dan MySQL terpasang di komputer Anda.
2. Clone repositori ini ke komputer Anda.
3. Buka terminal dan navigasikan ke direktori proyek.
4. Jalankan perintah berikut untuk menginstal semua dependensi:

    ```bash
    composer install
    ```

5. Salin file `.env.example` menjadi `.env`:

    ```bash
    cp .env.example .env
    ```

6. Generate kunci aplikasi:

    ```bash
    php artisan key:generate
    ```

7. Atur koneksi basis data Anda di dalam file `.env`.
8. Jalankan migrasi untuk membuat tabel basis data:

    ```bash
    php artisan migrate
    ```

9. (Opsional) Jalankan seeder untuk mengisi data awal ke dalam basis data:

    ```bash
    php artisan db:seed
    ```

## Menjalankan Aplikasi

Untuk menjalankan aplikasi, jalankan server lokal menggunakan perintah berikut:

```bash
php artisan serve
