<!DOCTYPE html>
<html lang="id">
<head>
    <title>Login - MySIPA</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
</head>
<body class="login-page-body"> <div class="login-container">
        
        <div class="login-header">
            <h2>MySIPA</h2>
            <p>Sistem Informasi Perkuliahan Akademik</p>
        </div>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?php echo session()->getFlashdata('error'); ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo base_url('auth/proses_login'); ?>" method="post" class="login-form">
            <div class="input-group">
                <label for="kode_peran">ID Pengguna</label>
                <input type="text" name="kode_peran" id="kode_peran" placeholder="NIM / NIDN" required>
            </div>
            
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Masukkan Password" required>
            </div>
            
            <button type="submit" class="login-button">Login</button>
        </form>
    </div>

</body>
</html>