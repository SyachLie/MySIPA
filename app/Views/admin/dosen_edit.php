<div class="form-box">
    <h4>Edit Data Dosen</h4>
    <form action="<?php echo base_url('admin/proses_edit_dosen'); ?>" method="post">
        
        <input type="hidden" name="nidn_lama" value="<?php echo $dosen['nidn']; ?>">

        <label>NIDN</label>
        <input type="text" name="nidn" value="<?php echo $dosen['nidn']; ?>" required>

        <label>Nama Lengkap</label>
        <input type="text" name="nama" value="<?php echo $dosen['nama']; ?>" required>

        <div style="margin-top: 20px;">
            <button type="submit" class="btn btn-warning">Update</button>
            <a href="<?php echo base_url('admin/dosen'); ?>" class="btn btn-danger">Batal</a>
        </div>
    </form>
</div>