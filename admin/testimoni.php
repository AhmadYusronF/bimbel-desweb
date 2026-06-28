<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
require_once '../connect.php';

$message = "";

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_testi'])) {
    $pendaftar_id = $_POST['pendaftar_id'];
    $text = $_POST['testimoni_text'];
    $asal = $_POST['asal'];

    $stmt = $conn->prepare("INSERT INTO testimoni (pendaftar_id, testimoni_text, asal) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $pendaftar_id, $text, $asal);

    if ($stmt->execute()) {
        $message = "<div class='alert alert-success'>Testimoni berhasil ditambahkan!</div>";
    } else {
        $message = "<div class='alert alert-danger'>Gagal menambahkan testimoni.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Testimoni - Bimbel Prestasi</title>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Segoe UI', sans-serif;
        }

        .sidebar {
            height: 100vh;
            background: white;
            border-right: 1px solid #e2e8f0;
        }

        .hover-translate-x {
            transition: transform 0.3s ease;
        }

        .hover-translate-x:hover {
            transform: translateX(10px);
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar p-4 d-none d-md-block">
                <div class="text-center mb-5">
                    <img src="../src/asset/logo.png" width="40" class="me-2">
                    <span class="fw-bold">Admin Panel</span>
                </div>
                <nav class="nav flex-column gap-2">
                    <a class="nav-link text-secondary hover-translate-x" href="index.php">Pendaftar</a>
                    <a class="nav-link active fw-bold text-primary hover-translate-x" href="testimoni.php">Kelola Testimoni</a>
                    <hr>
                    <a class="nav-link text-danger" href="logout.php">Keluar</a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 p-5">
                <div class="d-flex justify-content-between align-items-center mb-5">
                    <h2 class="fw-bold">Kelola Testimoni Siswa</h2>

                </div>

                <?= $message ?>

                <div class="row g-4">
                    <!-- Form Section -->
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm p-4 rounded-4 bg-white">
                            <h5 class="fw-bold mb-4">Tambah Testimoni Baru</h5>
                            <form method="POST">
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Pilih Siswa</label>
                                    <select name="pendaftar_id" class="form-select" required>
                                        <option value="">-- Pilih Siswa --</option>
                                        <?php
                                        $students = $conn->query("SELECT id, nama FROM pendaftar ORDER BY nama ASC");
                                        while ($s = $students->fetch_assoc()):
                                        ?>
                                            <option value="<?= $s['id'] ?>"><?= $s['nama'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Asal / Status</label>
                                    <input type="text" name="asal" class="form-control" placeholder="Contoh: Alumni ITB / Kelas 11 SMA" required>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label small fw-semibold">Isi Testimoni</label>
                                    <textarea name="testimoni_text" class="form-control" rows="4" placeholder="Tulis kesan pesan siswa..." required></textarea>
                                </div>
                                <button type="submit" name="add_testi" class="btn btn-primary w-100 rounded-pill py-2 fw-bold">Simpan Testimoni</button>
                            </form>
                        </div>
                    </div>

                    <!-- List Section -->
                    <div class="col-md-8">
                        <div class="card border-0 shadow-sm p-4 rounded-4 bg-white">
                            <h5 class="fw-bold mb-4">Daftar Testimoni Aktif</h5>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Siswa</th>
                                            <th>Asal</th>
                                            <th>Testimoni</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT t.*, p.nama FROM testimoni t
                                                JOIN pendaftar p ON t.pendaftar_id = p.id
                                                ORDER BY t.created_at DESC";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0):
                                            while ($row = $result->fetch_assoc()):
                                        ?>
                                                <tr>
                                                    <td class="fw-semibold"><?= $row['nama'] ?></td>
                                                    <td><span class="small text-secondary"><?= $row['asal'] ?></span></td>
                                                    <td class="small italic">"<?= substr($row['testimoni_text'], 0, 50) ?>..."</td>
                                                    <td>
                                                        <a href="delete_testimoni.php?id=<?= $row['id'] ?>"
                                                            class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus testimoni dari <?= $row['nama'] ?>?')">
                                                            Hapus
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endwhile;
                                        else: ?>
                                            <tr>
                                                <td colspan="4" class="text-center text-secondary">Belum ada testimoni.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>