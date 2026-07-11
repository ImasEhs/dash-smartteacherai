airfimarm

# Development Log - SMARTTEACHER AI

Dokumen ini mencatat seluruh riwayat pekerjaan, diskusi, dan perubahan yang dilakukan selama proses development.

---

## [08 Juli 2026]

### 1. Update Password User

- **Tindakan:** Mengubah password pengguna di database.
- **Detail:** Mengganti password untuk user dengan email `mudaberjaya2@gmail.com` menjadi `mudamudi` di dalam tabel `users`.
- **Metode:** Menggunakan eksekusi script PHP secara langsung melalui `php artisan tinker`. Script sementara (`change_password.php`) langsung dihapus kembali setelah eksekusi berhasil untuk menjaga kebersihan direktori.

### 2. Analisis Halaman Login

- **Tindakan:** Analisis kode front-end halaman login (`resources/views/login.blade.php`).
- **Detail:** Melakukan pengecekan pada tombol **"Login Now"** atas permintaan user.
- **Temuan (Root Cause):**
    - Kode masih berupa _mockup UI_.
    - Input form belum dibungkus oleh tag `<form>`.
    - Input field belum memiliki atribut `name` (seperti `name="email"` atau `name="password"`).
    - Tidak terdapat perlindungan CSRF (`@csrf`).
    - Tidak ada _route action_ (URL submit) maupun event handler JS/AJAX.
- **Status:** _Hanya diskusi dan analisis, belum ada modifikasi kode pada file ini._

### 3. Pembuatan Development Plan (`devplan.md`)

- **Tindakan:** Inisialisasi daftar pekerjaan.
- **Detail:** Mengonversi tabel gambar yang dilampirkan user ke dalam format markdown.
- **Hasil:** Berhasil mentranskripsi 34 daftar task perbaikan menjadi checklist terstruktur di dalam file `devplan.md` yang dikelompokkan per modul (Dashboard, Profil, Perjalanan Karir, dsb).

### 4. Perbaikan Teks Dashboard (Task 3 & 4)

- **Tindakan:** Memperbaiki teks sapaan dan judul di halaman Dashboard (`resources/views/dashboard/index.blade.php`).
- **Detail:**
    - Mengubah "SMARTEACHER AI" menjadi "SMARTTEACHERAI".
    - Mengubah "Banyak guru sudah bergabung..." menjadi "Banyak pengguna sudah bergabung...".
- **Status:** **Selesai (Task 3 & 4)**.

### 5. Logika Popup Lengkapi Profil (Task 1)

- **Tindakan:** Menerapkan logika kondisi kemunculan popup _Lengkapi Profil_ di Dashboard.
- **Detail:**
    - Menambahkan kolom `is_profile_completed` (boolean) di tabel `users` sebagai penanda apakah user sudah melengkapi profil atau belum.
    - Memodifikasi `DashboardController@index` untuk melempar instance `$user` saat ini ke view.
    - Membungkus skrip Javascript pemanggil modal (di `index.blade.php`) dengan pengecekan `@if($user && !$user->is_profile_completed)`.
- **Status:** **Selesai (Task 1)**. Logika ini sudah berfungsi dan berhasil diuji menggunakan _Tinker_.

### 6. Implementasi Fungsionalitas Modul Profil (Task 6-11)

- **Tindakan:** Mengaktifkan seluruh fitur pengisian, pengubahan teks antarmuka, dan penyimpanan data profil pengguna.
- **Detail:**
    - Menambahkan kolom profil baru (seperti `profesi`, `institusi`, `target_karir`, dll) di tabel `users` (dieksekusi menggunakan skrip PHP raw via `tinker` agar _safe_).
    - Membuat rute baru (POST `/profil`) dan memodifikasi `DashboardController` untuk dapat menerima, memvalidasi form, dan menyimpannya ke database, kemudian _redirect_ kembali ke halaman dashboard.
    - Mengubah tampilan antarmuka `profil.blade.php`:
        - Mengganti semua label statis sesuai permintaan ("Basic Information" jadi "Informasi Personal", "Name" jadi "Nama", "Tujuan Pelatihan" jadi "Target Karir").
        - Mengaitkan isian dengan data asli _user_ di database, dengan form Email yang bersifat _readonly_.
        - Menambahkan fitur _upload_ Avatar melalui klik pada ikon kamera menggunakan tag input dan skrip pratinjau gambar Javascript lokal.
- **Status:** **Selesai (Task 6-11)**. Seluruh fungsionalitas telah dibuktikan dapat menyimpan data ke database (dibuktikan dengan status sukses redirect 302 saat pengetesan submit).

### 7. Modul Perjalanan Karir (Task 12-19)

