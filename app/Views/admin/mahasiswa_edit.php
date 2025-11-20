<div class="form-box">
    <h4>Edit Data Mahasiswa</h4>
    <form action="<?php echo base_url('admin/proses_edit_mahasiswa'); ?>" method="post">
        
        <input type="hidden" name="nim_lama" value="<?php echo $mahasiswa['nim']; ?>">

        <label>NIM</label>
        <input type="text" name="nim" value="<?php echo $mahasiswa['nim']; ?>" required>

        <label>Nama Lengkap</label>
        <input type="text" name="nama" value="<?php echo $mahasiswa['nama']; ?>" required>

        <div style="margin-top: 20px;">
            <button type="submit" class="btn btn-warning">Update</button>
            <a href="<?php echo base_url('admin/mahasiswa'); ?>" class="btn btn-danger">Batal</a>
        </div>
    </form>
</div>