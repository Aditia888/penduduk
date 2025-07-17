<div class="container mt-4">
    <h3 class="mb-3"><?= $judul; ?></h3>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
    <?php elseif ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
    <?php endif; ?>

    <form method="post" action="<?= base_url('kritikSaran/kirim'); ?>">
        <div class="form-group">
            <label for="isi">Tulis Kritik atau Saran</label>
            <textarea name="isi" id="isi" class="form-control" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Kirim</button>
    </form>

    <hr>

    <h5 class="my-4">Kritik & Saran Sebelumnya</h5>
    <?php if (empty($list_kritik)): ?>
        <div class="alert alert-info">Belum ada kritik atau saran.</div>
    <?php else: ?>
        <ul class="list-group">
            <?php foreach ($list_kritik as $item): ?>
                <li class="list-group-item">
                    <small class="text-muted float-right"><?= date('d M Y H:i', strtotime($item->created_at)); ?></small>
                    <?= nl2br(htmlspecialchars($item->isi)); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>