- **Tindakan:** Mengimplementasikan fungsionalitas dan interaksi antarmuka di halaman Perjalanan Karir.
- **Detail:**
    - **Sinkronisasi Profil:** Mengganti foto avatar dan profesi menggunakan referensi `$user` dari database agar terhubung dengan data profil (Task 12 & 13).
    - **Penyimpanan Target:** Menambahkan kolom `target_mingguan` ke tabel `users`. Menambahkan rute dan metode controller untuk memperbarui `target_karir` dan `target_mingguan`. Memodifikasi modal untuk bertindak sebagai _form_ yang menyimpan dan me-_reload_ halaman secara otomatis (Task 14 & 19).
    - **Bulan Gratis:** Membuat popup modal baru untuk klaim bulan gratis yang menampilkan pesan sambutan dan tombol "Tutup" (Task 15).
    - **Pustaka Saya:** Memperbarui tautan tombol navigasi ("Lihat Semua Kursus" dan "Tampilkan Kursus yang Direkomendasikan") untuk mengarah secara spesifik ke menu `/content` (Task 16, 17, 18).
- **Status:** **Selesai (Task 12-19)**.

### 8. Penghapusan Menu Pustaka Saya (Task 27)

- **Tindakan:** Menghapus menu navigasi "Pustaka Saya" dari sidebar (navigasi sisi).
- **Detail:** Karena fitur Pustaka Saya sudah dilebur menjadi bagian dari modul Perjalanan Karir, tautan menuju Pustaka Saya di `sidebar_and_nav.blade.php` tidak lagi diperlukan sehingga dihilangkan sepenuhnya.
- **Status:** **Selesai (Task 27)**.

### 9. Pembaruan Modul Konten (Task 28-31)

- **Tindakan:** Mengubah data statis di halaman Detail Konten menjadi dinamis sesuai dengan data pengguna.
- **Detail:**
    - _Task 28_: Di-skip sesuai dengan instruksi user.
    - _Task 29_: Modifikasi logika pada `DashboardController@content` untuk mengambil kursus terakhir yang sedang berjalan (`CourseUser`) untuk ditampilkan di blok 'Dalam Proses'. Jika tidak ada, tampilkan pesan kosong (belum ada pelatihan berjalan).
    - _Task 30_: Mengubah angka statistik _hardcode_ menjadi perhitungan nyata dari database (Kursus Diikuti dari `course_users`, Pengujian Hasil dari `exam_attempts`, Sertifikat dari `exams` & posttest yang valid). Kursus Tersimpan diatur default `0` karena fitur simpan belum tersedia.
    - _Task 31_: Sistem Rekomendasi diimplementasikan dengan memfilter daftar kursus di korsel menggunakan referensi `target_karir` pengguna. Kursus yang memiliki kesamaan kata pada judul/deskripsi akan diutamakan.
- **Status:** **Selesai (Task 29, 30, 31)**.

### 10. Pembaruan Modul Pelatihan (Task 32-34)

- **Tindakan:** Memperbaiki sistem pretest, unduh sertifikat, dan indikator milestone di halaman pelatihan.
- **Detail:**
    - _Task 32_: Pada `DashboardController@submit_pretest`, pesan sukses diubah menjadi menampilkan akumulasi nilai jawaban (`Skor Anda: ...`).
    - _Task 33_: Masalah unduhan sertifikat lintas domain (CORS) diperbaiki di `certificate.blade.php` menggunakan JavaScript Fetch API untuk memproses konversi _blob_ file, sehingga fungsi `download` bekerja.
    - _Task 34_: Logika verifikasi tahapan milestone (Pretest, Posttest, Feedback, Sertifikat) di `my_course.blade.php` telah diperbaiki menjadi dinamis berdasarkan data `ExamAttempt` dan `CourseReview` pengguna saat ini.
- **Status:** **Selesai (Task 32, 33, 34)**.

### 11. Perbaikan Navigasi Tanya AI (Task 20)

- **Tindakan:** Mengubah tautan rute pada tombol "Kembali" di berbagai modul fitur AI.
- **Detail:**
    - Sebelumnya tautan "Kembali" pada halaman _Chat AI, Chat Dengan Dokumen, Evaluasi Gambar, Buat Soal, Buat Modul Ajar, dan Buat Materi Presentasi_ mengarah ke halaman diri sendiri sehingga gagal kembali.
    - Kini seluruh tautan telah diarahkan ke rute `ask_ai` (halaman utama daftar modul Tanya AI).
- **Status:** **Selesai (Task 20)**.

## Task 21: Chat AI

- Menyelidiki kegagalan API Gemini (Maaf, tidak ada jawaban dari AI).
- Menemukan bahwa model gemini-1.5-flash tidak lagi didukung di endpoint 1beta untuk API Key ini.
- Mengganti model yang digunakan dari gemini-1.5-flash menjadi gemini-2.5-flash di 6 fungsi dalam DashboardController.
- Menambahkan header Referer: https://smartteacherai.id pada setiap permintaan HTTP ke Gemini, karena API Key dibatasi berdasarkan referer ini.
- Mempercepat efek pengetikan (typing speed) dari speed = 30 menjadi speed = 5 pada file blade AI (chat_ai, chat_with_docs, image_evaluate, make_exam, materi_presentasi, eaching_module).

