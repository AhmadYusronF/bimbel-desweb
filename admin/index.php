<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
require_once '../connect.php';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Bimbel Prestasi</title>
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

        .stat-card {
            border: none;
            border-radius: 1rem;
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
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
                    <a class="nav-link active fw-bold text-primary hover-translate-x" href="index.php">Pendaftar</a>
                    <a class="nav-link text-secondary hover-translate-x" href="testimoni.php">Kelola Testimoni</a>
                    <hr>
                    <a class="nav-link text-danger" href="logout.php">Keluar</a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 p-5">
                <div class="d-flex justify-content-between align-items-center mb-5">
                    <h2 class="fw-bold">Halo, <?= $_SESSION['admin_user'] ?>!</h2>
                </div>

                <!-- Stats Row -->
                <div class="row g-4 mb-5">
                    <div class="col-md-4">
                        <div class="card stat-card p-4 shadow-sm bg-primary text-white">
                            <p class="mb-1 opacity-75">Total Pendaftar</p>
                            <h2 class="fw-bold mb-0">
                                <?php
                                $res = $conn->query("SELECT COUNT(*) as total FROM pendaftar");
                                echo $res->fetch_assoc()['total'];
                                ?>
                            </h2>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card stat-card p-4 shadow-sm bg-white">
                            <p class="mb-1 text-secondary">Pendaftar Hari Ini</p>
                            <h2 class="fw-bold mb-0 text-dark">
                                <?php
                                // Dynamic query to count registrations from today
                                $res_today = $conn->query("SELECT COUNT(*) as total FROM pendaftar WHERE DATE(tanggal_daftar) = CURDATE()");
                                echo $res_today->fetch_assoc()['total'];
                                ?>
                            </h2>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card stat-card p-4 shadow-sm bg-white">
                            <p class="mb-1 text-secondary">Program Terpopuler</p>
                            <h2 class="fw-bold mb-0 text-dark">
                                <?php
                                // Dynamic query to find the most frequent program
                                $res_prog = $conn->query("SELECT program FROM pendaftar GROUP BY program ORDER BY COUNT(*) DESC LIMIT 1");
                                if ($row_prog = $res_prog->fetch_assoc()) {
                                    echo $row_prog['program'];
                                } else {
                                    echo "Belum ada";
                                }
                                ?>
                            </h2>
                        </div>
                    </div>
                </div>

                <!-- Table Section -->
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h5 class="fw-bold mb-4">Daftar Pendaftar Terbaru</h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama</th>
                                    <th>WhatsApp</th>
                                    <th>Tingkat</th>
                                    <th>Program</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $result = $conn->query("SELECT * FROM pendaftar ORDER BY id DESC LIMIT 10");
                                while ($row = $result->fetch_assoc()):
                                ?>
                                    <tr>
                                        <td class="fw-semibold"><?= $row['nama'] ?></td>
                                        <td><?= $row['wa'] ?></td>
                                        <td><span class="badge bg-light text-dark border"><?= $row['tingkat'] ?></span></td>
                                        <td><?= $row['program'] ?></td>
                                        <td>
                                            <!-- Changed from Detail to Delete -->
                                            <a href="delete_pendaftar.php?id=<?= $row['id'] ?>"
                                                class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data <?= $row['nama'] ?>?')">
                                                Hapus
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>