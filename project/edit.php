<?php
include '../config.php';
$db = new Database();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "❌ Noto‘g‘ri ID!";
    exit;
}

$id = (int) $_GET['id'];

$project = $db->select('projects', '*', 'id = ?', [$id], 'i');
if (!$project || count($project) === 0) {
    echo "❌ Loyiha topilmadi!";
    exit;
}
$project = $project[0];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $link = $_POST['link'];
    $newImage = $_FILES['image'];

    $updateData = [
        'title' => $title,
        'description' => $description,
        'link' => $link
    ];

    if ($newImage['name']) {
        $uploadDir = '../src/images/';
        $imageName = time() . '_' . basename($newImage['name']);
        $uploadPath = $uploadDir . $imageName;
        
        if (move_uploaded_file($newImage['tmp_name'], $uploadPath)) {
            if ($project['image'] && file_exists('../' . $project['image'])) {
                unlink('../' . $project['image']);
            }
            $updateData['image'] = '../src/images/' . $imageName;
        } else {
            echo "❌ Rasm yuklanmadi!";
            exit;
        }
    }

    $updated = $db->update('projects', $updateData, 'id = ?', [$id], 'i');
    
    if ($updated >= 0) {
        header("Location: ../projects.php");
        exit;
    } else {
        echo "❌ Yangilashda xatolik.";
    }
}
?>
<?php include '../header.php'; ?>

<link rel="stylesheet" href="../src/css/edit.css">
<div class="container mt-5">
    <h2 class="mb-4 text-center">Loyihani tahrirlash</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="title" class="form-label">Nomi</label>
            <input type="text" class="form-control" name="title" id="title" required
                value="<?= htmlspecialchars($project['title']) ?>">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Tavsif</label>
            <textarea class="form-control" name="description" id="description" rows="4"
                required><?= htmlspecialchars($project['description']) ?></textarea>
        </div>

        <div class="mb-3">
            <label for="link" class="form-label">Loyiha havolasi (ixtiyoriy)</label>
            <input type="url" class="form-control" name="link" id="link"
                value="<?= htmlspecialchars($project['link']) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Joriy rasm:</label><br>
            <img src="../<?= $project['image'] ?>" width="200" style="object-fit:cover;" alt="Rasm">
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Yangi rasm (ixtiyoriy):</label>
            <input class="form-control" type="file" id="image" name="image" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">💾 Saqlash</button>
        <a href="../projects.php" class="btn btn-secondary">🔙 Orqaga</a>
    </form>
</div>

<?php include '../footer.php'; ?>