<?php
session_start();
include './template/header.php';
include './config.php';
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: ./login/');
    exit;
}

$db = new Database();

$sql = "SELECT id, name, username, created_at, updated_at FROM users ORDER BY created_at DESC";
$result = $db->executeQuery($sql)->get_result();
?>

<div class="container mt-4">
    <h1 class="mb-4">Foydalanuvchilar ro‘yxati</h1>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Ismi</th>
                    <th>Username</th>
                    <th>Ro‘yxatdan o‘tgan</th>
                    <th>Oxirgi tahrir</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php $i = 1; while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['username']) ?></td>
                            <td><?= htmlspecialchars($row['created_at']) ?></td>
                            <td><?= htmlspecialchars($row['updated_at']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Foydalanuvchilar topilmadi.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include './template/footer.php'; ?>
