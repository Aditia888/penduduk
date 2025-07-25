<!-- PAGE CONTENT-->
<div class="page-content--bgf7">

    <?php if ($user['role_id'] == 1 || $user['role_id'] == 5): ?>
        <!-- WELCOME-->
        <section class="welcome p-t-60">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="title-4">Selamat datang
                            <span><?= $user['username']; ?>!</span>
                        </h1>
                        <hr class="line-seprate">
                    </div>
                </div>
            </div>
        </section>
        <!-- END WELCOME-->

        <!-- STATISTIC-->
        <section class="statistic statistic2">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-lg-4">
                        <div class="statistic__item statistic__item--green">
                            <?php
                            $sum = 0;
                            foreach ($masuk as $total_masuk) {
                                $sum += $total_masuk->total;
                            }
                            ?>
                            <h2 class="number">Rp <?= rupiah($sum); ?></h2>
                            <span class="desc"><strong>Kas Masuk</strong></span>
                            <div class="icon">
                                <i class="zmdi zmdi-account-o"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="statistic__item statistic__item--orange">
                            <?php
                            $sum = 0;
                            foreach ($keluar as $total_keluar) {
                                $sum += $total_keluar->total;
                            }
                            ?>
                            <h2 class="number">Rp <?= rupiah($sum); ?></h2>
                            <span class="desc"><strong>Kas Keluar</strong></span>
                            <div class="icon">
                                <i class="zmdi zmdi-shopping-cart"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="statistic__item statistic__item--blue">
                            <?php
                            $sum_masuk = 0;
                            foreach ($masuk as $total_masuk) {
                                $sum_masuk += $total_masuk->total;
                            }
                            $sum_keluar = 0;
                            foreach ($keluar as $total_keluar) {
                                $sum_keluar += $total_keluar->total;
                            }
                            $saldo = $sum_masuk - $sum_keluar;
                            ?>
                            <h2 class="number">Rp <?= rupiah($saldo); ?></h2>
                            <span class="desc"><strong>Saldo Kas</strong></span>
                            <div class="icon">
                                <i class="zmdi zmdi-calendar-note"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- END STATISTIC-->

    <?php else: ?>
        <!-- DASHBOARD PENGENALAN PERUMAHAN DUTA ASRI CIAKAR -->
        <section class="welcome p-t-60">
            <div class="container text-center">
                <h1 class="title-4">Selamat Datang di</h1>
                <h2 class="title-3">Perumahan Duta Asri Ciakar</h2>
                <p class="m-t-20">Perumahan modern yang nyaman dan strategis di wilayah Ciakar.</p>
                <img src="<?= base_url('assets/images/duta-asri-banner.jpg'); ?>" alt="Duta Asri Ciakar" class="img-fluid m-t-30" style="max-width: 800px;">
            </div>
        </section>
    <?php endif; ?>

</div>