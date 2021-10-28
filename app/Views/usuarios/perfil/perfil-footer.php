            <?php if (session()->getFlashdata('mensaje_error')): ?>
                <div class="p-3 mt-3 w-50 bg-danger text-white text-center" style="margin: 0 auto"><?= session()->getFlashdata('mensaje_error') ?></div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('mensaje')): ?>
                <div class="p-3 mt-3 w-50 bg-success text-white text-center" style="margin: 0 auto"><?= session()->getFlashdata('mensaje') ?></div>
            <?php endif; ?>
        </main>
    </div>
</div>

<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
<script src="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.js"></script>
<script src="<?= base_url('assets/dashboard.js') ?>"></script>
</body>
</html>