<div class="form-box">
    <h4>Edit Data Ruangan</h4>

    <form action="<?php echo base_url('admin/proses_edit_ruangan'); ?>" method="post">

        <input type="hidden" name="id_ruangan" value="<?php echo $ruangan['id_ruangan']; ?>">

        <label for="nama_ruangan">Nama Ruangan:</label>
        <input type="text" name="nama_ruangan" id="nama_ruangan" value="<?php echo $ruangan['nama_ruangan']; ?>" required>

        <br><br>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="<?php echo base_url('admin/ruangan'); ?>" class="btn btn-danger">Batal</a>
    </form>
</div>