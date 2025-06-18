<?php
session_start();
include './config.php';
$db = new Database();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "❌ Noto‘g‘ri ID!";
    exit;
}
$id = (int)$_GET['id'];
$blog = $db->select('blogs', '*', 'id = ?', [$id], 'i');
if (!$blog || count($blog) === 0) {
    echo "❌ Blog topilmadi!";
    exit;
}
$blog = $blog[0];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $link = trim($_POST['link']);
    $image = $_FILES['image'];

    $updateData = [
        'title' => $title,
        'description' => $description,
        'link' => $link
    ];

    if (!empty($image['name'])) {
        $uploadDir = './src/images/';
        $imageName = time() . '_' . basename($image['name']);
        $uploadPath = $uploadDir . $imageName;

        if (move_uploaded_file($image['tmp_name'], $uploadPath)) {
            $oldImagePath = __DIR__ . '/' . ltrim($blog['image'], './');
            if (file_exists($oldImagePath)) unlink($oldImagePath);
            $updateData['image'] = $uploadPath;
        } else {
            echo "❌ Rasm yuklanmadi!";
            exit;
        }
    }

    $updated = $db->update('blogs', $updateData, 'id = ?', [$id], 'i');
    if ($updated >= 0) {
        header("Location: ./blogs.php");
        exit;
    } else {
        echo "❌ Yangilashda xatolik.";
    }
}
?>

<?php include './template/header.php'; ?>

<div class="container py-4">
    <h2 class="text-center mb-4">Blogni tahrirlash</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Sarlavha</label>
            <input type="text" class="form-control" name="title" required value="<?= htmlspecialchars($blog['title']) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Tavsif</label>
            <textarea class="form-control" name="description" rows="4" required><?= htmlspecialchars($blog['description']) ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Havola (ixtiyoriy)</label>
            <input type="url" class="form-control" name="link" value="<?= htmlspecialchars($blog['link']) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Joriy rasm:</label><br>
            <img src="<?= htmlspecialchars($blog['image']) ?>" width="200" style="object-fit:cover;">
        </div>

        <div class="mb-3">
            <label class="form-label">Yangi rasm (ixtiyoriy)</label>
            <input type="file" class="form-control" name="image" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">💾 Saqlash</button>
        <a href="./blogs.php" class="btn btn-secondary">🔙 Orqaga</a>
    </form>
</div>

<?php include './template/footer.php'; ?>
