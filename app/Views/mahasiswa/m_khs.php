<!DOCTYPE html>
<html lang="id">
<div class="ipk-box">
    <h3>Indeks Prestasi Kumulatif (IPK)</h3>
    <h2><?php echo number_format($ipk, 2); ?></h2>
    <p>Total SKS yang telah ditempuh: <?php echo $total_sks; ?></p>
</div>

<h3>Rincian Nilai</h3>
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Kode MK</th>
            <th>Nama Mata Kuliah</th>
            <th>SKS</th>
            <th>Nilai</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; foreach($khs as $row): ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $row['kode_mata_kuliah']; ?></td>
            <td><?php echo $row['nama_mata_kuliah']; ?></td>
            <td><?php echo $row['sks']; ?></td>
            <td><?php echo $row['nilai_huruf'] ? $row['nilai_huruf'] : 'Belum Dinilai'; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>