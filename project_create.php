<?php
session_start();
include './config.php';
$db = new Database();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $technologies = trim($_POST['technologies']);
    $link = trim($_POST['link']);
    $image = $_FILES['image'];

    $imagePath = '';
    if (!empty($image['name'])) {
        $uploadDir = './src/images/';
        $imageName = time() . '_' . basename($image['name']);
        $uploadPath = $uploadDir . $imageName;

        if (move_uploaded_file($image['tmp_name'], $uploadPath)) {
            $imagePath = $uploadPath;
        } else {
            echo "❌ Rasm yuklashda xatolik!";
            exit;
        }
    }

    $data = [
        'title' => $title,
        'description' => $description,
        'technologies' => $technologies,
        'link' => $link,
        'image' => $imagePath,
        'status' => 'inactive',
        'created_at' => date('Y-m-d H:i:s')
    ];

    $inserted = $db->insert('projects', $data);

    if ($inserted) {
        header("Location: ./projects.php");
        exit;
    } else {
        echo "❌ Loyiha qo‘shishda xatolik!";
    }
}
?>

<?php include './template/header.php'; ?>

<div class="container">
    <h2 class="mb-4 text-center">Yangi loyiha qo‘shish</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="title" class="form-label">Nomi</label>
            <input type="text" class="form-control" name="title" id="title" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Tavsif</label>
            <textarea class="form-control" name="description" id="description" rows="4" required></textarea>
        </div>

        <div class="mb-3">
            <label for="technologies" class="form-label">Texnologiyalar</label>
            <input type="text" class="form-control" name="technologies" id="technologies" required>
        </div>

        <div class="mb-3">
            <label for="link" class="form-label">Loyiha havolasi (ixtiyoriy)</label>
            <input type="url" class="form-control" name="link" id="link">
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Rasm (ixtiyoriy)</label>
            <input class="form-control" type="file" id="image" name="image" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">➕ Qo‘shish</button>
        <a href="./projects.php" class="btn btn-secondary">🔙 Orqaga</a>
    </form>
</div>

<?php include './template/footer.php'; ?>
