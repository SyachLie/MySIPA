</div> </div> <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // ============================================================
    // 1. POP-UP OTOMATIS (UNTUK TAMBAH & EDIT)
    // ============================================================
    
    // Jika ada pesan SUKSES (Hijau)
    <?php if (session()->getFlashdata('success')) : ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '<?php echo session()->getFlashdata('success'); ?>',
            showConfirmButton: false,
            timer: 2000
        });
    <?php endif; ?>

    // Jika ada pesan ERROR (Merah)
    <?php if (session()->getFlashdata('error')) : ?>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '<?php echo session()->getFlashdata('error'); ?>',
            confirmButtonColor: '#d33',
            confirmButtonText: 'Tutup'
        });
    <?php endif; ?>

    // ============================================================
    // 2. POP-UP KONFIRMASI (KHUSUS TOMBOL HAPUS)
    // ============================================================
    
    // Cari semua tombol yang punya class "btn-hapus-konfirmasi"
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.btn-hapus-konfirmasi');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault(); // Tahan dulu, jangan langsung pindah
                const href = this.getAttribute('href'); // Ambil link hapusnya

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data ini akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Kalau User klik Ya, baru buka link hapusnya
                        document.location.href = href;
                    }
                });
            });
        });
    });
</script>

</body>
</html>