</div> </div> <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Cek apakah ada pesan SUKSES (Hijau)
    <?php if (session()->getFlashdata('success')) : ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '<?php echo session()->getFlashdata('success'); ?>',
            showConfirmButton: false,
            timer: 2000 // Hilang sendiri dalam 2 detik
        });
    <?php endif; ?>

    // Cek apakah ada pesan ERROR (Merah)
    <?php if (session()->getFlashdata('error')) : ?>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '<?php echo session()->getFlashdata('error'); ?>',
            confirmButtonColor: '#d33',
            confirmButtonText: 'Tutup'
        });
    <?php endif; ?>
</script>

</body>
</html>