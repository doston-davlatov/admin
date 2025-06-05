<?php
include '../config.php';
$db = new Database();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $image = $_FILES['image'] ?? null;

    if ($image && $image['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../src/images/';
        $fileName = time() . '_' . basename($image['name']);
        $uploadPath = $uploadDir . $fileName;

        $fileType = strtolower(pathinfo($uploadPath, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($image['tmp_name'], $uploadPath)) {
                $insert = $db->insert('projects', [
                    'title' => $title,
                    'description' => $description,
                    'image' => $uploadPath
                ]);

                if ($insert) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Maʼlumotlar bazasiga yozishda xatolik']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Rasmni yuklashda xatolik']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Faqat rasm fayllariga ruxsat berilgan']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Rasm topilmadi yoki yuklashda xatolik']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Noto‘g‘ri so‘rov turi']);
}
exit;
