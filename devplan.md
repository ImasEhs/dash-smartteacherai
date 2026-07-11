# Development Plan - SMARTTEACHER AI

Berdasarkan data task yang dilampirkan, berikut adalah daftar task (34 item) yang perlu diselesaikan. Checklist ini disusun berdasarkan modul/halaman untuk memudahkan proses perbaikan (development).

## Dashboard

- [X] **1. Lengkapi Profil:** Popup **Lengkapi Profil** bila sudah diisi tidak muncul lagi saat buka page Dashboard.
- [X] **2. Notification:** Belum berjalan, notif berisi:
  - Bila ada pelatihan baru yang dibuat oleh instruktur.
  - Pengingat untuk menjalankan pelatihan (bila tidak menjalankan pelatihan selama 1 minggu).
- [X] **3. Greeting:** Wording "SMARTEACHER AI" direvisi - seharusnya "SMARTTEACHERAI".
- [X] **4. Title:** Title "Banyak guru sudah bergabung dengan SMARTEACHER AI" diganti menjadi "Banyak pengguna sudah bergabung dengan SMARTTEACHER AI".
- [ ] **5. Others:** **Page About, Support, Contact Us** belum berjalan.

## Detail Profil

- [X] **6. Profil:** Form data Profil hanya auto get **Email** saja, yang lain dapat diisi.
- [X] **7. Profil:** Title **Basic Information** ganti menjadi **Informasi Personal**.
- [X] **8. Profil:** Nama typo, saat ini **Name** harusnya **Nama**. Nama akan dijadikan nama pada sertifikat.
- [X] **9. Profil:** Foto Profil tidak dapat diganti - harusnya dapat diganti.
- [X] **10. Profil:** Saat klik **Simpan** Kembali ke halaman **Dashboard**.
- [X] **11. Profil:** Title **Tujuan Pelatihan** diganti menjadi **Target Karir**.

## Perjalanan Karir

- [X] **12. Perjalanan Karir:** Foto mengikuti Detail profil.
- [X] **13. Perjalanan Karir:** Profesi "Guru Sekolah Dasar" diganti menjadi data Profil cth "Guru".
- [X] **14. Perjalanan Karir:** Setelah klik dan mengisi data "Target Karir" dan "Tentukan target mingguan", lalu klik "Simpan" dibuat auto close.
- [X] **15. Perjalanan Karir:** "Mulai Bulan Gratis" akan muncul popup konfirmasi "Selamat anda mendapatkan akses semua pelatihan selama 1 bulan gratis" - tambah tombol "Tutup".
- [X] **16. Pustaka Saya:** Dalam proses:
  - Menampilkan kursus yang belum selesai (belum generate sertifikat).
  - "Tampilkan Kursus yang Direkomendasikan" menampilkan bagian bawah page Konten.
  - "Lihat semua kursus" menuju ke halaman Konten.
- [X] **17. Pustaka Saya:** Disimpan - kursus yang tersimpan (saved).
- [X] **18. Pustaka Saya:** Riwayat Belajar - Kursus yang sudah selesai (sudah generate sertifikat).
- [X] **19. Target Saya:** Target karir isinya yang dipilih pada Detail profil "Tujuan Pelatihan".

## Tanya AI

- [X] **20. AI Tools:** Ketika klik tombol **Back** kembali ke daftar tools AI.
- [X] **21. Chat AI:** Tanya AI tidak bisa digunakan karena responnya "Maaf, tidak ada jawaban dari AI". Harusnya merespon pertanyaan sesuai pertanyaan. Ketikan pada kolom chat dipercepat.
- [X] **22. Buat soal:**
  - Ada Form Bentuk Soal yang muncul opsi dropdown - Pilihan Ganda & Essai.
  - Ada Form jenjang sekolah muncul opsi dropdown - SD, SMP/MTS, SMA/MA, SMK.
  - Ada Form Mata pelajaran muncul free teks dapat diketik mapel.
  - Kalau dipilih "Pilihan Ganda" muncul opsi tambahan - Jumlah opsi jawaban keluar "3 Opsi (A, B, C)", "4 Opsi (A, B, C, D)", "5 Opsi (A, B, C, D, E)".
  - Jumlah soal maks 20.
- [X] **23. Buat Modul Ajar:** Selesai (Diimplementasikan dengan prompt dinamis).
- [X] **24. Evaluasi Gambar:** Selesai
  - Ada Form Jenis Pelatihan yang muncul opsi dropdown - Materi pembelajaran - Poster - Infografis.
  - Bila pilih Materi Pembelajaran maka akan analisis gambar dengan indikator penilaian (input berupa text area).
- [X] **25. Chat Dengan Dokumen:**
  - Ada form upload dokumen.
  - AI learn dari dokumen tersebut.
- [X] **26. Buat Materi Presentasi:** Selesai
    - Ada form upload dokumen (ditambahkan validasi tipe ekstensi & pratinjau dokumen).
    - AI learn dari dokumen tersebut (prompt distrukturisasi agar hasil berurutan per slide).

## Pustaka Saya

- [X] **27. Pustaka Saya:** Menu dihilangkan, sudah ada di menu Perjalanan Karir.

## Konten

- [X] **28. Detail Konten:** Foto dan jawaban user disesuaikan data pada profil.
- [X] **29. Detail Konten:** Konten pembelajaran tidak valid, yang dalam proses tidak sesuai dengan yang berjalan. Kalau belum ada pelatihan yang berjalan dibuat kosong.
- [X] **30. Detail Konten:** Card Kursus Diikuti - Pengujian Hasil - Kursus Tersimpan - Sertifikat belum sesuai datanya.
- [X] **31. Detail Konten:** Konten Pilihan terbaik untuk User ini hasil rekomendasi pelatihan dari Target pelatihan.

## Pelatihan

- [X] **32. Pretest:** Munculkan skor Pre Test setelah submit, tetapi tidak ada aturan lulus hanya menampilkan skornya saja.
- [X] **33. Sertifikat:** Tidak bisa unduh sertifikat.
- [X] **34. Milestone pelatihan:** Update centang bila sudah ada yang sudah dikerjakan: Pretest, Postest, Feedback, Sertifikat.
