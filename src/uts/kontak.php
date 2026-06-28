<?php
require_once '../../connect.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nama = $_POST['nama'];
  $wa = $_POST['wa'];
  $tingkat = $_POST['tingkat'] ?? '';
  $program = $_POST['program'];
  $pesan = $_POST['pesan'];


  $fasilitas_arr = [];
  if (isset($_POST['fasilitas1'])) $fasilitas_arr[] = "Modul Cetak Khusus";
  if (isset($_POST['fasilitas2'])) $fasilitas_arr[] = "Akses Tryout CBT";
  $fasilitas_string = implode(", ", $fasilitas_arr);


  $stmt = $conn->prepare("INSERT INTO pendaftar (nama, wa, tingkat, fasilitas, program, pesan) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssssss", $nama, $wa, $tingkat, $fasilitas_string, $program, $pesan);

  if ($stmt->execute()) {
    $message = "<div class='alert alert-success text-center rounded-pill mx-auto' style='max-width: 600px;'>Data atas nama $nama berhasil didaftarkan!</div>";
  } else {
    $message = "<div class='alert alert-danger text-center rounded-pill mx-auto' style='max-width: 600px;'>Terjadi kesalahan. Silakan coba lagi.</div>";
  }
}
?>
<!doctype html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bimbel Prestasi - Daftar</title>
  <link rel="stylesheet" href="../../node_modules/bootstrap/dist/css/bootstrap.min.css" />
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f8fafc;
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg bg-white shadow-sm fixed-top py-3">
    <div class="container">
      <a
        href="../../index.html"
        class="navbar-brand fw-bolder d-flex align-items-center fs-4 text-dark">
        <img
          src="../asset/logo.png"
          alt="Logo"
          width="48"
          height="48"
          class="me-2" />
        Bimbel <span class="text-primary ms-1">Prestasi</span>
      </a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div
        class="collapse navbar-collapse justify-content-end"
        id="navbarNav">
        <div
          class="navbar-nav align-items-center gap-3 fw-semibold"
          style="font-size: 0.9rem">
          <a class="nav-link text-secondary" href="../../index.html">Beranda</a>
          <a class="nav-link text-secondary" href="/src/uts/keunggulan.html">Keunggulan</a>
          <a class="nav-link text-secondary" href="/src/uts/program.html">Program</a>
          <a class="nav-link text-secondary" href="/src/jadwal.html">Jadwal</a>
          <a class="nav-link text-secondary" href="/src/tentang.html">Tentang</a>
          <a class="nav-link text-secondary" href="/src/uts/testimoni.php">Testimoni</a>
          <a class="nav-link text-secondary" href="/src/hubungi.html">Hubungi</a>
          <a
            href="/src/uts/kontak.php"
            class="btn btn-primary text-white rounded-pill px-4 py-2 ms-lg-2 fw-bold">Daftar</a>
        </div>
      </div>
    </div>
  </nav>

  <div style="height: 90px"></div>


  <div class="container py-5 mt-5">
    <?= $message ?>
    <div class="card border-0 shadow-sm p-4 p-md-5 rounded-4 bg-white mx-auto" style="max-width: 800px;">
      <h2 class="fw-bold text-center mb-3">Pendaftaran Online</h2>
      <p class="text-center text-secondary mb-5">Lengkapi formulir di bawah ini untuk bergabung.</p>

      <form method="POST" class="row g-3 justify-content-center">
        <div class="col-md-8">
          <div class="mb-3">
            <label class="form-label fw-semibold">Nama Lengkap Siswa</label>
            <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" required />
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">No. WhatsApp (Aktif)</label>
            <input type="tel" name="wa" class="form-control" placeholder="08..." required />
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold d-block">Tingkat Pendidikan</label>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="tingkat" id="smp" value="SMP" required />
              <label class="form-check-label" for="smp">SMP</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="tingkat" id="sma" value="SMA" />
              <label class="form-check-label" for="sma">SMA</label>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold d-block">Fasilitas Tambahan</label>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="fasilitas1" id="modul" value="ON" />
              <label class="form-check-label" for="modul">Modul Cetak Khusus</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="fasilitas2" id="tryout" value="ON" />
              <label class="form-check-label" for="tryout">Akses Tryout CBT</label>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Pilih Program</label>
            <select name="program" class="form-select">
              <option value="Reguler Class">Reguler Class</option>
              <option value="Intensif UTBK">Intensif UTBK</option>
              <option value="Privat Eksklusif">Privat Eksklusif</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Pesan/Pertanyaan</label>
            <textarea name="pesan" class="form-control" rows="3" placeholder="Tanyakan apa saja..."></textarea>
          </div>
          <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5">Kirim Sekarang</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</body>

</html>