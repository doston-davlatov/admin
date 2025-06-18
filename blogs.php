<?php
include './template/header.php';
include './config.php';
$db = new Database();

$blogs = $db->select('blogs', '*', null, null, 'i');
?>

<div class="container py-5">
    <h2 class="text-center mb-4">📚 Barcha Bloglar</h2>

    <div class="row">
        <?php if (!empty($blogs)): ?>
            <?php foreach ($blogs as $blog): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="<?= htmlspecialchars($blog['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($blog['title']) ?>" style="object-fit:cover; height:200px;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($blog['title']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($blog['description']) ?></p>
                            <div class="mt-auto d-flex justify-content-between gap-2">
                                <a href="blog_edit.php?id=<?= $blog['id'] ?>" class="btn btn-warning btn-sm">✏️ Tahrirlash</a>
                                <a href="blog_delete.php?id=<?= $blog['id'] ?>" class="btn btn-danger btn-sm"
                                   onclick="return confirm('Haqiqatan ham o‘chirmoqchimisiz?')">🗑️ O‘chirish</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center text-muted">Bloglar hali mavjud emas.</p>
        <?php endif; ?>
    </div>

    <div class="text-center mt-4">
        <a href="./blog_create.php" class="btn btn-success">➕ Yangi blog qo‘shish</a>
    </div>
</div>

<?php include './template/footer.php'; ?>