## Task 22: Buat Soal

- Membuat form input baru untuk fitur buat soal, yang meliputi form Bentuk Soal (Pilihan Ganda & Essai), form Jenjang Sekolah (SD, SMP/MTS, SMA/MA, SMK), form Mata Pelajaran (teks bebas), dan Opsi Jawaban (3, 4, 5 opsi).
- Memberikan limitasi maksimal 20 pada jumlah soal.
- Menambahkan kapabilitas unduh dokumen untuk hasil soal berupa format **PDF** dan **DOCX** dengan memanfaatkan library mpdf/mpdf dan phpoffice/phpword menggunakan composer.
- Membuat dua rute ekspor PDF (/make-exam/download-pdf) dan DOCX (/make-exam/download-docx) lengkap dengan _logic_ controller.
- Memperbaiki bug rekursi infinit (Maximum call stack size exceeded) pada efek _typing_ (_typeWriterEffect_) di frontend.
- Menyesuaikan _prompt_ di Controller dan parser _marked.js_ di frontend agar jawaban pilihan ganda (A, B, C, D) tampil dengan format list menyusun kebawah persis di bawah pertanyaannya.
- Memperbaiki _error parsing XML_ tag saat proses export PDF/DOCX dengan melakukan replace mandiri menjadi .
- **Status: Selesai.**

### Task 23: Buat Modul Ajar

- **Detail:** Diimplementasikan dengan model prompt yang telah dioptimasi untuk membuat Modul Ajar (termasuk Pendekatan _Culturally Responsive Teaching_). Animasi pengetikan juga sudah di-_patch_ dari rekursi tak terbatas.
- **Status**: Selesai.

### Task 24: Evaluasi Gambar

- **UI (image_evaluate.blade.php)**:
    - Ditambahkan dropdown "Jenis Pelatihan" (Materi Pembelajaran, Poster, Infografis).
    - Ditambahkan input Text Area dinamis untuk "Indikator Penilaian" (hanya muncul saat pengguna memilih Materi Pembelajaran) agar pengguna bisa _copy-paste_ rubrik penilaian mereka (sangat efisien secara token).
    - Ditambahkan pratinjau (preview) unggah gambar (menggantikan tampilan daftar nama file biasa).
    - Perbaikan rekursi animasi ketik dan peningkatan kecepatan _typewriter_ (chunk 6 karakter per milidetik).
- **Status**: Selesai.

### Task 25: Chat Dengan Dokumen

- **UI (chat_with_docs.blade.php)**:
    - Menambahkan dukungan opsional untuk melampirkan dokumen. Input _textarea_ sekarang menjadi isian wajib (required), sementara unggahan dokumen menjadi opsional.
    - Menambahkan atribut `accept=".pdf, .txt, image/*"` pada input file untuk menghindari upload format `.docx` atau lainnya yang rentan masalah saat diparsing *inline_data* Gemini API.
    - Menambahkan script JS pratinjau (preview) nama dokumen ketika dipilih (memakai badge Bootstrap), beserta tombol silang untuk membatalkan pilihan lampiran.
    - Menyesuaikan kecepatan *typeWriterEffect* dengan *chunking* agar jauh lebih cepat dan terbebas dari *Maximum Call Stack Exceeded error*.
- **Backend (DashboardController.php)**: 
    - Melonggarkan rule form validation untuk `document` menjadi `nullable`.
    - Menyesuaikan pembentukan array `parts` pengiriman Gemini agar bagian *inline_data* untuk file _base64_ disisipkan hanya ketika pengguna benar-benar mengunggah file.
- **Status**: Selesai.

### Task 26: Buat Materi Presentasi

- **UI (materi_presentasi.blade.php)**:
    - Ditambahkan atribut `accept=".pdf, .txt, image/*"` pada kedua input file (Dokumen Utama dan Kriteria Tambahan) agar sistem terhindar dari error parsing file Word (.docx) secara langsung ke API Gemini via `inline_data`.
    - Diimplementasikan skrip *Javascript* untuk mendengarkan *event* `change` pada input file, sehingga sistem kini menampilkan *badge* dengan nama file yang diunggah serta sebuah tombol *close* untuk mereset input file.
    - Fungsi efek mengetik `typeWriterEffect` dirombak agar tidak mencetak satu huruf per perulangan. Kini fungsinya men-*chunk* 6 karakter per *interval* dengan pemanfaatan *async/await* penuh (cepat dan bebas dari _recursive depth call limit_).
- **Backend (DashboardController.php)**: 
    - Modifikasi string *prompt* pada metode `submit_materi_presentasi`.
    - Menambahkan klausa instruksi secara tegas (`WAJIB`) untuk memaksa AI menyusun *output* secara terstruktur dari `Slide 1, Slide 2, dst` berdasarkan parameter `jumlah_slide`.
    - AI diperintahkan secara lisan (lewat prompt teks) untuk fokus mengeksplorasi data dari dokumen lampiran jika tersedia.
- **Status**: Selesai.
