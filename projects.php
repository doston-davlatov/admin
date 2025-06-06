<?php include './header.php'; ?>
<?php
include './config.php';
$db = new Database();
$projects = $db->select('projects', '*');
?>

<div class="container">
    <h2 class="text-center mb-4">📂 Barcha Loyihalar</h2>
    
    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Rasm</th>
                    <th>Nomi</th>
                    <th class="d-none d-md-table-cell">Tavsif</th>
                    <th class="d-none d-lg-table-cell">Texnologiyalar</th>
                    <th>GitHub</th>
                    <th>Holati</th>
                    <th class="d-none d-md-table-cell">Qo‘shilgan vaqt</th>
                    <th>Amallar</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($projects && count($projects) > 0): ?>
                    <?php foreach ($projects as $index => $project): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td>
                                <img src="<?= $project['image'] ?>" alt="rasm" width="100" height="80"
                                     style="object-fit: cover; border-radius: 8px;">
                            </td>
                            <td><?= htmlspecialchars($project['title']) ?></td>
                            <td class="d-none d-md-table-cell"><?= htmlspecialchars($project['description']) ?></td>
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
                            <td class="d-none d-md-table-cell"><?= $project['created_at'] ?></td>
                            <td>
                                <div class="d-grid gap-2">
                                    <a href="project/edit.php?id=<?= $project['id'] ?>" class="btn btn-warning btn-sm">✏️ Tahrirlash</a>
                                    <a href="project/delete.php?id=<?= $project['id'] ?>" class="btn btn-danger btn-sm"
                                       onclick="return confirm('Haqiqatan ham o‘chirmoqchimisiz?')">🗑️ O‘chirish</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="10" class="text-muted">Hech qanday loyiha mavjud emas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include './footer.php'; ?>
