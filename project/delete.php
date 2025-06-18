<?php
session_start();
require '../config.php';
$db = new Database();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "❌ Noto‘g‘ri so‘rov!";
    exit;
}

$id = (int)$_GET['id'];

$project = $db->select('projects', '*', 'id = ?', [$id], 'i');

if (!$project || count($project) === 0) {
    echo "❌ Loyiha topilmadi!";
    exit;
}
$project = $project[0];

$imagePath = '../src/images/' . $project['image'];
if ($project['image'] && file_exists($imagePath)) {
    unlink($imagePath);
}

$deleted = $db->delete('projects', 'id = ?', [$id], 'i');

if ($deleted > 0) {
    header("Location: ../projects.php");
    exit;
} else {
    echo "❌ Loyiha o‘chirilmadi.";
}
?>
