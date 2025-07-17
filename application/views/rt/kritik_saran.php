<div class="container mt-4">
    <h3 class="mb-3"><?= $judul; ?></h3>

    <?php if (empty($list_kritik)): ?>
        <div class="alert alert-info">Belum ada kritik atau saran dari warga RT Anda.</div>
    <?php else: ?>
        <ul class="list-group">
            <?php foreach ($list_kritik as $item): ?>
                <li class="list-group-item">
                    <strong><?= ucwords(strtolower($item->nama)); ?></strong><br>
                    <small class="text-muted"><?= date('d M Y H:i', strtotime($item->created_at)); ?></small><br>
                    <?= nl2br(htmlspecialchars($item->isi)); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>