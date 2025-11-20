<?php if (session()->get('success')): ?>
    <div class="alert alert-success">
        <?php echo session()->get('success'); ?>
    </div>
<?php endif; ?>
<?php if (session()->get('error')): ?>
    <div class="alert alert-danger">
        <?php echo session()->get('error'); ?>
    </div>
<?php endif; ?>

<div class="form-box">
    <h4>Tambah Mata Kuliah Baru</h4>
    <form action="<?php echo base_url('admin/tambah_mata_kuliah'); ?>" method="post">
        <input type="text" name="kode_mata_kuliah" placeholder="Kode Mata Kuliah (Contoh: MK001)" required>
        <input type="text" name="nama_mata_kuliah" placeholder="Nama Mata Kuliah" required>
        <input type="text" name="sks" placeholder="Jumlah SKS" required pattern="[0-9]*" title="SKS hanya boleh berisi angka.">
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>

<h3>Daftar Mata Kuliah</h3>
<table>
    <thead>
        <tr>
            <th>Kode MK</th>
            <th>Nama Mata Kuliah</th>
            <th>SKS</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($matkul_list as $mk): ?>
        <tr>
            <td><?php echo $mk['kode_mata_kuliah']; ?></td>
            <td><?php echo $mk['nama_mata_kuliah']; ?></td>
            <td><?php echo $mk['sks']; ?></td>
            <td>
                <a href="<?php echo base_url('admin/edit_mata_kuliah/'.$mk['id_mata_kuliah']); ?>" class="btn btn-info">Edit</a>
                <a href="<?php echo base_url('admin/hapus_mata_kuliah/'.$mk['id_mata_kuliah']); ?>" onclick="return confirm('Yakin? Menghapus ini mungkin akan mempengaruhi jadwal.')" class="btn btn-danger">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>