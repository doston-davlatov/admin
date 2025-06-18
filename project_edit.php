<?php
session_start();
include './config.php';
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
    $technologies = $_POST['technologies'];
    $deleteImage = isset($_POST['delete_image']) && $_POST['delete_image'] == '1';
    $newImage = $_FILES['image'];


    $updateData = [
        'title' => $title,
        'description' => $description,
        'technologies' => $technologies,
        'link' => $link
    ];

     if (!empty($newImage['name'])) {
        $uploadDir = './src/images/';
        $imageName = time() . '_' . basename($newImage['name']);
        $uploadPath = $uploadDir . $imageName;

        if (move_uploaded_file($newImage['tmp_name'], $uploadPath)) {

            $oldImagePath = __DIR__ . '/' . ltrim($project['image'], '../');

            if ($oldImagePath&& file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }

            $updateData['image'] = $uploadPath;
        } else {
            echo "❌ Rasm yuklanmadi!";
            exit;
        }
    }

    $updated = $db->update('projects', $updateData, 'id = ?', [$id], 'i');

    if ($updated >= 0) {
        header("Location: ./projects.php");
        exit;
    } else {
        echo "❌ Yangilashda xatolik.";
    }
}
?>
<?php include './template/header.php'; ?>

<div class="container">
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
            <label for="technologies" class="form-label">Texnologiyalar</label>
            <input class="form-control" name="technologies" id="technologies" rows="4"
                required><?= htmlspecialchars($project['technologies']) ?></input>
        </div>

        <div class="mb-3">
            <label for="link" class="form-label">Loyiha havolasi (ixtiyoriy)</label>
            <input type="url" class="form-control" name="link" id="link"
                value="<?= htmlspecialchars($project['link']) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Joriy rasm:</label><br>
            <img src="./<?= htmlspecialchars($project['image']) ?>" width="200" style="object-fit:cover;"
                alt="Rasm"><br>
        </div>


        <div class="mb-3">
            <label for="image" class="form-label">Yangi rasm (ixtiyoriy):</label>
            <input class="form-control" type="file" id="image" name="image" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">💾 Saqlash</button>
        <a href="./projects.php" class="btn btn-secondary">🔙 Orqaga</a>
    </form>
</div>

<?php include './template/footer.php'; ?>