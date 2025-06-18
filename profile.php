<?php
session_start();
include './config.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: ./login/');
    exit;
}

$db = new Database();
$user_id = (int)$_SESSION['user']['id'];

$user = $db->select('users', '*', 'id = ?', [$user_id], 'i');
if (!$user || count($user) === 0) {
    echo "❌ Foydalanuvchi topilmadi!";
    exit;
}
$user = $user[0];
?>
<?php include './template/header.php'; ?>
<div class="container mt-4">
    <h2 class="text-center mb-4">👤 Mening Profilim</h2>

    <div class="card mx-auto" style="max-width: 500px;">
        <div class="card-body text-center">
            <h4 class="card-title"><?= htmlspecialchars($user['name']) ?></h4>
            <p class="text-muted">@<?= htmlspecialchars($user['username']) ?></p>
            <p><strong>Role:</strong> <?= htmlspecialchars($user['role']) ?></p>
            <p><strong>Qo‘shilgan:</strong> <?= htmlspecialchars($user['created_at']) ?></p>

            <a href="./edit_profile.php" class="btn btn-warning w-100 my-2">✏️ Profilni tahrirlash</a>
            <a href="./logout.php" class="btn btn-danger w-100">🚪 Chiqish</a>
        </div>
    </div>
</div>

<?php include './template/footer.php'; ?>
