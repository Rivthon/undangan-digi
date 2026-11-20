# Undangan Digital Laravel

Website undangan pernikahan responsif dengan fitur personalisasi nama tamu, hitung mundur, detail acara, galeri, Google Maps, RSVP, dan buku ucapan.

## Menjalankan aplikasi

1. Nyalakan **Apache** dan **MySQL** dari XAMPP.
2. Buka `http://localhost/undangan-digi/public`.

Atau jalankan server Laravel:

```bash
php artisan serve
```

Lalu buka `http://127.0.0.1:8000`.

Nama tamu bisa dipersonalisasi lewat URL:

```text
http://127.0.0.1:8000/?to=Budi%20dan%20Keluarga
```

## Mengganti data acara

Semua nama, tanggal, waktu, lokasi, Instagram, kutipan, dan tautan Google Maps berada di `config/invitation.php`. Foto berada pada properti `background-image` di `public/css/invitation.css`.

Database MySQL yang digunakan adalah `undangan_digi`. Konfigurasi koneksi berada di `.env`.
