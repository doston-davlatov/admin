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

if (!empty($blog['image'])) {
    $imagePath = __DIR__ . '/' . ltrim($blog['image'], './');
    if (file_exists($imagePath)) unlink($imagePath);
}

$deleted = $db->delete('blogs', 'id = ?', [$id], 'i');

if ($deleted) {
    header("Location: ./blogs.php");
    exit;
} else {
    echo "❌ Blogni o‘chirishda xatolik!";
}
