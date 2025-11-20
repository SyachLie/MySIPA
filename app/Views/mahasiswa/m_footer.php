</div> </div> <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Cek apakah ada flashdata 'success'
    <?php if (session()->getFlashdata('success')) : ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '<?php echo session()->getFlashdata('success'); ?>',
            showConfirmButton: false,
            timer: 2000 // Pop-up hilang sendiri setelah 2 detik
        });
    <?php endif; ?>

    // Cek apakah ada flashdata 'error'
    <?php if (session()->getFlashdata('error')) : ?>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '<?php echo session()->getFlashdata('error'); ?>',
            confirmButtonColor: '#d33', // Warna tombol merah
            confirmButtonText: 'Tutup'
        });
    <?php endif; ?>
</script>
<script>
    // Ambil semua elemen dengan class 'btn-hapus'
    const deleteButtons = document.querySelectorAll('.btn-hapus');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault(); // Cegah link jalan langsung
            const href = this.getAttribute('data-href'); // Ambil alamat hapus

            // Tampilkan Pop-up Konfirmasi
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Mata kuliah ini akan dihapus dari KRS Anda.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33', // Merah
                cancelButtonColor: '#3085d6', // Biru
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kalau user klik "Ya", baru kita arahkan ke Controller
                    document.location.href = href;
                }
            });
        });
    });
</script>

</body>
</html>