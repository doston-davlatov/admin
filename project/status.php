<?php
include '../config.php';
$db = new Database();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $status = $_POST['status'];

    if (in_array($status, ['active', 'inactive'])) {
        $db->update('projects', ['status' => $status], "id = $id");
    }
}

header("Location: ../projects.php"); 
exit;
