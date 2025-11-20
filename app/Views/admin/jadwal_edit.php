<div class="form-box">
    <h4>Edit Jadwal Kuliah</h4>

    <form action="<?php echo base_url('admin/proses_edit_jadwal'); ?>" method="post">

        <input type="hidden" name="id_jadwal" value="<?php echo $jadwal['id_jadwal']; ?>">

        <label>Mata Kuliah:</label>
        <select name="id_mata_kuliah" required>
            <option value="">-- Pilih Mata Kuliah --</option>
            <?php foreach($matkul_list as $mk): ?>
            <option value="<?php echo $mk['id_mata_kuliah']; ?>" <?php echo ($mk['id_mata_kuliah'] == $jadwal['id_mata_kuliah']) ? 'selected' : ''; ?>>
                <?php echo $mk['nama_mata_kuliah']; ?>
            </option>
            <?php endforeach; ?>
        </select>

        <label>Dosen:</label>
        <select name="nidn" required>
            <option value="">-- Pilih Dosen --</option>
            <?php foreach($dosen_list as $d): ?>
            <option value="<?php echo $d['nidn']; ?>" <?php echo ($d['nidn'] == $jadwal['nidn']) ? 'selected' : ''; ?>>
                <?php echo $d['nama']; ?>
            </option>
            <?php endforeach; ?>
        </select>

        <label>Ruangan:</label>
        <select name="id_ruangan" required>
            <option value="">-- Pilih Ruangan --</option>
            <?php foreach($ruangan_list as $r): ?>
            <option value="<?php echo $r['id_ruangan']; ?>" <?php echo ($r['id_ruangan'] == $jadwal['id_ruangan']) ? 'selected' : ''; ?>>
                <?php echo $r['nama_ruangan']; ?>
            </option>
            <?php endforeach; ?>
        </select>

        <label for="nama_kelas">Nama Kelas:</label>
        <input type="text" name="nama_kelas" id="nama_kelas" value="<?php echo $jadwal['nama_kelas']; ?>" placeholder="Nama Kelas (A/B/C)" required>

        <label for="hari">Hari:</label>
        <input type="text" name="hari" id="hari" value="<?php echo $jadwal['hari']; ?>" placeholder="Hari (Senin/Selasa)" required>

        <label for="jam">Jam:</label>
        <input type="text" name="jam" id="jam" value="<?php echo $jadwal['jam']; ?>" placeholder="Jam (08:00-10:00)" required>

        <br>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="<?php echo base_url('admin/jadwal'); ?>" class="btn btn-danger">Batal</a>
    </form>
</div>