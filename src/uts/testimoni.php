<?php
require_once '../../connect.php';
?>
<!doctype html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bimbel Prestasi - Testimoni</title>

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
          <a class="nav-link text-primary" href="/src/uts/testimoni.php">Testimoni</a>
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
    <h2 class="text-center fw-bold display-5 mb-5">Kisah Sukses Siswa</h2>

    <div class="row g-4">
      <?php
      // JOIN query to get student name from pendaftar table
      $sql = "SELECT t.testimoni_text, t.asal, p.nama
                FROM testimoni t
                JOIN pendaftar p ON t.pendaftar_id = p.id
                ORDER BY t.created_at DESC";
      $result = $conn->query($sql);

      if ($result && $result->num_rows > 0):
        while ($row = $result->fetch_assoc()):
          // Create a simple avatar from initials (e.g., "Muhamad Fajar" -> "MF")
          $nameParts = explode(' ', $row['nama']);
          $initials = strtoupper(substr($nameParts[0], 0, 1));
          if (count($nameParts) > 1) {
            $initials .= strtoupper(substr(end($nameParts), 0, 1));
          }
      ?>
          <div class="col-md-6">
            <div class="card h-100 border-0 shadow-sm p-4 rounded-4 hover-translate">
              <p class="lead italic mb-4">
                "<?= htmlspecialchars($row['testimoni_text']) ?>"
              </p>
              <div class="d-flex align-items-center">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold me-3" style="width: 48px; height: 48px;">
                  <?= $initials ?>
                </div>
                <div>
                  <h5 class="mb-0 fw-bold"><?= htmlspecialchars($row['nama']) ?></h5>
                  <p class="text-secondary mb-0 small"><?= htmlspecialchars($row['asal']) ?></p>
                </div>
              </div>
            </div>
          </div>
        <?php endwhile;
      else: ?>
        <div class="col-12 text-center py-5">
          <p class="text-secondary">Belum ada testimoni yang tersedia.</p>
        </div>
      <?php endif; ?>
    </div>
  </div>
</body>

</html>