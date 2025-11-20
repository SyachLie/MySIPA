<?php if (session()->get('error')): ?>
    <div class="alert alert-danger">
        <?php echo session()->get('error'); ?>
    </div>
<?php endif; ?>

<div class="form-box">
    <h4>Edit Data Mata Kuliah</h4>

    <form action="<?php echo base_url('admin/proses_edit_mata_kuliah'); ?>" method="post">

        <input type="hidden" name="id_mata_kuliah" value="<?php echo $matkul['id_mata_kuliah']; ?>">

        <label for="kode_mata_kuliah">Kode Mata Kuliah:</label>
        <input type="text" name="kode_mata_kuliah" id="kode_mata_kuliah" value="<?php echo $matkul['kode_mata_kuliah']; ?>" required>

        <br>

        <label for="nama_mata_kuliah">Nama Mata Kuliah:</label>
        <input type="text" name="nama_mata_kuliah" id="nama_mata_kuliah" value="<?php echo $matkul['nama_mata_kuliah']; ?>" required>

        <br>

        <label for="sks">Jumlah SKS:</label>
        <input type="text" name="sks" id="sks" value="<?php echo $matkul['sks']; ?>" required pattern="[0-9]*" title="SKS hanya boleh berisi angka.">

        <br><br>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="<?php echo base_url('admin/mata_kuliah'); ?>" class="btn btn-danger">Batal</a>
    </form>
</div>