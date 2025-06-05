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

<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loyihani Tahrirlash - Doston Davlatov</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../src/css/edit.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        .container {
            max-width: 700px;
            margin: 60px auto;
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
            position: relative;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }

        h2::after {
            content: '';
            position: absolute;
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, #007bff, #00d4ff);
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 2px;
        }

        .form-label {
            font-weight: 600;
            color: #444;
            margin-bottom: 8px;
        }

        .form-control, .form-control:focus {
            border-radius: 8px;
            border: 1px solid #ced4da;
            padding: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 120px;
        }

        .btn {
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(90deg, #007bff, #00d4ff);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(90deg, #0056b3, #0096c7);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #6c757d;
            border: none;
        }

        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }

        img {
            border-radius: 10px;
            margin-bottom: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .mb-3 {
            margin-bottom: 20px !important;
        }

        @media (max-width: 576px) {
            .container {
                padding: 20px;
                margin: 30px 15px;
            }
            h2 {
                font-size: 1.75rem;
            }
            .btn {
                padding: 10px 20px;
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <?php include '../header.php'; ?>

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
                <img src="../<?= htmlspecialchars($project['image']) ?>" width="200" style="object-fit:cover;" alt="Rasm">
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
</body>
</html>