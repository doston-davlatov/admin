<?php include './header.php'; ?>
<?php
include './config.php';
$db = new Database();
$projects = $db->select('projects', '*');
?>

<div class="row">
    <div class="container">
        <h2 class="text-center mb-4">Barcha Loyihalar</h2>
        <table class="table table-bordered table-hover text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Rasm</th>
                    <th>Nomi</th>
                    <th>Tavsif</th>
                    <th>Havola</th> <!-- 🔗 qo‘shilgan ustun -->
                    <th>Qo‘shilgan vaqt</th>
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
                                    style="object-fit: cover;">
                            </td>
                            <td><?= htmlspecialchars($project['title']) ?></td>
                            <td><?= htmlspecialchars($project['description']) ?></td>
                            <td>
                                <?php if (!empty($project['link'])): ?>
                                    <a href="<?= htmlspecialchars($project['link']) ?>" target="_blank">🔗 Ko‘rish</a>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td><?= $project['created_at'] ?></td>
                            <td>
                                <a href="project/edit.php?id=<?= $project['id'] ?>" class="btn btn-warning btn-sm">✏️
                                    Tahrirlash</a>
                                <a href="project/delete.php?id=<?= $project['id'] ?>" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Haqiqatan ham o‘chirmoqchimisiz?')">🗑️ O‘chirish</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">Hech qanday loyiha mavjud emas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include './footer.php'; ?>
