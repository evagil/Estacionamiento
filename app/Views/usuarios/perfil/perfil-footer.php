            <?php if (session()->getFlashdata('mensaje_error')): ?>
                <div id="mensaje" class="alert alert-warning alert-dismissible fade show w-50" style="margin: 10px auto" role="alert">
                    <?= session()->getFlashdata('mensaje_error') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('mensaje')): ?>
                <div id="mensaje" class="alert alert-success alert-dismissible fade show w-50" style="margin: 10px auto" role="alert">
                    <?= session()->getFlashdata('mensaje') ?>
                </div>
            <?php endif; ?>
        </main>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
<script src="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.js"></script>
<script src="<?= base_url('assets/dashboard.js') ?>"></script>
<script type="text/javascript">
    $(document).ready(() => {
        setTimeout(() => {
            $('#mensaje').alert('close')
        }, 5000)
    })
</script>
</body>
</html>