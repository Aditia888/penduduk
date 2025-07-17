<!-- PAGE CONTENT -->
<div class="page-content--bgf7">
    <!-- PEMBAYARAN KAS & SAMPAH -->
    <section class="p-t-60">
        <div class="container">
            <!-- Dropdown Filter Tahun -->
            <div class="table-data__tool" style="margin-bottom: 10px;">
                <div class="table-data__tool-left">
                    <h3 class="title-5">Pembayaran Kas & Sampah</h3>
                </div>
                <div class="table-data__tool-right">
                    <form method="get" action="<?= base_url('kas'); ?>">
                        <select name="tahun" class="form-control" onchange="this.form.submit()">
                            <?php for ($y = date('Y') - 5; $y <= date('Y') + 1; $y++): ?>
                                <option value="<?= $y ?>" <?= ($tahun == $y) ? 'selected' : '' ?>><?= $y ?></option>
                            <?php endfor; ?>
                        </select>
                    </form>
                </div>
            </div>

            <!-- TABEL KAS -->
            <h5 class="mb-2 mt-4">Pembayaran Kas</h5>
            <div style="width: 100%;" class="mb-5">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Bulan</th>
                            <th>Tanggal Bayar</th>
                            <th>Status</th>
                            <th>Bukti</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($kas as $bulan => $row): ?>
                            <tr>
                                <td><?= date('F', mktime(0, 0, 0, $bulan, 10)); ?></td>
                                <td><?= $row ? date('d-m-Y', strtotime($row['tanggal'])) : '-'; ?></td>
                                <td>
                                    <?php
                                    if (!$row) echo 'Belum Bayar';
                                    elseif ($row['status_persetujuan'] == 0) echo 'Menunggu Persetujuan';
                                    elseif ($row['status_persetujuan'] == 1) echo 'Disetujui';
                                    else echo 'Ditolak';
                                    ?>
                                </td>
                                <td>
                                    <?php if ($row && $row['buktiPembayaran']): ?>
                                        <a href="<?= base_url('uploads/bukti_pembayaran/' . $row['buktiPembayaran']); ?>" target="_blank">Lihat</a>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!$row): ?>
                                        <form class="" action="<?= base_url('kas/upload'); ?>" method="post" enctype="multipart/form-data" class="d-flex align-items-center">
                                            <input type="hidden" name="bulan" value="<?= $bulan; ?>">
                                            <input type="hidden" name="tahun" value="<?= $tahun; ?>">
                                            <input type="hidden" name="status" value="kas">
                                            <div class="d-flex flex-column ">
                                                <input type="file" name="bukti" class="form-control bukti-file" required>
                                                <small class="text-danger d-none">Bukti Pembayaran Harus Diisi</small>
                                                <button type="submit" class="btn btn-sm btn-primary">Upload</button>
                                            </div>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- TABEL SAMPAH -->
            <h5 class="mb-2 mt-4">Pembayaran Sampah</h5>
            <div style="width: 100%;">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Bulan</th>
                            <th>Tanggal Bayar</th>
                            <th>Status</th>
                            <th>Bukti</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sampah as $bulan => $row): ?>
                            <tr>
                                <td><?= date('F', mktime(0, 0, 0, $bulan, 10)); ?></td>
                                <td><?= $row ? date('d-m-Y', strtotime($row['tanggal'])) : '-'; ?></td>
                                <td>
                                    <?php
                                    if (!$row) echo 'Belum Bayar';
                                    elseif ($row['status_persetujuan'] == 0) echo 'Menunggu Persetujuan';
                                    elseif ($row['status_persetujuan'] == 1) echo 'Disetujui';
                                    else echo 'Ditolak';
                                    ?>
                                </td>
                                <td>
                                    <?php if ($row && $row['buktiPembayaran']): ?>
                                        <a href="<?= base_url('uploads/bukti_pembayaran/' . $row['buktiPembayaran']); ?>" target="_blank">Lihat</a>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!$row): ?>
                                        <form action="<?= base_url('kas/upload'); ?>" method="post" enctype="multipart/form-data" class="d-flex align-items-center">
                                            <input type="hidden" name="bulan" value="<?= $bulan; ?>">
                                            <input type="hidden" name="tahun" value="<?= $tahun; ?>">
                                            <input type="hidden" name="status" value="sampah">
                                            <input type="file" name="bukti" class="form-control mr-2" required>
                                            <button type="submit" class="btn btn-sm btn-primary">Upload</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <!-- END PEMBAYARAN KAS & SAMPAH -->
</div>
<script>
    document.querySelectorAll('.form-upload').forEach(form => {
        form.addEventListener('submit', function(e) {
            const fileInput = form.querySelector('.bukti-file');
            const errorText = form.querySelector('.text-danger');

            if (!fileInput.files.length) {
                e.preventDefault(); // hentikan submit
                errorText.classList.remove('d-none');
            } else {
                errorText.classList.add('d-none');
            }
        });
    });
</script>