<h3>Selamat Datang di Panel Admin, <?php echo session()->get('nama_user'); ?>!</h3>

<hr>

<h4>Ringkasan Data</h4>

<div class="stat-cards-container">

    <div class="stat-card blue">
        <h2><?php echo $count_mahasiswa; ?></h2>
        <p>Total Mahasiswa</p>
    </div>

    <div class="stat-card green">
        <h2><?php echo $count_dosen; ?></h2>
        <p>Total Dosen</p>
    </div>

    <div class="stat-card orange">
        <h2><?php echo $count_matkul; ?></h2>
        <p>Total Mata Kuliah</p>
    </div>

    <div class="stat-card red">
        <h2><?php echo $count_ruangan; ?></h2>
        <p>Total Ruangan</p>
    </div>

</div>

<hr>