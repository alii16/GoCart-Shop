<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href = 'login.php';</script>";
    exit;
}

try {
    // Ambil user_id dari session
    $user_id = $_SESSION['user_id'];

    // Hapus user dari database
    $stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
    $stmt->execute([$user_id]);

    // Hapus session
    session_destroy();

    // Redirect ke halaman login dengan pesan sukses
    echo "<script>
        alert('Akun Anda berhasil dihapus.');
        window.location.href = 'login.php';
    </script>";
    exit;
} catch (PDOException $e) {
    // Tampilkan pesan kesalahan jika terjadi error
    echo "<script>
        alert('Terjadi kesalahan saat menghapus akun: " . htmlspecialchars($e->getMessage()) . "');
        window.location.href = 'index.php?page=profile';
    </script>";
}
