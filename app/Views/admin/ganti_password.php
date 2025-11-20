<div class="form-box">
    <h4>Ganti Password untuk: <?php echo $user['nama_user']; ?></h4>
    <p>Kode Peran: <?php echo $user['kode_peran']; ?></p>

    <form action="<?php echo base_url('admin/proses_ganti_password'); ?>" method="post">

        <input type="hidden" name="kode_peran" value="<?php echo $user['kode_peran']; ?>">
        <input type="hidden" name="role" value="<?php echo $role; ?>">

        <label for="new_password">Password Baru:</label>
        <input type="password" name="new_password" id="new_password" placeholder="Masukkan password baru" required>

        <button type="submit" class="btn btn-primary">Update Password</button>
        <a href="<?php echo base_url('admin/' . $role); ?>" class="btn btn-danger">Batal</a>
    </form>
</div>