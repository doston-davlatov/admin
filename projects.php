<?php 
session_start();
include './template/header.php';
require './config.php';

$db = new Database();
$projects = $db->select('projects', '*');
?>

<div class="container my-4">
    <h2 class="text-center mb-4">📂 Barcha Loyihalar</h2>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Rasm</th>
                    <th>Nomi</th>
                    <th class="d-none d-md-table-cell">Tavsif</th>
                    <th class="d-none d-lg-table-cell">Texnologiyalar</th>
                    <th>Link</th>
                    <th>Holati</th>
                    <th class="d-none d-md-table-cell">Qo‘shilgan</th>
                    <th>Amallar</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($projects && count($projects) > 0): ?>
                    <?php foreach ($projects as $index => $project): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td>
                                <?php if (!empty($project['image'])): ?>
                                    <img src="<?= htmlspecialchars($project['image']) ?>" alt="rasm" width="100" height="80" style="object-fit: cover; border-radius: 8px;">
                                <?php else: ?>
                                    <span class="text-muted">Rasm yo‘q</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($project['title']) ?></td>
                            <td class="d-none d-md-table-cell"><?= htmlspecialchars(mb_strimwidth($project['description'], 0, 80, '...')) ?></td>
                            <td class="d-none d-lg-table-cell"><?= htmlspecialchars($project['technologies']) ?></td>
                            <td>
                                <?php if (!empty($project['link'])): ?>
                                    <a href="<?= htmlspecialchars($project['link']) ?>" target="_blank">🔗 Link</a>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <form action="project/status.php" method="POST" class="d-inline">
                                    <input type="hidden" name="id" value="<?= $project['id'] ?>">
                                    <select name="status" onchange="this.form.submit()" class="form-select form-select-sm">
                                        <option value="active" <?= $project['status'] === 'active' ? 'selected' : '' ?>>🟢 Aktiv</option>
                                        <option value="inactive" <?= $project['status'] === 'inactive' ? 'selected' : '' ?>>⚪ Nofaol</option>
                                    </select>
                                </form>
                            </td>
                            <td class="d-none d-md-table-cell"><?= htmlspecialchars($project['created_at']) ?></td>
                            <td>
                                <div class="d-grid gap-2">
                                    <a href="project_edit.php?id=<?= $project['id'] ?>" class="btn btn-warning btn-sm">✏️ Tahrirlash</a>
                                    <a href="project/delete.php?id=<?= $project['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Haqiqatan ham o‘chirmoqchimisiz?')">🗑️ O‘chirish</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-muted">🚫 Hozircha loyiha mavjud emas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="text-center mt-4">
        <a href="./project_create.php" class="btn btn-success px-4">➕ Yangi loyiha qo‘shish</a>
    </div>
</div>

<?php include './template/footer.php'; ?>
