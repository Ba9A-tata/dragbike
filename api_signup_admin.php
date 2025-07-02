<?php
// api_signup_admin.php
header('Content-Type: application/json');
require_once 'koneksi.php';

$response = ['success' => false, 'message' => 'Gagal membuat akun.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($nama) || empty($username) || empty($password)) {
        $response['message'] = 'Semua field wajib diisi!';
        echo json_encode($response);
        exit;
    }
    
    // Hash password untuk keamanan
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO admins (nama, username, password) VALUES (?, ?, ?)");
        $stmt->execute([$nama, $username, $hashed_password]);
        $response = ['success' => true, 'message' => 'Sign up berhasil!'];
    } catch (\PDOException $e) {
        if ($e->getCode() == 23000) { // Kode error untuk duplicate entry
            $response['message'] = 'Username sudah digunakan!';
        } else {
            http_response_code(500);
            $response['message'] = 'Server error: ' . $e->getMessage();
        }
    }
}

echo json_encode($response);
?>




// BAHANNNN

<?php
/**
 * File: api_signup_admin.php
 * Deskripsi: Mendaftarkan akun admin baru ke database.
 */

require_once "koneksi.php";  // 1. Koneksi ke database

// 2. Ambil data dari form
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);  // Enkripsi password

// 3. Insert data admin baru ke tabel
$query = "INSERT INTO admin (username, password) VALUES (?, ?)";
$stmt = $pdo->prepare($query);
$stmt->execute([$username, $password]);  // Eksekusi query

// 4. Kirim respon ke klien
echo "Admin berhasil dibuat!";
?>
